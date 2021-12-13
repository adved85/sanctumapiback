<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['role', 'full_name'];

    /**
     * The accessor getRoleAttribute - appends first 'role' name to user data
     *
     * @return string
     */
    public function getRoleAttribute(): string
    {
        return $this->roles()->first() ? $this->roles()->first()->name : '';
    }

    /**
     * The accessor getFullNameAttribute - appends 'full_name' to user data
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $bothNamesDefined = (isset($this->first_name) && isset($this->last_name));
        return !$bothNamesDefined ? 'full name' : $this->first_name . ' ' . $this->last_name;
    }
}
