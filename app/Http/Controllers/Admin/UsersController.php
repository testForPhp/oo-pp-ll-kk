<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::orderBy('id','desc')->get();
        return view('admin.user.index',compact('user'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return $this->returnResponse(['message'=>'用户不存在'],404);
        }

        return view('admin.user.edit',compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['username','password','id']);

        if(empty($data)){
            return $this->returnResponse(['message'=>'请填写修改的内容！'],400);
        }
        if(empty($data['id'])){
            return $this->returnResponse(['message'=>'请选择用户'],400);
        }

        if($data['password'] != ''){
            $data['password'] = bcrypt($data['password']);
        }

        if(empty($data['password'])){
            unset($data['password']);
        }

        if(empty($data['username'])){
            unset($data['username']);
        }

        if(User::where('id',$data['id'])->update($data)){
            return $this->returnResponse(['message'=>'修改成功']);
        }

        return $this->returnResponse(['message'=>'提交失败！'],500);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = $request->only(['username','password']);
        $data['password'] = bcrypt($data['password']);

        if(User::create($data)){
            return $this->returnResponse(['message'=>'添加成功']);
        }
        return $this->returnResponse(['message'=>'提交错误！'],500);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return $this->returnResponse(['message'=>'用户不存在'],400);
        }

        if($user->delete()){
            return $this->returnResponse(['message'=>'删除成功']);
        }

        return $this->returnResponse(['message'=>'提交失败'],500);
    }
    
}