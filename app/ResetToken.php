<?php

namespace App;

use App\Jobs\ResetPasswordEmailJob;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ResetToken extends Model {

    protected $fillable = ['user_id', 'token','count'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * Creates a new token for the given user if it does not exist, otherwise it will return the existing one
     * @param User $user
     * @return mixed
     */
    public static function generateFor(User $user)
    {
        $count=0;
        if ($token = $user->resetToken)
        {
            $count=$token->count;
            $token->delete();
        }
            return static::createToken($user,$count);
    }


    /**
     *Triggers a Job with the purpose of sending an email
     */
    public function sendResetEmail()
    {
        $resetEmail = new ResetPasswordEmailJob($this->user);
        $resetEmail->dispatch($this->user);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function createToken($user,$count)
    {
        return static::create([
            'user_id' => $user->id,
            'token'   => str_random(50),
            'count' => $count+1,
        ]);
    }



}
