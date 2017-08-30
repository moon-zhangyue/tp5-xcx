<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix') . $value;  //本地图片
        } else {
            $finalUrl = $value;
        }
        return $finalUrl;
    }
}
