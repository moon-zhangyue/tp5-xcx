<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 上午 11:42
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code      = 404;
    public $msg       = 'The category is not found,Please check the params';
    public $errorCode = 50000;
}