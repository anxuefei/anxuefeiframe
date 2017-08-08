<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/8/2
 * Time: 19:54
 */

namespace app\admin\controller;


use houdunwang\core\Controller;

class Common extends Controller{
    public function __construct(){
//        判断如果session['user']变量不存在就表示没有登录，如果有表示已经登陆了不需要跳转到登录页面
        if(!isset($_SESSION['user'])){
//            p($_SESSION['user']);exit;
            go("?s=admin/login/index");
        }
    }
}