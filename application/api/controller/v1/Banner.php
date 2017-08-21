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
use think\Validate;

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
        (new IDMustBePositivelent())->goCheck();
        $validate = new IDMustBePositivelent();

        $result = $validate->batch()->check($data);
        if($result){

        }else{

        }
        dump($validate->getError());
    }
}