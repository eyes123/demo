<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>书画平台登录</title>
    <script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/artDialog/artDialog.js"></script>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/login.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Js/artDialog/skins/blue.css" />
    <script type="text/javascript" src="/demo/Public/Js/common.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/Login.js"></script>
   <script type="text/javascript">
       $(document).ready(function () {
       // 验证码生成
       var captcha_img = $('#captcha-container').find('img')
       var verifyimg = captcha_img.attr("src");
       captcha_img.attr('title', '点击刷新');
       captcha_img.click(function(){
             if( verifyimg.indexOf('?')>0){
                    $(this).attr("src", verifyimg+'&random='+Math.random());
                 }else{
                     $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                  }
          });
       });
   </script>
</head>
<body style="text-align: center;margin:auto;">
<div id="header">
    <h1 >书画后台管理系统</h1>
</div>
<div class="login_form">
<form style="margin-top:10px;" action="" method="post" name="login">
     <input type="hidden" name="act" value="login" />
    <p>
        <span class="input_name">用户名：</span>
        <span class="input"><input type="text" name="username" maxlength="16"/></span>
    </p>
    <p>
       <span class="input_name">密&nbsp;&nbsp;码：</span>
       <span class="input"><input type="password" name="password"/></span>
    </p>
    <p id="captcha-container">
        <span class="input_name">验证码：</span>
       <span class="input">
           <input name="verify" width="50%" height="50" class="captcha-text" placeholder="验证码" type="text">
           <img width="30%" class="left15" height="40" alt="验证码" src="/demo/index.php?s=/Home/Index/verify_c" title="点击刷新">
       </span>
   </p>
    <div class="submit"><input type="submit" name="submit" value="" /></div>
</form>
</div>
<!-- 网页底部 -->
<div class="s-foot">
    
</div>
</body>
</html>