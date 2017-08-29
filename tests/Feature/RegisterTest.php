<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    public function test_user_can_fully_confirm_their_email_address()
    {
        $this->withExceptionHandling();

        $this->post('register', [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $user = User::whereName('test')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
        $this->get('register/confirm?token=' . $user->confirmation_token);

        $this->assertTrue($user->fresh()->confirmed);
    }
}
