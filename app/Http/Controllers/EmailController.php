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
    private ElasticsearchHelperInterface $elasticsearchHelper;
    private RedisHelperInterface $redisHelper;

    public function __construct(ElasticsearchHelperInterface $elasticsearchHelper, RedisHelperInterface $redisHelper) {
        $this->elasticsearchHelper = $elasticsearchHelper;
        $this->redisHelper = $redisHelper;
    }


    // TODO: finish implementing send method
    public function send(ValidateEmailRequest $request) {
        foreach ($request->emails as $emailData) {
            $mail = $this->createMailerFromRequestData($emailData);
            $this->storeEmail($mail);
            SendEmail::dispatch($mail);
        }

        return response()->json(['message' => 'Emails sent successfully']);
    }

    private function createMailerFromRequestData(array $emailData): Mailer {
        return new Mailer($emailData['to'], $emailData['subject'], $emailData['body']);
    }

    private function storeEmail(Mailer $mail) {
        $result = $this->elasticsearchHelper->storeEmail($mail);
        $this->redisHelper->storeRecentMessage($result, $mail->subject, $mail->to);
    }

    public function list() {
        $emails = $this->elasticsearchHelper->getAllDataFromIndex('emails');

        return response()->json($emails);
    }
}
