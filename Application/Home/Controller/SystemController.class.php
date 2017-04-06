<?php
namespace Home\Controller;
use Think\Controller;
class SystemController extends Controller {
	public $my_info;
	
	public function _initialize(){
		
        $this->my_info=UserController::User_info();
	
		$this->assign('CONTROLLER_NAME',CONTROLLER_NAME);
		$this->assign('ACTION_NAME',ACTION_NAME);
		
		$this->assign('my_info',$this->my_info);
    }
	
	
	
	public function index(){
		
		$my_info=$this->my_info;
		$system=M('system');
	
		
		//提交处理
		if($_POST){
			
			
				$field=array(
				'stitle'=>trim($_POST['stitle']),
				'slogo'=>'',
				'surl'=>trim($_POST['surl']),
				'skeywords'=>trim($_POST['skeywords']),
				'sdescription'=>trim($_POST['sdescription']),
				's_name'=>trim($_POST['s_name']),
				's_phone'=>trim($_POST['s_phone']),
				's_tel'=>trim($_POST['s_tel']),
				's_fax'=>trim($_POST['s_fax']),
				's_qq'=>trim($_POST['s_qq']),
				's_qqu'=>trim($_POST['s_qqu']),
				's_email'=>trim($_POST['s_email']),
				's_address'=>trim($_POST['s_address']),
				'scopyright'=>trim($_POST['scopyright'])
				);			
				
				if($_POST['Filename']){					
					$slogo=self::fileupload("/Public/images/Upload/");
					if($slogo['info']){
						$return=array('error'=>0,'info'=>$slogo['info'],'divid'=>'slogo','id'=>'url1');						
					}else{
						$return=array('error'=>1,'info'=>'上传失败，请检查网络后重试');
					}
					$this->ajaxReturn($return,'json');
					exit;
				}else{
					//上传的图片 和 显示框图片一致，使用 上传图片，如果不一致，那么选择用显示的图片
					if($_POST['slogo'][0] == $_POST['old_logo'])						
						$slogo['info']=trim($_POST['slogo'][0]);
					else
						$slogo['info']=trim($_POST['old_logo']);
				}
				
				$field['slogo']=$slogo['info'];
				
				if($system->where(array('id'=>$my_info['system_id']))->find()){
					//已经存在就 修改					
					$msg=$system->where(array('id'=>$my_info['system_id']))->save($field);
				}else{
					//保存
					$msg=$system->add($field);
				}
				
			
			if($msg){
				//$this->success('处理成功！，请清除缓存！', 'Index/index');
				/* cookie('System_need','yes'); */
				$return =array('error'=>0,'info'=>'基本设置提交成功！自动清除缓存！稍等。。。。');
			}else{
				$return =array('error'=>1,'info'=>'表单内容一样，请重新提交！');
				//$this->error('表单内容一样，请重新提交！');
			}
			$this->ajaxReturn($return,'json');exit;
		}else{
			
			$info=$system->where(array('id'=>$my_info['system_id']))->find();
			
			$this->assign('info',$info);
		}
		$this->display('Index/index');
    }
   
   
   /* 文件上传类中的上传类*/
   public function fileupload($path){
		$my_info=$this->my_info;
		$set_path="$path".$my_info['username'];//目录
		
		if(!file_exists($set_path)) mkdir($set_path, 0777, true);
	
	    import('Common/ORG/Upload');
	    $up = new \fileupload();		//实例化一个对象
		//设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
		$up -> set("path", '.'.$set_path);
		$up -> set("maxsize", 2000000);
		$up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
		$up -> set("israndname", false);
	  
		//使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
		if($up -> upload('Filedata')) {
			
			//获取上传后文件名子
			//var_dump($up->getFileName());
			
			$msg=array('error'=>0,'info'=>$set_path.'/' . $up->getFileName());
		} else {
			
			//获取上传失败以后的错误提示
			//	var_dump($up->getErrorMsg());
			$msg=array('error'=>1,'info'=>$up->getErrorMsg());
		}
		
		return $msg;
   }
   
   
   
