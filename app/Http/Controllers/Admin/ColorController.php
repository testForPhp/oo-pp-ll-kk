<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $color = Color::orderBy('id','desc')->paginate(20);
       return view('admin.system.color.index',compact('color'));
    }

    public function create()
    {
        return view('admin.system.color.create');
    }

    public function edit($id)
    {
        $color = Color::find($id);
        if(is_null($color)){
            return $this->returnResponse(['message'=>'color is empty'],400);
        }
        return view('admin.system.color.edit',compact('color'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'color' => 'required',
            'id' => 'required'
        ]);
        $data = $request->only(['id','code','color']);

        $model = new Color();

        $result = $model::find($data['id']);

        if(is_null($result)){
            return $this->returnResponse(['message'=>'颜色不存在'],400);
        }

        $color = $model::where('id','!=',$data['id'])->where(function ($query) use($data){
           $query->orWhere('code',$data['code'])->orWhere('color',$data['color']);
        })->first();

        if($color){
            return $this->returnResponse(['message'=>'代码或颜色已存在！'],400);
        }

        if($model::where('id',$data['id'])->update($data)){
            return $this->returnResponse(['message'=>'修改成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);

    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:color|max:10',
            'color' => 'required|unique:color|max:20'
        ]);

        $data = $request->only(['code','color']);

        if(Color::create($data)){
            return $this->returnResponse(['message'=>'提交成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);
    }

    public function destroy($id)
    {
        $color = Color::find($id);
        if(is_null($color)){
            return $this->returnResponse(['message'=>'颜色不存在'],404);
        }
        if($color->delete()){
            return $this->returnResponse(['message'=>'删除成功']);
        }
        return $this->returnResponse(['message'=>'删除失败'],500);
    }

}