<?php
include'header.php';
?>
<div class="w"><img src="./images/2016-04-03_175425.png"></div>
<div class="register w mt20">
    <div class="registermain w">
        <h2>加入我们</h2>
        <p>请在此处输入以下详细信息</p>
        <form action="action.php?a=reg" method="post">
            <div>
                <label>用户名:</label>
                <input type="text" name="name">
            </div>
            <div>
                <label>密码</label>
                <input type="password" name="password">
            </div>
            <div>
                <label>再次输入密码</label>
                <input type="password" name="repassword">
            </div>
        
        <h3>国家</h3>
        <span class="zg fl">中国</span>
        <a href="#" class="xhx fl">国家不正确吗？</a>
        <div class="clear"></div>
       
        <div class="check mt20">
            <input type="checkbox" name="age" value="1" class="fl">
            <label class="fl">我已年满 18 周岁并希望通过电子邮箱接收独家优惠和新闻资讯。</label>
        <div class="clear"></div>
        </div>
        <div class="check2 mt20">
            <input type="checkbox" name="ty" value="1" class="fl">
            <label class="fl">是的，我同意隐私政策。</label>
            <div class="clear"></div>
        </div>
<div class="jia">
        <input type="submit" class="jiaru" value="加入我们">
</div>
        </form>
    </div>
</div>
<?php
include'footer.php';
?>
