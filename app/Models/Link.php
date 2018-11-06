<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public $table = 'links';

    public $fillable = ['title','link','sort_id','user_id','status','type','color'];


    public function sort()
    {
        return $this->hasOne('App\Models\Sort','id','sort_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function colorCode()
    {
        return $this->hasOne('App\Models\Color','color','color');
    }

    public function colorLog()
    {
        return $this->hasOne('App\Models\FeeLog','link_id','id')->where('status',0);
    }
}
