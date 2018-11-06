<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    public $table = 'system';

    public $timestamps = false;

    public $fillable = ['website','notice','weblink','newlink','email','count','keyword','descr','forever','member_notice','skin'];


}
