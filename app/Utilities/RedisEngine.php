<?php

namespace App\Utilities;

use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisEngine implements RedisHelperInterface
{

    public function storeRecentMessage(mixed $id, string $messageSubject, string $toEmailAddress): void
    {
        $this->put($id, [
            'subject' => $messageSubject,
            'to' => $toEmailAddress
        ]);
    }

    public function put($key, $value, $minutes = null){
        $value = json_encode($value);
        return Redis::command('set', [$key, $value]);
    }

    public function get($key){
        $value = Redis::command('get', [$key]);
        return json_decode($value, true);
    }
}
