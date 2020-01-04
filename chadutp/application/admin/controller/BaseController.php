<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/13
 * Time: 9:35
 */

namespace app\admin\controller;


use think\Controller;

class BaseController extends Controller
{

    public function upload($file){
        // 获取表单上传文件 例如上传了001.jpg

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $image = $info->getSaveName();
                $path = str_replace("\\","/",$image);
                $img_path = '/uploads/'.$path;
                return $img_path;
//                echo $info->getSaveName();
//                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}