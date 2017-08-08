<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/30
 * Time: 20:47
 */
//Controller类所在的空间名
namespace houdunwang\core;

//创建一个Controller类用来执行一些对应的提示信息，和载入提示模版
class Controller{
//    创建一个属性url默认值为window.history.back(),表示如果跳转地址没有传递默认跳转到上一级
    private $url="window.history.back()";
//    创建一个msg属性用来接收操作完成的提示信息
    private $msg;
//    创建一个template属性用来接收引入的提示模版路径
    private $template;
//    创建一个setRedirect方法用来跳转到制定的页面，并将获得的跳转地址返回到/houdunwang/core中的boot类中的appRun方法触发__tostring方法载入跳转页面完成跳转
    protected function setRedirect($url){
//        将跳转的地址接收并返回到appRun方法触发__toString方法载入跳转页面完成跳转
        $this->url="location.href='{$url}'";
//        返回到当前对象
        return $this;
    }
//    创建一个success方法用来显示操作成功后的提示信息，并将提示信息返回到当前对象，输出在提示页面
    protected function success($msg){
//        将操作的提示信息接收并返回到当前对象，显示在要加载的提示页面
        $this->msg=$msg;
//        将提示要载入的提示页面地址赋值给template返回到当前对象，触发__tostring方法完成载入提示模版并显示提示信息
        $this->template='./view/success.php';
//        返回对象，触发__tostring方法
        return $this;
    }
//    创建一个error方法完成一些操作错误或者失败的信息完成失败时的操作提示
    protected function error($msg){
//        将操作的提示信息接收并返回到当前对象，显示在要加载的提示页面
        $this->msg=$msg;
//        将提示要载入的提示页面地址赋值给template返回到当前对象，触发__tostring方法完成载入提示模版并显示提示信息
        $this->template='./view/error.php';
//        返回对象，触发__tostring方法
        return $this;
    }
    public function __toString(){
//        触发__tostring方法时引入跳转页面，完成跳转，如果没有自动跳转就手动跳转到指定页面
        include $this->template;
//        因为__tostring方法只能返回一个字符串，所以要返回一个空字符串
       return '';
    }


}