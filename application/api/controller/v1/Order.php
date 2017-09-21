<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8 0008
 * Time: 下午 17:08
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Order as OrderService;
use app\api\validate\OrderPlace;
use think\Controller;
use app\api\service\Token;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;

class Order extends BaseController
{

    /*
     * 查询scope--前置方法---在BaseController
     * */
//    protected function needExclusiveScope()
//    {
//        $scope = TokenService::getCurrentTokenVar('scope');
//        write_log('checkExclusiveScope-->scope:'.print_r($scope,true)."\r\n",'token');
//        if($scope){
//            if($scope == ScopeEnum::User){
//                return true;
//            }else{
//                throw new ForbiddenException();
//            }
//        }else{
//            throw new TokenException();
//        }
//
//    }

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder()
    {
        $model = new OrderPlace();
        $model->goCheck();

        $products = input('post.products/a'); //获取数组
        write_log('products:' . print_r($products, true) . "\r\n", 'order');
        $uid = Token::getCurrentUid();
        write_log('uid:' . $uid . "\r\n", 'order');
        $order  = new OrderService();
        $status = $order->place($uid, $products);
        write_log('status:' . print_r($status, true) . "\r\n", 'order');
        return $status;
    }

}