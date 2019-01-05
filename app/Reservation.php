<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $fillable = [
        'num_persons',
        'user_id'
    ];

    public function chairs(){
        return $this->belongsToMany('App\Chair', 'chairs_has_reservations', 'reservation_id', 'chair_id')
            ->withTimestamps();
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
