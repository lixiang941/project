<?php
include '../init.php';
//var_dump($_GET);
$gid = $_GET['gid'];
$gname = $_GET['gname'];

//echo $gid;
//echo $gname;
//查询所有图片
$sql="SELECT id,name,is_face FROM ".PRE."image WHERE goods_id={$gid}";
$image = query($link,$sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="../css/css.css" type="text/css" rel="stylesheet" />
<link href="../css/main.css" type="text/css" rel="stylesheet" />
<link rel="shortcut icon" href="../images/main/favicon.ico" />
<style>
body{overflow-x:hidden; background:#f2f0f5; padding:15px 0px 10px 5px;}
#searchmain{ font-size:12px;}
#search{ font-size:12px; background:#548fc9; margin:10px 10px 0 0; display:inline; width:100%; color:#FFF; float:left}
#search form span{height:40px; line-height:40px; padding:0 0px 0 10px; float:left;}
#search form input.text-word{height:24px; line-height:24px; width:180px; margin:8px 0 6px 0; padding:0 0px 0 10px; float:left; border:1px solid #FFF;}
#search form input.text-but{height:24px; line-height:24px; width:55px; background:url(../images/main/list_input.jpg) no-repeat left top; border:none; cursor:pointer; font-family:"Microsoft YaHei","Tahoma","Arial",'宋体'; color:#666; float:left; margin:8px 0 0 6px; display:inline;}
#search a.add{ background:url(../images/main/add.jpg) no-repeat -3px 7px #548fc9; padding:0 10px 0 26px; height:40px; line-height:40px; font-size:14px; font-weight:bold; color:#FFF; float:right}
#search a:hover.add{ text-decoration:underline; color:#d2e9ff;}
#main-tab{ border:1px solid #eaeaea; background:#FFF; font-size:12px;}
#main-tab th{ font-size:12px; background:url(../images/main/list_bg.jpg) repeat-x; height:32px; line-height:32px;}
#main-tab td{ font-size:12px; line-height:40px;}
#main-tab td a{ font-size:12px; color:#548fc9;}
#main-tab td a:hover{color:#565656; text-decoration:underline;}
.bordertop{ border-top:1px solid #ebebeb}
.borderright{ border-right:1px solid #ebebeb}
.borderbottom{ border-bottom:1px solid #ebebeb}
.borderleft{ border-left:1px solid #ebebeb}
.gray{ color:#dbdbdb;}
td.fenye{ padding:10px 0 0 0; text-align:right;}
.bggray{ background:#f9f9f9}
</style>
</head>
<body>
<!--main_top-->
<table width="99%" border="0" cellspacing="0" cellpadding="0" id="searchmain">
  <tr>
    <td width="99%" align="left" valign="top">您的位置：商品图片管理</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search">
  		<tr>
   		 <td width="60%" align="left" valign="middle">
	         <form method="post" action="action.php?a=addimg" enctype="multipart/form-data">
             <span>添加图片：</span>
            <input type="hidden" name="gid" value="<?php echo $gid?>">
            <input type="hidden" name="gname" value="<?php echo $gname?>">
	         <input type="file" name="pic" value="" class="text-word">
	         <input name="" type="submit" value="上传" class="text-but">
	         </form>
         </td>
  		  <td width="40%" align="center" valign="middle" style="text-align:left; width:150px;">你正在管理<font color="red" size="6"><?php echo $gname?></font>的图片</td>
  		</tr>
	</table>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <tr>
        <th align="center" valign="middle" class="borderright">编号</th>
        <th align="center" valign="middle" class="borderright">图片</th>
        <th align="center" valign="middle" class="borderright">是否封皮</th>
        <th align="center" valign="middle">操作</th>
      </tr>
        <?php if(!empty($image)){?>
        <?php foreach($image as $value){?>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="center" valign="middle" class="borderright borderbottom">1</td>
        <td align="center" valign="middle" class="borderright borderbottom">

    <?php 
            
$filename =$value['name'];
$img_url = getUrl($filename,'/50_');


    ?>
        <img src="<?php echo $img_url?>">

</td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['is_face']==1?'<a href="action.php?a=is_face&gid='.$gid.'&gname='.$gname.'&id='.$value['id'].'"><font color="green" size="6">√</font></a>':'<a href="action.php?a=is_face&gid='.$gid.'&gname='.$gname.'&id='.$value['id'].'"><font color="red" size="5">×</font></a>'?></td>
   
        
        <td align="center" valign="middle" class="borderbottom"><a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">删除</a></td>
      </tr>
      <?php } ?>
      <?php } ?>
    </table></td>
    </tr>
  <tr>
    <td align="left" valign="top" class="fenye">11 条数据 1/1 页&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">首页</a>&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">上一页</a>&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">下一页</a>&nbsp;&nbsp;<a href="#" target="mainFrame" onFocus="this.blur()">尾页</a></td>
  </tr>
</table>
</body>
</html>
