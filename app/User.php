<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mockery\Exception;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * One to One realtionship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function loginToken()
    {
        return $this->hasOne('App\LoginToken');
    }

    /**
     * If user was already authenticated returns FALSE, otherwise will authenticate and return TRUE
     * @return bool
     */
    public function firstAuthentication()
    {
        if (! $this->email_verified_at){
            $this->email_verified_at=Carbon::now();
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Checks if the user has email verified
     * @return bool
     */
    public function isEmailVerified() : bool
    {
        return true && $this->email_verified_at;
    }

    /**
     * retreves user by email
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public static function byEmail($email)
    {
        return static::where('email',$email)->first();
    }
}
