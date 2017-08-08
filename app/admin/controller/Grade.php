<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/8/1
 * Time: 21:38
 */
//grade类所在的空间
namespace app\admin\controller;

//引入父类controller，完成提示信息的操作
use houdunwang\core\Controller;
//引入view类完成加载模版和数据的操作
use houdunwang\view\View;
//引入garde类因为和这个类名字一样所以起一个别名，用来完成调用和修改数据库对应的表的内容
use system\model\Grade as GradeModel;
//创建一个grade类完成班级的添加，删除，修改和内容的显示
class Grade extends Common{
//    创建一个lists方法用来显示grade类对应的数据库中班级表的信息
    public function lists(){
//        调用system\model空间的grade类触发houdunwang\model里model类得到表名grade，通过对应空间的base类中的get方法获取grade表的所有内容，通过有结果集的操作调出数据，返回到这个对象，将得到的值传给View类空间的base类中的with方法将数据返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成加载数据和载入对应模版的操作
        $data=GradeModel::get();
//        调用view类触发对应空间的base类，使用base类中的make方法获得引入的模版路径，通过with方法将接收的数据返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成加载数据和载入对应模版的操作，
        return View::make()->with(compact('data'));
    }
//    创建一个store方法完成班级的添加操作
    public function store(){
//        判断是不是POST模式也就是点击了添加，如果是就执行if判断的代码完成添加
        if(IS_POST){
//            调用system\Model的grade类触发grade类的父类houdunwang\model的model类获得表名，在通过父类空间的base类中的save方法将提交的数据进行处理完成添加，通过无结果集的操作完成数据添加，将结果返回到当前对象
            GradeModel::save($_POST);
//            调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
            return $this->success('添加成功')->setRedirect("?s=admin/grade/lists");
        }
//        调用View类触发对应空间的make方法获得要引入的模版路径，返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成载入对应模版的操作，
        return View::make();
    }
//    创建一个remove方法完成班级数据的删除操作
    public function remove(){
//            调用system\Model的grade类触发grade类的父类houdunwang\model的model类获得表名，在通过父类空间的base类中的where方法将where条件也就是get参数中的gid的值得到相当于是班级表的GID，通过destory方法执行无结果集的操作完成数据删除，将结果返回到当前对象完成删除
        GradeModel::where("gid={$_GET['gid']}")->destory();
//        调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
        return $this->success('删除成功')->setRedirect("?s=admin/grade/lists");
    }
//    创建一个update方法完成修改班级数据的操作
    public function update(){
//        将get参数gid的值存起来也就是班级表中的gid的值，到时填写where条件时使用
        $gid=$_GET['gid'];
//        判断是不是POST模式也就是点击了修改，如果是就执行if判断的代码完成修改
        if(IS_POST){
 //            调用system\Model的grade类触发grade类的父类houdunwang\model的model类获得表名，在通过父类空间的base类中的where方法将where条件也就是get参数中的gid的值得到相当于是班级表的GID，再通过update方法执行无结果集的操作将重新提交的数据更新到数据库完成数据修改，将结果返回到当前对象完成修改
            GradeModel::where("gid={$gid}")->update($_POST);
//            调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
            return $this->success('修改成功')->setRedirect('?s=admin/grade/lists');
        }
//            调用system\Model的grade类触发grade类的父类houdunwang\model的model类获得表名，在通过父类空间的base类中的find方法将where条件也就是grade表的gid值得到，但是因为find方法不知到where条件的字段名，所以要获得grade表的主键名也就是对应的GID，通过base类中的getprikey获得grade表的主键名，填写到where条件的字段名上也就是gid，最后执行有结果集的操作获得原来的旧内容，将结果返回到当前对象，传到View空间的base类中的with方法将得到的内容显示在修改页面
        $oldData=GradeModel::find($gid);
        //        调用view类触发对应空间的base类，使用base类中的make方法获得引入的模版路径，通过with方法将接收的数据返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成加载数据和载入对应模版的操作，
        return View::make()->with(compact('oldData'));
    }

}