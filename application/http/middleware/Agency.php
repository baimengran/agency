<?php

namespace app\http\middleware;

use think\Db;
use think\facade\Session;

class Agency
{
    public function handle($request, \Closure $next)
    {
        if(Session::has('user')){

            $user = Session::get('user');
            $user = Db::name('user')->where('openid',$user['openid'])->find();
            if($user['agency_id']==0){
                header("Location:" . url('index/index/index'));
                exit;
            }
        }
        return $next($request);
    }
}
