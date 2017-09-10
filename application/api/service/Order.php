<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9 0009
 * Time: 下午 13:43
 */

namespace app\api\service;

use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\Order as OrderModel;
use app\api\model\UserAddress;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    protected $oProducts; //订单的商品列表,客户端传过来的订单列表
    protected $products;  //真实的商品信息(包括库存量)
    protected $uid;


    /**
     * @param int $uid 用户id
     * @param array $oProducts 订单商品列表
     * @return array 订单商品状态
     * @throws Exception
     */
    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->products  = $this->getProductsByOrder($oProducts);
        $this->uid       = $uid;
        $status          = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        $orderSnap      = $this->snapOrder();
        $status         = self::createOrderByTrans($orderSnap);
        $status['pass'] = true;
        return $status;
    }

    // 预检测并生成订单快照
    private function snapOrder()
    {
        // status可以单独定义一个类
        $snap = [
            'orderPrice'  => 0,
            'totalCount'  => 0,
            'pStatus'     => [],
//            'snapAddress' => json_encode($this->getUserAddress()),
            'snapAddress' => json_encode('东大街'),
            'snapName'    => $this->products[0]['name'],
            'snapImg'     => $this->products[0]['main_img_url'],
        ];

        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }


        for ($i = 0; $i < count($this->products); $i++) {
            $product  = $this->products[$i];
            $oProduct = $this->oProducts[$i];

            $pStatus            = $this->snapProduct($product, $oProduct['count']);
            $snap['orderPrice'] += $pStatus['totalPrice'];
            $snap['totalCount'] += $pStatus['count'];
            array_push($snap['pStatus'], $pStatus);
        }
        return $snap;
    }

    // 单个商品库存检测
    private function snapProduct($product, $oCount)
    {
        $pStatus = [
            'id'           => null,
            'name'         => null,
            'main_img_url' => null,
            'count'        => $oCount,
            'totalPrice'   => 0,
            'price'        => 0
        ];

        $pStatus['counts'] = $oCount;
        // 以服务器价格为准，生成订单
        $pStatus['totalPrice']   = $oCount * $product['price'];
        $pStatus['name']         = $product['name'];
        $pStatus['id']           = $product['id'];
        $pStatus['main_img_url'] = $product['main_img_url'];
        $pStatus['price']        = $product['price'];
        return $pStatus;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass'         => true,
            'orderPrice'   => 0,
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$userAddress) {
            throw new UserException(
                [
                    'msg'       => '用户收货地址不存在，下单失败',
                    'errorCode' => 60001,
                ]);
        }
        return $userAddress->toArray();
    }


    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex  = -1;
        $pStatus = [
            'id'         => null,
            'haveStock'  => false,
            'count'      => 0,
            'name'       => '',
            'totalPrice' => 0
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }

        if ($pIndex == -1) {
            // 客户端传递的productid有可能根本不存在
            throw new OrderException(
                [
                    'msg' => 'id为' . $oPID . '的商品不存在，订单创建失败'
                ]);
        } else {
            $product               = $products[$pIndex];
            $pStatus['id']         = $product['id'];
            $pStatus['name']       = $product['name'];
            $pStatus['count']      = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }


    // 根据订单查找真实商品
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        // 为了避免循环查询数据库
        $products = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }

    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    private function createOrderByTrans($snap)
    {
        try {
            $orderNo             = $this->makeOrderNo();
            $order               = new OrderModel();
            $order->user_id      = $this->uid;
            $order->order_no     = $orderNo;
            $order->total_price  = $snap['orderPrice'];
            $order->total_count  = $snap['totalCount'];
            $order->snap_img     = $snap['snapImg'];
            $order->snap_name    = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items   = json_encode($snap['pStatus']);
            $order->save();

            $orderID     = $order->id;
            $create_time = $order->create_time;

            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            return [
                'order_no'    => $orderNo,
                'order_id'    => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function makeOrderNo()
    {
        $yCode   = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

}