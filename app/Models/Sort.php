<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    public $table = 'sort';
    public $timestamps = false;

    public $fillable = ['title','code','sorting','type'];

    public function links()
    {
        return $this->hasMany('App\Models\link');
    }

    public function countLink()
    {
        return $this->links()->where('status',1)
            ->where('type',1)
            ->count();
    }

    public function whereActionOrderByLink()
    {
        return $this->links()->where('status',1)
            ->orderBy('type','desc')
            ->orderBy('id','asc')
            ->get();
    }
}
