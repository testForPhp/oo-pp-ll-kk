<?php
namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\FeeLog;
use App\Models\Link;
use App\Models\Sort;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function index()
    {
        $sort = Sort::orderBy('type','desc')->orderBy('sorting','asc')->get();
        $ad = Ad::where('status',0)->orderBy('sort','asc')->orderBy('id','asc')->get();
        $skin = Cache::get('system')->skin;

        return view('home.' . $skin . '.index',compact(['sort','ad']));
    }

    /**
     * 创建首页
     */
    public function html()
    {
        $hostname = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
        $host = $hostname . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_ADD']);

        $index = file_get_contents($host . '/okdsdkjhjkmn');
        $this->createHtml($index,'index.html');
    }

    /**
     * 创建文件
     * @param $data 数据 string|array
     * @param $path 文件名称 string
     */
    private function createHtml($data,$path)
    {
        file_put_contents($path,$data);
    }


    public function autoUpdateFeeLog()
    {
        $model = new FeeLog();
        $log = $model->where('status',0)->get();

        if($log->isEmpty()){
            return false;
        }
        $time = time();

        foreach ($log as $value){
            if($time > $value->end_date){
                $this->updateFeeLogStatus($value);
            }
        }

    }


    private function updateFeeLogStatus($item)
    {
        if($item->type == 'recommend'){
            Link::where('id',$item->link_id)->update([
                'sort_id' => $item->sort_id,
                'color' => ''
            ]);
        }elseif($item->type == 'rank'){
            Link::where('id',$item->link_id)->update([
                'type' => 0,
                'color' => ''
            ]);
        }elseif($item->type == 'color'){
            Link::where('id',$item->link_id)->update(['color'=>'']);
        }elseif($item->type == 'img'){
            Ad::where('id',$item->link_id)->update(['status'=>1]);
        }

        FeeLog::where('id',$item->id)->update(['status'=>1]);
    }
}