<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateEmailRequest;
use App\Models\User;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\Mailer;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // TODO: finish implementing send method
    public function send(User $user, ValidateEmailRequest $request, ElasticsearchHelperInterface $elasticsearchHelper)
    {
        $user = $request->user();

        foreach ($request->emails as $emailData) {
            $mail = new Mailer($emailData['to'], $emailData['subject'], $emailData['body']);
            $result = $elasticsearchHelper->storeEmail($mail);
            dd($result);
        }

//        /** @var ElasticsearchHelperInterface $elasticsearchHelper */
//        $elasticsearchHelper = app()->make(ElasticsearchHelperInterface::class);
//        // TODO: Create implementation for storeEmail and uncomment the following line
//        // $elasticsearchHelper->storeEmail(...);

        /** @var RedisHelperInterface $redisHelper */
        $redisHelper = app()->make(RedisHelperInterface::class);
        // TODO: Create implementation for storeRecentMessage and uncomment the following line
        // $redisHelper->storeRecentMessage(...);
    }

    //  TODO - BONUS: implement list method
    public function list()
    {

    }
}
