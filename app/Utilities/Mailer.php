<?php

namespace App\Utilities;

class Mailer
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
        return 'emails';
    }

    public static function fromArray(array $emails): \Illuminate\Support\Collection
    {
        return collect($emails)->map(function ($emailData) {
            return new self($emailData['to'], $emailData['subject'], $emailData['body']);
        });
    }
}
