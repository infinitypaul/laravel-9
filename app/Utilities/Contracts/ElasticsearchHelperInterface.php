<?php

namespace App\Utilities\Contracts;

use App\Utilities\Mailer;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message inside elasticsearch using the Mailer object.
     *
     * @param  Mailer  $mail
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(Mailer $mail): mixed;

    public function getAllEmails(): array;
}
