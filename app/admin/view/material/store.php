<?php include './view/admin/header.php'?>
<div class="container">
    <?php include './view/admin/left.php'?>
    <div class="col-xs-9">
        <a href="?s=admin/material/store" class="btn btn-default">添加</a>
        <a href="?s=admin/material/lists" class="btn btn-primary">列表</a>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputFile">上传素材</label>
                <input type="file" id="exampleInputFile" name="upload" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">保存</button>
        </form>
    </div>
</div>
</body>
</html>