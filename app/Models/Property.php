<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Models\PropertySizeUnit;
use App\Models\Customer;
use App\Models\User;
class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'no',
        'street',
        'city',
        'state',
        'country',
        'price',
        'currency',
        'photos',
        'size',
        'unit',
        'agent_id',
        'customer_id',
        'flag',
        'status'
    ];

    protected $casts = [
        'photos' => 'array',
        'price' => 'decimal:2',
        'size' => 'decimal:2'
    ];
    protected $appends = [
        'full_address',
        'formatted_price',
        'formatted_size',
        'photos_url',
    ];

    // Relationship with User model for agent
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Relationship with User model for customer
    // Change the customer relationship to point to Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function getPhotosUrlAttribute()
    {
        if (!$this->photos) return [];

        return array_map(function ($photo) {
            return Storage::disk('public')->url($photo);
        }, $this->photos);
    }
    public function countryData()
    {
        return $this->belongsTo(Country::class, 'country', 'id')
        ->withDefault(['name' => '', 'currency_symbol' => '']);
    }

    public function stateData()
    {
        return $this->belongsTo(State::class, 'state', 'id')
        ->withDefault(['name' => '']);
    }

    public function cityData()
    {
        return $this->belongsTo(City::class, 'city', 'id')
        ->withDefault(['name' => '']);
    }

    public function unitData()
    {
        return $this->belongsTo(PropertySizeUnit::class, 'unit', 'id')
        ->withDefault(['unit_key' => '']);
    }

    public function getFullAddressAttribute()
    {
        return sprintf(
            '%s %s, %s, %s, %s',
            $this->no,
            $this->street,
            $this->cityData?->name ?? '',
            $this->stateData?->name ?? '',
            $this->countryData?->name ?? ''
        );
    }

    public function getFormattedPriceAttribute()
    {
         // Add debug logging
        \Log::info('Price Components:', [
            'currency_symbol' => $this->countryData?->currency_symbol,
            'price' => $this->price
        ]);
        return sprintf(
            '%s %s',
            $this->countryData?->currency_symbol ?? '',
            number_format($this->price, 2)
        );
    }

    public function getFormattedSizeAttribute()
    {
        // Add debug logging
        \Log::info('Size Components:', [
            'size' => $this->size,
            'unit_key' => $this->unitData?->unit_key
        ]);
        return sprintf(
            '%s %s',
            number_format($this->size, 2),
            $this->unitData?->unit_key ?? ''
        );
    }
}
