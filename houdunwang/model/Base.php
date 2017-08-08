<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/7/30
 * Time: 19:27
 */
//base类所在的空间名
namespace houdunwang\model;
//开启pdo所在的空间，完成操作数据库的一些操作
use PDO;
//开启PDOException所在的空间
use PDOException;
//创建一个base类用来执行连接数据库，查看数据库数据，修改数据的一些操作并对应的数据返回给对应的方法中
class Base{
//    创建一个静态属性pdo用来连接数据库，如果为空就连接数据库，如果不为空表示数据库已经连接
    private static $pdo=NULL;
//    创建一个用来接收表名的属性，方便完成一些获取内容修改内容时填写表名的操作
    private $table;
//    创建一个where属性用来储存where条件
    private $where=NULL;
//    当调用BASE类时自动执行这个方法，并调用当前类的connect方法连接数据库
    public function __construct($table)
    {
//        调用connect方法完成数据库连接的操作
        $this->connect();
//        将传递过来的标的名字接收到，完成调取对应表的数据或修改的操作
        $this->table=$table;
    }
//    创建一个CONNECT方法用来连接数据库的操作
    private function connect(){
//        判断静态属性的值是不是为NULL如果为NULL表示没有连接数据库，如果不为NULL表示数据库已经连接，防止重复连接数据库
        if(is_null(self::$pdo)){
//                调用C函数引用c函数中的参数连接对应的数据库
            $dsn="mysql:host=".c('database.db_host').';'.'dbname='.c('database.db_name');
//                连接数据库
            $pdo=new PDO($dsn,c('database.db_user'),c('database.db_password'));
//                设置错误方法为异常错误
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//                将数据库编码设置成c函数对应的参数
            $pdo->exec("SET NAMES ".c("database.db_charset"));
//                将$pdo对象赋值给静态属性$pdo，表示已经连接了数据库防止重复连接
            self::$pdo=$pdo;
        }

    }
//    创建一个get方法用来获取对应表的所有数据
    public function get(){
//        如果where属性不为NULL表示获取的是单条数据
        if(is_null($this->where)){
//        获取传过来的对应的表的数据，将对应的表添加到获取所有数据的SQL语句中，并通过有结果集的操作完成获取数据，并将获取的数据转换才关联数组返回到对应的对象
            $sql = "SELECT * FROM {$this->table}";
        }else{
            $sql="SELECT * FROM {$this->table} WHERE {$this->where}";
        }

//        通过有结果集的操作执行sql语句完成获取对应表的数据
        $result=self::$pdo->query($sql);
//        将多去的数据转换成关联数组
        $data= $result->fetchAll(PDO::FETCH_ASSOC);
//        将转好的数据返回给当前的对象
        return $data;

    }
//    创建一个q方法用来执行一些有结果集的sql语句，并将获取的数据返回给当前对象
    public function q($sql){
//            通过有结果集的操作执行传递过来的sql语句，并将获取的结果赋值给$result
        $result=self::$pdo->query($sql);
//            将获取的结果转换成关联数组返回给当前对象
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }
//创建一个e方法用来执行一些没有结果集的sql语句，并将获取的数据返回给当前对象
    public function e($sql){
//            通过没有结果集的操作执行传递过来的sql语句，并将执行完获取的结果赋值给$afRows
        $afRows=self::$pdo->exec($sql);
//            将获取的结果返回给当前对象
        return $afRows;

    }
    public function save($data){
//        获取对应表的字段信息，获得字段信息中的FIELD值也就是表中对应的字段名，来和提交过来的数据进行匹配，因为name值和字段名是一样的名字，到时匹配如果是一样的名字的就表示是添加的内容，如果name值和field名字不一样说明是验证码一类的内容可以直接过滤掉，最后见过滤好的内容进行转换添加到表中
        $tableInfo=$this->q("DESC {$this->table}");
//        创建一个便利用来储存对应表的字段名
        $tableFields=[];
//        因为获得的表的字段信息是一个数组所以见数组便利，将对应的Field值也就是字段名储存到$tablefieds中用来和提交过来的数据的name名进行匹配
        foreach($tableInfo as $Info){
//            将便利好的field值存到tablefields变量中组后获得的数据就是
//            Array
//            (
//                [0] => aid
//                [1] => title
//                 [2] => click
//)
            $tableFields[] = $Info['Field'];
        }
//        p($tableFields);exit;
//        创建一个变量用来接收过滤好的提交数据
        $felterData = [];
        //        p($data);
//        Array
//        (
//            [title] =>
//                [click] =>
//        [captcha] =>

//        便利提交过来的数据，判断name值是不是存在于tableFields数组中，如果存在表示是需要添加的内容，让felterData将对应的name值和数据储存，最后惊醒转换添加到对应的表中
        foreach($data as $k=>$v){
//            判断name值是不是存在于$tablefields这个数组中，也就是表的字段名和提交过来的name值是不是一样，如果一样就将对应的数据储存起来
            if(in_array($k,$tableFields)){
//                将对应的数据储存起来，最后进行转换添加到对应的表中，name值相当于对应的字段名，到时直接将name值转换成字段名
                $felterData[$k] =$v;
            }
        }
//        p($felterData);exit;
//        因为进行添加时的sql语句是INSERT INTO {$this->table} (title,click) VALUES ('撒旦法','范德萨')
//        现在获得的数据是Array
//        (
//            [title] => 撒旦法
//        [click] => 范德萨
//)
//        所以要将键值和键名拿到，最后转换完的键值就是要添加的内容，键名就是字段名
        $field=implode(',',array_keys($felterData));
//        p($field);exit;获得数组$felterdata的所有键值，然后转换成字符串title,click，最后相当于这就是要填写的字段名
//        将$felterdata中的所有键值拿到进行转换，因为添加的值是字符串要添加引号，所以两边要连接双引号，用引号都好隔开最后获得的数据就是'撒旦法','范德萨'，让后将这个数据添加到values后面完成添加操作
        $values="'" .implode("','",array_values($felterData)). "'";
//        p($values);exit;'撒旦法,范德萨'
//        将对应的表名，字段名，要添加的值添加到sql语句中，最后通过无结果集的操作完成添加
//        p($values);exit;
        $sql="INSERT INTO {$this->table} ({$field}) VALUES ({$values})";
//        通过无结果集的操作执行sql语句完成添加操作，最后将操作结果返回到index方法完成添加
        return $this->e($sql);
    }
//    创建一个where方法用来接收修改删除时的where条件，
    public function where($where){
//        将调用where方法是穿过来的数据接收到where属性中，用来修改和删除数据时添加where条件
        $this->where= $where;
//        将得到的where条件返回到对应的对象中，和对应的方法完成删除或修改操作
        return $this;
    }
//    创建一个update方法完成对应数据表的内容修改的操作
    public function update($data){
//        判断where属性有没有传递参数，也就是有没有where条件，如果没有表示没有where条件直接弹出提示内容并终止代码
        if(!$this->where){
//            如果没有where条件终止代码并打印提示信息
            exit('updata方法修改内容要有where条件');
        }
        //        p($data);exit;
//        Array
//        (
//            [title] => 司法大案
//            [click] => 萨芬的
//)
//        因为修改表内容的sql语句是update arc set title=...,click=.. where aid=..;但是post提交的数据是一个数组，对应的name值就是对应的字段名，name只对应的键值就是对应的字段内容，所以要将提交的数据转换成title=司法大案,click=萨芬的
//        创建一个变量用来接收转换好的字段和对应的数据
        $set='';
//        遍历post传递过来的数据转换成对应的sql语句中的内容
        foreach($data as $field => $value){
//            将遍历的内容存到set变量中$field相当于字段名，value相当于字段名对应的内容，因为是一个字符串所以要加引号，因为两个字段内容中间要有逗号隔开，所以后面添加一个逗号，但是最后一个字段值不需要逗号所以转换完以后要将最后一个逗号删除
            $set .= "{$field} ='{$value}',";
        }
//        将转换完成的字符串也就是要修改好的内容最后一个逗号去掉传到sql语句中加上where条件通过e方法执行没有结果集的操作完成修改
        $set =rtrim($set,',');
//        p($set);exit;title'='大法师',click'='324'
//        将所有条件添加到sql语句组成完成的修改内容的sql语句，最后通过e方法完成修改
        $sql="UPDATE {$this->table} SET {$set} WHERE {$this->where}";
//        p($sql);exit;
//        将修改的结果返回到当前对象，也就是app空间下的entry类中的updata方法中的arc类调用的updata放法完成修改
        return $this->e($sql);
    }
//    创建一个getprikey方法来获取对应表的主键，也就是id字段
    private function getPriKey(){
//        获取对应表的表结构，用来判断对应的有主键的字段名，也就是对应的id字段
        $data=$this->q("DESC {$this->table}");
//        常见一个空变量用来接收获取的标的带有主键属性的字段名
        $key='';
//        遍历获得表结构判断字段属性中的key如果有PRI属性表示这个字段是主键如果没有表示不是主键
        foreach($data as $v){
//            判断键名key的属性是不是PRI如果是直接让对应的字段名赋值给变量key，终止循环
            if($v['Key']=='PRI'){
//                将对应的字段名也就是每个表的id名赋值给key，方便以后添写where条件是调用
                $key =$v['Field'];
//                终止foreach循环
                break;
            }
        }
//        将获得对应的字段名返回给调用这个函数的对象
        return $key;
    }
//    创建一个find方法用来完成查询单挑数据的操作
    public function find($id){
//        通过getprikey方法获得这个表的主键名，也就是这个表的id名，方便查询是填写where条件
        $key=$this->getPriKey();
//        组建查询对应数据的sql语句，通过q方法也就是有结果集的操作获得对应的数据
        $sql ="SELECT * FROM {$this->table} WHERE {$key} = {$id}";
//        通过有结果集的操作获得对应的数据
        $data=$this->q($sql);
//        将获得的数据转换成一位数字返回到当前对象方便调用，
        return current($data);
    }
//    创建一个destory方法用来执行删除的sql语句完成删除数据的操作
    public function destory(){
//        判断where属性有没有传递参数，也就是有没有where条件，如果没有表示没有where条件直接弹出提示内容并终止代码
        if(!$this->where){
//            如果没有where条件终止代码并打印提示信息
            exit('updata方法修改内容要有where条件');
        }
//        通过e方法执行没有结果集的sql语句完成删除对应的数据的操作
        return $this->e("DELETE FROM {$this->table} WHERE {$this->where}");
    }


}