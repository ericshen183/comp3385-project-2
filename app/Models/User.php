<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'biography',
        'photo', // Ensure these fields are fillable
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }
}
