<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/21 0021
 * Time: 上午 11:44
 */

namespace app\api\service;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');//对外接口,引入此文件

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        
    }
}