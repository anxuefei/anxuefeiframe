<?php include './view/admin/header.php'?>
<div class="container">
    <?php include './view/admin/left.php'?>
    <div class="col-xs-9 animated bounceInUp">
        <a href="?s=admin/student/store" class="btn btn-primary">添加</a>
        <a href="?s=admin/student/lists" class="btn btn-default">列表</a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>性别</th>
                <th>头像</th>
                <th>所属班级</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $k=>$v): ?>
            <tr>
                <td><?php echo $k+1;?></td>
                <td><?php echo $v['sname']?></td>
                <td><?php echo $v['sex']?></td>
                <td>
                    <img src="<?php echo $v['profile']?>" width="50">
                </td>
                <td><?php echo $v['gname']?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="?s=admin/student/update&sid=<?php echo $v['sid']?>" class="btn btn-warning btn-xs">编辑</a>
                        <a href="javascript:if(confirm('确定删除吗?')) location.href='?s=admin/student/remove&sid=<?php echo $v['sid']?>';" class="btn btn-danger btn-xs">删除</a>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>