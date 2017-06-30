<?php

namespace App;

trait RecordActivity
{

    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    public function activities()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function recordActivity($event)
    {
        $this->activities()->create([
            'type' => 'created_' . strtolower((new \ReflectionClass($this))->getShortName()),
            'user_id' => auth()->id(),
        ]);
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

}
