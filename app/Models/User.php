<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser

{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Diasumsikan Anda sudah menambahkan ini ke fillable
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
        'is_admin' => 'boolean', 
    ];
     /**
     * Tentukan apakah pengguna dapat mengakses panel admin Filament tertentu.
     * * Ini adalah metode wajib (abstract method) dari interface FilamentUser.
    * * @param \Filament\Panel $panel
    * @return bool
    */
    public function canAccessPanel(Panel $panel): bool
    {
        // dd( $this->is_admin);

        // return $this->is_admin ?? false;
         return str_ends_with($this->email, '@gmail.com') && $this->hasVerifiedEmail();
    }

}
