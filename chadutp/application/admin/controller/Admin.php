<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class Admin extends Controller
{
    public function admin_list(){
        $data = Db::name('admin')->paginate(10);   //查询数据库表名    分页
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function admin_add(){
        $data = Request::instance()->param();      //获取当前请求参数
        if(!empty($data)){
            $rs = Db::name('admin')->insert($data);
            if($rs){
                $this->success('新增成功！','admin/admin_list');
            }else{
                $this->error('新增失败！');
            }
        }else {
            return $this->fetch();
        }
    }
    public function admin_edit($id){
        $da = Request::instance()->post();
        if(!empty($da)){
            $rs = Db::name('admin')->where('id',$da['id'])->update($da);
            if($rs){
                $this->success('修改成功！','admin/admin_list');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $data = Db::name('admin')->where('id',$id)->find();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($id){
        $rs=Db::name('admin')->delete($id);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}