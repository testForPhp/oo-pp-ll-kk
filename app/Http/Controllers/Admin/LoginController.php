<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = $request->only(['username','password']);

        if(Auth::guard('admin')->attempt($data)){
            return $this->returnResponse([
                'url' => '/fileStore/index',
                'message' => '登陆成功'
            ]);
        }
        return $this->returnResponse(['message'=>'账号或密码错误！'],400);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        redirect('/fileStore/login');
    }
}