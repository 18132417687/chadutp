<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/27
 * Time: 19:55
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class User extends BaseController
{
    public function user_list(){
        $data=Db::name('user')->paginate(5);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function user_add(){
        $data = Request::instance()->param();  //获取当前请求变量
        if(!empty($data)){
            $file = request()->file('avatarurl');
            $avatarurl = $this->upload($file);
            $data['avatarurl'] = $avatarurl;
            $res =DB::name('user')->insert($data);
            if ($res){
                $this->success('新增成功！','user/user_list');
            }else {
                $this->error('新增失败！');
            }
        }else {
            return $this->fetch();
        }
    }
    public function user_edit($id){
        $da = Request::instance()->post();
        if(!empty($da)){
            $file = request()->file('avatarurl');
            $avatarurl = $this->upload($file);
            $da['avatarurl'] = $avatarurl;
            $rs = Db::name('user')->where('id',$da['id'])->update($da);
            if($rs){
                $this->success('修改成功！','user/user_list');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $data = Db::name('user')->where('id',$id)->find();
//            dump($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($id){
        $rs=db('user')->delete($id);
        if($rs){
            $this->success('删除成功','user/user_list');
        }else{
            $this->error('删除失败');
        }
    }
}