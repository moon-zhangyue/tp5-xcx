<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31 0031
 * Time: 下午 15:47
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositivelent;
use app\lib\exception\ThemeException;
use think\Controller;
use think\Db;

class Theme extends Controller
{
    /*
     * @url /theme?ids=id1,id2,id3.....
     * @return 一组theme模型
     * */
    public function getSimpleList($ids='')
    {
        $model = new IDCollection();
        $model->goCheck();

        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg','headImg')->select($ids);
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id)
    {
        $model = new IDMustBePositivelent();
        $model->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw new ThemeException();
        }
        return $theme;
    }
}