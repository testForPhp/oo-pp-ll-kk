<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ad::orderBy('sort','asc')->get();
        return view('admin.ad.index',compact('ads'));
    }

    public function create()
    {
        return view('admin.ad.create');
    }

    public function edit($id)
    {
        $ad = Ad::find($id);
        if(is_null($ad)){
            return $this->returnResponse(['message'=>'广告不存在'],400);
        }
        return view('admin.ad.edit',compact('ad'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'img' => 'required',
            'link' => 'required',
            'id' => 'required'
        ]);
        $data = $request->only(['img','link','sort','id']);

        if($request->has('status')){
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
        }

        if(Ad::where('id',$data['id'])->update($data)){
            return $this->returnResponse(['message'=>'修改成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);

    }

    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required',
            'link' => 'required'
        ]);
        $data = $request->only(['img','link','sort']);

        if($request->has('status')){
            $data['status'] = 0;
        }

        if(Ad::create($data)){
            return $this->returnResponse(['message'=>'添加成功']);
        }
        return $this->returnResponse(['message'=>'添加失败'],500);
    }

    public function destroy($id)
    {
        $ad = Ad::find($id);
        if(is_null($ad)){
            return $this->returnResponse(['message'=>'广告不存在'],400);
        }
        if($ad->delete()){
            return $this->returnResponse(['message'=>'删除成功']);
        }
        return $this->returnResponse(['message'=>'删除失败'],500);
    }
}