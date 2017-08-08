<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/8/1
 * Time: 20:25
 */
//entry类所在的空间
namespace app\admin\controller;

//引入父类Controller
use houdunwang\core\Controller;
//引入view类完成加载模版
use houdunwang\view\View;
use system\model\User;

//创建一个entry类来完成后台主页面的加载操作
class Entry extends Common{
//    创建一个index方法完成后台页面的默认页面加载操作
    public function index(){
//        调用VIEW类空间的make方法返回对象触发__tostring方法完成模版加载
        return View::make();
    }
//    创建一个changPassword方法完成修改密码的操作
    public function changePassword(){
//        判断是不是post模式，也就是点击了修改按钮
        if(IS_POST){
//            获得提交的新数据
            $data=$_POST;
//            获得要修改的用户的对应数据
            $userData=User::find("{$_SESSION['user']['uid']}");
//            p($userData);exit;
//            判断提交的旧密码和原来数据的密码一样不一样，如果一样就让修改，如果不一样表示密码错误不能进行密码修改
            if(!password_verify($data['oldPassword'],$userData['password'])){
//                弹出提示信息
                return $this->error('原密码不正确');
            };
//            判断两次填写的新密码是否一致，如果不一致弹出提示信息让重新输入
            if($data['newPassword']!=$data['confirmPassword']){
//                弹出错误的提示信息
                return $this->error('两次新密码输入不一致');
            }
//            将新填写的密码进行加密，因为update接收的是一个数组，对应的键名相当于是表中的字段名所以要将数据组成数组，因为密码对应的字段名是passoword,所以见键名取名为password
            $password=['password'=>password_hash($data['newPassword'],PASSWORD_DEFAULT)];
//            将对应数据的password值进行替换，完成修改密码
            User::where("uid={$_SESSION['user']['uid']}")->update($password);
//            将session文件和储存的值删除，重新登录
//            删除session变量
            session_unset();
//            删除session文件
            session_destroy();
//            跳到登录页面并提示修改成功
            return $this->setRedirect('?s=admin/login/index')->success('修改成功');
        }
//        调用VIEW类空间的make方法返回对象触发__tostring方法完成修改密码模版加载
        return View::make();
    }
}