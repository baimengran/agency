<?php

namespace app\index\validate;

use think\Validate;

class DeliverGoods extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'id'=>'require|number',
        's_num'=>'require|number',
        'num'=>'require|number',
        'consignee'=>'require|min:2|max:25',
        'phone'=>["require"|"regex"=>"/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/"],
        'address'=>'require|max:100',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'product_id.require'=>'发货产品错误',
        'product_id.number'=>'发货产品错误',
        's_num.require'=>'剩余数量错误',
        'num.require'=>'请输入数量',
        'num.number'=>'数量输入错误',
        'consignee.require'=>'请输入收货人名称',
        'consignee.min'=>'收货人名称不能小于两个字',
        'consignee.max'=>'收货人数量不呢个大于25个字',
        'phone.require'=>'请输入收货人电话',
        'phone.regex'=>'请输入正确手机号或座机',
        'address.require'=>'请输入收货人地址',
        'address.max'=>'收货地址字数不能超过100个字'
    ];
}
