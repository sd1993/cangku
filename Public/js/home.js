
	
	//新增
	function button_click(this_){	
		
			var type=$(this_).attr("data-button");
			var info_id=$(this_).attr("data-info_id");
			
		
			var html;
			
			switch(type)
			{
				case "add": //新增
					var title=$(this_).attr("data-title")?$(this_).attr("data-title"):layer.msg("您的按钮标题还未设置！");		
					//清空
					 document.getElementById("form-x").reset();
					 $("input[name=id]").val("0");					
					//标题 
					$(".icon-pencil-square-o").text(title);
					//取消隐藏
					$(".margin-top").attr("style","");
					break;
				case "edit"://修改
					var title=$(this_).attr("data-title");
					var url=$(this_).attr("data-url")
					if(!title){
						layer.msg("您的按钮标题还未设置！");
					}else if(!url){
						layer.msg("您的请求地址还未设置！");
					}else{
						
						Ajax(info_id,url);
						//标题 
						$(".icon-pencil-square-o").text(title);
						//取消隐藏
						$(".margin-top").attr("style","");
					}
					
					break;
				
				case "del"://删除	部门  连同 删除 职位
					var url=$(this_).attr("data-url");
					if(url){
						layer.confirm("确认删除",function(){
							$(this_).parents(".form-group").remove();					
							$.post(url,{"action":type,"info_id":info_id},function(info){
						
								if(info.error != 0){						
									layer.msg(info.info);
									
								}else{						
									layer.msg(info.info,function() {		
												
										 window.location.reload();						
										
									});						
								}									
							},"json")
						})
					}else{
						layer.msg("您的请求地址还未设置！");
					}
					break;
				
				case"cj"://提交
					var url=$(this_).attr("data-url");
					if(url){
						$.post(url,$("#form-x").serialize(),function(info){
					
							if(info.error != 0){						
								layer.msg(info.info);
								
							}else{						
								layer.msg(info.info,function() {		
											
									 window.location.reload();						
									
								});						
							}	
						},"json")
					}else{
						layer.msg("您的请求地址还未设置！");	
					}							
					
					break;
				default:
					layer.msg("无效指令！！！");
					break;
			}
			
			
			
	}
	
	
	
	
	
	
	
	
	
	
