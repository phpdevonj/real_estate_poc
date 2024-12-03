<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertySizeUnit extends Model
{
    protected $fillable = ['unit_key'];
    // If your table name is different from property_size_units
    protected $table = 'property_size_units';
}
