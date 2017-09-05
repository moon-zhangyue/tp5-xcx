<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 下午 16:36
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code      = 404;
    public $msg       = '用户不存在';
    public $errorCode = 60000;
}