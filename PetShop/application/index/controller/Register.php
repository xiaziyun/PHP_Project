<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Register extends Controller{
    
    public function register(){
        return $this->fetch();
    }
    
    public function doRegister(){
        $param = input('post.');
        if(empty($param['name'])){
            $this->error('姓名不能为空');
        }
        if(empty($param['email'])) {
            $this->error('email不能为空');
        }
        if(empty($param['sex'])){
            $this->error('性别不能为空');
        }
        if(empty($param['passw1'])) {
            $this->error('密码不能为空');
        }
        if($param['passw2'] != $param['passw1']) {
            $this->error('两次密码不一致');
        }
        if(empty($param['phone'])){
            $this->error('手机号不能为空');
        }
        $data=Db::table('member')->where('email', $param['email'])->find();
        if(!empty($data)){
            $this->error('email已被注册');
        }else{
            $result = Db::execute("insert into member(email,password,name,sex,mobile,address,bonus,balance)
                values('" . $param['email'] . "','" .md5($param['passw1']) . "','" . $param['name'] . "','" . $param['sex'] . "','" . $param['phone'] . "', null, 0, 0)");
            $this->success('用户['.$param['email'].']新增成功', 'index/index');
        }
    }
}