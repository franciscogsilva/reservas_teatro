<?php

namespace App;

use App\Chair;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    protected $table = 'chairs';
    protected $fillable = [
        'row',
        'column'
    ];

    public function reservation(){
        return $this->belongsTo('App\Reservation', 'reservation_id');
    }
}
