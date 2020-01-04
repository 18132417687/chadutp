<?php


namespace app\api\controller;


class Search extends Common
{
    public function index(){
        $map['r_name'] = [['like', 'goods_title%']];
        $list = Db::table("goods")->fetchSql(true)->where($map)->select();
        dump($list);
//        $result = DB::name('goods')->where('biaoqian_name','like',"%".$goods_title."%")->select();
    }

}