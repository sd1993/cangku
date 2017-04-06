<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>登录</title>  
    <link rel="stylesheet" href="/Public/css/pintuer.css">
    <link rel="stylesheet" href="/Public/css/admin.css">
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/pintuer.js"></script>  
    <script src="/Public/layer/layer.js"></script>  
</head>
<body>
<div class="bg"></div>
<div class="container">
    <div class="line bouncein">
        <div class="xs6 xm4 xs3-move xm4-move">
            <div style="height:150px;"></div>
            <div class="media media-y margin-big-bottom">           
            </div>         
            
            <div class="panel loginbox">
                <div class="text-center margin-big padding-big-top"><h1>后台管理中心</h1></div>
                <div class="panel-body" style="padding:30px; padding-bottom:10px; padding-top:10px;">
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="text" class="input input-big" name="name" placeholder="登录账号" data-validate="请填写账号" />
                            <span class="icon icon-user margin-small"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="password" class="input input-big" name="password" placeholder="登录密码" data-validate="请填写密码" />
                            <span class="icon icon-key margin-small"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field">
                            <input type="text" class="input input-big" name="code"  placeholder="填写右侧的验证码" data-validate="请填写右侧的验证码" />
                           <img src="/index.php/Home/User/ValidateCode" alt="" width="100" height="32" class="passcode" style="height:43px;cursor:pointer;" onclick="this.src=this.src+'?'">  
                                                   
                        </div>
                    </div>
                </div>
                <div style="padding:30px;"><input type="submit" class="button button-block bg-main text-big input-big" value="登录"></div>
            </div>
                
        </div>
    </div>
</div>

<script>
$(function(){
	$("input[name=code]").blur(function(){
	
		$("input[type=submit]").click();
	})

	$("input[type=submit]").click(function(){
		
		var name=$("input[name=name]");
		var password=$("input[name=password]");
		var code=$("input[name=code]");
		if(name.val() && password.val() && code.val()){
			$.post("/index.php/Home/User/login",{"name":name.val(),"password":password.val(),"code":code.val(),"action":"1"},function(info){
				
					if(info.error != 0){
						
						layer.msg(info.info);
					}else{
						
						layer.msg(info.info);
						window.location.href="/index.php/Home/index/index";
						
						
					}
				
					
				},"json")
		
		}else{
			if(!name.val())
				layer.msg(name.attr("data-validate"));
			if(!password.val())
				layer.msg(name.attr("data-validate"));
			if(!code.val())
				layer.msg(name.attr("data-validate"));
		}
		
	
	})

})
	
</script>
</body>
</html>