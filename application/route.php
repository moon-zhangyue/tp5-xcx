<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

use think\Route;

//Route::rule('hello','sample/Test/hello');
//Route::post('hello/:id','sample/Test/hello');

//Route::rule('hello','sample/Test/hello');

//Banner
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner'); //首页banner图路由
//Theme
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList'); //主题列表路由
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne'); //主题路由

//Product
//Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory'); //获取某分类下全部商品路由
//Route::get('api/:version/product/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']); //获取商品详情路由
//Route::get('api/:version/product/recent', 'api/:version.Product/getRecent'); //最近新品路由


//路由分组---批量设定路由---内部写法一样
Route::group('api/:version/product',function(){
    Route::get('/by_category', 'api/:version.Product/getAllInCategory'); //获取某分类下全部商品路由
    Route::get('/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']); //获取商品详情路由
    Route::get('/recent', 'api/:version.Product/getRecent'); //最近新品路由
});

//Category
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories'); //商品分类列表路由

//Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
//Route::post('api/:version/token/app', 'api/:version.Token/getAppToken'); //最后用的获取token接口
Route::post('api/:version/token/app', 'api/:version.Token/getToken'); //现在用获取token接口
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

//Address
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');//更新用户地址信息


Route::get('api/:version/checkPrimaryScope', 'api/:version.Address/checkPrimaryScope');//测试前置操作




