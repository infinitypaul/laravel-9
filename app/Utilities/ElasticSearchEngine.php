<?php

namespace App\Utilities;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Elasticsearch\Client;

class ElasticSearchEngine implements  ElasticsearchHelperInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function storeEmail(Mailer $mail): mixed
    {
        $this->indexData($mail);
        return $mail->searchableID();
    }

    public function getAllEmails(int $size = 1000): array
    {
        $params = [
            'index' => 'emails',
            'size' => $size,
        ];

        $response = $this->client->search($params);

        return array_map(function ($hit) {
            return $hit['_source'];
        }, $response['hits']['hits']);
    }

    private function indexData($data): void
    {
        $params = [
            'index' => $data->searchableAs(),
            'id' => $data->searchableID(),
            'body' => $data->toSearchableArray()
        ];
        $this->client->index($params);
    }
}
