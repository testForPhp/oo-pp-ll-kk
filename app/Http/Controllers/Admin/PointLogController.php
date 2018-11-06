<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointLog;

class PointLogController extends Controller
{
    public function index()
    {
        $code = PointLog::orderBy('id','desc')->paginate(20);
        return view('admin.pointLog.index',compact('code'));
    }
}