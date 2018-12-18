<?php

namespace app\index\controller;
use think\Db;
use think\Controller;

class Login extends Controller{
    
    public function login(){
        return $this->fetch();
    }
    
    public function loginOut(){
        session('email', null);
        $this->redirect('login/login');
    }
    
    public function doLogin(){
        $email=input('post.email');
        $passw=input('post.passw');
        echo $passw;
        if(empty($email) || empty($passw)){
            $this->error('Email或密码不能为空');
        }else {
            $has=Db::table('member')->where('email',$email)->find();
            if(empty($has)){
                $this->error('您输入的用户名不存在');
            }else {
                if($has['password'] != $passw){
                    $this->error('您输入的密码不正确');
                }else {
                    session('email', $email);
                    $this->redirect('index/index');
                }
            }
        }
    }
}