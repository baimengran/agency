<?php

namespace app\admin\validate;

use think\Validate;

class Agency extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'    =>    ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'title' => 'require',
        'product'=>'checkProduct'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'    =>    '错误信息'
     *
     * @var array
     */
    protected $message = [
        'title.require' => '代理名称必须填写',
        'product'=>'代理产品填写错误',
    ];

    public function checkProduct($value,$data,$rule){
        foreach($value as $v){
            if(!array_key_exists('agency_price',$v)){
                return '请填写代理单价';
            }
            if(!array_key_exists('agency_box_price',$v)){
                return '请填写代理每箱价格';
            }
            if(!array_key_exists('first_boxful_num',$v)){
                return '请填写首次订货箱数';
            }
            if(!array_key_exists('again_boxful_num',$v)){
                return '请填写补货箱数';
            }
            if(!preg_match("/^[1-9][0-9]*$/",$v['first_boxful_num'])){
                return '首次订货箱数必须是正整数';
            }
            if(!preg_match("/^[1-9][0-9]*$/",$v['again_boxful_num'])){
                return '补货箱数必须是正整数';
            }
            if(!is_numeric($v['agency_price'])){
                return '单价填写错误';
            }
            if(!is_numeric($v['agency_box_price'])){
                return '每箱价格填写错误';
            }
        }
        return true;
    }
}
