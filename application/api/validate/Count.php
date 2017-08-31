<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/8/31
 * Time: 22:40
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15',
    ];
}