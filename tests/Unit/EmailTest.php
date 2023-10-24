<?php

namespace Tests\Unit;

use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
