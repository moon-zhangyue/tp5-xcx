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
        //ASP面向切面过程
        $validate = new IDMustBePositivelent();
        $validate->goCheck();

        $banner = BannerModel::getBannerByID($id);
//        $data = $banner->toArray();  //转换成数组
//        unset($data['delete_time']); //删除某些字段
        $banner->hidden(['update_time','delete_time']); //自带隐藏字段
//        $banner->visible(['id']); //设置显示字段

//        $banner = BannerModel::get($id);

//        $banner = new BannerModel();
//        $banner = $banner->get($id);

//        $banner =  BannerModel::with(['items','items.img'])->find($id);

        if (!$banner) {
            throw new BannerMissException();
        }
        return json($banner);

//        $result = $validate->batch()->check($data);
//        if($result){
//
//        }else{
//
//        }
//        dump($validate->getError());
    }
}