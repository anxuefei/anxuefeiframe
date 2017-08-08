<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/31
 * Time: 20:46
 */
//model类所在的空间名。
namespace houdunwang\model;

//创建一个Model类完成载入base类完成连接数据库，修改对应表的数据的操作
class Model{
    public static function __callStatic($name, $arguments){
//        获取调用model类的方法名字包括空间名，比如Arc::get()，因为调用arc类是回去system\model空间的arc类中查找，但是arc类中没有这个方法就会来父类model里面查找，就会触发这个函数获取arc的空见和类的名字获得的结果就是system\model\Arc,因为arc对应的就是数据库中的arc表所以通过截取字符串截取到字符串arc传到当前空间的base类中完成调取和修改对应表的数据内容的操作
//        将获取的对应的类的名字存到$className中，用来完成截取对应表名字的操作，因为到时调用那个表的数据不确定所以不能写死，就可以调用system中model目录中的对应表名的类完成调用和修改表内容的操作
        $className=get_called_class();
//        p($className);exit;
//        system\model\Arc
//        将要获取内容或修改表的表明截取到
//        通过strrchr截取到的数据是\Arc，然后通过删除ltrim 将\删除获得Arc，因为库中的表名都是小写的，所以最后通过strtolower转换获得表明arc然后传到base类中完成调用对应表的数据好修改的操作
        $table= strtolower(ltrim(strrchr($className,'\\'),'\\'));
//        将获得的数据最后返回到entry中的对应方法中，将获得数据传送到with参数中接收到最后返回到boot类中的arrRun方法触发__tostring方法完成加载数据的操作
        return call_user_func_array([new Base($table),$name],$arguments);
    }

}