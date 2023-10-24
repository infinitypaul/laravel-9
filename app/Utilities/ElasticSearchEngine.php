<?php

namespace App\Utilities;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchEngine implements  ElasticsearchHelperInterface
{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function storeEmail($mailer): mixed
    {
        $this->update($mailer);
        return $mailer->searchableID();
    }

    public function update($data): callable|array
    {
        $params = [
            'index' => $data->searchableAs(),
            'id' => $data->searchableID(),
            'body' => $data->toSearchableArray()
        ];
        return $this->client->index($params);
    }




}
