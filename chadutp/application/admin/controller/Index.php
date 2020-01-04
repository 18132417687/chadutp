<?php


namespace app\admin\controller;


use think\Controller;

class Index extends Controller
{
    public function index(){
        //防跳墙
        if(session('?name')){
            return $this->fetch();
        }else {
            $this->redirect('login/login');
        }
    }
    public function welcome(){
        return $this->fetch();
    }

}