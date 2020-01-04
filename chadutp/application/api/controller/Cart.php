<?php


namespace app\api\controller;


use think\Db;

class Cart extends Common
{
    public function index(){
        $data = Db::name('cart')->select();
        if ($data){
            $this->return_msg(200,'购物车列表传输成功！',$data);
        }else{
            $this->return_msg(400,'购物车列表传输失败！');
        }
    }
    // 添加购物车
    public function add(){
            $data = $this->params;
            $list = db('cart')->where(array('goods_id'=>$data['goods_id']))->find();
            if($list){
                $db_res = db('cart')->where(array('goods_id'=>$data['goods_id']))->setInc('num',$data['num']);   //setInc将数字字段值增加
                if($db_res){
                    $db_res = Db::name('cart')->select();
                    $this->return_msg(200,'加入购物车成功！',$db_res);
                }else{
                    $this->return_msg(400,'加入购物车失败！');
                }
        }else{
            $db_res = db('cart')->insert($data);
            if($db_res){
                $db_res = Db::name('cart')->select();
                $this->return_msg(200,'加入购物车正确',$db_res);
            }else{
                $this->return_msg(400,'加入购物车失败');
            }
        }
    }
//    // 数量加减购物车
//    public function num(){
//        $data = $this->params;
//        $db_res = db('cart')->where(array('goods_id'=>$data['goods_id']))->update(array('goods_number'=>$data['goods_number']));
//        if($db_res){
//            $this->return_msg(200,'数量修改正确',$db_res);
//        }else{
//            $this->return_msg(400,'数量修改失败');
//        }
//    }
    // 删除购物车
    public function del(){
        $data = $this->params;
        $db_res = db('cart')->where(array('goods_id'=>$data['goods_id']))->delete();
        if($db_res){
            $data = Db::name('cart')->select();
            $this->return_msg(200,'删除购物车成功！',$data);
        }else{
            $this->return_msg(400,'删除购物车失败！');
        }
    }
    //购物车商品数量减少
    public function numreduce(){
        $data = $this->params;
        $list = db('cart')->where(array('goods_id'=>$data['goods_id']))->find();
        if($list){
            $db_res = db('cart')->where(array('goods_id'=>$data['goods_id']))->update(array('num'=>$data['num']));
            if($db_res){
                $this->return_msg(200,'商品数量减少成功！',$db_res);
            }else{
                $this->return_msg(400,'商品数量减少失败！');
            }
        }else{
            $db_res = db('cart')->insert($data);
            if($db_res){
                $this->return_msg(200,'商品数量减少正确',$db_res);
            }else{
                $this->return_msg(400,'商品数量减少失败');
            }
        }
    }
    //购物车商品数量增加
    public function numadd(){
        $data = $this->params;
        $list = db('cart')->where(array('goods_id'=>$data['goods_id']))->find();
        if($list){
            $db_res = db('cart')->where(array('goods_id'=>$data['goods_id']))->update(array('num'=>$data['num']));
            if($db_res){
                $this->return_msg(200,'商品数量增加成功！',$db_res);
            }else{
                $this->return_msg(400,'商品数量增加失败！');
            }
        }else{
            $db_res = db('cart')->insert($data);
            if($db_res){
                $this->return_msg(200,'商品数量增加正确',$db_res);
            }else{
                $this->return_msg(400,'商品数量增加失败');
            }
        }
    }



}