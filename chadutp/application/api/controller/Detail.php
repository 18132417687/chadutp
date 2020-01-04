<?php


namespace app\api\controller;


use think\Db;

class Detail extends Common
{
    public function index(){
        //获取数据
        $data = $this->params;
        //连接数据库，根据商品id查找商品
        $res = Db::name('goods')->where(array('goods_id'=>$data['goods_id']))->find();
        if($res){
            $this->return_msg(200,'商品详情内容传输成功!',$res);
        }else{
            $this->return_msg(400,'商品详情内容传输失败！');
        }
    }
}