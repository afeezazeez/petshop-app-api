<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;



/**
 * @property int $id
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
        'avatar',
        'address',
        'phone_number',
        'is_marketing',
        'last_login_at'

    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Takes string password and Hashes it
     *@return Attribute<string, string>
     */
    public function password(): Attribute
    {
        return Attribute::set(fn($value) => Hash::make($value));
    }


}
