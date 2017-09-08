<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8 0008
 * Time: 上午 11:25
 */

namespace app\lib\exception;


/**
 * token验证失败时抛出此异常
 */
class ForbiddenException extends BaseException
{
    public $code      = 403;
    public $msg       = '权限不够';
    public $errorCode = 10001;
}