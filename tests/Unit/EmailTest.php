<?php

namespace Tests\Unit;

use App\Jobs\SendEmail;
use App\Mail\OrderShipped;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class EmailTest extends TestCase
{
    use RefreshDatabase;


    public function test_job_dispatched_with_valid_data()
    {

        Queue::fake();


        $user = User::factory()->create();
        $this->actingAs($user);

        $validData = [
            'emails' => [
                [
                    'to' => 'test@example.com',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ]
            ]
        ];


        $response = $this->postJson(route('email.send', $user->id), $validData);


        $response->assertStatus(200);

        Queue::assertPushed(SendEmail::class, function ($job) use ($validData) {
            return $job->mailer->to === $validData['emails'][0]['to'] &&
                $job->mailer->subject === $validData['emails'][0]['subject'] &&
                $job->mailer->body === $validData['emails'][0]['body'];
        });
    }

    public function test_job_not_dispatched_with_invalid_data()
    {

        Queue::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'emails' => [
                [
                    'to' => 'invalid-email',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ]
            ]
        ];


        $response = $this->postJson(route('email.send', $user->id), $invalidData);


        $response->assertStatus(422);
        Queue::assertNotPushed(SendEmail::class);
    }

    public function test_email_has_expected_subject_and_body()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $emailData = [
            'emails' => [
                [
                    'to' => 'test@example.com',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ]
            ]
        ];

        $this->postJson(route('email.send', $user->id), $emailData);

        Mail::assertSent(OrderShipped::class, function ($mail) use ($emailData) {
            return $mail->hasTo($emailData['emails'][0]['to']) &&
                $mail->mailing->subject === $emailData['emails'][0]['subject'];
        });
    }
}
