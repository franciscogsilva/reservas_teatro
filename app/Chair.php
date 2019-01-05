<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    protected $table = 'chairs';
    protected $fillable = [
        'row',
        'column'
    ];

    public function reservations(){
        return $this->belongsToMany('App\Reservation', 'chairs_has_reservations', 'chair_id', 'reservation_id')
            ->withTimestamps();
    }
}
