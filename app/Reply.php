<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favorite');
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
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }
}
