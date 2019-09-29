<?php

namespace app\admin\controller;
use think\Controller;
use think\File;
use think\Log;
use think\Request;

class Upload
{
	//图片上传
    public function upload(){
        \think\facade\Log::error(111);
       $file = request()->file('file');
       $info = $file->move('static/uploads/');
       if($info){
            return json('/static/uploads/'.$info->getSaveName());
        }else{
            return json($file->getError());
        }
    }

    //会员头像上传
    public function uploadface(){
       $file = request()->file('file');
       $info = $file->move('/static/uploads/');
       if($info){
            return json( 'static/uploads/face/'.$info->getSaveName());
        }else{
            return json($file->getError());
        }
    }

}