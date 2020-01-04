<?php


namespace app\api\controller;


use think\Db;

class Category extends Common
{
    public function index(){
        //查询数据库
        $data=Db::name('category')->select();
        //判断数据是否传输成功
        if ($data){
            $this->return_msg(200,'分类数据传输成功！',$data);
        }else{
            $this->return_msg(400,'分类数据传输失败！');
        }
    }

}