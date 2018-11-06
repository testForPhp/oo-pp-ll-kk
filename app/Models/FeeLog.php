<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeLog extends Model
{
    public $table = 'fee_log';

    public $fillable = ['type','link_id','user_id','sort_id','end_date'];

    //type类型,img:图片,rank:排名,color:颜色,recommend:精品

    public function link()
    {
        return $this->hasOne('App\Models\Link','id','link_id');
    }
}
