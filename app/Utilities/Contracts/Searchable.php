<?php

namespace App\Utilities\Contracts;

interface Searchable
{
    public function searchableAs(): string;
    public function searchableID(): mixed;
    public function toSearchableArray(): array;
}
