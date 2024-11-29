<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    // A city belongs to a state
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
