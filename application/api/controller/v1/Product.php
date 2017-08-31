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
use app\lib\exception\ProductException;
use think\Exception;

class Product
{
    public function getRecent($count)
    {
        $model = new Count();
        $model->goCheck();
        $products = ProductModel::getMostRecent($count);
        if(!$products){
            throw new ProductException();
        }
        return $products;
    }
}