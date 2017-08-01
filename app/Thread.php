<?php

namespace App;

use App\Filters\ThreadFilter;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function ($builder) {
        //     return $builder->withCount('replies');
        // });

        static::addGlobalScope('creator', function ($builder) {
            return $builder->with('creator');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        $this->subscriptions->filter(function ($sub) use ($reply) {
            return $sub->user->id != $reply->owner->id;
        })->each->notify($reply);

        return $reply;
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function scopefilter($query, ThreadFilter $filter)
    {
        return $filter->apply($query);
    }

    public function scopeBy($query, $username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $query->where('user_id', $user->id);
    }

    public function path()
    {
        return "/thread/{$this->channel->slug}/{$this->id}";
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany('App\ThreadSubscription');
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
