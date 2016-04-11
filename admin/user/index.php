<?php 

include '../init.php';
//搜索开始
//接受搜索内容
if($_GET['name']!=''){
    $name =$_GET['name'];
    $where = " WHERE name LIKE '%{$name}%'";
    $url = "&name={$name}";
}
//var_dump($name);

//分页处理
//每页显示条数
$num = 3;
$sql="SELECT COUNT(id) as total FROM ".PRE."user {$where}";
$total=query($link,$sql);
//总条数
$total = $total[0]['total'];
//总页数
$amount = ceil($total/$num);
//获取当前页码
$page = empty($_GET['page'])?'1':(int)$_GET['page'];

//判断page范围
$page = max(0,$page);
$page =min($page,$amount);

//获取偏移量
$offset = ($page-1)*$num;

//开始分页
$sql ="SELECT id,name,password,role,`lock` FROM ".PRE."user {$where} limit {$offset},{$num}";
$user = query($link,$sql);

//上一页
$prev = $page -1;
//下一页
$next = $page +1;

//var_dump($user);
$i++;
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
    <td width="99%" align="left" valign="top">您的位置：用户管理</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search">
  		<tr>
   		 <td width="90%" align="left" valign="middle">
	         <form method="get" action="index.php">
	         <span>管理员：</span>
             <input type="text" name="name" value="<?php echo $name?>" class="text-word">
	         <input name="" type="submit" value="查询" class="text-but">
	         </form>
         </td>
  		  <td width="10%" align="center" valign="middle" style="text-align:right; width:150px;"><a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">新增管理员</a></td>
  		</tr>
	</table>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <tr>
        <th align="center" valign="middle" class="borderright">编号</th>
        <th align="center" valign="middle" class="borderright">管理帐号</th>
        <th align="center" valign="middle" class="borderright">权限</th>
        <th align="center" valign="middle" class="borderright">锁定</th>
        <th align="center" valign="middle">操作</th>
      </tr>
    <?php if(!empty($user)):?>
    <?php foreach($user as $value):?>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
      <td align="center" valign="middle" class="borderright borderbottom"><?php echo ($page-1)*$num+$i;?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['name']?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php 
    $role=$value['role'];
    switch($role){
        case 0:
            echo '普通用户';
            break;
        case 1:
            echo '管理员';
            break;
        case 2:
            echo '超级管理员';
            break;
    }
    
?></td>
    <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['lock']==0?'<a href="action.php?a=lock&id='.$value['id'].'&lock=1">开启</a>':'<a href="action.php?a=lock&id='.$value['id'].'&lock=0">锁定</a>'?></td>
       
    <td align="center" valign="middle" class="borderbottom">
    <a href="edit.php?id=<?php echo $value['id']?>" target="mainFrame" onFocus="this.blur()" class="add">编辑</a>
    <?php if($value['role']!=2){?>
    <span class="gray">&nbsp;|&nbsp;</span>
    <a href="action.php?a=del&id=<?php echo $value['id']?>" target="mainFrame" onFocus="this.blur()" class="add">删除</a>
    <?php  } ?>
    </td>
      </tr>
    <?php $i++ ?>
    <?php endforeach;?>
    <?php endif;?>
    </table></td>
    </tr>
  <tr>
  <td align="left" valign="top" class="fenye"><?php echo $total?> 条数据 <?php echo $page ?>/<?php echo $amount?> 页&nbsp;&nbsp;<a href="index.php?page=1<?php echo $url?>" target="mainFrame" onFocus="this.blur()">首页</a>&nbsp;&nbsp;<a href="index.php?page=<?php echo $prev.$url?>" target="mainFrame" onFocus="this.blur()">上一页</a>&nbsp;&nbsp;<a href="index.php?page=<?php echo $next.$url?>" target="mainFrame" onFocus="this.blur()">下一页</a>&nbsp;&nbsp;<a href="index.php?page=<?php echo $amount.$url?>" target="mainFrame" onFocus="this.blur()">尾页</a></td>
  </tr>
</table>
</body>
</html>
