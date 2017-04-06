<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>  
    <link rel="stylesheet" href="/Public/css/pintuer.css">
    <link rel="stylesheet" href="/Public/css/admin.css">
    <script src="/Public/js/jquery.js"></script>   
	<script src="/Public/layer/layer.js"></script> 
	
	
	

	 
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="<?php echo ($info["slogo"]); ?>" class="radius-circle rotate-hover" height="50" alt="" /><?php echo ($info["stitle"]); ?></h1>
  </div>
  <div class="head-l">
  <a class="button button-little bg-green" href="/index.php/Home/User/del_System_need" target="_self"><span class="icon-home"></span> 清除缓存 </a> 
  &nbsp;&nbsp;
  <!-- <a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> 
  &nbsp;&nbsp; -->
  <a class="button button-little bg-red Login_out" ><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <?php if(is_array($menus)): foreach($menus as $key=>$vo): ?><h2><span class="<?php echo ($vo["class"]); ?>"></span><?php echo ($vo["name"]); ?></h2>
    <ul style="display:block">
		<?php if(is_array($vo["childs"])): foreach($vo["childs"] as $key=>$childs): ?><li><a href="/index.php/Home/<?php echo ($childs["controller"]); ?>/<?php echo ($childs["method"]); ?>"  target="right" data-h2="<?php echo ($vo["name"]); ?>"><span class="icon-caret-right"></span><?php echo ($childs["name"]); ?></a></li><?php endforeach; endif; ?>
	</ul><?php endforeach; endif; ?>
  <!-- <h2><span class="icon-user"></span>基本设置</h2>
  <ul style="display:block">
    <li><a href="/index.php/Home/System/index" target="right"><span class="icon-caret-right"></span>网站设置</a></li>
    <li><a href="pass.html" target="right"><span class="icon-caret-right"></span>修改密码</a></li>
    <li><a href="page.html" target="right"><span class="icon-caret-right"></span>单页管理</a></li>  
    <li><a href="adv.html" target="right"><span class="icon-caret-right"></span>首页轮播</a></li>   
    <li><a href="book.html" target="right"><span class="icon-caret-right"></span>留言管理</a></li>     
    <li><a href="column.html" target="right"><span class="icon-caret-right"></span>栏目管理</a></li>
  </ul>   
  <h2><span class="icon-pencil-square-o"></span>栏目管理</h2>
  <ul>
    <li><a href="list.html" target="right"><span class="icon-caret-right"></span>内容管理</a></li>
    <li><a href="add.html" target="right"><span class="icon-caret-right"></span>添加内容</a></li>
    <li><a href="cate.html" target="right"><span class="icon-caret-right"></span>分类管理</a></li>        
  </ul>   -->
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  //面包屑
  $(".leftnav ul li a").click(function(){
		$(".li-h2").text($(this).attr("data-h2"));
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
		
  })
  
  //退出登录
  $(".Login_out").click(function(){
	layer.confirm("确认退出？",function() {
			$.post("/index.php/Home/User/Login_out",function(info){
				
					if(info.error != 0){
						
						layer.msg(info.info);
					}else{
						
						
							window.location.href="/index.php/Home/index/index";
						
						
					}
				
					
			},"json")
	});
	
	
  
  })
});
</script>
<ul class="bread">
  <li><a href="javascript:void(0)" class="icon-home"> 菜单列表</a></li>
  <li><a href="javascript:void(0)" target="right" class=" li-h2"> 基础设置</a></li>
  <li><a href="javascript:void(0)" id="a_leader_txt">网站设置</a></li>
  <li><b>当前语言：</b><span style="color:red;">中文</span>
 <!--  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;切换语言：<a href="##">中文 </a> &nbsp;&nbsp;<a href="##">英文</a>  --></li>
</ul>
<div class="admin">

  <iframe scrolling="auto" rameborder="0" src="/index.php/Home/User/iframe?CONTROLLER_NAME=<?php echo ($CONTROLLER_NAME); ?>&ACTION_NAME=<?php echo ($ACTION_NAME); ?>" name="right" width="100%" height="100%">
  
  </iframe>  
  
 <div style="text-align:center;">
	<p>来源:<a href="/index.php/Home/index/index" target="_blank"><?php echo ($info["scopyright"]); ?></a></p>
</div>
</div>

<!-- <iframe frameborder="0" scrolling="no" style="width: 366px;position: fixed;bottom: 20px;right: 25px;font-size: 0;line-height: 0;z-index: 100;" src="/index.php/Home/System/tishi"> -->
</body>
</html>