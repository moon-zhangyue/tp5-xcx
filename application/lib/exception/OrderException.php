<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9 0009
 * Time: 下午 14:44
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code      = 404;
    public $msg       = '订单不存在，请检查ID';
    public $errorCode = 80000;
}