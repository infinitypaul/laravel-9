<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateEmailRequest;
use App\Jobs\SendEmail;
use App\Mail\OrderShipped;
use App\Models\User;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    // TODO: finish implementing send method
    public function send(User $user, ValidateEmailRequest $request, ElasticsearchHelperInterface $elasticsearchHelper, RedisHelperInterface $redisHelper)
    {
        foreach ($request->emails as $emailData) {
            $mail = new Mailer($emailData['to'], $emailData['subject'], $emailData['body']);

            $this->storeEmail($mail, $elasticsearchHelper, $redisHelper);
            SendEmail::dispatch($mail);
        }

        return response()->json(['message' => 'Emails sent successfully']);
    }

    private function storeEmail(Mailer $mail, ElasticsearchHelperInterface $elasticsearchHelper, RedisHelperInterface $redisHelper)
    {
        $result = $elasticsearchHelper->storeEmail($mail);
        $redisHelper->storeRecentMessage($result, $mail->subject, $mail->to);
    }

    //  TODO - BONUS: implement list method
    public function list(ElasticsearchHelperInterface $elasticsearchHelper)
    {
        $emails = $elasticsearchHelper->getAllEmails();

        return response()->json($emails);
    }
}
