<?php

namespace app\admin\controller;

use think\Db;
use think\Request;

class Goods extends MoreController
{
    public function goods_list()
    {
        //查询数据库
        $data = Db::name('goods')
            ->alias('g')
            ->field('g.goods_id,t.tea_name,g.goods_title,g.goods_price,g.goods_reprice,
            g.goods_number,g.goods_address,g.goods_img,g.goods_img1,g.goods_img2,g.goods_img3,
            g.goods_banner1,g.goods_banner2,g.goods_banner3')
            ->join('tea t', 't.tea_id = g.tea_id')//联表
            ->order('goods_id asc')//由小到大将商品id排序
            ->paginate(10);         //分页
        $this->assign('data', $data);  //对模板变量进行赋值
        return $this->fetch();               //展示数据
    }

    public function goods_add()
    {
        $da = input('post.');//获取当前请求参数
        $tea = Db::name('tea')->select(); //查询数据库
        $this->assign('tea', $tea);   //对模板变量进行赋值
        $file = request()->file('image'); //上传图片
        if ($file) {
            $fileName = $this->upload($file);
            foreach ($fileName as $value) {  //循环遍历所要上传的图片
                $data = [
                    'goods_img' => $value[0],
                    'goods_banner1' => $value[1],
                    'goods_banner2' => $value[2],
                    'goods_banner3' => $value[3],
                    'goods_img1' => $value[4],
                    'goods_img2' => $value[5],
                    'goods_img3' => $value[6],
                ];
                $res = array_merge_recursive($da, $data);//把图片文字两个数组合并为一个数组
                $rs = Db::name('goods')->insert($res); //将数据插入到数据库中
                if ($rs) {
                    $this->success('新增成功！', 'goods/goods_list');
                } else {
                    $this->error('新增失败！');
                }
            }
        } else {
            return $this->fetch();
        }
    }

    public function goods_edit($goods_id){
        $da = Request::instance()->post();       //获取当前请求参数
        $tea = Db::name('tea')->select(); //选择分类
        $this->assign('tea', $tea);        //对模板变量进行赋值
        $file = request()->file('image'); //上传图片
        if ($file) {
            $fileName = $this->upload($file);
            foreach ($fileName as $value) {       //循环遍历所要上传的图片
                $data = [
                    'goods_img' => $value[0],
                    'goods_banner1' => $value[1],
                    'goods_banner2' => $value[2],
                    'goods_banner3' => $value[3],
                    'goods_img1' => $value[4],
                    'goods_img2' => $value[5],
                    'goods_img3' => $value[6],
                ];
                $da[] = $data;
                $result = [];
                //对数组中的每个元素应用用户自定义函数
                //把二维数组转化为一维数组
                array_walk_recursive($da, function ($value) use (&$result) {
                    array_push($result, $value);
                });
                $info = [
                    'goods_id' => $result[0],
                    'goods_title' => $result[1],
                    'tea_id' => $result[2],
                    'goods_price' => $result[3],
                    'goods_reprice' => $result[4],
                    'goods_number' => $result[5],
                    'goods_address' => $result[6],
                    'goods_img' => $result[7],
                    'goods_banner1' => $result[8],
                    'goods_banner2' => $result[9],
                    'goods_banner3' => $result[10],
                    'goods_img1' => $result[11],
                    'goods_img2' => $result[12],
                    'goods_img3' => $result[13],
                ];
                //修改数据库中的内容
                $rs = Db::name('goods')->where('goods_id', $info['goods_id'])->update($info);
                if ($rs) {
                    $this->success('修改成功！', 'goods/goods_list');
                } else {
                    $this->error('修改失败！');
                }
            }
        } else {
            $data = Db::name('goods')->where('goods_id', $goods_id)->find();
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    public function del($goods_id){
        //根据id将商品删除
        $rs = Db::name('goods')->delete($goods_id);
        if ($rs) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}