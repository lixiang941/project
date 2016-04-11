<?php
include './init.php';
$a = $_GET['a'];
//var_dump($link);

switch($a){
    case 'dologin':
        $name = $_POST['username'];
        $password = $_POST['pwd'];
        //检测用户名是否正确
        $preg ='/^[a-zA-Z]\w{4,8}$/';
        if(!preg_match($preg,$name,$arr)){
            redirect('用户名格式错误','./login.php');
            exit;
        }    

        //检测密码长度是否正确
        if(!strlen($password)>6){
            redirect('密码长度不正确','./login.php');
            exit;
        }
        //检测用户名是否在数据库中
        $sql="SELECT id,name,password,role,`lock` FROM ".PRE."user WHERE name='{$name}' AND role !=0";
        //echo $sql;exit;

        $user = query($link,$sql);
        if(!empty($user)){
            $password = md5($password);
            if($user[0]['password']!=$password){
                redirect('用户名或密码不正确！','./login.php');
                exit;
            }
            //将除密码以外的所有信息存入session
            unset($user[0]['password']);
            $_SESSION['admin']=$user[0];
           // echo '<pre>';
            //var_dump($_SESSION);
            redirect('登录成功','./index.php');  
        }else{
            redirect('用户名或密码不正确','./login.php');
            exit;
        }
        break;
    case 'loginout':
        unset($_SESSION['admin']);
        header('location:login.php');
        break;
}
