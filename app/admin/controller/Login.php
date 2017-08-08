<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/8/2
 * Time: 19:50
 */

namespace app\admin\controller;

use Gregwar\Captcha\CaptchaBuilder;
use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\User;

class Login extends Controller{
//    创建一个index方法完成载入登录页面和登陆操作
    public function index(){
//        判断是不是post模式也就是点击了登陆按钮
//      echo  password_hash('admin',PASSWORD_DEFAULT);exit;
        if(IS_POST){
            $data=$_POST;
//            p($data);
//            判断post模式提交的captcha的值和session储存的captcha的值一样不一样，如果一样表示验证码输入正确，如果不一样表示验证码输入错误
            if(strtolower(addslashes($data['captcha']))!=$_SESSION['captcha']){
//                将错误信息弹出到页面
                return $this->error('验证码错误')->setRedirect('?s=admin/login/index');
            };
            $data['username']=addslashes($data['username']);
//            获取对应的user表中的数据用来判断用户名正不正确
            $userData=User::where("username='{$data['username']}'")->get();
//            p($userData);
//            判断如果！usreData为空表示用户名不存在，如果不为空表示已经可以登录
            if(!$userData){
                return $this->error('用户名不存在')->setRedirect('?s=admin/login/index');
            }
//            判断提交的数据中的password的值和经过转换的数据库对应的password数据比较如果一样表示密码正确，如果不一样表示密码错误
            if(!password_verify($data['password'],$userData[0]['password'])){
                return $this->error('密码不正确')->setRedirect('?s=admin/login/index');
            }
//            判断提交的数据auto的值存不存在，如果存在表示点击了七天免登录，将对应的session_id的有效时间延长7天
            if(isset($data['auto'])){
                setcookie(session_name(),session_id(),time()+7*24*3600,'/');
            }else{
                setcookie(session_name(),session_id(),0,'/');
            }
//            将session['user']储存表示已经登录
            $_SESSION['user']=[
//                用来修改密码时修改对应的数据库信息
                'uid' => $userData[0]['uid'],
//            用来显示页面的用户名
                'username' => $userData[0]['username']
            ];
//            提示登录成功跳转到后台主页
            return $this->setRedirect("?s=admin/entry/index")->success('登陆成功');
        }
//        调用index方法时引入登录页面
        return View::make();
    }
//    创建一个captcha方法用来载入验证码
    public function captcha(){
        $builder = new CaptchaBuilder;
        $builder->build();
        header('Content-type: image/jpeg');
        $builder->output();
//        接收session
        $_SESSION['captcha'] =strtolower($builder->getPhrase()) ;
    }
//    创建一个del方法用来删除session变量和文件完成退出登录的操作
    public function del(){
//        删除session变量
        session_unset();
//        删除session文件
        session_destroy();
//        跳转到登录页面，弹出退出成功的信息
        return $this->setRedirect("?s=admin/login/index")->success('退出成功');
    }
    public function verify(){
        if ($_POST['c']==$_SESSION['captcha']){
            echo 1;
        }else{
            echo 0;
        }
    }
}