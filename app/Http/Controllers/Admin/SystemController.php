<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemController extends Controller
{
    public function index()
    {
        $system = System::first();
        $skin = $this->skinFilePath();
        return view('admin.system.index',compact('system','skin'));
    }

    /**
     * 读取皮肤目录
     * @return array
     */
    private function skinFilePath()
    {
        $skinFilePath = base_path() . '/resources/views/home';
        $path = scandir($skinFilePath);
        $data = array();
        foreach ($path as $item){
            if($item != '.' &&  $item != '..'){
                $data[] = $item;
            }
        }
        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'website' => 'required',
            'weblink' => 'required',
            'newlink' => 'required'
        ]);

        $data = $request->only(['website','notice','weblink','newlink','email','count','keyword','descr','forever','member_notice','skin']);

        $system = System::first();

        if(is_null($system)){
            $result = System::create($data);
        }else{
            $result = System::where('id',$system->id)->update($data);
        }

        if($result){
            $this->updateCache();
            return $this->returnResponse(['message'=>'更新成功']);
        }
        return $this->returnResponse(['message'=>'更新失败'],500);
    }

    public function updateCache()
    {
        if(Cache::has('system')){
            Cache::forget('system');
        }
        $system = System::first();
        Cache::forever('system',$system);
    }
}