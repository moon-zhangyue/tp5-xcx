<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16 0016
 * Time: 下午 15:20
 */

namespace app\sample\controller;


class Test
{
    public function hello($id,$name,$age)
    {
        echo $id;
        echo $name;
        echo $age;
        return 'hello,haha';
    }
}