<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function problems()
    {
    	return $this->hasMany('App\Problem');
    }
}
