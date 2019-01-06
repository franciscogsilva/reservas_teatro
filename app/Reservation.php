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
        return $this->hasMany('App\Chair');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
