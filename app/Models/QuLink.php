<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuLink extends Model
{
    public $table = 'quque_link';

    public $fillable = ['link','link_id'];

    public function insert($data)
    {
        return DB::table($this->getTable())->insert($data);
    }
}
