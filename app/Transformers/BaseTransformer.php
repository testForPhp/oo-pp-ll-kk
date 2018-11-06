<?php
namespace App\Transformers;

abstract class BaseTransformer
{
    public function transformerCollection(array $items)
    {
        return array_map([$this,'transformer'],$items);
    }

    public abstract function transformer($item);
}