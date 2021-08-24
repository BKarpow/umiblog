<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public const ROLE_USER = 41;
    public const ROLE_MODER = 74;
    public const ROLE_ADMIN = 185;
    /**
     * Імена ролей для відображення на сайті
     * @var string[]
     */
    private $roleAliases = [
        self::ROLE_ADMIN => 'Administrator',
        self::ROLE_MODER => 'Moderator',
        self::ROLE_USER => 'User',
    ];

    public function isAdmin():bool
    {
        return (int)$this->role === self::ROLE_ADMIN;
    }

    public function isModer():bool
    {
        return (int)$this->role === self::ROLE_MODER;
    }

    public function isUser():bool
    {
        return (int)$this->role === self::ROLE_USER;
    }

    /**
     * Поаерне аліас імя для ролі яке вказано в моделі користувачів
     * @return string
     */
    public function getAliasRole():string
    {
        $r = (int)$this->role;
        if (isset($this->roleAliases[$r])){
            return $this->roleAliases[$r];
        }
        return '';
    }
}
