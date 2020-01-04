<?php


namespace app\api\controller;


use think\Db;

class Banner extends Common
{
    public function index(){
        $data=Db::name('banner')->select();
        if ($data){
            $this->return_msg(200,'轮播图传输成功！',$data);
        }else{
            $this->return_msg(400,'轮播图传输失败！');

        }
    }

}