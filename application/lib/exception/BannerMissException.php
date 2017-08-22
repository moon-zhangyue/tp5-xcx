<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22 0022
 * Time: 下午 16:25
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code     = 404;
    public $msg      = 'Request banner is not found';
    public $errorCod = 40000;
}