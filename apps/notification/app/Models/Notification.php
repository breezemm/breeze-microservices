<?php


use MongoDB\Laravel\Eloquent\Model;

class Notification extends Model
{

    public function notifications()
    {
        return $this->belongsTo(User::class);
    }
}
