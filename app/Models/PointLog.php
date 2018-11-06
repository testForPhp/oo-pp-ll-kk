<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    public $table = 'point_log';

    public $fillable = ['code','user_id','point'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
