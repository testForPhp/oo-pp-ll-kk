<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointSort extends Model
{
    public $table = 'point_sort';

    public $fillable = ['point','link','sort','summary'];
}
