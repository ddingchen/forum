<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany('App\Thread')->latest();
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function lastReply()
    {
        return $this->hasOne('App\Reply')->latest();
    }

    public function read($thread)
    {
        cache()->forever($this->visitedThreadCacheKey($thread), Carbon::now());
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf('user.%s.thread.%s', $this->id, $thread->id);
    }

    public function getAvatarPathAttribute($avatarPath)
    {
        return $avatarPath ? '/storage/' . $avatarPath : '/img/generic-avatar.png';
    }
}
