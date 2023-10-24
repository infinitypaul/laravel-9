<?php

namespace App\Utilities\Contracts;

use App\Utilities\Mailer;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message inside elasticsearch using the Mailer object.
     *
     * @param Searchable $data
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(Searchable $data): mixed;

    public function getAllDataFromIndex(string $index, int $size = 1000): array;
}
