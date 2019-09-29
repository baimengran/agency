<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/2
 * Time: 17:41
 */


use think\facade\Env;

return [
    'token'=>Env::get('TOKEN'),
    'app_id'=>Env::get('APPID'),
    'app_secret'=>Env::get('APPSECTET'),
    'token_url'=>Env::get('TOKENURL'),
    'menu_url'=>Env::get('MENUURL'),
    'auth'=>Env::get('AUTH'),
    'mch_id'=>Env::get('MCHID'),
    'pay_key'=>Env::get('PAYKEY'),
];

