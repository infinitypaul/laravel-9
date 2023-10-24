<?php

namespace App\Utilities;

use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Redis;

class RedisEngine implements RedisHelperInterface
{
    protected const REDIS_PREFIX = 'email:';

    public function storeRecentMessage(mixed $id, string $messageSubject, string $toEmailAddress): void
    {
        $key = self::REDIS_PREFIX . $id;
        $this->put($key, [
            'subject' => $messageSubject,
            'to' => $toEmailAddress
        ], 60);
    }

    public function put($key, $value, $minutes = null)
    {
        $value = json_encode($value);
        if ($minutes) {
            return Redis::setex($key, $minutes * 60, $value);
        }
        return Redis::set($key, $value);
    }

    public function get($key)
    {
        $value = Redis::get($key);
        return json_decode($value, true);
    }
}

