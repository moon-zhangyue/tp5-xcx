<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/10
 * Time: 20:10
 */

namespace app\api\service;


class Pay
{
    private $orderNo;
    private $orderID;

    function __construct($orderID)
    {
        if (!$orderID)
        {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {

    }
}