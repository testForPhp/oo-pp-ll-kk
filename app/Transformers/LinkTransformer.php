<?php
namespace App\Transformers;

use Illuminate\Support\Facades\Cache;

class LinkTransformer extends BaseTransformer
{
    public function transformer($item)
    {
        return [
            'title' => $item['title'],
            'link' => $item['link'],
        ];
    }

    public function objectTransformer($item)
    {
        $data = array();
        $data['title'] = $item->title;
        $data['link'] = $item->link;
        $data['sort'] = $item->sort->title;
        $data['id'] = $item->id;
        $data['recommend'] = ($item->sort_id == Cache::get('fee')->recommend_id) ? true : false;
        $data['color'] = isset($item->colorCode->code) ? $item->colorCode->code : '';
        return $data;
    }
}