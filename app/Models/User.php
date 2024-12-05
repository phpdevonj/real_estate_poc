<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Enums\UserType;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'address',
        'mobile',
        'email',
        'status',
        'role',
        'avatar',
    ];
    protected static function booted()
    {
        static::deleting(function ($user) {
            // This code runs automatically before the user is deleted
            if ($user->avatar && $user->avatar !== 'avatars/default.jpg') {
                Storage::disk('public')->delete($user->avatar);
            }
        });
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $casts = [
        'role' => 'integer',
    ];

    public function isAdmin(): bool
    {   if (is_array($this->role) && isset($this->role['App\\Enums\\UserType'])) {
            return $this->role['App\\Enums\\UserType'] === UserType::Admin;
        }
        return $this->role === UserType::Admin;
    }

    public function isAgent(): bool
    {
        if (is_array($this->role) && isset($this->role['App\\Enums\\UserType'])) {
            return $this->role['App\\Enums\\UserType'] === UserType::Agent;
        }
        return $this->role === UserType::Agent;
    }

    public function getRoleValueAttribute()
    {
        if (is_array($this->role) && isset($this->role['App\\Enums\\UserType'])) {
            return (int)$this->role['App\\Enums\\UserType'];
        }
        return 0;
    }
}
