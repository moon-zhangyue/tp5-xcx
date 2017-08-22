<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22 0022
 * Time: 下午 15:56
 */

namespace app\lib\exception;


class BaseException
{
    //http状态码 404 200
    public $code = 400;

    //错误具体信息
    public $msg = 'params error';

    //自定义的错误码
    public $errorCode = 10000;



}