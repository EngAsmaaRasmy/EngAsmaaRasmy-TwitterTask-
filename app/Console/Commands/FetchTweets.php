<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TwitterService;

class FetchTweets extends Command
{
    protected $signature = 'fetch:tweets {query} {count=10000}';
    protected $description = 'Fetch tweets from Twitter and store them in MongoDB';

    protected $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        parent::__construct();
        $this->twitterService = $twitterService;
    }

    public function handle()
    {
        $query = $this->argument('query');
        $count = $this->argument('count');

        $topTweets = $this->twitterService->fetchTopTweets($query, $count);
        $recentTweets = $this->twitterService->fetchRecentTweets($query, $count);

        $this->twitterService->storeTweets(array_merge($topTweets, $recentTweets));
        $this->twitterService->storeTopUsersToFirebase();

        $this->info('Tweets fetched and stored successfully.');
    }
}
