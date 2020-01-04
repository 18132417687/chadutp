<?php


namespace app\api\controller;


use think\Db;

class Video extends Common
{
    public function index(){
        $data=$this->params;
        $res = Db::name('video')
            ->alias('v')
            ->field('v.video_id,s.study_id,v.video_title,v.video_author,v.video_date,v.video_read,v.video_zan,v.video_para1,v.video_para2,v.video_para3,v.video_para4,v.video_para5,v.video_para6,v.video_para7,v.video_para8,v.video_para9,v.video_para10,v.video_img')
            ->join('study s','v.study_id=s.study_id')
            ->where(['v.study_id'=>$data['study_id']])
            ->paginate(1);
        if ($res){
            $this->return_msg(200,'视频列表传输成功！',$res);
        }else{
            $this->return_msg(400,'视频列表传输失败！');
        }
    }

}