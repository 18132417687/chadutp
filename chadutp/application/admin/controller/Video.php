<?php


namespace app\admin\controller;


use think\Db;
use think\Request;

class Video extends MoreController
{
    public function video_list()
    {
        $data = Db::name('video')
            ->alias('a')
            ->field('video_id,study_name,video_title,video_author,video_date,video_read,video_zan,video_para1,video_para2,video_para3,video_para4,video_para5,video_para5,video_para6,video_para7,video_para8,video_para9,video_para10,video_img,video_img1')
            ->join('study s', 'a.study_id = s.study_id')
            ->order('video_id asc')
            ->paginate(10);   //查询数据库表名    分页
//        print_r($data);
        $this->assign('data', $data);    ////变量输出  分配
        return $this->fetch();   //把内容渲染到页面里
    }

    public function video_add()
    {
        $da = input('post.');
//        $data = Request::instance()->param();      //获取当前请求参数
        $study = Db::name('study')->select();
        $this->assign('study', $study);
//        dump($data);
        $file = request()->file('image');
//        dump($file);
        if ($file) {
            $fileName = $this->upload($file);
//            dump($fileName);
            foreach ($fileName as $value) {
                $data = [
                    'video_img' => $value[0],
                    'video_img1' => $value[1],
                ];
                $res = array_merge_recursive($da, $data);
//                dump($res);
//                dump($data);
                $rs = Db::name('video')->insert($res);
                dump($rs);
                if ($rs) {
                    $this->success('新增成功！', 'video/video_list');
                } else {
                    $this->error('新增失败！');
                }
            }
        } else {
            return $this->fetch();
        }
    }

    public function video_edit($video_id)
    {
        $da = Request::instance()->post();
        $study = Db::name('study')->select();
        $this->assign('study', $study);
//        dump($da);
        $file = request()->file('image');
        if ($file) {
            $fileName = $this->upload($file);
            foreach ($fileName as $value) {
                $data = [
                    'video_img' => $value[0],
                    'video_img1' => $value[1],
                ];
                $da[] = $data;
                $result = [];
                array_walk_recursive($da, function ($value) use (&$result) {
                    array_push($result, $value);
                });
                $info = [
                    'video_id' => $result[0],
                    'study_id' => $result[1],
                    'video_title' => $result[2],
                    'video_author' => $result[3],
                    'video_date' => $result[4],
                    'video_read' => $result[5],
                    'video_zan' => $result[6],
                    'video_para1' => $result[7],
                    'video_para2' => $result[8],
                    'video_para3' => $result[9],
                    'video_para4' => $result[10],
                    'video_para5' => $result[11],
                    'video_para6' => $result[12],
                    'video_para7' => $result[13],
                    'video_para8' => $result[14],
                    'video_para9' => $result[15],
                    'video_para10' => $result[16],
                    'video_img' => $result[17],
                    'video_img1' => $result[18],

                ];
//                dump($info);
                $rs = Db::name('video')->where('video_id', $info['video_id'])->update($info);
                if ($rs) {
                    $this->success('修改成功！', 'video/video_list');
                } else {
                    $this->error('修改失败！');
                }
            }
        } else {
            $data = Db::name('video')->where('video_id', $video_id)->find();
//            dump($data);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    public function del($video_id)
    {
        $rs = Db::name('video')->delete($video_id);
        if ($rs) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}