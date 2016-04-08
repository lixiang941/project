<?php
include './init.php';
$a = $_GET['a'];

switch($a){
    case 'dologin':
        $name = $_POST['username'];
        $password = $_POST['pwd'];
        //检测用户名是否正确
        $preg ='/^[a-zA-Z]\w{5,8}$/';
        if(!preg_match($preg,$name,$arr)){
            echo '';
        }    
    break;
}
