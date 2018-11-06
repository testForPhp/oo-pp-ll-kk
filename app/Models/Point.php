<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Point extends Model
{
    public $table = 'point';

    public $fillable = ['code','point'];

    public function insert($data)
    {
        return DB::table($this->getTable())->insert($data);
    }

    public function sort()
    {
        return $this->belongsTo('App\Models\PointSort','sort_id','id');
    }

}