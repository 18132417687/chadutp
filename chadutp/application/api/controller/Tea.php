<?php


namespace app\api\controller;


use think\Db;

class Tea extends Common
{
    public function index(){
        $data = $this->params;
        $res = Db::name('tea')
            ->alias('t')
            ->field('t.tea_id,c.category_id,t.tea_name,t.tea_img')
            ->join('category c','t.category_id=c.category_id')
            ->where(['t.category_id' =>$data['category_id']])
            ->select();
        if ($res){
            $this->return_msg(200,'茶种分类传输成功！',$res);
        }else{
            $this->return_msg(400,'茶种分类传输失败！');
        }
    }

}