<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 17:46
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取http传入的参数
        //对参数做校验
        $request = Request::instance();
        $params  = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
//                'code'      => 400,
//                'errorCode' => 10002
            ]);
//            $e->msg = $this->error;
            throw $e;
//            $error = $this->getError();
//            throw new Exception($error);
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return false;
    }
}