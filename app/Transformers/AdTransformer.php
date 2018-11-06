<?php
namespace App\Transformers;

class AdTransformer extends BaseTransformer
{
    public function transformer($item)
    {
        return [
            'id' => $item['id'],
            'thumb' => $item['img'],
            'url' => $item['link']
        ];
    }
}