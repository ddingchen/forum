<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true,
    ];
});

$factory->state(App\User::class, 'unconfirmed', function ($faker) {
    return ['confirmed' => false];
});

$factory->state(App\User::class, 'admin', function ($faker) {
    return ['name' => 'dc'];
});

$factory->define(App\Thread::class, function ($faker) {
    $sentence = $faker->sentence;
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },
        'slug' => str_slug($sentence),
        'title' => $sentence,
        'body' => $faker->paragraph,
        'replies_count' => 0,
        'locked' => false,
    ];
});

$factory->define(App\Reply::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});

$factory->define(App\Channel::class, function ($faker) {
    $word = $faker->word;
    return [
        'name' => $word,
        'slug' => $word,
    ];
});

$factory->define(Illuminate\Notifications\DatabaseNotification::class, function ($faker) {
    return [
        'id' => Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => auth()->id() ?: factory('App\User')->create()->id,
        'notifiable_type' => 'App\User',
        'data' => ['data'],
    ];
});
