<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/4
 * Time: 23:09
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}