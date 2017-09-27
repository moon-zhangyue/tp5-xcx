<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/8/31
 * Time: 22:38
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositivelent;
use app\lib\exception\ProductException;
use think\Exception;
use app\api\controller\BaseController;

class Product
{
    public function getRecent($count)
    {
        $model = new Count();
        $model->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
//        $collection = collection($products);
        $products = $products->hidden(['summary']); //数据集隐藏字段
        return $products;
    }


    /**
     * 获取某分类下全部商品(不分页）
     * @url /product/all?id=:category_id
     * @param int $id 分类id号
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getAllInCategory($id)
    {
        $model = new IDMustBePositivelent();
        $model->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $data = $products->hidden(['summary']);
        return $data;
    }

    /**
     * 获取商品详情
     * 如果商品详情信息很多，需要考虑分多个接口分布加载
     * @url /product/:id
     * @param int $id 商品id号
     * @return Product
     * @throws ProductException
     */
    public function getOne($id)
    {
        $model = new IDMustBePositivelent();
        $model->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }

    /*
     * 删除商品
     * */
    public function delOne($id)
    {

    }
}