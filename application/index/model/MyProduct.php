<?php

namespace app\index\model;

use think\Model;

class MyProduct extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('Product','product_id');
    }
}
