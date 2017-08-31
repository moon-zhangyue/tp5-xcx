<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31 0031
 * Time: 下午 15:47
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;

class Theme
{
    /*
     * @url /theme?ids=id1,id2,id3.....
     * @return 一组theme模型
     * */
    public function getSimpleList($ids='')
    {
        $model = new IDCollection();
        $model->goCheck();
        return 'success';
    }
}