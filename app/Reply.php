<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

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

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
