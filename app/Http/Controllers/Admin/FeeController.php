<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeeController extends Controller
{
    public function index()
    {
       $fee = Fee::first();
        return view('admin.system.fee',compact('fee'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['rank','rank_num','color','color_num','img','img_num','recommend','recommend_num','recommend_id']);
        $model = new Fee();
        $fee = $model::first();
        if($fee){
            $result = $model->where('id',$fee->id)->update($data);
        }else{
            $result = $model->create($data);
        }

        if($result){
            Cache::forget('fee');

            Cache::forever('fee',$model::first());
            return $this->returnResponse(['message'=>'更新成功']);
        }
        return $this->returnResponse(['message'=>'更新失败！'],500);
    }
}