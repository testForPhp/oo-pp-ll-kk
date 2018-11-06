<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Sort;
use Illuminate\Http\Request;

class SortController extends Controller
{
    public function index()
    {
        $sort = Sort::orderBy('type','desc')->orderBy('sorting','asc')->get();

        return view('admin.sort.index',compact('sort'));
    }

    public function create()
    {
        return view('admin.sort.create');
    }

    public function edit($id)
    {
        $sort = Sort::find($id);

        if(is_null($sort)){
            return $this->returnResponse(['message'=>'分类不存在'],400);
        }
        return view('admin.sort.edit',compact('sort'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'sorting' => 'required'
        ]);
        $data = $request->only(['title','code','sorting','id']);

        if(empty($data['id'])){
            return $this->returnResponse(['message' => '请选择分类'],400);
        }

        if($request->has('type')){
            $data['type'] = 1;
        }else{
            $data['type'] = 0;
        }

        if(Sort::where('id',$data['id'])->update($data)){
            return $this->returnResponse(['message'=>'修改成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required',
            'sorting' => 'required'
        ]);

        $data = $request->only(['title','code','sorting']);

        if($request->has('type')){
            $data['type'] = 1;
        }

        if(Sort::create($data)){
            return $this->returnResponse(['message' => '添加成功']);
        }
        return $this->returnResponse(['提交失败'],500);
    }

    public function destroy($id)
    {
        $sort = Sort::find($id);

        if(is_null($sort)){
            return $this->returnResponse(['message'=>'分类不存在'],400);
        }
        $sort_id = $sort->id;

        if($sort->delete()){
            Link::where('sort_id',$sort_id)->delete();
            return $this->returnResponse(['message'=>'删除成功']);
        }
        return $this->returnResponse(['message'=>'删除失败'],500);
    }

}