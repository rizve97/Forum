<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function problem()
    {
    	return $this->belongsTo('App\Problem');
    }
    public function solution()
    {
    	return $this->belongsTo('App\Solution');
    }
}
