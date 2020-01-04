<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/29
 * Time: 18:48
 */

namespace app\admin\model;


use think\Model;

class Goods extends Model
{
    //查询时需要隐藏的字段
    protected $hidden = ['update_time'];
    //自动时间戳写入
    protected $autoWriteTimestamp = true;
    //是否采用批量验证
    protected $batchValidate = true;

    public function store($data){
        $result = $this->allowField(true)->validate (true)->save ($data);
        if($result===false){
            return ['code'=>0,'msg'=>$this->getError()];
        }
        return ['code'=>1,'msg'=>'商品添加成功'];
    }

}