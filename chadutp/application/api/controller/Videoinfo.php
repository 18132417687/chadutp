<?php


namespace app\api\controller;


use think\Db;

class Videoinfo extends Common
{
    public function index(){
        $data = $this->params;
        $res = Db::name('video')->where(array('video_id'=>$data['video_id']))->find();
        if($res){
            $this->return_msg(200,'视频详情内容传输成功!',$res);
        }else{
            $this->return_msg(400,'视频详情内容传输失败！');
        }
    }

}