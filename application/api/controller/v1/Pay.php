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

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];


    //预订单信息
    public function getPreOrder($id = '')
    {
        $model = new IDMustBePositivelent();
        $model->goCheck();

        $pay = new PayService($id);
        return $pay->pay();
    }