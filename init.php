<?php

//session开启
session_start();

//声明一个PATH 这个PATH拼接定位前台的project项目目录下
define('PATH',str_replace('\\','/',dirname(__FILE__).'/'));

// 定义一个前台项目目录
define('URL','http://localhost/project/');


//导入config文件
include PATH.'./config.php';
//导入function.php文件
include PATH.'./function.php';

//时区
date_default_timezone_set('PRC');

// 字符集
header("content-type:text/html;charset=utf-8");

//错误级别 
error_reporting(E_ALL ^ E_NOTICE);

//数据库前四步

$link = mysqli_connect(HOST,USER,PWD);
if(mysqli_connect_errno($link)){
    echo mysqli_connect_error($link);
    exit;
}
mysqli_select_db($link,DB);
mysqli_set_charset($link,CHARSET);

