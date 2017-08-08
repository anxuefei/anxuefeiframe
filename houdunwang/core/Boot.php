<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/30
 * Time: 16:10
 */
//bott类所在的空间名
namespace houdunwang\core;
//创建Boot类来完成框架的初始化和载入模版的操作
class Boot{
//    创建一个run方法来完成框架的初始化和执行应用的操作
    public static function run(){
 //        调用handliderror处理错误信息
        self::handleError();
//        调用初始化方法完成框架初始化来开启session设置时区一些操作
        self::init();
//        调用appRun方法实现模版载入和调用应用类的操作
        self::appRun();

    }
//    创建handleerror方法执行引入的库，完成错误处理
    private static function handleError(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }
//    创建一个init方法完成框架的初始化，比如开启session和设置时区的一些操作
    private static function init(){
//        判断有没有session_id如果有表示已经开启了seesion，如果没有就开启session
        session_id()||session_start();
//        设置时区,完成不同用户访问页面时显示的时间都是一样的时间
        date_default_timezone_set('PRC');
//        创建一个常量来判断用户操作一些应用时是不是post模式，来完成相应的操作，比如一些添加和留言操作
        define('IS_POST',$_SERVER['REQUEST_METHOD']=='POST' ? true :false);
    }
    private static function appRun(){
//        判断get参数S的值存不存在，如果不存在就默认为home/entry/index，也就是默认调用的为APP目录中的home中controller文件夹中的entry文件中的entry类中的index方法，载入主页面
        $s=isset($_GET['s'])?strtolower($_GET['s']) :'home/entry/index';
//        将$s转换为数组，方便组合自动调用方法时调用的对应空间的类名和调用对应的方法名
//        默认调用的类是app目录下的home也就是转换为数组后$arr[0]的参数，下的conrtoller下的entry也就是数组$arr[1]文件的entry方法中的index方法方法名也就是$arr[2];
        $arr=explode('/',$s);
//        p($arr);exit;
//        Array
//        (
//            [0] => home
//            [1] => entry
//        [2] => index
//)
//        因为在houdunwang\view空间中的base类中的make方法中组建文件引入路径时也需要get参数s的值，所以将$arr对应的参数存在常量中，因为常量不存在使用范围的限制
//        因为将get参数的s值转换为数组后就相当于是$arr[0]='home',$arr[1]='entry',$arr[2]='index';引入模版时的路径的文件夹名和文件名和对应的参数值一样所以将这几个值存到常量中方便调用
//        将$arr[0]对应的值存到常量中，方便在houdunwang\View空间的base类组建模版引入路径时使用，默认的主页路径是../app/home/view/entry/index.php,相当于是../app/$arr[0]/view/$arr[1]/$arr[2].php;所以为了方便调用将$arr对应的值存到常量中，因为常量不存在使用范围的限制
        define('APP',$arr[0]);
//        将$arr[1]对应的值存到常量中，方便在houdunwang\View空间的base类组建模版引入路径时使用，默认的主页路径是../app/home/view/entry/index.php,相当于是../app/$arr[0]/view/$arr[1]/$arr[2].php;所以为了方便调用将$arr对应的值存到常量中，因为常量不存在使用范围的限制
        define('CONTROLLER',$arr[1]);
//        将$arr[2]对应的值存到常量中，方便在houdunwang\View空间的base类组建模版引入路径时使用，默认的主页路径是../app/home/view/entry/index.php,相当于是../app/$arr[0]/view/$arr[1]/$arr[2].php;所以为了方便调用将$arr对应的值存到常量中，因为常量不存在使用范围的限制
        define('ACTION',$arr[2]);
//        组合调用的类的空间名和类名，因为类名字首字母为大写，因为调用的类名也就是$arr[1]所以要将$arr[1]的首字母改为大写
        $className="\app\\{$arr[0]}\controller\\".ucfirst($arr[1]);
//        自动调用控制器里的方法，默认为调用app\home\controller空间下的entry类中的index方法，因为只有输出对象时才会触发__tostring方法，所以要将返回的对象输出来触发__tostring方法完成载入应用模版和提示信息的一些操作
        echo call_user_func_array([new $className,$arr[2]],[]);
    }
}