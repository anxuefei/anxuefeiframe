<?php
/**
 * Created by PhpStorm.
 * User: AAA
 * Date: 2017/8/1
 * Time: 23:00
 */
//material类所在的空间
namespace app\admin\controller;

//引入父类controller，完成提示信息的操作
use houdunwang\core\Controller;
//引入view类完成加载模版和数据的操作
use houdunwang\view\View;
//引入material类因为和这个类名字一样所以起一个别名，用来完成调用和修改数据库对应的表的内容
use system\model\Material as MaterialModel;
//创建一个material类完成素材的添加，删除和内容的显示
class Material extends Common{
//    创建一个lists方法用来显示material类对应的数据库中素材表的信息
    public function lists(){
//            调用system\model空间的material类触发houdunwang\model里model类得到表名material，通过对应空间的base类中的get方法获取material表的所有内容，通过有结果集的操作调出数据，返回到这个对象，将得到的值传给View类空间的base类中的with方法将数据返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成加载数据和载入对应模版的操作，但是material表中的create_time储存的是一个时间戳所以使用时要见这个数据的时间戳格式化
        $data=MaterialModel::get();
//        p($data);exit;
//        调用system\model空间的material类触发houdunwang\model里model类得到表名meterial，通过对应空间的base类中的get方法获取material表的所有内容，通过有结果集的操作调出数据，返回到这个对象，将得到的值传给View类空间的base类中的with方法将数据返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成加载数据和载入对应模版的操作
        return View::make()->with(compact('data'));
    }
//    创建一个remove方法完成素材数据的删除和删除对应的数据库文件的操作
    public function remove(){
//        获得get参数mid传过来的值也就是material表中的gid对应的值，用来添写where条件
        $mid=$_GET['mid'];
//        因为删除数据库表中的数据也要将对应的数据文件上传所以要获得要删除数据的文件路径也就是material表中的path值.
//        通过houdunwang\model空间的base类中的find方法获取要删除的数据信息获得删除的文件路径
        $data=MaterialModel::find($mid);
//        判断这个文件路径对应的文件是不是一个文件如果是就将对应的文件删除
        is_file($data['path']) && unlink($data['path']);
//        调用houdunwang\model空间的destory方法，将where条件传送到where方法完成素材的内容删除和数据库对应文件的删除操作
        MaterialModel::where("mid={$mid}")->destory();
//            调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
        return $this->success('删除成功')->setRedirect('?s=admin/material/lists');

    }
//    创建一个store方法完成素材的添加操作也就是上传文件
    public function store(){
//        判断是不是POST模式也就是点击了上传，如果是就执行if判断的代码完成添加
        if(IS_POST){
//            获得上传的文件信息
            $info=$this->upload();
//            p($info);exit;
//            因为素材表中只需要文件的路径名，和上传时间就可以所以需要将对应的数据重新获取赋值给$data获得material表需要的对应内容，最后将$data添加到对应的素材表material中
            $data=[
//                获得上传文件的文件路径名
                'path' => $info['path'],
//                获得当前文件上传的时间戳，也就是文件上传时间
                'create_time' => time()
            ];
//            调用system\Model的material类触发material类的父类houdunwang\model的model类获得表名，在通过父类空间的base类中的save方法将重新的到的数据也就是文件路径名和创建时间进行处理，通过无结果集的操作完成数据添加，将结果返回到当前对象
            MaterialModel::save($data);
//            调用houdunwang\core中的父类Controller中的success方法将对应的提示信息接收并获得要载入的提示模版路径，再调用setRedirect方法将跳转的地址传入到跳转地址，最后将对象返回到houdunwang\core空间的boot类中的appRun方法输出对象，触发controller类中的__tostring方法完成载入对应的提示模版显示对应的提示信息的操作
            return $this->success('上传成功')->setRedirect('?s=admin/material/lists');
        }
//        调用View类触发对应空间的make方法获得要引入的模版路径，返回到houdunwang\core中的boot类中的arrRun方法输出这个对象，触发View类空间的base类中的__tostring方法完成载入对应模版的操作，
        return View::make();
    }
//    创建一个文件上传方法引用composer中的上传库完成文件上传
    public function upload(){
        //创建上传目录
        $dir = 'upload/' . date( 'ymd' );
        is_dir( $dir ) || mkdir( $dir, 0777, true );
        //设置上传目录
        $storage = new \Upload\Storage\FileSystem( $dir );
        $file    = new \Upload\File( 'upload', $storage );
        //设置上传文件名字唯一
        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName( $new_filename );

        //设置上传类型和大小
        // Validate file upload
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations( array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype( [ 'image/png', 'image/gif', 'image/jpeg' ] ),

            //You can also add multi mimetype validation
            //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size( '5M' )
        ) );

        //组合数组
        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
//            'md5'        => $file->getMd5(),
//            'dimensions' => $file->getDimensions(),
            //自己组合的上传之后的完整路径
            'path'       => $dir . '/' . $file->getNameWithExtension(),
        );


        // Try to upload file
        try {
            // Success!
            $file->upload();

            return $data;
        } catch ( \Exception $e ) {
            // Fail!
            $errors = $file->getErrors();
            foreach ( $errors as $e ) {
                throw new \Exception( $e );
            }

        }
    }
}