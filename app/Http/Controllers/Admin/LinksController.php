<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Sort;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index($id)
    {
        $sort = Sort::where('id',$id)->first();

        $links = $sort->links()->where('status',1)->orderBy('type','desc')->orderBy('id','desc')->paginate(20);
        return view('admin.link.index',compact(['sort','links']));
    }

    public function edit($id)
    {
        $link = Link::find($id);
        if(is_null($link)){
            return $this->returnResponse(['message'=>'链接不存在'],400);
        }
        return view('admin.link.edit',compact('link'));
    }

    public function pending()
    {
        $links = Link::where('status',0)->orderBy('id','desc')->paginate(20);
        return view('admin.link.pending',compact('links'));
    }

    public function chileError()
    {
        $links = Link::where('status',2)->orderBy('id','desc')->paginate(20);
        return view('admin.link.pending',compact('links'));
    }

    public function active($id)
    {
        $link = Link::find($id);
        if(is_null($link)){
            return $this->returnResponse(['message'=>'链接不存在'],400);
        }
        $status = 1;
        if($link->status == 1){
            $status = 0;
        }
        $link->status = $status;

        if($link->save()){
            return $this->returnResponse(['message'=>'更新成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);
    }

    public function search(Request $request)
    {
        $query = new Link();
        $data = $request->only(['title','link']);
        if($data['title'] != ''){
            $query = $query->where('title','like',"%{$data['title']}%");
        }
        if($data['link'] != ''){
            $query = $query->where('link','like',"%{$data['link']}%");
        }
        $links = $query->get();
        return view('admin.link.search',compact('links'));
    }

    public function update( Request $request)
    {
        $request->validate([
            'title' => 'required|max:8',
            'link' => 'required',
            'id' => 'required'
        ],[
            'title.required' => '标题不能为空',
            'link.required' => '链接不能为空',
            'title.max' => '标题不能大于8位'
        ]);
        $data = $request->only(['title','link','id']);

        $sort = Link::find($data['id']);
        if(empty($sort)){
            return $this->returnResponse(['message'=>'链接不存在'],400);
        }

        if($request->has('color')){
            $color = $request->get('color');
            if($color != ''){
                $data['color'] = $color;
            }else{
                $data['color'] = '';
            }
        }

        if($request->has('type')){
            $data['type'] = 1;
        }else{
            $data['type'] = 0;
        }
        if($request->has('status')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }

        if(Link::where('id',$data['id'])->update($data)){
            return $this->returnResponse(['message'=>'修改成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);
    }

    public function create($id)
    {
        $sort = Sort::find($id);
        if(is_null($sort)){
            return $this->returnResponse(['message'=>'分类不存在'],400);
        }

        return view('admin.link.create',compact('sort'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:8',
            'link' => 'required',
            'sort_id' => 'required'
        ],[
            'title.required' => '标题不能为空',
            'link.required' => '链接不能为空',
            'sort_id.required' => '请选择分类'
        ]);
        $data = $request->only(['title','link','sort_id']);

        $sort = Sort::find($data['sort_id']);
        if(empty($sort)){
            return $this->returnResponse(['message'=>'分类不存在'],400);
        }

        if($request->has('color')){
            $color = $request->get('color');
            if($color != ''){
                $data['color'] = $color;
            }
        }

        if($request->has('type')){
            $data['type'] = 1;
        }
        if($request->has('status')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        $data['addtime'] = time();

        if(Link::create($data)){
            return $this->returnResponse(['message'=>'提交成功']);
        }
        return $this->returnResponse(['message'=>'提交失败'],500);

    }

    public function destroy($id)
    {
        $link = Link::find($id);
        if(is_null($link)){
            return $this->returnResponse(['message'=>'链接不存在'],400);
        }
        if($link->delete()){
            return $this->returnResponse(['message'=>'删除成功']);
        }
        return $this->returnResponse(['message'=>'删除失败'],500);
    }

}