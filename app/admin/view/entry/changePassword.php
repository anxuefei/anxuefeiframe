<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/cs/animate.css">
</head>
<body>
<div class="container animated bounceInDown" style="margin: 30px auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">修改密码</h3>
        </div>
        <div class="panel-body">
            <form action="" method="post" role="form">
                <div class="form-group">
                    <label for="">旧密码：</label>
                    <input type="password" class="form-control" name="oldPassword" id="" required>
                </div>
                <div class="form-group">
                    <label for="">新密码：</label>
                    <input type="password" class="form-control" name="newPassword" id="" required>
                </div>
                <div class="form-group">
                    <label for="">确认密码：</label>
                    <input type="password" class="form-control" name="confirmPassword" id="" required>
                </div>
                <button type="submit" class="btn btn-primary">修改</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>