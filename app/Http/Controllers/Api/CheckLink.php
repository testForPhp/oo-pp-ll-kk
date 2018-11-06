<?php
namespace App\Http\Controllers\Api;

use App\Models\Link;
use App\Models\QuLink;
use Illuminate\Support\Facades\Cache;

class CheckLink
{
    public function auto()
    {
        $link = Link::where('status',1)->get(['link','id']);
        $linkFormaer = collect($link)->map(function ($item){
            return array('link'=>$item->link,'link_id'=>$item->id);
        });
        (new QuLink())->insert($linkFormaer->toArray());
    }

    public function check()
    {
        $link = QuLink::limit(20)->get();
        if($link->isEmpty()){
            exit();
        }
        return $this->linkForm($link);
    }



    private function linkForm($link)
    {
        $source = Cache::get('system')->newlink;
        $linkModel = new Link();

        foreach ($link as $item){
            $result = $this->getUrlContent($item->link,$source);
            if($result === false){
                $linkModel->where('id',$item->link_id)->update([
                    'status' => 2,
                    'remark' => '网站无法访问！'
                ]);
            }
            $item->delete();
        }

    }

    private function getUrlContent($url,$source = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($source != ''){
            curl_setopt($ch, CURLOPT_REFERER, $source);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<400) ? true : false;
    }

}