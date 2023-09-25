<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function channel()
    {
    	return $this->belongsTo('App\Channel');
    }
    public function solutions()
    {
    	return $this->hasMany('App\Solution');
    }
    public function votes()
    {
    	return $this->hasMany('App\Likes');
    }
    public function scopeLikes($query)
    {
    	return $query->where('vote',1);
    }
    public function scopeDislikes($query)
    {
    	return $query->where('vote',0);
    }
}
