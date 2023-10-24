<?php

namespace App\Utilities\Contracts;

use App\Utilities\Mailer;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param  string  $messageBody
     * @param  string  $messageSubject
     * @param  string  $toEmailAddress
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(Mailer $mail): mixed;

    public function getAllEmails(): array;
}
