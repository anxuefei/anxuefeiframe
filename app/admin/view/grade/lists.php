<?php include './view/admin/header.php'?>
<div class="container">
    <?php include './view/admin/left.php'?>
    <div class="col-xs-9 animated bounceInUp">
        <a href="?s=admin/grade/store" class="btn btn-primary">添加</a>
        <a href="?s=admin/grade/lists" class="btn btn-default">列表</a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>班级名称</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $k=>$v): ?>
            <tr>
                <td><?php echo $k+1;?></td>
                <td><?php echo $v['gname']?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="?s=admin/grade/update&gid=<?php echo $v['gid']?>" class="btn btn-warning btn-xs">编辑</a>
                        <a href="javascript:if(confirm('确定删除吗?')) location.href='?s=admin/grade/remove&gid=<?php echo $v['gid']?>';" class="btn btn-danger btn-xs">删除</a>
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