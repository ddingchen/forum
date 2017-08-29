<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ThreadReceivesNewReply' => [
            'App\Listeners\NotifyMentonedUsers',
            'App\Listeners\NotifySubscriptions',
        ],
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\SendConfirmationEmailRequest',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
