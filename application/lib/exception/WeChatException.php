<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/3
 * Time: 21:10
 */

namespace app\lib\exception;
use think\Exception;


/**
 * 微信服务器异常
 */
class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = 'wechat unknown error';
    public $errorCode = 999;
}