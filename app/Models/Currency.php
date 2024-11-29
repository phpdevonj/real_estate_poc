<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    // A currency can belong to many countries
    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
