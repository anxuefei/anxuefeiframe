<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/31
 * Time: 20:31
 */
//entry类所在的空间名
namespace app\home\controller;

//引入父类controller的路径
use houdunwang\core\Controller;
//引入view类完成加载页面和显示数据的操作
use houdunwang\model\Model;
use houdunwang\view\View;
//创建一个entry类完成载入数据和模版的操作
class Entry extends Controller{
//    创建一个index方法完成载入默认页面和默认数据的操作
    public function index(){
//        关联学生表和班级表，因为要显示学生对应的班级信息，最后调用Model空间的base类的q方法执行有结果集的操作，获取所有的学生信息和对应的班级名
            $data=Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid");
//        调用view空间中的view类执行同空间的base类中的make方法获得页面的引入路径，通过with方法获得对应的数据内容，返回到appRun方法，输出该对象触发对应的__tostring方法完成载入数据和页面的操作
        return View::make()->with(compact('data'));
    }
    public function show(){
//        关联学生表和班级表，因为要显示学生对应的班级信息，通过get参数传过来的sid的值来判断having条件，也就是学生表sid对应的值，获取学生表中对应的学生信息，最后调用Model空间的base类的q方法执行有结果集的操作，获取要查询的学生信息和对应的班级名
        $data=Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid WHERE sid={$_GET['sid']}");
//        载入显示学生信息的模版，将获取数据载入到模版，便利数组获得对应学生的详细信息
        return View::make()->with(compact('data'));
    }

}