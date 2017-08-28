<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18 0018
 * Time: 下午 15:29
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositivelent;
use app\api\validate\TestValidate;
use app\lib\exception\BannerMissException;
use think\Exception;
use think\Validate;
use app\api\model\Banner as BannerModel;

class Banner
{
    /*
     * 获取制定id的banner信息
     *
     * @id banner的id
     * @url /banner/:id
     * @http    get
     * @return  array of banner item , code 200
     * @throws  MissException
     *
     * */
    public function getBanner($id)
    {
        $validate = new IDMustBePositivelent();
        $validate->goCheck();

//        $banner  = BannerModel::getBannerByID($id);

        $banner = BannerModel::get($id);

        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;

//        $result = $validate->batch()->check($data);
//        if($result){
//
//        }else{
//
//        }
//        dump($validate->getError());
    }
}