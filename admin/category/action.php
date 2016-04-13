<?php

include '../init.php';

$a = $_GET['a'];

switch($a){
    case 'add':
        //var_dump($_POST);
        $name = $_POST['name'];
        $pid  = $_POST['pid'];
        $path = $_POST['path'];
        $display =$_POST['display'];
        $sql="INSERT INTO ".PRE."category(name,pid,path,`display`) VALUES('{$name}',{$pid},'{$path}',{$display})";
        $result = execute($link,$sql);
        if ($result)
        {
            redirect('添加成功','./index.php');
        } 
            else 
        {
            redirect('添加失败','./add.php');
        }
        break;
    case 'del':
        $id = $_GET['id'];
        $sql="SELECT id,name,pid,path,display FROM ".PRE."category WHERE pid={$id}";
        $result = query($link,$sql);
        if($result){
            redirect('亲你有子类不能直接删除','./index.php');
        }else{
            $sql="DELETE FROM ".PRE."category WHERE id={$id}";
            $result = execute($link,$sql);
            if($result){
                header('location:index.php');
            }else{
                header('location:index.php?pid='.$id);
            }
        }
        break;
    case 'edit':
       // var_dump($_POST);
        $id = $_POST['id'];
        $name = $_POST['name'];
        $pid = $_POST['pid'];
        $path =$_POST['path'];
        $display = $_POST['display'];
        $sql ="UPDATE ".PRE."category SET name='{$name}',pid={$pid},path='{$path}',display={$display} WHERE id={$id}";
        $result = execute($link,$sql);
        if($result){
            redirect('修改成功','./index.php');
        }else{
            redirect('修改失败','./index.php');
        }
        break;
    case 'display':
        $id = $_GET['id'];
        $display =$_GET['display'];
        $sql="UPDATE ".PRE."category SET display={$display} WHERE id={$id}";
      // echo $sql;exit;
        $result = execute($link,$sql);
        if($result){
            header('location:./index.php');
        }else{
            header('location:./index.php');
        }
        break;
}
