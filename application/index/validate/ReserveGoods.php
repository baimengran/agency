<?php

namespace app\index\validate;

use think\Validate;

class ReserveGoods extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'product_id'=>'require|number',
        'price'=>'require|float',
        'num'=>'require|number',
        'total_price'=>'require|float',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'product_id.require'=>'商品必须选择',
        'product_id.number'=>'商品错误',
        'price.require'=>'单价必须填写',
        'price.float'=>'单价填写错误',
        'num.require'=>'数量必须填写',
        'num.number'=>'数量填写错误',
        'total_price.require'=>'总价错误',
        'total_price.float'=>'总价错误'
    ];
}
