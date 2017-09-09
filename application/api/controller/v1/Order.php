<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8 0008
 * Time: 下午 17:08
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use think\Controller;
use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;

class Order extends BaseController
{

    /*
     * 查询scope--前置方法---在BaseController
     * */
//    protected function needExclusiveScope()
//    {
//        $scope = TokenService::getCurrentTokenVar('scope');
//        write_log('checkExclusiveScope-->scope:'.print_r($scope,true)."\r\n",'token');
//        if($scope){
//            if($scope == ScopeEnum::User){
//                return true;
//            }else{
//                throw new ForbiddenException();
//            }
//        }else{
//            throw new TokenException();
//        }
//
//    }

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder()
    {

    }
}