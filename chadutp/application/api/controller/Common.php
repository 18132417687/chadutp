<?php


namespace app\api\controller;


use think\Controller;
use think\Image;
use think\Request;
use think\Validate;

class Common extends Controller
{
    protected $request;  //用来处理参数
    protected $params;   //过滤后符合要求的数据
    protected $validater;   //用来验证数据/参数

    protected $rules = array(
        //轮播图
        'Banner'=>array(
          'index'=>array()
        ),
        //大分类
        'Category'=>array(
            'index' =>array(
            )
        ),
        //茶种分类
        'Tea'=>array(
            'index'=>array(
            'category_id' =>'require'
            ),
        ),
        //茶种商品列表
        'Goods'=>array(
            'index'=>array(
            'tea_id'=>'require'
            ),
        ),
        //商品详情
        'Detail' =>array(
            'index'=>array(
            'goods_id'=>'require'
            ),
        ),
        //学茶分类
        'Study' =>array(
            'index' =>array(
            )
        ),
        //文章列表
        'Article' =>array(
            'index' =>array(
                'study_id'=>'require'
            )
        ),
        //文章详情
        'Articleinfo' =>array(
            'index'=>array(
                'article_id'=>'require'
            )
        ),
        //视频列表
        'Video' =>array(
            'index' =>array(
                'study_id'=>'require'
            )
        ),
        //视频详情
        'Videoinfo' =>array(
            'index'=>array(
                'video_id'=>'require'
            )
        ),
        //购物车列表
        'Cart' =>array(
            'index'=>array(),
            'add' =>array(
                'goods_id'=>'require',
                'goods_title'=>'require',
                'goods_price'=>'require',
                'goods_img'=>'require',
                'num'=>'require',
                'selected'=>'require'
            ),
            'del'=>array(
                'goods_id'=>'require'
            ),
            'numreduce'=>array(
                'goods_id'=>'require',
//                'num'=>'require',
            ),
            'numadd'=>array(
                'goods_id'=>'require',
                'num'=>'require',
            )
        ),
        //商品模糊查询
        'Search'=>array(
            'index' =>array(
//                'goods_title' =>'require'
            )
        ),
        //用户
        'User' =>array(
            'index' =>array(),
            'info' =>array(),
            'message' =>array()
        ),
    );
    protected function _initialize(){
        parent::_initialize();
        $this->request = Request::instance();
//        $this->chenck_time($this->request->only(['time']));
//        $this->check_token($this->request->param());
        $this->params = $this->check_params($this->request->param(true));
    }
//验证参数  参数过滤
//param[array] $arr [除time和token外的所有参数]
//return [return] [合格的参数数组]
    public function check_params($arr){

        //获取参数的验证规则
        $rule = $this->rules[$this->request->controller()][$this->request->action()];
        //验证参数并返回错误
        $this->validter = new Validate($rule);
        if(!$this->validter->check($arr)){
            $this->return_msg(400,$this->validter->getError());

        }
//        如果正常，通过验证
        return $arr;
    }
//    //验证请求是否超时
//    public  function chenck_time($arr){
//        if(!isset($arr['time']) || intval($arr['time']) <=1){
//            $this->return_msg(400,'时间戳不正确！');
//        }
//        if(time() - intval($arr['time']) >60){
//            $this->return_msg(400,'请求超时！');
//        }
////        if(time() - intval($arr['time']) <10){
////            $this->return_msg(400,'请求重复！');
////        }
//    }



    //数据返回json格式
    public function return_msg($code,$msg='',$data=[]){
        $return_data['code'] = $code;
        $return_data['msg'] = $msg;
        $return_data['data'] = $data;
        echo json_encode($return_data);die;
    }

//
//    //验证token（防止篡改数据）
//    //param[array]$arr[全部请求参数]         return【json】[token验证结果]
//    public function check_token($arr){
////        api传过来的token
//        if(!isset($arr['token']) || empty($arr['token'])){
//            $this->return_msg(400,'token不能为空！');
//        }
//        $app_token = $arr['token'];   //传过来的token
////        服务器端生成token
//        unset($arr['token']);
//        $service_token = '';
//        foreach($arr as $key => $value){
//            $service_token = md5($value);      //md5（api_md5(username).md5(password).md5(time)_api）
//
//        }
//        $service_token = md5('api_' . $service_token .'_api');   //服务器端即时生成的token
////        echo $service_token;exit;
////        对比token，返回结果
//        if($app_token !== $service_token){
//            $this->return_msg(400,'token值不正确！');
//        }
//    }
//

//    图片上传
    public  function upload_file($file,$type = ''){
        $info = $file->move(ROOT_PATH. 'public' .DS.'uploads');
        if($info){
            $path = '/uploads/'.$info->getSaveName();
            //裁剪图片
            if(!empty($type)){
                $this->image_edit($path,$type);
            }
            return str_replace('\\','/',$path);
        }else{
            $this->return_msg(400,$file->getError());
        }
    }

    //图片修改
    public  function  image_edit($path,$type){
        $image = Image::open(ROOT_PATH.'public'.$path);
        switch($type){
            case 'head_img':
                $image->thumb(150,150,Image::THUMB_CENTER)->save(ROOT_PATH.'public'.$path);
                break;
            case 'chat_img':
                $image->save(ROOT_PATH.'public' . $path);
                break;
        }
    }


}