<?php

namespace App;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
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

    public function unfavorite()
    {
        $attribute = ['user_id' => auth()->id()];

        $this->favorites()->where($attribute)->get()->each->delete();
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
}
