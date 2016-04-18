<?php

include '../init.php';


$a = $_GET['a'];


switch($a){
    case 'add':
        var_dump($_POST);
        //1. 判断所有表单是否为空
        foreach($_POST as $value){
          //  var_dump($value);
            if($value==''){
             
                redirect('表单填写不完整','./add.php');
                exit;
            }
        }
        //2 处理文件上传
      //  echo PATH.'uploads/'
        $filename =upload('pic',PATH.'uploads/');
        var_dump($filename);
        //如果上传不成功
        if(!$filename){
            redirect('上传失败','./add.php');
            exit;
        }
        //echo 111;
        //缩放图片
        //处理图片路径

        $img_path = PATH.'uploads/';
        $img_path .=substr($filename,0,4).'/';
        $img_path .=substr($filename,4,2).'/';
        $img_path .=substr($filename,6,2).'/';
        $img_path.=$filename;
       // echo $img_path;
        if(
            !zoom($img_path,150,150) ||
            !zoom($img_path,80,80) ||
            !zoom($img_path,50,50)
        ){
           // echo 111;
            //拼接缩放图片路径
            // $path_150 =dirname($img_path) 
            $path_150 = dirname($img_path).'/150_'.basename($img_path);
            $path_80 = dirname($img_path).'/80_'.basename($img_path);
            $path_50 = dirname($img_path).'/50_'.basename($img_path);
            @unlink($path_150);
            @unlink($path_80);
            @unlink($path_50);
            //删除原图
            unlink($img_path);
            redirect('缩放失败','./add.php');exit;
        }
        //接受数据
        $name = $_POST['name'];
        $cate_id = $_POST['cate_id'];
        $price =$_POST['price'];
        $stock =$_POST['stock'];
        $status =$_POST['status'];
        $is_hot = $_POST['is_hot'];
        $is_new = $_POST['is_new'];
        $is_best = $_POST['is_best'];
        $describe = $_POST['describe'];
        $addtime = time();

        $sql="INSERT INTO ".PRE."goods(name,cate_id,price,stock,status,is_hot,is_new,is_best,addtime,`describe`) VALUES('{$name}',{$cate_id},{$price},{$stock},{$status},{$is_hot},{$is_new},{$is_best},{$addtime},'{$describe}')";
        $goods_id=execute($link,$sql);
        if($goods_id){
            //将商品图片添加到图片表
            $sql="INSERT INTO ".PRE."image(name,goods_id,is_face) VALUES('{$filename}',{$goods_id},1)";
            $result = execute($link,$sql);
            if($result){
                redirect('商品添加成功','./index.php');exit;
            }else{
                $sql="DELETE FROM ".PRE."goods WHERE id={$goods_id}";
                $res=execute($link,$sql);
                if($res){
                $path_150 = dirname($img_path).'/150_'.basename($img_path);
                $path_80 = dirname($img_path).'/80_'.basename($img_path);
                $path_50 = dirname($img_path).'/50_'.basename($img_path);
                @unlink($path_150);
                @unlink($path_80);
                @unlink($path_50);
                //删除原图
                unlink($img_path);
                    redirect('商品添加失败','./add.php');exit;
                }
            }

        }else{
            $path_150 = dirname($img_path).'/150_'.basename($img_path);
            $path_80 = dirname($img_path).'/80_'.basename($img_path);
            $path_50 = dirname($img_path).'/50_'.basename($img_path);
            @unlink($path_150);
            @unlink($path_80);
            @unlink($path_50);
            //删除原图
            unlink($img_path);
            redirect('添加商品失败','./add.php');exit;
        }
        

        break;
    case 'addimg':
        $gid = $_POST['gid'];
        $gname =$_POST['gname'];

        //上传缩放问题
        $filename =upload('pic',PATH.'uploads/');
        if(!$filename){
             redirect('上传失败','./image.php?gid='.$gid.'&gname='.$gname);
         
        exit;
        }
        //图片缩放
        //拼路径
        $img_path = getPath($filename);
        // echo $img_path;
        if(
            !zoom($img_path,150,150)||
            !zoom($img_path,80,80)||
            !zoom($img_path,50,50)
        ){
            $path_150 = dirname($img_path).'/150_'.basename($img_path);
            $path_80 = dirname($img_path).'/80_'.basename($img_path);
            $path_50 = dirname($img_path).'/50_'.basename($img_path);
            @unlink($path_150);
            @unlink($path_80);
            @unlink($path_50);
            unlink($img_path);
            redirect('缩放失败','./image.php?gid='.$gid.'&gname='.$gname);
          
        }

        

        $sql="INSERT INTO ".PRE."image(name,goods_id,is_face) VALUES('{$filename}',{$gid},0)";
        $result = execute($link,$sql);
        if($result){
            redirect('添加成功','image.php?gid='.$gid.'&gname='.$gname);
            exit;
           
        }else{
             $path_150 = dirname($img_path).'/150_'.basename($img_path);
            $path_80 = dirname($img_path).'/80_'.basename($img_path);
            $path_50 = dirname($img_path).'/50_'.basename($img_path);
            @unlink($path_150);
            @unlink($path_80);
            @unlink($path_50);
            unlink($img_path);
            redirect('添加失败','image.php?gid='.$gid.'&gname='.$gname);
           
        exit;
        }
       

        break;
    case 'is_face':
        var_dump($_GET);
        $gid=$_GET['gid'];
        $gname = $_GET['gname'];
        $id = $_GET['id'];
        $sql="UPDATE ".PRE."image SET is_face=0 WHERE goods_id={$gid}";
       // echo $sql;
        $result = execute($link,$sql);
        if($result){
            $sql="UPDATE ".PRE."image SET is_face =1 WHERE id ={$id}";
            $res = execute($link,$sql);
            if($res){
              //  echo 333;
                header('location:image.php?gid='.$gid.'&gname='.$gname);
            }else{
               // echo 22;
                header('location:image.php?gid='.$gid.'&gname='.$gname);
            }
        }else{
            //echo 111;
            header('location:image.php?gid='.$gid.'&gname='.$gname);
        }
        break;

    case 'del':
        $gid = $_GET['gid'];
        //干掉图片
        //这个商品的图片都拿出来
        $sql="SELECT name FROM ".PRE."image WHERE goods_id={$gid}";
        $image = query($link,$sql);
        //var_dump($image);
        if($image){
        foreach($image as $value){
            //拼接路径
            $path = getPath($value['name']);
            $path_150 = getPath($value['name'],'150_');
            $path_80 = getPath($value['name'],'80_');
            $path_50 = getPath($value['name'],'50_');
           // echo $path_50;
          // var_dump($value);

            @unlink($path_150);
            @unlink($path_80);
            @unlink($path_50);
            @unlink($path);
        }

        //删除图片表中的数据库
        $sql="DELETE FROM ".PRE."image WHERE goods_id={$gid}";
        $result =execute($link,$sql);
        if($result){
            header('location:index.php');
        }else{
            
            header('location:index.php');
        }
    }else{
        
            header('location:index.php');
    }
        break;

    case 'edit':
        echo '<pre>';
        var_dump($_POST);
        $gid= $_POST['gid'];
        $name= $_POST['name'];
        $cate_id=$_POST['cate_id'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $describe = $_POST['describe'];
        $sql="UPDATE ".PRE."goods SET name='{$name}',cate_id={$cate_id},price='{$price}',stock={$stock},`describe`='{$describe}' WHERE id={$gid}";
       // echo $sql;exit;
        $result = execute($link,$sql);
        if($result){
            redirect('修改成功','./index.php');
        }else{
            redirect('修改失败','./edit.php?gid='.$gid);
        }
                    

        break;
    case 'status':
        var_dump($_GET);
        $gid = $_GET['gid'];
        $status = $_GET['status'];
        $sql="UPDATE ".PRE."goods SET `status`={$status} WHERE id={$gid}";
        $result = execute($link,$sql);
        if($result){
            header("location:index.php");
        }else{
        
            header("location:index.php");
        }
        break;
    case 'is_hot':
       // var_dump($_GET);
        $gid = $_GET['gid'];
        $is_hot = $_GET['is_hot'];
        $sql="UPDATE ".PRE."goods SET `is_hot`={$is_hot} WHERE id={$gid}";
        $result = execute($link,$sql);
        if($result){
            header("location:index.php");
        }else{
        
            header("location:index.php");
        }
        break;
    case 'is_best':
       // var_dump($_GET);
        $gid = $_GET['gid'];
        $is_best = $_GET['is_best'];
        $sql="UPDATE ".PRE."goods SET `is_best`={$is_best} WHERE id={$gid}";
        $result = execute($link,$sql);
        if($result){
            header("location:index.php");
        }else{
        
            header("location:index.php");
        }
        break;
        case 'is_new':
       // var_dump($_GET);
        $gid = $_GET['gid'];
        $is_new = $_GET['is_new'];
        $sql="UPDATE ".PRE."goods SET `is_new`={$is_new} WHERE id={$gid}";
        $result = execute($link,$sql);
        if($result){
            header("location:index.php");
        }else{
        
            header("location:index.php");
        }
        break;
    case 'delimg':
       // var_dump($_GET);
        $iid = $_GET['iid'];
        $is_face = $_GET['is_face'];
        $gid = $_GET['gid'];
        if($is_face ==1){
            redirect('你是封皮不能删除','./image.php?gid='.$gid);
            exit;
        }        
        $sql="DELETE FROM ".PRE."image WHERE id={$iid}";
        $result = query($link,$sql);
        if($result){
            header('location:image.php?gid='.$gid);
        }else{
            
            header('location:image.php?gid='.$gid);
        }
        break;
}
