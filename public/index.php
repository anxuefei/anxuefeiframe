<?php
//引用composer 库中的自动载入来完成框架的文件载入功能
include '../vendor/autoload.php';
//调用\houdunwang\core空间中的boot类中的run方法来完成框架载入和初始化操作
houdunwang\core\Boot::run();