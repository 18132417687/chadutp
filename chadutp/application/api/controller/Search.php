<?php


namespace app\api\controller;


class Search extends Common
{
      public function index(){
            $data = request()->param();
            $list = DB::name('goods')->where('goods_title','like',"%".$data['goods_title'] ."%")->select();
            if ($list){
                $this->return_msg(200,'商品查询成功！',$list);
            }else{
                $this->return_msg(400,'商品查询失败！');
            }
        }

}