<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22 0022
 * Time: 下午 14:41
 */

namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

class Banner extends Model
{
    public static function getBannerByID($id)
    {
//        $result = Db::query('select * from banner_item where banner_id = ?', [$id]);
//        $result = Db::table('banner_item')
//            ->where(function ($query) use ($id) {
//                $query->where('banner_id', '=', $id);
//            })->select();
        //表达式/数组/闭包

        $result = Db::table('banner_item')
            ->where(function ($query) use ($id) {
                $query->where('banner_id', '=', $id);
            })->select();

        return $result;

    }
}