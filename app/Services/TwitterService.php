<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class TwitterService
{
    protected $twitter;
    protected $firebase;

    public function __construct(TwitterOAuth $twitter)
    {
        $firebaseDatabaseUrl = config('services.firebase.database_url');

        $this->twitter = $twitter;
        $this->firebase = (new Factory)
            ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri($firebaseDatabaseUrl)
            ->createDatabase();
    }

    public function fetchTopTweets($query, $count = 1000)
    {
        if (config('services.twitter.use_dummy_data')) {
            return $this->loadDummyData()->top_tweets->statuses;
        } 

        $response = $this->twitter->get('search/tweets', ['q' => $query, 'count' => $count, 'result_type' => 'popular']);
        return $this->checkResponse($response);
    }

    public function fetchRecentTweets($query, $count = 1000)
    {
        if (config('services.twitter.use_dummy_data')) {
            return $this->loadDummyData()->recent_tweets->statuses;
        }

        $response =$this->twitter->get('search/tweets', ['q' => $query, 'count' => $count, 'result_type' => 'recent']);
        return $this->checkResponse($response);

    }

    protected function loadDummyData()
    {
        $dummyDataPath = storage_path('json/dummy_tweets.json');
        $dummyData = file_get_contents($dummyDataPath);
        return json_decode($dummyData);
    }

    public function checkResponse($response)
    {
        if (isset($response->statuses)) {
            return $response->statuses;
        } else {
            Log::error('Twitter API response error: ' . json_encode($response));
            return [];
        }
    }

    public function storeTweets($tweets)
    {
        foreach ($tweets as $tweet) {
            Tweet::create([
                'tweet' => $tweet->text,
                'useruid' => $tweet->user->id,
                'datetime' => $tweet->created_at,
            ]);

            User::updateOrCreate([
                'id' => $tweet->user->id
            ], [
                'name' => $tweet->user->name,
                'followers_count' => $tweet->user->followers_count,
            ]);
        }
    }

    public function storeTopUsersToFirebase()
    {
        if (!$this->firebase) {
            Log::error('Firebase is not initialized.');
            return;
        }

        $topUsers = User::orderBy('followers_count', 'desc')->take(20)->get();
        $database = $this->firebase;

        foreach ($topUsers as $user) {
            $database->getReference('top_users/' . $user->id)->set([
                'name' => $user->name,
                'followers_count' => $user->followers_count,
            ]);
        }
    }
}
