<?php


namespace app\admin\controller;


use think\Controller;

class MoreController extends Controller
{
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $files = request()->file('image');
//        $files = array();
        foreach ($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    // 成功上传后 获取上传信息
                    $image[] = '/uploads/'.$info->getSaveName();
//                    dump($image[]);
                    $path = str_replace("\\","/",$image);
                }else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
        }
        $arr['image'] = $path;
        return $arr;

    }

}