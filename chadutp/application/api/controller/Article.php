<?php


namespace app\api\controller;


use think\Db;

class Article extends Common
{
    public function index(){
        $data=$this->params;
        $res = Db::name('article')
            ->alias('a')
            ->field('a.article_id,s.study_id,a.article_title,a.article_author,a.article_date,a.article_read,a.article_zan,a.article_para1,a.article_para2,a.article_para3,a.article_para4,a.article_para5,a.article_para6,a.article_para7,a.article_para8,a.article_para9,a.article_para10,a.article_img')
            ->join('study s','a.study_id=s.study_id')
            ->where(['a.study_id'=>$data['study_id']])
            ->paginate(10);
        if ($res){
            $this->return_msg(200,'文章列表传输成功！',$res);
        }else{
            $this->return_msg(400,'文章列表传输失败！');
        }
    }

}