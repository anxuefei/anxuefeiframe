<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/8/2
 * Time: 0:42
 */
//student类所在的空间
namespace app\admin\controller;

//引入父类controller，完成提示信息的操作
use houdunwang\core\Controller;
//引入model类用来获取关联表时的数据，获得对应的班级和学生信息
use houdunwang\model\Model;
//引入view类完成加载模版和数据的操作
use houdunwang\view\View;
//引入grade类用来和学生表关联，显示对应的班级信息
use system\model\Grade;
//引入material类用来引入素材，添加学生和修改学生信息时用来选取所需要的素材
use system\model\Material;
//引入stu类完成修改学生表数据修改，添加删除和显示的操作
use system\model\Stu;
//创建一个student类完成学生信息的修改，添加删除和显示的操作
class Student extends  Common{
//    创建一个lists方法用来显示student类对应的数据库中学生表和对应的班级表的信息
    public function lists(){
//        用过model中的有结果集的操作将学生表和班级表关联，用来获取学生对应的班级信息，完成页面显示学生信息所在班级信息的操作
        $data=Model::q("SELECT * FROM stu s Join grade g ON s.gid=g.gid");
//        通过view类中的make方法和with方法载入学生和对应班级的信息并引入学生模版页面
        return View::make()->with(compact('data'));
    }
//    创建一个store方法完成学生信息的添加操作
    public function store(){
//        判断是不是post模式也就是点击了添加按钮，如果是就执行if中的代码
        if(IS_POST){
//            因为提交过来的多选信息是一个数组，但是在stu表中hobby对应的hobby需要的是一个字符串，所以判断有没有选择多选信息，如果没有就只见调用save方法通过没有结果集的操作完成添加，如果选择了爱好类就将提交过来的爱好信息转换成字符串获取新的提交数据在调用save方法完成添加
            if(isset($_POST['hobby'])){
//                将提交过来的爱好类的信息转换成字符串传，组成新的上传数据，完成添加
                $_POST['hobby']=implode(',',$_POST['hobby']);
            }
//            调用houdunwang\model中的model类空间的base类中的save方法将新获得的提交数据传过去完成添加
            Stu::save($_POST);
//        调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
            return $this->success('保存成功')->setRedirect("?s=admin/student/lists");
        }
//        获取所有的班级信息用来添加学生信息时选择对应的班级
        $gradeData= Grade::get();
//        获取上传的素材信息，用来添加学生信息时选择对应的素材
        $materialData=Material::get();
//        通过View类空间的base类中的with方法接收所有的班级信息和素材，用matk方法获取要引入的学生添加页面，最后通过__tostring方法完成引入模版和显示班级信息和素材信息的操作
        return View::make()->with(compact('gradeData','materialData'));
    }
//    创建update方法来完成修改学生信息的操作
    public function update(){
//        获得where条件对应的sid的值也就是get参数传过来的sid的值
        $sid=$_GET['sid'];
//        判断是不是post模式，也就是点击了修改按钮
        if(IS_POST){
//         因为提交过来的多选信息是一个数组，但是在stu表中hobby对应的hobby需要的是一个字符串，所以判断有没有选择多选信息，如果没有就只见调用save方法通过没有结果集的操作完成添加，如果选择了爱好类就将提交过来的爱好信息转换成字符串获取新的提交数据在调用save方法完成添加
            if(isset($_POST['hobby'])){
//                将提交过来的hobby对应的数据转换成字符串，组成新的提交数据
                $_POST['hobby']=implode(',',$_POST['hobby']);
            }
//            调用houdunwang\model中的model类空间的base类中的where方法获得where条件对应的值，通过update方法将提交的数据也就是修改后的内容进行无结果集的操作完成数据库中对应的stu表的数据修改完成修改学生信息的操作
            Stu::where("sid={$sid}")->update($_POST);
//            调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
            return $this->success('保存成功')->setRedirect("?s=admin/student/lists");
        }
//        获得对应的学生信息的旧数据，用来显示在修改页面
        $oldData=Stu::find($sid);
//        因为修改表单中hobby对应的信息是一个多选属性，而多选属性提交的数据是数组模式，而数据库中存的信息是一个字符串，所以要将获得的数据中对应的hobby对应的值转换成数组，才能在修改页面完成显示
        $oldData['hobby']=explode(',',$oldData['hobby']);
//        获得班级的所有信息，用来修改学生信息时选择要修改的班级
        $gradeData= Grade::get();
//        获得素材的所有信息，用来修改学生信息内容时修改所需要的素材信息
        $materialData=Material::get();
//        调用View类空间的base类中的with方法接收传送的旧数据和所有的班级，素材信息用来显示在修改页面，用make方法获取要引入的修改页面的路径，最后通过__tostring方法载入所有数据，引入修改页面，将要修改的信息显示在修改页面
        return View::make()->with(compact('oldData','gradeData','materialData'));
    }
//    创建一个remove方法完成学生数据的删除操作
    public function remove(){
//        调用model类空间的base类中的where方法获取wehre条件，通过destory方法完成删除学生信息的操作
        Stu::where("sid={$_GET['sid']}")->destory();
//        调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
        return $this->success('删除成功')->setRedirect('?s=admin/student/lists');
    }
}