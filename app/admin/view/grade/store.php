<?php include './view/admin/header.php'?>
<div class="container">
    <?php include './view/admin/left.php'?>
    <div class="col-xs-9">
        <a href="?s=admin/grade/store" class="btn btn-default">添加</a>
        <a href="?s=admin/grade/lists" class="btn btn-primary">列表</a>
        <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">班级名称</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="gname">
            </div>
            <button type="submit" class="btn btn-success">添加</button>
        </form>
    </div>
</div>
</body>
</html>