	public function pass(){
		$my_info=$this->my_info;
		if($_POST['mpass'] &&  $_POST['newpass'] && $_POST['renewpass']){
			//原密码是否对
			if( md5($_POST['mpass']) == $my_info['password']){
				
				if( $_POST['newpass'] == $_POST['renewpass']  && $_POST['mpass'] != $_POST['renewpass']){
					$password=md5(trim($_POST['renewpass']));
					$User = M("Users"); // 实例化User对象
					$msg=$User->where(array('id'=>$my_info['id']))->save(array('password'=>$password));
					if($msg){
						$return=array('error'=>0,'info'=>'密码修改成功，自动跳转，请重新登录！');
						//$this->success('修改成功', 'Index/index');
						
					}else{
						//echo $_POST['renewpass'],':',md5($_POST['renewpass']),'-----',$my_info['password'];exit;
						//$this->error('网络不稳定，请稍后再试！');
						$return=array('error'=>1,'info'=>'网络不稳定，请稍后再试！');
					}
				}else{
					//新密码和原密码相同
					//$this->error('原始密码和新密码不能相同！');
					$return=array('error'=>2,'info'=>'原始密码和新密码不能相同！');
				}
			}else{
				//echo $_POST['mpass'],':',md5($_POST['mpass']),'-----',$my_info['password'];exit;
				//$this->error('原始密码错误！');
				$return=array('error'=>3,'info'=>'原始密码错误！');
			}
			$this->ajaxReturn($return,'json');
			
			exit;
		}
		
		$this->display('System/pass');
	}
	
	
	/*栏目管理*/
	public function func(){
		$ups=$_GET['ups']?$_GET['ups']:0;
		$Func=M('function');
		if($_POST){
			if($_POST['name']){
				if($_POST['id']>0){
					//print_r($_POST);exit;
					if($_POST['ups']==$_POST['id']) unset($_POST['ups']);
					$funcs=$Func->where(array('id'=>$_POST['id']))->save($_POST);
					$msg=array('error'=>0,'info'=>'修改成功');
					//$this->success('修改成功', 'func');
				}else{
					unset($_POST['id']);
					$funcs=$Func->add($_POST);
					//$this->success('新增成功', 'func');
					$msg=array('error'=>0,'info'=>'新增成功');
				}
			}else{
				$msg=array('error'=>1,'info'=>'菜单标题不能为空！');
			}
			$this->ajaxReturn($msg,'json');
			exit;
		}else{
			$funcs=$Func->where(array('ups'=>$ups,'state'=>1))->order('sort asc')->select();
			$data=$Func->where(array('state'=>1))->order('sort asc')->select();
			import('Common/ORG/Tree');
			$treeObj = new \Tree();//引用Tree类
			$arr=$treeObj->genCate($data,$ups,0,'id',array('name'=>'ups','value'=>$ups));
			krsort($arr);
			$PanelHead=array();
			foreach($arr as $v){
				$PanelHead[]='<a href="/index.php/Home/System/func?ups='.$v['id'].'">'.$v['info'].'</a>';
			}
			if($ups==0)
					$PanelHead='';
			else
					$PanelHead='/'.implode('/',$PanelHead);
			
			$this->assign('PanelHead',$PanelHead);
		}
		
		
		$this->assign('funcs',$funcs);
		$this->display('System/func');
	}
	
	
	/*栏目上级菜单的AJAX*/
	
	public function func_ajax(){
		$action=$_POST['action'];
		$info_id=$_POST['info_id'];
		switch($action){
			case 'menus'://取菜单
				$Func=M('function');
				$funcs=$Func->where(array('state'=>1))->order('sort asc')->select();
				import('Common/ORG/Tree');
				$treeObj = new \Tree();//引用Tree类
				$data=$treeObj->genCate($funcs,0,0,'ups',array('name'=>'id'));
				goto data_end;
				break;
			case 'infos'://内容
				$Func=M('function');
				$data=$Func->where(array('id'=>$info_id,'state'=>1))->find();
				goto data_end;
				break;
			case 'del'://栏目删除
				$Func=M('function');
				$ups=$Func->where(array('ups'=>$_POST['info_id']))->find();
				if($ups)
				{
					$funcs=2;
				}else{
					if($Func->where(array('id'=>$_POST['info_id']))->save(array('state'=>2)))			
						$funcs=0;
					else
						$funcs=1;
				} 	
					
				switch($funcs)
				{
					case '0':
						$msg=array(
							'error'=>0,
							'info'=>'删除成功'
							
						);
						break;
					case '1':
						$msg=array(
							'error'=>1,
							'info'=>'网络不稳定，请稍后再试！'
							
						);
						break;
					default:
						$msg=array(
							'error'=>2,
							'info'=>'含有下级菜单 【'.$ups['name'].' 】等不能删除！'
							
						);
						break;
						
					
						
				}
				break;
			 
			  data_end:
				if($data)
					$msg=array('error'=>0,'info'=>$data);
				else
					$msg=array('error'=>1,'info'=>'无法获取菜单列表，请稍后再试！');
			
			default:
				break;
		}
		
		
		//print_r($carr);
		$this->ajaxReturn($msg,'json');
	//	echo json_encode($carr);
		
	}
	
	/*栏目删除*/
	public function del(){
		
		
		
		
		$this->ajaxReturn($return,'json');
	}
	
	
	/*提示框架*/
	public  function tishi(){
		
			
			switch(isset($_POST['action']) ? $_POST['action'] : NULL)
				{
					
					case 'System_need'://系统提示
						if(cookie('System_need') == 'yes')
						{
							$infos=array(
								'error'=>0,
								'info'=>'网站设置已经修改过，请清除缓存！'
							);
						}else{
								$infos=array(
									'error'=>1
								
								);
						}
						goto json_data;
						break;
					default:
						
						
						$this->display('System/tishi');
						break;
					
					json_data:
							
							$this->ajaxReturn($infos,'json');exit;
				}
		
		
			
		
		
		
	}
	
	
	
}