<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user, $take = 50)
    {
        return $user->activities()
            ->latest()
            ->take($take)
            ->get()
            ->groupBy(function ($record) {
                return $record->created_at->format('Y-m-d');
            });
    }
}
