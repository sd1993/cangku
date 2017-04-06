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
  <div class="panel-head"><strong class="icon-reorder"> <a href="/index.php/Home/System/func">公司部门列表</a><?php echo ($PanelHead); ?></strong></div>
  <div class="padding border-bottom">
    <button type="button" class="button border-yellow lol" 
				data-button="add"
				data-title="新增公司部门"
				onclick="button_click(this)"
	><span class="icon-plus-square-o"></span> 新增公司部门</button>
  </div>
  <table class="table table-hover text-center">
    <tr>
      <th width="5%">ID</th>
      <th width="15%">部门名称</th>
      <th width="15%">上级部门</th>
      <th width="15%">岗位名称</th>
      <th width="15%">部门主要负责人</th>
      <th width="15%">状态</th>    
      <th width="10%">操作</th>
    </tr>
	<?php if(is_array($list)): foreach($list as $i=>$vo): ?><tr>
      <td><?php echo ($i +1); ?></td>
      <td><?php echo ($vo["name"]); ?></td>	 
      <td><?php if($vo[ups_name]) echo $vo[ups_name];else echo '最高权限'; ?></td>	 
      <td><?php echo ($vo["post_name"]); ?></td>
	 <td><?php echo ($vo["principal_name"]); ?></td>
      <td><?php echo ($department_state[$vo['state']]); ?></td>
     
      <td>
		<div class="button-group"> 
		
		<a class="button border-main"  
				data-info_id="<?php echo ($vo["id"]); ?>"
				data-button="edit"
				data-url="/index.php/Home/Department/department_ajax"
				data-title="修改公司部门" 
				onclick="button_click(this)"
		><span class="icon-edit"></span> 修改</a> 
		
		<a class="button border-red" 
				data-info_id="<?php echo ($vo["id"]); ?>"
				data-button="del"
				data-url="/index.php/Home/Department/department_ajax"
				onclick="button_click(this)"
		><span class="icon-trash-o"></span> 删除</a> 
		</div>
	  </td>
    </tr><?php endforeach; endif; ?>
    <tr>
        <td colspan="8">
		 <div class="pagelist">
		<?php echo ($page); ?>
		</div>
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
          <label>上级部门：</label>
        </div>
        <div class="field">
          <select name="ups" class="input w50">
            <option value="">选择部门</option>
           
          </select>
          <div class="tips"></div>
        </div>
      </div> 
	  <div class="form-group">
        <div class="label">
          <label>部门负责人：</label>
        </div>
        <div class="field">
          <select name="principal_id" class="input w50">
            <option value="0">最高权限</option>
           
          </select>
          <div class="tips"></div>
        </div>
      </div> 
	  
      <div class="form-group">
        <div class="label">
          <label>部门名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="name" />
          <div class="tips"></div>
        </div>
      </div>
   
      <div class="form-group ">
        <div class="label">
          <label>岗位分级：</label>
        </div>
        <div class="field">
         <button class="button"  type="button" data-button="post" > 添加岗位</button> 
        </div>
      </div>
    
	<div class="post"></div>
	 
	 
     
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o"  type="button" data-button="cj" data-url="/index.php/Home/Department/index" onclick="button_click(this)"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$(function(){
	$(document).on("click",".button",function(){
	
		
				var type=$(this).attr("data-button");
				
				switch(type)
				{
					case "add":
						genCate();//上级菜单
						break;
					case "delline"://删除	岗位
						$(this).parents(".form-group").remove();					
						post_list(2);
					break;
					
					case "post"://增加 岗位
						var num=post_list();
						html ='<div class="form-group"><div class="label post_list"><label>岗位:'+num+'</label></div><div class="field"><input type="text" class="input w50" name="post[]" /><a class="button border-red" data-info_id="'+num+'" data-button="delline" ><span class="icon-trash-o"></span> 删除</a></div><div class="tips"></div></div>';
						$(".post").append(html);
					break;
					default:
						break;
				}
				
				
				
		})
		
	
})

	
	//AJAX
	function Ajax(info_id,url){
		$(".post").html("")	;	
		$.post(url,{"action":"infos","info_id":info_id},function(data){
			var infos=data.info;
			if(data.error == 0)
			{
				genCate(infos.ups,infos.principal_id);//上级菜单(部门ID，负责人ID)
				
			
				$("input[name=name]").val(infos.name);//部门名称
				$("input[name=id]").val(infos.id);//部门ID
				var post_name=infos.post_name,html='';//岗位分级		
				if(post_name)
				{
					post_name=post_name.split(",");	
						
					for(var k =0 ; k < post_name.length;k++){	
						
						html ='<div class="form-group"><div class="label post_list"><label>岗位'+(k+1)+'</label></div><div class="field"><input type="text" class="input w50" name="post[]" value="'+post_name[k]+'"/><a class="button border-red" data-info_id="'+(k+1)+'" data-button="delline" "><span class="icon-trash-o"></span> 删除</a></div><div class="tips"></div></div>';
						$(".post").append(html);
					}
				}
			
			}else{
				layer.msg(infos);
			}
		
		},"json")
	}
	
	
	
	//异步 拉取 上级部门 、 员工
	function genCate(info_ups,principal_id){
			
			$.post("/index.php/Home/Department/department_ajax",{"action":"department"},function(data){
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
				var option='<option value="0" '+selected+'>最高权限</option>'+option;
				$("select[name=ups]").html(option);
					
			},"json")
			
			$.get("/index.php/Home/User/users",{"action":"all"},function(data){
				var option='';
				var infos=data.info
				if(data.error == 0){				
					for(var k =0 ; k < infos.length;k++){
						if(principal_id==infos[k].id) selected='selected';
						var lv =getLv(infos[k].lv);
						option+='<option value="'+infos[k].id+'" '+selected+'>'+lv+infos[k].username+'</option>';
						selected='';
					}
					if(principal_id==0) selected='selected';
					
				}else{
				
					layer.msg(data.info);
				}
				var option='<option value="0" '+selected+'>选择部门负责人</option>'+option;
				$("select[name=principal_id]").html(option);
					
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
	
	
	
	//获取 列表数量 并 重整 编号
	function post_list(order){
		var num=0,lastNum;
		$(".post_list").each(function(i,v){
			num++;
			if(order == 2)
				lastNum=	"剩余岗位:"+num;
			else
				lastNum=	"岗位:"+(num+1);
			layer.msg(lastNum);
			$(v).find("label").text("岗位:"+num);		
		
		})
		
		return num+1;
	}
</script>
</body>
</html>