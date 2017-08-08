<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
    <script>
        window.onload=function(){
            var a=3;
            var m=document.getElementById('m');
            setInterval(function(){
                a--;
                m.innerHTML=a;
            },1000)
        }
    </script>
</head>
<body>
<div>
    <div style="width: 400px;margin: 200px auto;">
        <h1><?php echo $this->msg ?></h1>
        <p>
            <span style="color: red" id="m">3</span>
            秒后自动跳转!!
            <br>
            如果没有跳转请点击
            <a href="javascript:<?php echo $this->url?>;" class="btn btn-primary">跳转</a>
        </p>
    </div>
    <script>
        setInterval(function(){
            <?php echo $this->url ?>
        },3000)
    </script>
</div>
</body>
</html>