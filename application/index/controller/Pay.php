<?php
/**
 * Created by PhpStorm.
 * User: 刘彪
 * Date: 2019/7/26
 * Time: 11:14
 */

namespace app\index\controller;


use app\index\controller\Base;
use think\Db;
use think\facade\Cache;
use think\facade\Log;
use think\Loader;
use think\Request;

class Pay
{
    protected $body;            //商品描述
    protected $out_trade_no;    //订单号
    protected $total_fee;       //支付金额
    protected $notify_url;      //异步回调地址
    protected $open_id;         //用户标识
    protected $pay_key;
    protected $app_id;

    //小程序支付接口
    public function miniProgramPay($openid, $order_desc, $total_fee, $no, $url)
    {
        //用户token
        if (!$no) {
            return ['code' => 0, 'msg' => '订单不能为空'];
        }
        if (!$openid) {
            return ['code' => 0, 'msg' => '请登录后操作'];
        }

        $this->app_id = config('wechat.app_id');
        $this->body = $order_desc;
        $this->out_trade_no = $no;
        $this->total_fee = $total_fee * 100;
        $this->notify_url = url('/index/Pay/notify', '', '', true);
        $this->open_id = $openid;
        $this->pay_key = config('wechat.pay_key');


        $unifiedorder = $this->unifiedorder();
        if ($unifiedorder['return_code'] == 'SUCCESS') {
            $timestamp = time();
            $noncestr = $this->createNoncestr();
            if (!Cache::get('jsApiTicket')) {
                (new Base())->jsApiTicket();
            }
            $jsApiTicket = Cache::get('jsApiTicket');
            $signArray = [
                'noncestr' => $noncestr,
                'jsapi_ticket' => $jsApiTicket,
                'url' => $url,
            ];
            //js-sdk_config签名
            $sign = [
                'appId' => config('wechat.app_id'),
                'timestamp' => "$timestamp",
                'nonceStr' => $noncestr,
                'signature' => $this->getJsSdkSign($signArray),
            ];
            //js-sdk_pay签名
            $data = [];
            $timestamp = time();
            $data['timeStamp'] = "$timestamp";              //时间戳
            $data['nonceStr'] = $unifiedorder['nonce_str'];     //随机字符串
            $data['signType'] = 'MD5';                //签名算法，暂支持 MD5
            $data['package'] = 'prepay_id=' . $unifiedorder['prepay_id'];  //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->genPaySign($unifiedorder, $data['timeStamp']);// 之前以为是$unifiedOrder['sign']; 后来发现是调用的这种方法. 签名方案参见微信公众号支付帮助文档;

            $data['out_trade_no'] = $this->out_trade_no;
            return ['code' => 1, 'config_sign' => $sign, 'pay_sign' => $data];
        } else {
            return ['code' => 0, 'msg' => $unifiedorder];
        }
    }

    public function notify()
    {
        $xml = file_get_contents('php://input');
        $notify_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if ($notify_data['result_code'] == 'SUCCESS' && $notify_data['return_code'] == 'SUCCESS') {
            Db::startTrans();
            try {
                $orderInfo = Db::name('order_goods')->where(['no' => $notify_data['out_trade_no']])->find();
                if ($orderInfo) {
                    if ($orderInfo['closed'] == 2 || $orderInfo['closed'] == 0) {
                        Log::error('weix-success');
                        $xml = '<xml>
                                    <return_code><![CDATA[SUCCESS]]></return_code>
                                    <return_msg><![CDATA[OK]]></return_msg>
                                </xml>';
                        return $xml;
                    }
                    $data = [
                        'payment_method' => 'WeChat',
                        'payment_no' => $notify_data['transaction_id'],
                        'closed' => 2,
                        'paid_at' => strtotime($notify_data['time_end']),
                    ];
                    //订货，
                    if ($orderInfo['type'] == 1) {
                        $data['status'] = 1;

                    }
                    Db::name('order_goods')->update($data);


                    Db::commit();
                } else {
                    Log::error('支付回调——未找到订单');
                }
            } catch (\Exception $e) {
                Db::rollback();
                Log::error($e->getMessage());
            }
        }
    }

    //统一下单接口
    private function unifiedorder()
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $parameters = array(
            'appid' => trim(config('wechat.app_id')),                       //小程序ID
            'mch_id' => trim(config('wechat.mch_id')),                  //商户号
            'nonce_str' => $this->createNoncestr(),         //随机字符串
            'body' => $this->body,                          //商品描述
            'out_trade_no' => $this->out_trade_no,           //商户订单号
            'total_fee' => $this->total_fee,                //总金额 单位 分
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],  //终端IP
            'notify_url' => $this->notify_url,              //通知地址  确保外网能正常访问
            'openid' => $this->open_id,                     //用户id
            'trade_type' => 'JSAPI',                         //交易类型
        );
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);

        $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        return $return;
    }

    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsSdkSign($params)
    {
        if (!empty($params)) {
            $p = ksort($params);
            if ($p) {
                $str = '';
                foreach ($params as $k => $val) {
                    $str .= $k . '=' . $val . '&';
                }
                $strs = rtrim($str, '&');
                return sha1($strs);
            }
        }
        return '参数错误';
    }

    private function genPaySign($unifiedOrder, $time)
    {
        $appId = $this->app_id;
        $nonceStr = $unifiedOrder['nonce_str'];
        $package = 'prepay_id=' . $unifiedOrder['prepay_id'];
        $signType = "MD5";
        $timeStamp = $time;
        $key = $this->pay_key;

        return md5(sprintf("appId=%s&nonceStr=%s&package=%s&signType=%s&timeStamp=%s&key=%s", $appId, $nonceStr, $package, $signType, $timeStamp, $key));
    }

    //作用：生成签名
    private function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->pay_key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    //作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = null;
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }

            $buff .= $k . "=" . $v . "&";
//            print_r($buff);die;
        }

        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    private function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . $this->arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    //xml转换成数组
    private function xmlToArray($xml)
    {


        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);
        return $val;
    }

    private static function postXmlCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);


        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);


        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return json(['code' => 0, 'msg' => 'curl出错，错误码:' . $error, 400]);
        }
    }

}