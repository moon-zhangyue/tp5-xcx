<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9 0009
 * Time: 上午 10:59
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }

    /*
     * 查询scope
   * */
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    protected function checkSuperScope()
    {
//        Token::needSuperScope();
    }

}