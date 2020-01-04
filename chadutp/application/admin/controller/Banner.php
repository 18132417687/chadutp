<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class Banner extends BaseController
{
    public function banner_list(){
        $data = Db::name('banner')->paginate(3);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function banner_add(){
        $data = Request::instance()->param();  //获取当前请求变量
        if(!empty($data)){
            $file = request()->file('banner_img');
            $banner_img = $this->upload($file);
            $data['banner_img'] = $banner_img;
            $res =DB::name('banner')->insert($data);
            if ($res){
                $this->success('新增成功！','banner/banner_list');
            }else {
                $this->error('新增失败！');
            }
        }else {
            return $this->fetch();
        }
    }
    public function banner_edit($banner_id){
        $da = Request::instance()->post();
//        $da = input('post.');
//        dump($da);
        if(!empty($da)){
            $file = request()->file('banner_img');
            $banner_img = $this->upload($file);
            $da['banner_img'] = $banner_img;
            $rs = Db::name('banner')->where('banner_id',$da['banner_id'])->update($da);
            if($rs){
                $this->success('修改成功！','banner/banner_list');
            }else{
                $this->error('修改失败！');
            }
        }else{
            $data = Db::name('banner')->where('banner_id',$banner_id)->find();
//            dump($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($banner_id){
        $rs=Db::name('banner')->delete($banner_id);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}