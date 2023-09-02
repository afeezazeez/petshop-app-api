<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JwtToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'unique_id',
        'token_title',
        'restrictions',
        'permissions',
        'expired_at',
        'last_used_at',
        'refreshed_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->expired_at = Carbon::now()->addMinutes(10);
            $model->unique_id = $model->generateHashToken(6);
        });
    }


    public function generateHashToken(int $length): array|string|null
    {
        return  hash('sha256', Str::random($length));
    }
}
