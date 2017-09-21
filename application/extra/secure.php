<?php
/**
 * 敏感信息配置文件
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/4
 * Time: 21:25
 */
//盐--随机无意义字符串
return [
    'token_salt'   => 'HHstDKWADJAWDLdw',
    'pay_back_url' => 'http://www.tp-xcx.com/index.php/api/v1/pay/notify'
    //此地址可以是真实地址,也可以用Ngrok做内网穿透
];