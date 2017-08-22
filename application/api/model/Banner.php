<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22 0022
 * Time: 下午 14:41
 */

namespace app\api\model;


use think\Exception;

class Banner
{
    public static function getBannerByID($id)
    {
         //TODO: 根据Bnaner ID号  获取Banner信息
        try{
            1/0;
        } catch (Exception $ex){
            //TODO 可以记录日志
            throw $ex;
            return 'This is info of Banner';
        }

    }
}