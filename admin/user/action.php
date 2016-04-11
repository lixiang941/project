<?php
include '../init.php';

$a = $_GET['a'];
switch($a){
    //添加
    case 'add':
        $name=$_POST['name'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $role = $_POST['role'];
        // var_dump($_POST);
        //判断两次密码是否正确
        if($password !=$repassword){
            redirect('两个密码不正确','./add.php');
            exit;
        }
        
        //添加管理员
        $sql="INSERT INTO ".PRE."user(id,name,password,`role`) VALUES(NULL,'{$name}',md5('{$password}'),$role)";
        $result= execute($link,$sql);
        if($result){
            redirect('添加成功','./index.php');
        }else{
            redirect('添加失败','./add.php');
        }
        break;
   //删除
    case 'del':
        $id= $_GET['id'];
        $sql="DELETE FROM ".PRE."user WHERE id={$id}";
        $result = execute($link,$sql);
        if($result){
            header('location:index.php');
        }else{
            header('location:index.php');
        }
        break;
    //修改锁定状态
    case 'lock':
        $id=$_GET['id'];
        $lock=$_GET['lock'];
        $sql="UPDATE ".PRE."user SET `lock`={$lock} WHERE id={$id}";
        $result = execute($link,$sql);
        if($result){
            header('location:index.php');
        }else{
            header('location:index.php');
        }
        break;
    //修改用户信息
    case 'edit':
        $id = $_POST['id'];
        $name=$_POST['name'];
        //$password = $_POST['password'];
        $role = $_POST['role'];
        if(empty($_POST['password'])){
            $sql="UPDATE ".PRE."user SET name='{$name}',role={$role} WHERE id={$id} ";
            if(execute($link,$sql)){
                redirect('修改成功','index.php');
            }else{
                redirect('修改失败','edit.php?id='.$id);
            }
        }else{
            $password=$_POST['password'];
            $repassword=$_POST['repassword'];
            if($password !=$repassword){
                redirect('两次密码不一致',"edit.php?id={$id}");
                exit;
            }
            
            $sql="UPDATE ".PRE."user SET name='{$name}',password=md5('{$password}'),role={$role} WHERE id={$id} ";
            if(execute($link,$sql)){
                redirect('修改成功','index.php');
            }else{
                redirect('修改失败','edit.php?id='.$id);
            }
        }
         break;
}


