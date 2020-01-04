<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\Request;

class Article extends MoreController
{
    public function article_list(){
        $data = Db::name('article')
            ->alias('a')
            ->field('article_id,study_name,article_title,article_author,article_date,article_read,article_zan,article_para1,article_para2,article_para3,article_para4,article_para5,article_para5,article_para6,article_para7,article_para8,article_para9,article_para10,article_img,article_img1')
            ->join('study s','a.study_id = s.study_id')
            ->order('article_id asc')
            ->paginate(10);   //查询数据库表名    分页
//        print_r($data);
        $this->assign('data',$data);    ////变量输出  分配
        return $this->fetch();   //把内容渲染到页面里
    }
    public function article_add(){
        $da = input('post.');
//        $data = Request::instance()->param();      //获取当前请求参数
        $study = Db::name('study')->select();
        $this->assign('study',$study);
//        dump($data);
        $file = request()->file('image');
//        dump($file);
        if($file){
            $fileName = $this->upload($file);
//            dump($fileName);
            foreach ($fileName as $value) {
                $data = [
                    'article_img' => $value[0],
                    'article_img1' => $value[1],
                ];
                $res = array_merge_recursive($da, $data);
//                dump($res);
//                dump($data);
                $rs = Db::name('article')->insert($res);
//                dump($rs);
                if ($rs) {
                    $this->success('新增成功！', 'article/article_list');
                } else {
                    $this->error('新增失败！');
                }
            }
        }else {
            return $this->fetch();
        }
    }
    public function article_edit($article_id){
        $da = Request::instance()->post();
        $study = Db::name('study')->select();
        $this->assign('study',$study);
//        dump($da);
        $file = request()->file('image');
        if($file){
            $fileName = $this->upload($file);
            foreach ($fileName as $value){
                $data=[
                    'article_img'=>$value[0],
                    'article_img1'=>$value[1],
                ];
                $da[]=$data;
                $result=[];
                array_walk_recursive($da,function ($value) use (&$result){
                    array_push($result,$value);
                });
                $info=[
                    'article_id'=>$result[0],
                    'study_id'=>$result[1],
                    'article_title'=>$result[2],
                    'article_author'=>$result[3],
                    'article_date'=>$result[4],
                    'article_read'=>$result[5],
                    'article_zan'=>$result[6],
                    'article_para1'=>$result[7],
                    'article_para2'=>$result[8],
                    'article_para3'=>$result[9],
                    'article_para4'=>$result[10],
                    'article_para5'=>$result[11],
                    'article_para6'=>$result[12],
                    'article_para7'=>$result[13],
                    'article_para8'=>$result[14],
                    'article_para9'=>$result[15],
                    'article_para10'=>$result[16],
                    'article_img'=>$result[17],
                    'article_img1'=>$result[18],

                ];
//                dump($info);
                $rs = Db::name('article')->where('article_id',$info['article_id'])->update($info);
                if($rs){
                    $this->success('修改成功！','article/article_list');
                }else {
                    $this->error('修改失败！');
                }
            }
        }else{
            $data = Db::name('article')->where('article_id',$article_id)->find();
//            dump($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function del($article_id){
        $rs=Db::name('article')->delete($article_id);
        if($rs){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


}