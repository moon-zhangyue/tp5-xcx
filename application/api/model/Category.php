<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 上午 11:00
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = [
        'delete_time', 'create_time', 'update_time'
    ];

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

}