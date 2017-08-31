<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31 0031
 * Time: 下午 16:37
 */

namespace app\api\validate;


use think\Validate;

class IDCollection extends BaseValidate
{
    protected  $rule = ['ids' => 'require|checkIDs'];

    protected $message = [
        'ids' => 'ids参数必须为以逗号分隔的多个正整数'
    ];

    protected  function checkIDs($ids)
    {
        $values = explode(',',$ids);

        if(empty($values) || !is_array($values)){
            return false;
        }

        foreach ($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false; //必须正整数
            }
        }
        return true;
    }
}