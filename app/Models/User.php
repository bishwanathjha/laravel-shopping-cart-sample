<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 * @package App\Model
 */
class User extends Authenticatable
{
    const TABLE = 'users';
    const PRIMARY_KEY = 'id';

    const ID = 'id';
    const UUID = 'uuid';
    const ApiToken = 'api_token';
    const Name = 'name';
    const Email = 'email';
    const Password = 'password';
    const RoleType = 'role_type';
    const AvatarUrl = 'avatar_url';
    const Phone = 'phone';
    const Address = 'address';
    const IsEnabled = 'is_enabled';
    const LastSeenIP = 'last_seen_ip';
    const PasswordUpdatedAt = 'password_updated_at';
    const LastActivityAt = 'last_activity_at';
    const LastLoginAt = 'last_login_at';
    const CreatedAt = 'created_at';
    const UpdatedAt = 'updated_at';

    const ROLE_ADMIN = 1;
    const ROLE_CUSTOMER = 2;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid', 'token', 'role_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token', 'remember_token'
    ];

    /**
     * @param int $role
     * @return bool
     */
    static public function IsValidRole($role) {
        return in_array($role, [self::ROLE_ADMIN, self::ROLE_CUSTOMER]);
    }
}
