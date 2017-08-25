<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarTest extends TestCase
{
    public function test_only_members_may_upload_the_avatar()
    {
        $this->withExceptionHandling();

        $this->json('post', 'api/user/1/avatar')
            ->assertStatus(401);
    }

    public function test_a_invalid_avatar_is_not_allowed()
    {
        $this->withExceptionHandling()->signIn();

        $this->json('post', 'api/user/' . auth()->user() . '/avatar', ['avatar' => 'image'])
            ->assertStatus(422);
    }

    public function test_a_valid_avatar_will_be_passed()
    {
        $this->signIn();

        $this->json('post', 'api/user/' . auth()->user() . '/avatar', [
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ])->assertStatus(204);
    }

    public function test_a_user_may_add_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('post', 'api/user/' . auth()->user() . '/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals('/storage/avatars/' . $file->hashName(), auth()->user()->avatar_path);
        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
