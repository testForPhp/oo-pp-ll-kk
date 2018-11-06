<?php
namespace App\Http\Controllers;


use App\Models\Point;
use App\Models\PointLog;
use App\Models\PointSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RechargeController extends Controller
{
    public function index()
    {
        $rechargeMenu = 'active';
        $point = PointSort::orderBy('sort')->get();
        return view('member.recharge',compact(['rechargeMenu','point']));
    }

    public function activeCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ],[
            'code.required' => '激活码不能为空'
        ]);
        $code = Point::where('code',$request->get('code'))->first();
        if(is_null($code)){
            return $this->returnResponse(['message'=>'激活码不存在'],404);
        }
        if($code->status == 1){
            return $this->returnResponse(['message'=>'激活码已被使用'],400);
        }

        $point = $code->sort->point;

        $user = Auth::user();
        $user->point = $user->point + $point;

        if(!$user->save()){
            return $this->returnResponse(['message'=>'操作失败，请刷新尝试'],500);
        }

        PointLog::create([
            'code' => $code->code,
            'user_id' => $user->id,
            'point' => $point
        ]);

        $code->status = 1;
        $code->save();
        return $this->returnResponse(['message'=>'充值成功！']);
    }
}