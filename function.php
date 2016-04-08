<?php

    /*
     *  文件上传函数
     *
     *  @param $name 表单file的 name属性值
     *  
     *  @param $dir   上传成功保存的路径
     *
     *  @param $allow_type 文件上传的类型
     *
     *
     *  @return  $filename 成功返回新的文件名，上传失败返回false
     *
     * */

function upload($name,$dir='./uploads',$allow_type=array('jpg','gif','png','jpeg')){
    // 1.判断错误
    //
    if($_FILES[$name]['error']){
        echo '上传错误';
        return false;
      /*  switch($_FILES['file']['error']){
            case 1:
                echo '';
            case 2:
                echo ''
    }*/
    }

    //2.获取后缀名

    $suffix = pathinfo($_FILES[$name]['name'],PATHINFO_EXTENSION);
    //  echo $suffix;
    //3.判断文件类型是否正确

    if(!in_array($suffix,$allow_type)){
        echo '兄弟 文件类型不对呀，你是不搞错了  重来';
        return false;
    }
    //4.新的文件名

    $filename = date('Ymd').uniqid().mt_rand(0,9999).'.'.$suffix;

    //5. 判断上传文件目录是否存在

    $save_path = rtrim($dir,'/');

    $save_path .='/';
    //echo $save_path;
    //拼接完整路径  ./uploads/2015/07/16/  
    $save_path .=date('Y/m/d');
    //判断目录
    if(!file_exists($save_path)){
        mkdir($save_path,'777',true);
    }

    $path = $save_path.'/'.$filename;
    //echo $path;
    //6.判断是否是post 上传

    if(!is_uploaded_file($_FILES[$name]['tmp_name'])){
        echo '小兄弟 这点出息呀  动不动就来玩我！！';
        return false;
    }
    //7。移动图片完成上传
    if(!move_uploaded_file($_FILES[$name]['tmp_name'],$path)){
        echo '文件移动失败 文件上传不成功';
        return false;
    }

    return $filename;

}


/**
     * 缩放函数
     * @param string    $img_path   图片路径
     * @param int       $width      缩放后的宽
     * @param int       $height     缩放后的高
     * @return  没有返回值，函数自动保存缩放好的图片
     **/
    function zoom($img_path, $width=200, $height=200){

        // 1.获取图片的后缀
        $suffix = ltrim(strrchr($img_path, '.'),'.');

        if($suffix == 'jpg'){
            $suffix = 'jpeg';
        }

        // 拼接两个函数名
        // 创建图片资源的函数名
        // imagecreatefromjpeg imagecreatefrompng imagecreatefromgif
        $func_resource = 'imagecreatefrom'.$suffix;

        // 保存图片的函数名
        // imagejpeg  imagepng   imagegif
        $func_save = 'image'.$suffix;

        //echo $func_resource.'<br/>';
        //echo $func_save.'<br/>';
        //exit;

        // 获取原图的宽和高
        list($src_w, $src_h)=getimagesize($img_path);
        
        // 直接缩放
        // 打开原图产生资源
        $src =$func_resource($img_path);

        // 创建小图
        $dst = imagecreatetruecolor($width, $height);

        // 专业缩放的函数
        imagecopyresampled($dst, $src, 0,0, 0,0, $width, $height, $src_w, $src_h);


        // 处理缩放后的完整图片路径
        $save_path = dirname($img_path).'/'.$width.'_'.basename($img_path);

        //echo $save_path;
          //  exit;

        // 保存缩放后的图片
        // imagejpeg imagepng imagegif  保存成功返回真，保存失败返回假
        $result = $func_save($dst, $save_path);

        //echo '绽放<br/>';

        // 销毁资源
        imagedestroy($src);
        imagedestroy($dst);


        return $result;

    }

/*
 * 拼接URL函数
 * @param $img_name 图片名
 *
 * @param $pre  前缀
 *  
 * @return 返回图片拼接好路径URL
 *
 * */
function getUrl($img_name,$pre=''){
    //拼接url
    $img_url = URL.'uploads/';
    $img_url .=substr($img_name,0,4).'/';
    $img_url .=substr($img_name,4,2).'/';
    $img_url .=substr($img_name,6,2).'/';
    $img_url .=$pre.$img_name;
    return $img_url;

}

/*
 *  查询数据表
 *
 * @author MartinLee  LiXiang941@163.com
 *
 * @param $sql 这是一个查询的sql语句
 * 
 * @return 成功返回数组列表 失败返回false
 *
 * */
    function query($sql){
        $result =mysqli_query($link,$sql);
        //如果查询成功，直接返回结果集
        if($result && mysqli_num_rows($result)>0){
            //先声明一个空数组
            $arr = array();
            $arr= mysqli_fetch_all($result,MYSQLI_ASSOC);
            //返回数组
            return $arr;
        }
        //查询失败返回false
        return false;  
    }

/*
 *  专业执行  insert delete update 函数
 *
 *  @param $sql 执行insert delete update 的sql语句
 *  
 *  @retrun delete update 成功返回真  失败返回假
 *
 *  @return  insert 成功返回自增id,失败返回假
 *
 *
 *
 * */

function execute($sql){
    $result = mysqli_query($sql);
    if($result && mysqli_affected_rows($link)>0){
        //如果有自增id 则返回id
        if(mysqli_insert_id($link)){
            return mysqli_insert_id($link);
        }
        return true;
    }

    return false;
}

