<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/30
 * Time: 18:54
 */
//View类所在的空间名
namespace houdunwang\view;

//用来让app/home/controller中的entry类中的index方法调用view类时自动触发Base类中的方法完成载入app中的模版和需要显示的数据的操作
class View
{
//    创建一个静态调用不存在的方法时执行的方法执行Base类中对应的方法
    public static function __callStatic($name, $arguments)
    {
//        将当前空前中base类对应方法返回的对象值返回到entry类中的index方法中，并返回到houdunwang/core/boot类中的APPRUN方法中echo出来触发当前空前的__tostring完成载入模版和对应数据的操作
        return call_user_func_array([new Base(),$name],$arguments);
    }
}