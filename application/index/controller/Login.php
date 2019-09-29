<?php

namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Log;
use think\facade\Response;
use think\facade\Session;
use think\Request;

class Login extends Controller
{
    public function login()
    {
        $this->getCode();
    }

    public function getCode($scope = 'snsapi_userinfo')
    {
        Log::error(1);
        $url = config('wechat.auth');
        $app_id = config('wechat.app_id');
        if ($scope == 'snsapi_base') {
            $url_path = '/index/login/getOpenid';
        } else {
            $url_path = '/index/login/getUserInfo';
        }
        Log::error(\think\facade\Request::domain());
        $redirect_uri = urlencode(\think\facade\Request::domain() . $url_path);
        $response_type = 'code';
        $state = 'STATE';
        $app = ['appid' => $app_id, 'redirect_uri' => $redirect_uri, 'response_type' => $response_type, 'scope' => $scope, 'state' => $state];
        $app = 'appid=' . $app_id . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
//        $url = $url . '?' . http_build_query($app) . '#wechat_redirect';
        $url = $url . '?' . $app;
        header("location:" . $url);
        exit;
    }

    public function getOpenid()
    {

    }

    public function getUserInfo(Request $request)
    {
        $code = $request->param('code');
        if (!$code) {
            $this->getCode();
        } else {
            $access_token = $this->getAccessToken($code);

            if (array_key_exists('errcode', $access_token)) {
                Log::error('getAccessToken-' . json_encode($access_token));
                exit;
            }
            $get_user_info = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token['access_token'] . '&openid=' . $access_token['openid'] . '&lang=zh_CN';
            $res = $this->http_url($get_user_info);
            $res = json_decode($res, true);

            if (array_key_exists('errcode', $res)) {
                Log::error('getUserInfo', $res);
                exit;
            }
            try {
                $user = User::where('openid', $res['openid'])->find();
                if ($user) {
                    unset($res['privilege']);
                    $res['avatar'] = $res['headimgurl'];
                    unset($res['headimgurl']);
                    unset($res['language']);
                    $user = User::where('openid', $res['openid'])->update($res);
                    $user = User::field('id,nickname,wechatid,agency_id,avatar,status,openid')->with(['agency'=>function($query){
                        $query->field('id,title');
                    }])->where('openid', $res['openid'])->find();

                    Session::set('user', $user->toArray());
                    Log::error(11);
                } else {
                    unset($res['privilege']);
                    $res['avatar'] = $res['headimgurl'];
                    unset($res['headimgurl']);
                    $charid = strtoupper(md5(uniqid(mt_rand(), true)));
                    $res['token'] = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
                    $res['level']=0;
                    $res['path']='-';
                    $user = User::create($res);
                }

                $user = User::field('id,nickname,wechatid,agency_id,avatar,status,openid')->with(['agency'=>function($query){
                    $query->field('id,title');
                }])->where('openid', $res['openid'])->find();
                Session::set('user', $user->toArray());

                $url = \think\facade\Request::domain() . '/index/index/index';
                return redirect($url);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error('getUserInfo-' . $e);
                exit;
            }
        }
    }



    public function getAccessToken($code)
    {

//        Log::error('opend_'.$open_id);
        //https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $appid = config('wechat.app_id');
        $secret = config('wechat.app_secret');
        $grant_type = 'authorization_code';
        $app = ['appid' => $appid, 'secret' => $secret, 'code' => $code, 'grant_type' => $grant_type];
        $url = $url . '?' . http_build_query($app);
        $res = $this->http_url($url);
        $res = json_decode($res, true);
        if (array_key_exists('errcode', $res)) {
            Log::error('getAccessToken_' . json_encode($res));
        } else {
            $check = $this->checkAccessToken($res['access_token'], $res['openid']);
            if (!$check) {
                $res = $this->getRefresh_Token($res['refresh_token'], $appid);
            }
        }
        return $res;
    }

    function getRefresh_Token($refresh_token, $appid)
    {
        $get_refresh_token_url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$appid&grant_type=refresh_token&refresh_token=$refresh_token";
        $res = $this->http_url($get_refresh_token_url);
        return json_decode($res, true);
    }


    public function checkAccessToken($access_token, $openid)
    {

        $check_url = "https://api.weixin.qq.com/sns/auth?access_token=$access_token&openid=$openid";
        $res = $this->http_url($check_url);
        $result = json_decode($res, true);
        if (isset($result['errmsg']) && $result['errcode'] == 0) {
            return 1;       //access_token有效
        } else {
            return 0;       //access_token无效
        }
    }

    function http_url($url, $data = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "error:" . curl_error($ch);
            exit;
        }
        curl_close($ch);
        return $res;
    }

}
