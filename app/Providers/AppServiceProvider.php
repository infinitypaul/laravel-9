<?php

namespace App\Providers;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\ElasticSearchEngine;
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
    }
}
