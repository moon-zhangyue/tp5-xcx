<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18 0018
 * Time: 下午 15:29
 */

namespace app\api\controller\v1;


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
        $data = [
            'name'=>'vendorddsaaa',
            'email'=>'vendor@qq.com',
        ];
        $validate = new Validate([
           'name' => 'require|max:10',
            'email' => 'email',
        ]);
        $result = $validate->check($data);

    }
}