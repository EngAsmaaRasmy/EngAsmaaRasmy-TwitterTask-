<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\ServiceProvider;
use App\Services\TwitterService;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TwitterService::class, function ($app) {
            return new TwitterService(new TwitterOAuth(
                env('TWITTER_CONSUMER_KEY'),
                env('TWITTER_CONSUMER_SECRET'),
                env('TWITTER_ACCESS_TOKEN'),
                env('TWITTER_ACCESS_TOKEN_SECRET')
            ));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
