<?php

namespace Depotwarehouse\SoDoge\Model;

use Depotwarehouse\Toolbox\DataManagement\Validation\ValidationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{

    public $table = "users";

    protected $fillable = [ "username", "email", "password" ];
    protected $hidden = [ "password" ];

    public $createRules = [
        'username' => 'required|unique:users|between:3,80|alpha_num',
        'email' => 'unique:users|between:3,80|email',
        'password' => 'required|between:3,250|confirmed'
    ];

    public static function boot()
    {
        User::creating(function (User $user) {
            $v = \Validator::make($user->getAttributes(), $user->createRules);

            if ($v->fails()) {
                throw new ValidationException($v);
            }
        });
    }

    public function shibes()
    {
        return $this->hasMany(Shibe::class, 'user_id', 'id');
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
