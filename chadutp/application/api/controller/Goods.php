<?php


namespace app\api\controller;


use think\Db;

class Goods extends Common
{
    public function index(){
        //获取数据
        $data = $this->params;
        //查询数据库，根据茶种分类id连表查找商品
        $res = Db::name('goods')
            ->alias('g')
            ->field('g.goods_id,t.tea_name,g.selected,g.goods_title,g.goods_price,
            g.goods_reprice,g.goods_number,g.goods_address,g.goods_img,g.goods_img1,
            g.goods_img2,g.goods_img3,g.goods_banner1,g.goods_banner2,g.goods_banner3')
            ->join('tea t','t.tea_id = g.tea_id')
            ->where(['g.tea_id' =>$data['tea_id']])
            ->select();
        //判断数据是否传输成功
        if ($res){
            $this->return_msg(200,'茶种商品列表传出成功！',$res);
        }else{
            $this->return_msg(400,'茶种商品列表传输失败！');
        }
    }
}