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
use app\api\validate\PagingParameter;
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


    /**
     * 根据用户id分页获取订单列表（简要信息）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new PagingParameter())->goCheck();
        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }

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