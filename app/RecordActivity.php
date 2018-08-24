<?php

namespace App;
/**
 * Record Activity
 */
trait RecordActivity
{   
    protected static function bootRecordActivity(){
        
    if(auth()->guest()) return;
       foreach(static::getEvents() as $event){
        static::created(function ($model) use ($event){
            $model->recordActivity('created', $model);
         });
       }


    static::deleting(function ($model){
        $model->activity()->delete();
     });


    }


    protected static function getEvents(){
        return ['created'];
    }

    public function recordActivity($event)
    {
        // Activity::create([
        //     'user_id' => auth()->id(),
        //     'type' => $this->getActivityType($event),
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);

        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function getActivityType($event)
    {   
        $type = strtolower( ( new \ReflectionClass($this) )->getShortName());
        return $event .'_' .$type;
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
