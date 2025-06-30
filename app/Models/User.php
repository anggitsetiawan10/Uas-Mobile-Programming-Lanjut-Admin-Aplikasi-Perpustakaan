<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
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

    /**
     * Relasi: User memiliki banyak peminjaman.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Relasi: User memiliki banyak ulasan.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relasi: User memiliki banyak notifikasi.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function profile() {
    return $this->hasOne(UserProfile::class);
    }
}
