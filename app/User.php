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
        'name', 'email', 'password','remember_token'
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
     * One to One realtionship
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resetToken()
    {
        return $this->hasOne('App\ResetToken');
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
     * extracts user by email
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public static function byEmail($email)
    {
        return static::where('email',$email)->first();
    }

    public function changePassword($request)
    {
        if($this->remember_token=$request->input('remember_token') && $this->resetToken->token=$request->input('reset_token')){
            $this->password=$request->input('password');
            $this->remember_token=str_random(50);
            $this->save();
            $this->resetToken->delete();
            return $this;
        }
        throw new Exception('Division by zero.');
    }
}
