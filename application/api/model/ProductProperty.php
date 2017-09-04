<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/4
 * Time: 23:10
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden=['product_id', 'delete_time', 'id'];
}