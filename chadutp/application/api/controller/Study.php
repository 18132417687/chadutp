<?php


namespace app\api\controller;


use think\Db;

class Study extends Common
{
    public function index(){
        $data = Db::name('study')->select();
        if ($data){
            $this->return_msg(200,'学茶文章、视频传输成功！',$data);
        }else{
            $this->return_msg(400,'学茶文章、视频传输失败！');
        }
    }

}