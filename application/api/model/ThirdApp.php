<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/5
 * Time: 22:30
 */

namespace app\api\model;


use think\Model;

class ThirdApp extends BaseModel
{
    public static function check($ac, $se)
    {
        $app = self::where('app_id','=',$ac)
            ->where('app_secret', '=',$se)
            ->find();
        return $app;

    }
}
