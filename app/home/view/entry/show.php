<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
    <script src="./static/js/jquery.min.js"></script>
    <script src="./static/bt3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./static/cs/animate.css">
</head>
<body>
<nav class="navbar navbar-inverse animated bounceInDown" style="border-radius: 0px;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:;">欢迎进入学生管理系统</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?s=home/entry/index">返回主页</a></li>
                <li><a href="?s=admin/entry/index">管理学生信息</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container animated bounceInUp" style="margin-top:100px; ">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php foreach($data as $v):?>
            <h3 class="panel-title"><?php echo $v['sname']?>同学的详细信息</h3>
            <?php endforeach;?>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>头像</th>
                    <th>生日</th>
                    <th>爱好</th>
                    <th>所属班级</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $k => $v):?>
                    <tr>
                        <td><?php echo $k+1?></td>
                        <td><?php echo $v['sname']?></td>
                        <td><?php echo $v['sex']?></td>
                        <td><img src="<?php echo $v['profile']?>" width="50"></td>
                        <td><?php echo $v['birthday']?></td>
                        <th><?php echo $v['hobby']?></th>
                        <td><?php echo $v['gname']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>