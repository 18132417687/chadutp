<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class Study extends Controller
{
    public function study_list(){
        $data = Db::name('study')->paginate(10);   //查询数据库表名    分页
        //        print_r($data);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function study_add(){
        $data = Request::instance()->param();      //获取当前请求参数
//        dump($data);
        if(!empty($data)){
            $rs = Db::name('study')->insert($data);
            if($rs){
                $this->success('新增成功！','study/study_list');
            }else{
                $this->error('新增失败！');
            }
        }else {
            return $this->fetch();
        }
    }
    public function study_edit($study_id){
        $da = Request::instance()->post();
//        dump($da);
        if(!empty($da)){
            $rs = Db::name('study')->where('study_id',$da['study_id'])->update($da);
            if($rs){
                $this->success('修改成功！','study/study_list');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $data = Db::name('study')->where('study_id',$study_id)->find();
//            dump($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($study_id){
        $rs=Db::name('study')->delete($study_id);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


}