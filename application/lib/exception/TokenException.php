<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/4
 * Time: 21:34
 */

namespace app\lib\exception;


/**
 * token验证失败时抛出此异常
 */
class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}
