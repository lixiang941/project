<?php
include '../init.php';
//搜索条件
if($_GET['name'] !=''){
    $name =$_GET['name'];
    $and = "and g.name LIKE '%{$name}%'";
    $url = "&name={$name}";
}
//开始分页
$num = 3;
$sql="SELECT COUNT(*) total FROM ".PRE."goods g ,".PRE."image i WHERE g.id=i.goods_id {$and}";
$total = query($link,$sql);
//总条数
$total = $total[0]['total'];
//总页数
$amount = ceil($total/$num);

$page = empty($_GET['page'])?'1':(int)$_GET['page'];

$page = max($page,0);
$page = min($page,$amount);

$offset = ($page-1)*$num;



//将所有下面要求显示的字段全部查询出来
$sql ="SELECT g.id gid,g.name gname,g.cate_id,g.price,g.stock,g.status,g.is_hot,g.is_new,g.is_best,g.addtime,i.id iid,i.name iname,i.is_face FROM ".PRE."goods g,".PRE."image i WHERE g.id=i.goods_id and i.is_face =1 {$and} limit {$offset},{$num}";
//echo $sql;exit; 
$goodslist = query($link,$sql);
//var_dump($goodslist);

for($i=0;$i<count($goodslist);$i++){
    $sql="SELECT name FROM ".PRE."category WHERE id={$goodslist[$i]['cate_id']}";
    $row = query($link,$sql);
  //  var_dump($row);
    $goodslist[$i]['cate_name']=$row[0]['name'];
   
   // var_dump($goodslist);
}

//下一页
$next = $page+1;
//上一页
$prev = $page-1;


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
    <td width="99%" align="left" valign="top">您的位置：商品管理</td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="search">
  		<tr>
   		 <td width="90%" align="left" valign="middle">
	         <form method="get" action="index.php">
	         <span>商品名称：</span>
	         <input type="text" name="name" value="" class="text-word">
	         <input name="" type="submit" value="查询" class="text-but">
	         </form>
         </td>
  		  <td width="10%" align="center" valign="middle" style="text-align:right; width:150px;"><a href="add.html" target="mainFrame" onFocus="this.blur()" class="add">增商品</a></td>
  		</tr>
	</table>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main-tab">
      <tr>
        <th align="center" valign="middle" class="borderright">编号</th>
        <th align="center" valign="middle" class="borderright">商品名称</th>
        <th align="center" valign="middle" class="borderright">商品图片</th>
        <th align="center" valign="middle" class="borderright">商品分类</th>
        <th align="center" valign="middle" class="borderright">商品价格</th>
        <th align="center" valign="middle" class="borderright">商品库存</th>
        <th align="center" valign="middle" class="borderright">是否上架</th>
        <th align="center" valign="middle" class="borderright">是否热销</th>
        <th align="center" valign="middle" class="borderright">是否精品</th>
        <th align="center" valign="middle" class="borderright">是否新品</th>
      
        <th align="center" valign="middle">操作</th>
      </tr>
        <?php if(!empty($goodslist)){?>
        <?php foreach($goodslist as $value){?>
      <tr onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#edf5ff'">
        <td align="center" valign="middle" class="borderright borderbottom">1</td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['gname']?></td>
<?php
    $filename =$value['iname'];
    $img_url = getUrl($filename,'/50_');

        
?>
    <td align="center" valign="middle" class="borderright borderbottom"><img src="<?php echo $img_url?>" alt="我是图片"></td>
        <td align="center" valign="middle" class="borderright borderbottom">

        <?php echo $value['cate_name']?>


</td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['price']?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['stock']?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['status']==1?'<a href="action.php?a=status&gid='.$value['gid'].'&status=0">上架</a>':'<a href="action.php?a=status&gid='.$value['gid'].'&status=1">下架</a>'?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['is_hot']==1?'<a href="action.php?a=is_hot&gid='.$value['gid'].'&is_hot=0">热销</a>':'<a href="action.php?a=is_hot&gid='.$value['gid'].'&is_hot=1">不热</a>'?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['is_best']==1?'<a href="action.php?a=is_best&gid='.$value['gid'].'&is_best=0">精品</a>':'<a href="action.php?a=is_best&gid='.$value['gid'].'&is_best=1">不精</a>'?></td>
        <td align="center" valign="middle" class="borderright borderbottom"><?php echo $value['is_new']==1?'<a href="action.php?a=is_new&gid='.$value['gid'].'&is_new=0">新品</a>':'<a href="action.php?a=is_new&gid='.$value['gid'].'&is_new=1">普通</a>'?></td>
      
 
        <td align="center" valign="middle" class="borderbottom"><a href="image.php?gid=<?php echo $value['gid']?>&gname=<?php echo $value['gname']?>" target="mainFrame" onFocus="this.blur()" class="add">图片管理</a><span class="gray">&nbsp;|&nbsp;</span><a href="edit.php?gid=<?php echo $value['gid']?>" target="mainFrame" onFocus="this.blur()" class="add">编辑</a><span class="gray">&nbsp;|&nbsp;</span><a href="action.php?a=del&gid=<?php echo $value['gid']?>" target="mainFrame" onFocus="this.blur()" class="add">删除</a></td>
      </tr>
        <?php } ?>
        <?php } ?>
    </table></td>
    </tr>
  <tr>
  <td align="left" valign="top" class="fenye"><?php echo $total?> 条数据 <?php echo $page ?>/<?php echo $amount?> 页&nbsp;&nbsp;<a href="index.php?page=1<?php echo $url?>" target="mainFrame" onFocus="this.blur()">首页</a>&nbsp;&nbsp;<a href="index.php?page=<?php echo $prev.$url?>" target="mainFrame" onFocus="this.blur()">上一页</a>&nbsp;&nbsp;<a href="index.php?page=<?php echo $next.$url?>" target="mainFrame" onFocus="this.blur()">下一页</a>&nbsp;&nbsp;<a href="index.php?page=<?php echo $amount.$url?>" target="mainFrame" onFocus="this.blur()">尾页</a></td>
</tr>
</table>
</body>
</html>
