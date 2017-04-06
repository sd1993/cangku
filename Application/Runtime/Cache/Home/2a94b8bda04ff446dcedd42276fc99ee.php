<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>网站信息</title>  
     <?php echo ($head_data); ?>
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 网站信息</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" id="sb" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>网站标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="stitle" value="<?php echo ($info["stitle"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>网站LOGO：</label>
        </div>
        <div class="field" id="div_slogo">
          <input readonly type="text" id="url1" name="old_logo" class="input tips" style="width:25%; float:left;" value="<?php echo ($info["slogo"]); ?>" data-toggle="hover" data-place="right" data-image="<?php echo ($info["slogo"]); ?>"  />	 		
          <input type="button" class="button bg-blue margin-left" id="spanButtonPlaceholder" value="+ 浏览上传" >
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>网站域名：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="surl" value="<?php if($info['surl']) echo $info['surl'];else echo $_SERVER['HTTP_HOST']; ?>" readonly />
        </div>
      </div>
      <div class="form-group" style="display:none">
        <div class="label">
          <label>副加标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="sentitle" value="<?php echo ($info["sentitle"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>网站关键字：</label>
        </div>
        <div class="field">
          <textarea class="input" name="skeywords" style="height:80px"><?php echo ($info["skeywords"]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>网站描述：</label>
        </div>
        <div class="field">
          <textarea class="input" name="sdescription"><?php echo ($info["sdescription"]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>联系人：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_name" value="<?php echo ($info["s_name"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>手机：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_phone" value="<?php echo ($info["s_phone"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>电话：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_tel" value="<?php echo ($info["s_tel"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group" style="display:none;">
        <div class="label">
          <label>400电话：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_400" value="<?php echo ($info["s_400"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>传真：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_fax" value="<?php echo ($info["s_fax"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>QQ：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_qq" value="<?php echo ($info["s_qq"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group" style="display:none">
        <div class="label">
          <label>QQ群：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_qqu" value="<?php echo ($info["s_qqu"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
     
      <div class="form-group">
        <div class="label">
          <label>Email：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_email" value="<?php echo ($info["s_email"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>地址：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="s_address" value="<?php echo ($info["s_address"]); ?>" />
          <div class="tips"></div>
        </div>
      </div>  
              
      <div class="form-group">
        <div class="label">
          <label>底部信息：</label>
        </div>
        <div class="field">
          <textarea name="scopyright" class="input" style="height:120px;"><?php echo ($info["scopyright"]); ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o submit" type="button"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>



<script type="text/javascript" src="/Public/swfu/js/jquery.js"></script>
<script type="text/javascript" src="/Public/swfu/js/swfupload.js"></script>
<script type="text/javascript" src="/Public/swfu/js/handlers.js"></script>
<link href="/Public/swfu/css/default.css" rel="stylesheet" type="text/css" />
<script>
var swfu;
		window.onload = function () {
			swfu = new SWFUpload({
				upload_url: "/index.php/Home/System/index",
				post_params: {"PHPSESSID": "<?php echo session_id();?>"},
				file_size_limit : "2 MB",
				file_types : "*.jpg;*.png;*.gif;*.bmp",
				file_types_description : "JPG Images",
				file_upload_limit : "100",
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,//上传成功触发
				upload_complete_handler : uploadComplete,
				button_image_url : "/Public/swfu/images/upload.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 113,
				button_height: 45,
				button_text : '',
				button_text_style : '.spanButtonPlaceholder { font-family: Helvetica, Arial, sans-serif; font-size: 14pt;} ',
				button_text_top_padding: 0,
				button_text_left_padding: 0,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,			
				flash_url : "/Public/swfu/swf/swfupload.swf",
				custom_settings : {
					upload_target : "divFileProgressContainer"
				},				
				debug: false
			});
		};
$(function(){
	
	
	
	$(".submit").click(function(){
		
		$.post("/index.php/Home/System/index",$("#sb").serialize(),function(info){
				
					if(info.error != 0){						
						layer.msg(info.info);
					}else{						
						layer.msg(info.info,function() {
							
							 parent.location.reload();							
							// window.location.reload();
						});						
					}									
		},"json")
		
		
	
	})


	

	

})
	
</script>
</body></html>