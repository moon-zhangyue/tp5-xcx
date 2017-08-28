<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/28 0028
 * Time: 上午 11:23
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code      = 404;
    public $msg       = '参数错误';
    public $errorCode = 10000;
}