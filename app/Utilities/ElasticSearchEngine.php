<?php

namespace App\Utilities;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\Searchable;
use Elasticsearch\Client;

class ElasticSearchEngine implements  ElasticsearchHelperInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function storeEmail(Searchable $data): mixed
    {
        $this->indexData($data);
        return $data->searchableID();
    }

    public function getAllDataFromIndex(string $index, int $size = 1000): array
    {
        $params = [
            'index' => $index,
            'size' => $size,
        ];

        $response = $this->client->search($params);

        return array_map(function ($hit) {
            return $hit['_source'];
        }, $response['hits']['hits']);
    }

    private function indexData(Searchable $data): void
    {
        $params = [
            'index' => $data->searchableAs(),
            'id' => $data->searchableID(),
            'body' => $data->toSearchableArray()
        ];
        $this->client->index($params);
    }
}
