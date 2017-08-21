<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 14:03
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePositivelent extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected function isPositiveInteger($value , $rule = '' , $data = '' , $field = '')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0 ){
            return true;
        }else{
            return $field.'必须是正整数';
        }
    }
}