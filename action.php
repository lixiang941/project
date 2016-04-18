<?php

    include './init.php';

    $a = $_GET['a'];

    switch($a){
    case 'reg':
        var_dump($_POST);
        $name = $_POST['name'];
        $password= $_POST['password'];
        $repassword = $_POST['repassword'];
        $age = $_POST['age'];
        $ty = $_POST['ty'];
        if($age !=1){
            //header('location:register.php');
            redirect('亲 你还没有年满18','./register.php');exit;
            exit;
        }
        if($ty != 1){
            redirect('请点击我同意','./register.php');exit;
            
            // header('location:register.php');
            exit;
        }
        if($password != $repassword){
            redirect('两次密码不正确','./register.php');exit;
        }
        $sql="INSERT INTO ".PRE."user(name,password,role) VALUE('{$name}',md5('{$password}'),0)";
      //  echo $sql;exit;
        $res = execute($link,$sql);
        var_dump($res);
        if($res){
            $_SESSION['home']=$_POST;
           redirect('注册成功','./index.php');
            exit;
        }else{
            redirect('注册失败','./register.php');exit;
        }
        
        break;
        case 'loginout':
            unset($_SESSION['home']);
            header('location:./index.php');
        break;
    }
