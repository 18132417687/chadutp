<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class Category extends BaseController
{
    public function category_list(){
        $data = Db::name('category')->paginate(5);   //查询数据库表名    分页
        //        print_r($data);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function category_add(){
        $data = Request::instance()->param();  //获取当前请求变量
//        $data = input('post.');

//        dump($data);
        if(!empty($data)){
            $file = request()->file('category_img');    //请求input表单里的file
            $category_img = $this->upload($file);     //file的值给upload
            $data['category_img'] = $category_img;     //把拿到的值给前端页面
            $rs = Db::name('category')->insert($data);
            if($rs){
                $this->success('新增成功！','category/category_list');
            }else{
                $this->error('新增失败！');
            }
        }else {
            return $this->fetch();
        }
    }
    public function category_edit($category_id){
        $da = Request::instance()->post();
//        $da = input('post.');
//        dump($da);
        if(!empty($da)){
            $file = request()->file('category_img');
            $category_img = $this->upload($file);
            $da['category_img'] = $category_img;
            $rs = Db::name('category')->where('category_id',$da['category_id'])->update($da);
            if($rs){
                $this->success('修改成功！','category/category_list');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $data = Db::name('category')->where('category_id',$category_id)->find();
//            dump($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($category_id){
        $rs=Db::name('category')->delete($category_id);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}