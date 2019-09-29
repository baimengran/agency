<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    //

    public function getStatusTimeAttr($value){
        return date('Y-m-d H:i:s',$value);
    }
    public function agency()
    {
        return $this->belongsTo('Agency', 'agency_id');
    }
}
