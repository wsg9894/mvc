<?php 

header("content-type:text/html;charset=utf-8");


//定义当前目录
define('APP_PATH',__DIR__.'/');
//定义报错级别
define('debug',true);

//加载主要配置文件  从config文件里面返回主要配置信息
$config = include(APP_PATH.'config/config.php');

//加载框架的主要配置文件  支撑整个框架的运行
include APP_PATH.'framework/application.php';

//实例化主要类库  new的时候要写路径  否则就会报错
//  new 命名空间+类名
$obj = new framework\application\application($config);
$obj->run();


