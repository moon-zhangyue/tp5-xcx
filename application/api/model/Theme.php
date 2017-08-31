<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31 0031
 * Time: 下午 15:50
 */

namespace app\api\model;

use think\Model;

class Theme extends BaseModel
{
    public function topicImg()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }

    public function products()
    {
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

}