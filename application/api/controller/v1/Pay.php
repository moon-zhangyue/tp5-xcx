<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/10
 * Time: 16:21
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositivelent;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];


    /*
     * 预订单信息
     * param $id--订单id
     */
    public function getPreOrder($id = '')
    {
        $model = new IDMustBePositivelent();//正整数检测
        $model->goCheck();

        $pay = new PayService($id);
        return $pay->pay();
    }

    //接受微信通知--每隔一段时间就调用
    public function redirectNotify()
    {
        //1.检查库存-更新订单状态-减库存-成功返回处理信息
        //post:xml格式:不会携带参数
        $notify = new WxNotify();
        $notify->handle();
    }
}