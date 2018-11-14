<?php

namespace App;

use App\Jobs\RegistrationEmailJob;
use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{

    protected $fillable=['user_id','token'];

    public static function generateFor(User $user)
    {
        if (! $user->loginToken) {
            return static::create([
                'user_id'=>$user->id,
                'token' =>str_random(50)
            ]);
        }
        return $user->loginToken;
    }



    public function sendRegistrationEmail()
    {
        $registrationEmail = new RegistrationEmailJob($this->user);
        $registrationEmail->dispatch($this->user);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
