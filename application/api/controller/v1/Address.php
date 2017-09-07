<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 下午 14:07
 */

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\service\Token as TokenService;
use app\lib\exception\UserException;
use think\Controller;

class Address extends Controller
{
    protected $beforeActionList = [
        'first' => 'only','second'
    ];

    public function first()
    {
        echo 'a';
    }

    public function second()
    {
        echo 'b';
    }

    /**
     * 获取用户地址信息
     * @return UserAddress
     * @throws UserException
     */
    public function getUserAddress()
    {
        $uid         = Token::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if (!$userAddress) {
            throw new UserException([
                'msg'       => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();
        //根据token获取uid
        //根据uid查找用户数据,判断用户是否存在
        //用户存在 获取用户从客户端提交的信息
        //根据用户信息判断 添加还是更新
        $uid  = TokenService::getCurrentUid();
        $user = User::get($uid);
        if (!$user) {
            throw new UserException();
        }
        $dataArray = $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;
        if (!$userAddress) {
            $user->address()->save($dataArray);
        } else {
            $user->address->save($dataArray);
        }
        return json(new SuccessMessage(),201);
    }
}