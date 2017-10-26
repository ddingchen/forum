<?php

namespace App;

use App\Events\ThreadReceivesNewReply;
use App\Filters\ThreadFilter;
use App\Reply;
use App\Visits;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $casts = [
        'locked' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('creator', function ($builder) {
            return $builder->with('creator');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
            $thread->slug = str_slug($thread->title);
            $thread->save();
        });

    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivesNewReply($this, $reply));

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
        return "/thread/{$this->channel->slug}/{$this->slug}";
    }

    public function lock()
    {
        $this->locked = true;
        $this->save();
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

    public function notifySubscribers($reply)
    {
        $this->subscriptions()
            ->where('user_id', '<>', $reply->owner->id)
            ->get()
            ->each
            ->notify($reply);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function setSlugAttribute($slug)
    {
        if (static::whereSlug($slug)->exists()) {
            $slug = $slug . '-' . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function hasUpdatesFor($user = null)
    {
        $user = $user ?: auth()->user();
        return $this->updated_at > cache($user->visitedThreadCacheKey($this));
    }

    public function visits()
    {
        return new Visits($this);
    }

    public function markBestReply(Reply $reply)
    {
        $this->update([
            'best_reply_id' => $reply->id,
        ]);
    }
}
