<?php

namespace App\Providers;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\ElasticSearchEngine;
use App\Utilities\RedisEngine;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ElasticsearchHelperInterface::class, function ($app) {
                $client = ClientBuilder::create()
                    ->setHosts(config('elasticsearch.connections.default.hosts'))
                    ->setSSLVerification(false)
                    ->build();

            return new ElasticSearchEngine($client);
        });

        $this->app->bind(RedisHelperInterface::class, function ($app) {
            return new RedisEngine();
        });
    }
}
