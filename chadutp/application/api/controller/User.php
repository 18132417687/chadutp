<?php


namespace app\api\controller;


use think\Db;

class User extends Common
{
    public function index(){
        if($this->request->isPost()){
            $AppID = 'wxaaec353e73492229';    //小程序appid
            $APPSecret = '8610c7e6bd39b4d6f9907065c436d37c';    //小程序秘钥
            $js_code = input('code/s');
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$AppID&secret=$APPSecret&js_code=$js_code&grant_type=authorization_code";
            $openID=$this->curl_get($url);    //使用下面的curl_get方法获取openid和session_key
            $openID=json_decode($openID, TRUE);
            $is_openid = Db::table('user')->where('openid',$openID['openid'])->find();    //去数据库里查找openid
            if($is_openid){
                $this->return_msg(200,'获取用户信息成功！',$openID);
            }else{  //不存在将openid加入到数据库中
                $userdata['openid']=$openID['openid'];
                DB::table('user')->insert($userdata);
                $this->return_msg(200,'openid插入成功！',$openID);
            }
        }else{
            $this->return_msg(400,'用户信息传输失败！');
        }
    }
    public function info(){
        if($this->request->isPost()){
            $openId = $this->params;
//            dump($openId['openid']);
//            exit;
            if (empty($openId['openid'])) {
                $this->return_msg(400,'请求参数错误！');
            }
            $info = db('user')->where('openid',$openId['openid'])->field(true)->find();
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
            $data = $this->params;
            $userInfo =$data['userInfo'];
            $info = ['avatarUrl' => $userInfo['avatarUrl'],
                'city' => $userInfo['city'],
                'country' => $userInfo['country'],
                'gender' => $userInfo['gender'],
                'language' => $userInfo['language'],
                'nickName' => $userInfo['nickName'],
                'province' => $userInfo['province'],
                ];
            DB::name('user')->where('openid',$data['openId'])->update($info);
           $info = db('user')->where('openid',$data['openId'])->field(true)->find();
            $this->return_msg(200,'请求成功！',$info);

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