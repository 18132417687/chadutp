<?php


namespace app\api\controller;


use think\Db;

class User extends Common
{
    public function index(){
        if($this->request->isPost()){
            $AppID = 'wxaaec353e73492229';
            $APPSecret = '8610c7e6bd39b4d6f9907065c436d37c';
            $js_code = input('code/s');
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$AppID&secret=$APPSecret&js_code=$js_code&grant_type=authorization_code";
            $openID=$this->curl_get($url);
            $openID=json_decode($openID, TRUE);
            $is_openid = Db::table('user')->where('openid',$openID['openid'])->find();
            if($is_openid){
            }else{
                $userdata['openid']=$openID['openid'];
                DB::table('user')->insert($userdata);
            }
        }else{
            $this->return_msg(400,'用户信息传输失败！');
        }
    }
    public function info(){
        if($this->request->isPost()){
            $openId = input('openId/s');
            if (!empty($openId)) {
                $this->return_msg(400,'请求参数错误！');
            }
            $info = db('user')->where('openid',$openId)->field(true)->find();
            if ($info) {
                $this->return_msg(200,'获取用户信息成功！',$info);
            }else{
                $this->return_msg(401,'请获取用户信息！');//这里的状态码，最好改成其他的。用作前端判断
            }
        }else{
            $this->return_msg(400,'请求类型错误！');
        }
    }
    //保存用户信息，当上面这个接口，返回404时候，弹出获取用户的button按钮，点击按钮之后，获取用户请求这个接口
    public function message()
    {
        if($this->request->isPost()){

        }else{
            $this->return_msg(400,'请求类型错误！');
        }
    }
    function curl_get($url='',$postdata='', $options=array()){

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if($postdata){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        }

        if (!empty($options)){
            curl_setopt_array($ch, $options);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


}