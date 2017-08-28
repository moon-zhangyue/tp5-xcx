<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22 0022
 * Time: 下午 15:54
 */

namespace app\lib\exception;

use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    //需要返回客户端当前请求的URL路径
    public function render(\Exception $e)
    {

        //instanceof 用于确定一个 PHP 变量是否属于某一类 class 的实例
        if ($e instanceof BaseException) {
            //自定义异常
            $this->code      = $e->code;
            $this->msg       = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code      = 500;
                $this->msg       = 'Service Error';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }

        //请求的值
        $request = Request::instance();

        $result = [
            'msg'         => $this->msg,
            'errorCode'   => $this->errorCode,
            'requset_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e)
    {
        Log::init([
            'type'  => 'File',
            'path'  => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(), 'error');
    }
}