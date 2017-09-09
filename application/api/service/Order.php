<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9 0009
 * Time: 下午 13:43
 */

namespace app\api\service;


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
            'snapAddress' => json_encode($this->getUserAddress()),
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

}