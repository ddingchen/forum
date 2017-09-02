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

        $this->post('register', [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    public function test_user_can_fully_confirm_their_email_address()
    {
        Mail::fake();

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

    public function test_confirming_an_invalid_token()
    {
        $this->get('register/confirm?token=123')
            ->assertRedirect('thread')
            ->assertSessionHas('flash.message', 'Invalid token.');
    }
}
