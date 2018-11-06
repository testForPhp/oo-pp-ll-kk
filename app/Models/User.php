<?php

namespace App\Models;

use App\Mail\PasswordForget;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    protected $rememberTokenName = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password','email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function sendPasswordResetNotification($token)
    {
        $data['token'] = url('/password/reset',$token);
        $data['name'] = $this->name;
        $data['website'] = cache('system')->website;
        $data['email'] = cache('system')->email;
        Mail::to($this->email)->send(new PasswordForget($data));
    }
}
