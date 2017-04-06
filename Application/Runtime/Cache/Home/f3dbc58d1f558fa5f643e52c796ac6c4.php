<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
 <?php echo ($head_data); ?>
 </head>
<body>
<div class="panel admin-panel">
  <div class="panel-head"><strong class="icon-reorder"> <a href="/index.php/Home/System/func">菜单列表</a><?php echo ($PanelHead); ?></strong></div>
  <div class="padding border-bottom">
    <button type="button" class="button border-yellow" 
		data-button="add"
		data-title="新增菜单"
		onclick="button_click(this)"
	
	><span class="icon-plus-square-o"></span> 新增菜单</button>
  </div>
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">ID</th>
      <th width="15%">一级分类</th>
      <th width="10%">排序</th>
      <th width="10%">操作</th>
    </tr>
	<?php if(is_array($funcs)): foreach($funcs as $i=>$vo): ?><tr>
      <td><?php echo ($i +1); ?></td>
      <td><?php echo ($vo["name"]); ?></td>
      <td><?php echo ($vo["sort"]); ?></td>
      <td>
		<div class="button-group"> 
		<a class="button border-green" href="/index.php/Home/System/func?ups=<?php echo ($vo["id"]); ?>" ><span class="icon-edit"></span> 子菜单</a> 
		<a class="button border-main" 
			data-info_id="<?php echo ($vo["id"]); ?>"			
			data-button="edit"
			data-url="/index.php/Home/System/func_ajax"
			data-title="修改公司部门" 
			onclick="button_click(this)"
		><span class="icon-edit"></span> 修改</a> 
		
		<a class="button border-red" 
			data-info_id="<?php echo ($vo["id"]); ?>"
			data-button="del"			
			data-url="/index.php/Home/System/func_ajax"
			onclick="button_click(this)"
		><span class="icon-trash-o"></span> 删除</a> 
		</div>
	  </td>
    </tr><?php endforeach; endif; ?>
    <tr>
	<td>
	<ul id="demo"></ul>
	</td>
	</tr>
  </table>
</div>

<div class="panel admin-panel margin-top " style="display:none">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span></strong></div>
  <div class="body-content">
    <form method="post" class="form-x" id="form-x" action="/index.php/Home/System/func">
	<input type="hidden" name="id" >
      <div class="form-group">
        <div class="label">
          <label>上级菜单：</label>
        </div>
        <div class="field">
          <select name="ups" class="input w50">
            <option value="0">顶级菜单</option>
           
          </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>菜单标题：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="name" />
          <div class="tips"></div>
        </div>
      </div>
   
      <div class="form-group">
        <div class="label">
          <label>对应的控制器：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="controller" />
          <div class="tips"></div>
        </div>
      </div>
     
	 <div class="form-group">
        <div class="label">
          <label>对应的方法：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="method" />
          <div class="tips"></div>
        </div>
      </div>
	 
	 
      <div class="form-group">
        <div class="label">
          <label>菜单描述：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="desc"/>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>菜单排序：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="sort" value="0"  data-validate="number:排序必须为数字" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o"  type="button" data-button="cj" data-url="/index.php/Home/System/func" onclick="button_click(this)"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$(function(){
	//上级菜单变动
	$("select[name=ups]").change(function(){
	
		change_input($(this).val());
	})

	//新增
	$(document).on("click",".button",function(){
	
			var type=$(this).attr("data-button");
			
			switch(type)
			{
				case "add": //新增
					genCate("<?php echo ($_GET[ups]); ?>");//上级菜单
					change_input(0);	//对应的控制器 和	 对应的方法  可编辑性			
					
					break;
				
				
				default:
					break;
			}
			
			
			
	})
	
	
	
	
	
})
	//AJAX
	function Ajax(info_id){
		$.post("/index.php/Home/System/func_ajax",{"action":"infos","info_id":info_id},function(data){
			var infos=data.info;
			if(data.error == 0){				
				genCate(infos.ups);//上级菜单
				change_input(infos.ups);
				$("input[name=id]").val(infos.id);//id
				$("input[name=name]").val(infos.name);//名称
				$("input[name=controller]").val(infos.controller);//controller
				$("input[name=method]").val(infos.method);//method
				$("input[name=desc]").val(infos.desc);//描述
				$("input[name=sort]").val(infos.sort);//排序
			}else{
				layer.msg(infos.info);
			}	
		
		},"json")
	}
	//异步 拉取 上级菜单
	function genCate(info_ups){
			
			$.post("/index.php/Home/System/func_ajax",{"action":"menus"},function(data){
				var option=selected='';
				var infos=data.info
				if(data.error == 0){				
					for(var k =0 ; k < infos.length;k++){
						if(info_ups==infos[k].id) selected='selected';
						var lv =getLv(infos[k].lv);
						option+='<option value="'+infos[k].id+'" '+selected+'>'+lv+infos[k].info+'</option>';
						selected='';
					}
					if(info_ups==0) selected='selected';
					
				}else{
				
					layer.msg(data.info);
				}
				var option='<option value="0" '+selected+'>顶级菜单</option>'+option;
				$("select[name=ups]").html(option);
					
			},"json")
			
			
	
	}
	function getLv(count){
		var lv="";
			for(var k=0;k<count;k++){
			
				lv+="&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		if(count>0) lv=lv+"├";else lv="";
		return lv;
	}
	//对应的控制器 和 对应的方法 只有二级目录下才可以输入
	function change_input(ups){
		var readonly="";
		if(ups<1){
			$("input[name=controller]").attr("readonly","readonly");
			$("input[name=method]").attr("readonly","readonly");
		}else{
			$("input[name=controller]").removeAttr("readonly");
			$("input[name=method]").removeAttr("readonly");
		} 
		
		
	
	}
</script>
</body>
</html>