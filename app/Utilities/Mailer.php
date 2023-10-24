<?php

namespace App\Utilities;

use App\Utilities\Contracts\Searchable;

class Mailer implements Searchable
{
    public string $to;
    public string $subject;
    public string $body;

    public function __construct($to, $subject, $body) {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function toSearchableArray(): array
    {
        return [
            'to' => $this->to,
            'subject' => $this->subject,
            'body' => $this->body
        ];
    }

    public function searchableAs(): string
    {
        return 'emails';
    }

    public function searchableID(): string
    {
        return $this->to . '-' . md5($this->subject . $this->body);
    }

}
