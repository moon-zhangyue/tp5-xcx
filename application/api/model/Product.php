<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31 0031
 * Time: 下午 15:47
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'
    ];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    /**
     * 获取某分类下商品
     * @param $categoryID
     * @param int $page
     * @param int $size
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getProductsByCategoryID($categoryID)
    {
        $procudts = self::where('category_id', '=', $categoryID)->select();
        return $procudts;
    }
}