<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    public $table = 'fee';

    public $fillable = ['rank','rank_num','color','color_num','img','img_num','recommend','recommend_num','recommend_id'];

}
