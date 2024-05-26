<?php

namespace LeaderBoard\ORM\Model;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method int getId()
 * @method string getUniqueId()
 */
class User extends AbstractModel
{
    use HasFactory, Notifiable, HasApiTokens, Authorizable, CanResetPassword, MustVerifyEmail;

    public const TABLE_NAME = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function init(): void
    {
        $this->table = self::TABLE_NAME;
    }
}
