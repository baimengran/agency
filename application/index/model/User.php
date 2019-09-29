<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    //
    public function agency(){
        return $this->belongsTo('Agency','agency_id');
    }

}
