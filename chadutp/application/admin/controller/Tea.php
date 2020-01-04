<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class Tea extends BaseController
{
    public function tea_list(){
        $data = Db::name('tea')
            ->alias('t')
            ->field('t.tea_id,t.tea_name,t.tea_img,c.category_name')
            ->join('category c','t.category_id=c.category_id')
            ->paginate(10);
        $this->assign('data',$data);
        return $this->fetch();

    }
    public function tea_add(){
        $data = input('post.');
//        $data = Request::instance()->param();      //获取当前请求参数
        $category = Db::name('category')->select();
        $this->assign('category',$category);
//        dump($data);
        if(!empty($data)){
            $file = request()->file('tea_img');
            $tea_img = $this->upload($file);
            $data['tea_img'] = $tea_img;
            $rs = Db::name('tea')->insert($data);
            if($rs){
                $this->success('新增成功！','tea/tea_list');
            }else{
                $this->error('新增失败！');
            }
        }else {
            return $this->fetch();
        }
    }
    public function tea_edit($tea_id){
        $da = Request::instance()->post();
        $category = Db::name('category')->select();
        $this->assign('category',$category);
//        dump($da);
        if(!empty($da)){
            $file = request()->file('tea_img');
            $tea_img = $this->upload($file);
            $da['tea_img'] = $tea_img;
            $rs = Db::name('tea')->where('tea_id',$da['tea_id'])->update($da);
            if($rs){
                $this->success('修改成功！','tea/tea_list');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $data = Db::name('tea')->where('tea_id',$tea_id)->find();
//            dump($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($tea_id){
        $rs=Db::name('tea')->delete($tea_id);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


}