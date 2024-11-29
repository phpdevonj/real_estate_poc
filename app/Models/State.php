<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
     // A state belongs to a country
     public function country()
     {
         return $this->belongsTo(Country::class);
     }

     // A state has many cities
     public function cities()
     {
         return $this->hasMany(City::class);
     }
}
