<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public $table = 'ads';

    public $fillable = ['link','img','sort','status','user_id'];

    public function log()
    {
        return $this->hasOne('App\Models\FeeLog','link_id','id');
    }

    public function activeLog()
    {
        return $this->log()->where('status',0);
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
    
}
