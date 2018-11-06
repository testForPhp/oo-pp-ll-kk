<?php
namespace App\Http\Controllers;


use App\Models\Link;
use App\Models\LinksSource;
use Illuminate\Http\Request;

class SourceController extends Controller
{

    public function get(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);

        $ip = $request->ip();
        $url = $this->pregUrl($request->get('url'));

        if(empty($url)){
            return false;
        }

        $model = new LinksSource();
        $isSource = $model::where('link',$url)
            ->where('id',$ip)
            ->first();

        if($isSource){
            return false;
        }

        $link = Link::where('link','like',"%{$url}%")->first();

        if(is_null($link)){
            return false;
        }

        $model::create([
            'link' => $url,
            'ip' => $ip,
            'addtime' => date('Y-m-d'),
            'links_id' => $link->id
        ]);

        $link->source = $link->source + 1;
        $link->save();

    }


    /**
     * 正则截取网址 xxx.com
     * @param $url
     * @return bool|mixed|string
     */
    public function pregUrl($url)
    {
        if (empty($url)) {
            return false;
        }
        $reg = '/^(http:\/\/)?([^\/]+)/i';
        $matches = array();
        preg_match($reg, $url, $matches);
        $surec = $matches[2];
        if (strpos($matches[2],'www.') !== false) {
            $urlArray = explode(".",$matches[2]);
            unset($urlArray[0]);
            $surec = implode(".",$urlArray);
        }
        return $surec;
    }
}