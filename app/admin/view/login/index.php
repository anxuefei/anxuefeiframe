<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="./static/js/jquery.min.js"></script>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/cs/animate.css">
    <script>
       $(function () {
           $('input[name=captcha]').blur(function () {
               var cdata= $(this).val();
               if(cdata==''){
                   return;
               };
               $.ajax({
                   url  : "?s=admin/login/verify",
                   data : {c:cdata},
                   type : 'post',
                   success:function(phpData){
                       if(phpData==1){
                           $('#captcha').html(
                               '<span style="color: green">验证码正确</span>'
                           );
                           $('input[name=captcha]').removeClass('error');
                       }else {
                           $('#captcha').html(
                               '<span style="color: red">验证码不正确</span>'
                           );
                           $('input[name=captcha]').addClass('error');
                       }
                   }
               })
               $('form').submit(function () {
                   if($('.error').length>0){
                       return false;
                   }
               })
           })
       })
    </script>
</head>
<body>
<div class="container animated bounceInDown" style="margin: 30px auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">登录页面</h3>
        </div>
        <div class="panel-body">
            <form action="" method="post" role="form">
                <div class="form-group">
                    <label for="">用户名：</label>
                    <input type="text" class="form-control" name="username" id="" required>
                </div>
                <div class="form-group">
                    <label for="">密码：</label>
                    <input type="password" class="form-control" name="password" id="" required>
                </div>
                <div class="form-group">
                    <label for="">验证码：</label>
                    <input type="text" class="form-control" name="captcha"  required>

                    <br>
                    <div id="captcha">
                    </div>
                    <img src="?s=admin/login/captcha" onclick="this.src=this.src+'&'+Math.random();">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="auto">
                        七天免登录
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">登录</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>