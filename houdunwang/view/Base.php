<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/30
 * Time: 18:55
 */
//Base类所在的空间名
namespace houdunwang\view;

//创建一个Base类，当app/home/controller/entry中的entry类中的index方法调用View类时会调用这个类中的方法完成载入前台页面的操作和载入显示的数据
class Base{
//    创建一个属性默认为空数组，用来接收传过来的数据，并将接收的数据返回到/houdunwang/core/boot文件中的boot类中的APPRUN方法并echo时触发__tostring，完成先加载数据再载入模版的操作
    private $data=[];
//    创建一个template属性用来组建引入的模版路径
    private $template;
//    创建一个MAKE方法完成路径组合的操作
    public function make(){
//        组合当前对象需要引入的模版路径，并返回到/houdunwang/core/boot中的APPRUN方法中输出当前对象，触发__tostring方法载入当前路径完成载入模版的操作
        $this->template="../app/".APP."/view".'/'.CONTROLLER.'/'.ACTION.'.php';
//        返回对象触发__tostring方法
        return $this;
    }
//    创建一个with方法用来接收传过来的数据并返回到当前对象触发__tostring，完成数据加载
    public function with($data){
//        将传递的数据赋值给属性$data并将获得的数据返回到当前对象触发__tostring,完成加载数据
        $this->data=$data;

        return $this;
    }
//    创建一个输出对象是自动触发的方法完成现在如数据再载入模版的操作，让所对应的数据能在对应的模版中调用
    public function __toString()
    {
//        将或的数据进行转换，将对应的键名转换为变量名，将对应的键值转换为变量值，方便页面调用时使用

        extract($this->data);
//        p($this->data);exit;
//        引入当前对象对应的模版
//        p($this->template);exit;
        include $this->template;
//        因为__tostring方法必须返回一个字符串，所以要返回一个空字符串
        return '';
    }

}