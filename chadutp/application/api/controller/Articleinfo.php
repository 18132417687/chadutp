<?php


namespace app\api\controller;



use think\Db;

class Articleinfo extends Common
{
    public function index(){
        $data = $this->params;
        $res = Db::name('article')->where(array('article_id'=>$data['article_id']))->find();
        if($res){
            $this->return_msg(200,'文章详情内容传输成功!',$res);
        }else{
            $this->return_msg(400,'文章详情内容传输失败！');
        }
    }
}