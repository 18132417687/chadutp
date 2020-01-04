<?php


namespace app\api\controller;


use think\Request;

class Userinfo extends Common
{
    protected function _initialize(){    //控制器的初始化方法
        $header = Request::instance()->header();
        $this->openId = $header['openid'];
        if (empty($header['openid'])) {
            echo json_encode(['status'=>false,'msg'=>'请求信息错误']);exit();
        }else{
            $user = db('user')->where('openId',$header['openid'])->field(true)->find();
            if (!$user) {
                echo json_encode(['status'=>false,'msg'=>'用户信息错误']);exit();
            }else{
                if ($user['id'] != intval($header['id'])) {
                    echo json_encode(['status'=>false,'msg'=>'用户信息不匹配']);exit();
                }else{
                    $this->id = $user['id'];
                }
            }
        }
    }

}