<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 20:17
 */

namespace app\admin\model;


use think\Model;

class Admin extends Model
{
    //查询时需要隐藏的字段
    protected $hidden =['update_time'];
    //自动时间戳写入
    protected $autoWriteTimestamp =true;
    //是否采用批量验证
    protected $batchValidate =true;

    public function checkUser($name,$password){
        $info =$this->where('name','=',$name)->find();
//        dump($info);
        if ($info['password']== $password){
            return $info;
        }else{
            return null;
        }
    }
}