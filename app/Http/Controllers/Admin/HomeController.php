<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\FeeLog;
use App\Models\Link;
use App\Models\Point;
use App\Models\Sort;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $sort = Sort::orderBy('type','desc')->orderBy('sorting','asc')->get();
        return view('admin.home.index',compact('sort'));
    }

    public function welcome()
    {
        $feelogModel = new FeeLog();

        $data['link'] = Link::where('status',1)->count();
        $data['pedding'] = Link::where('status',0)->count();
        $data['ad'] = $feelogModel::where('status',0)->count();
        $data['code'] = Point::where('status',1)->count();
        $data['user'] = User::count();
        $data['sort'] = Sort::count();

        $more['recommend'] = $feelogModel->where('status',0)->where('type','recommend')->count();
        $more['rank'] = $feelogModel->where('status',0)->where('type','rank')->count();
        $more['color'] = $feelogModel->where('status',0)->where('type','color')->count();
        $more['img'] = $feelogModel->where('status',0)->where('type','img')->count();


        return view('admin.home.welcome',compact('data','more'));
    }
}