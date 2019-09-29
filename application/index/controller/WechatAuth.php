<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/3
 * Time: 0:12
 */

namespace app\index\controller;


use app\common\WechatOline;
use app\index\model\User;
use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Log;
use think\facade\Request;
use think\facade\Session;

class WechatAuth extends Controller
{
    public function index()
    {
        //接入微信开发者
        $echostr = Request::param('echostr');
        if ($this->checkSignature()) {
            $this->responseMessage();
//            $this->createMenu();
            return $echostr;
        } else {
            return '';
        }

    }

    private function responseMessage()
    {
        $postStr = file_get_contents('php://input');
        if (!empty($postStr)) {
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            $fromUsername = $postObj->FromUserName;//发送方openid
            $toUsername = $postObj->ToUserName;//开发者微信号
            $ev = $postObj->Event;//事件
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>

                            <FromUserName><![CDATA[%s]]></FromUserName>

                            <CreateTime>%s</CreateTime>

                            <MsgType><![CDATA[%s]]></MsgType>

                            <Content><![CDATA[%s]]></Content>

                            <FuncFlag>0</FuncFlag>

                            </xml>";
            if ($ev == 'subscribe') {
                $this->createAccount($fromUsername);

                //事件key
                $ev_key = $postObj->EventKey;


                if (!empty($ev_key)) {
                    $key_value = explode('_', $ev_key[0]);
                    Log::error($key_value);

                    if ($key_value[0] == 'qrscene') {
                        $info = json_decode($key_value[1], true);
                        if ($info['type'] == 'agency') {
                            $this->updateAccount($info['userid'],$fromUsername);
                        }
                    }
                }
                //https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN
                //用户第一次关注,推送消息
                $msgType = "text";
                $contentStr = '欢迎关注我!';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }

            if ($ev == 'SCAN') {
                $this->createAccount($fromUsername);
                //事件key
                $ev_key = $postObj->EventKey;

                $ev_key = json_encode($ev_key, true);
                $ev_key = json_decode($ev_key, true);
                $ev_key = json_decode($ev_key[0], true);
                if (!empty($ev_key)) {
                    if ($ev_key['type'] == 'agency') {
                        Log::error($ev_key['userid']);
                        $this->updateAccount($ev_key['userid'],$fromUsername);
                        return '';
                    }
                }
            }
            if (!empty($keyword)) {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                return $resultStr;
            } else {
                echo "Input something...";
            }
        } else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = Request::get('signature');
        $timestamp = Request::param('timestamp');
        $nonce = Request::param('nonce');
        $token = config('wechat.token');

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }


    public function createMenu()
    {

        $accessToken = Cache::get('AccessToken');
        Log::error($accessToken);
        if (!$accessToken) {
            $accessToken = (new Base())->accessToken();
        }
        $url = Config::get('wechat.menu_url');
        $app = ['access_token' => $accessToken];
        $url = $url . '?' . http_build_query($app);
        $dai = Request::domain();
        $menu = [
            'button' => [
                [
                    'name' => '个人中心',
                    'sub_button' => [
                        [
                            "type" => "view",
                            "name" => "个人中心",//二级菜单
                            "url" => "$dai/index/my_address/index"
                        ], [
                            "type" => "view",
                            "name" => "在线订购",//二级菜单
                            "url" => "$dai/index/index/index"
                        ],
                        [
                            "type" => "view",
                            "name" => "我要代理",//二级菜单
                            "url" => "$dai/index/agency/i_want"
                        ]

                    ]
                ]
            ]
        ];

        $menu = json_encode($menu, JSON_UNESCAPED_UNICODE);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $menu);
        $result = curl_exec($ch);
        Log::error($result);
        curl_close($ch);
    }


    public function templateMessage($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=';

        if(!Cache::has('AccessToken')){
            (new Base())->accessToken();
        }
        $accessToken = Cache::get('AccessToken');
        $url = $url . $accessToken;

        $data = [
            'touser' => $openid,
            'template_id' => 'p-qA2zITfTYO87jY9xZEcajvCO4Fzf8wPCsoM3t-vXw',
            'data' => [
                'first' => [
                    'value' => '啊啊啊啊',
                ],
                'remark' => [
                    'value' => 'ttttttt',
                ],
            ],
        ];
        // 请求参数类型
        $param = urldecode(json_encode($data));
        $output = (new WechatOline())->http_url($url,$data);
        $res_data = json_decode($output, true);
        if(array_key_exists('errcode',$res_data)&&array_key_exists('errmsg',$res_data)){
            if($res_data['errcode']==41001&&preg_match('/.*access_token.*/',$res_data['errmsg'])){
                (new Base())->accessToken();
                $this->templateMessage($openid);
                exit;
            }
        }
        if ($res_data['errcode'] == 0&&$res_data['errmsg']=='ok') {
            return json(['code'=>1,'msg'=>'发送成功']);
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


    public function createAccount($fromUsername)
    {
        $openid = json_encode($fromUsername, true);
        $openid = json_decode($openid, true);

        $user = Db::name('user')->where('openid', $openid[0])->count('id');
        if (!$user) {
            $wechatOline = new WechatOline();

            $access_token = $wechatOline->getAccessToken();
            if (array_key_exists('errcode', $access_token)) {
                Log::error($access_token);
                exit;
            }

            $user_info = $wechatOline->userInfo($access_token['access_token'], $openid[0]);
            if (array_key_exists('errcode', $user_info)) {
                Log::error($user_info);
                exit;
            }

            $charid = strtoupper(md5(uniqid(mt_rand(), true)));
            $data = [
                'openid' => $user_info['openid'],
                'token' => substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12),
                'level' => 0,
                'path' => '-',
                'nickname' => $user_info['nickname'],
                'sex' => $user_info['sex'],
                'city' => $user_info['city'],
                'province' => $user_info['province'],
                'country' => $user_info['country'],
                'avatar' => $user_info['headimgurl'],
                'create_time'=>time(),
                'update_time'=>time(),
            ];
            $user = Db::name('user')->where('openid',$data['openid'])->count('id');
            if(!$user){
                $user = Db::name('user')->insert($data);
            }
            $user = User::field('id,nickname,wechatid,agency_id,avatar,status,openid')->with(['agency'=>function($query){
                $query->field('id,title');
            }])->where('openid', $fromUsername)->find();
            Session::set('user', $user->toArray());
        }
    }

    public function updateAccount($user_id, $fromUsername)
    {
        $p_user = Db::name('user')->where('id', $user_id)->find();

        $c_user = Db::name('user')->where('openid', $fromUsername)->find();
        if($c_user['pid']==0){
            Db::name('user')->where('openid', $fromUsername)->update([
                'pid' => $p_user['id'],
                'level' => $p_user['level'] + 1,
                'path' => $p_user['path'] . $p_user['id'] . '-',
            ]);
        }
//                        if ($p_user['agency_id'] != 0 && $p_user['status'] == 1) {
        $user = User::field('id,nickname,wechatid,agency_id,avatar,status,openid')->with(['agency'=>function($query){
            $query->field('id,title');
        }])->where('openid', $fromUsername)->find();
        Session::set('user', $user->toArray());

//                        } else {
//                            $msgType = "text";
//                            $contentStr = '您扫的二维码用户还不是代理';
//                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                            echo $resultStr;
//                        }
    }
}