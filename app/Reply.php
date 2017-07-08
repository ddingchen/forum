<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favorite');
    }

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function favorite()
    {
        $attribute = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attribute)->exists()) {
            $this->favorites()->create($attribute);
        }
    }

    public function unfavorite()
    {
        $attribute = ['user_id' => auth()->id()];

        $this->favorites()->where($attribute)->delete();
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
