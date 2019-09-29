<?php

namespace app\admin\model;

use think\Model;

class MyProduct extends Model
{
    //
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function product()
    {
        return $this->belongsTo('Product', 'product_id');
    }
}
