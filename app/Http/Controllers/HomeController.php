<?php

namespace App\Http\Controllers;

use App\Models\FeeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeMenu = 'active';

        return view('member.home',compact(['homeMenu']));
    }

    public function linkLog()
    {
        $linklogMenu = 'active';
        $feelog = FeeLog::where('status',0)
            ->where('type','!=','img')
            ->where('user_id',Auth::id())
            ->paginate(15);
        return view('member.log',compact(['linklogMenu','feelog']));
    }
}
