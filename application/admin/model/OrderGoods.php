<?php

namespace app\admin\model;

use think\Model;

class OrderGoods extends Model
{


    public function user(){
        return $this->belongsTo('User','user_id');
    }

    public function product(){
        return $this->belongsTo('Product','product_id');
    }


}
