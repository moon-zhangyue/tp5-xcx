<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22 0022
 * Time: 下午 15:56
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    //http状态码 404 200
    public $code = 400;

    //错误具体信息
    public $msg = 'params error';

    //自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        if (!is_array($params)) {
            throw new Exception('参数必须是数组');
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }

}