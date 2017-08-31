<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'topic_img_id', 'head_img_id'];

    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }

}
