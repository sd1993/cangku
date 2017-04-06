<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	
	public function _initialize(){
		
      
		
		
    }
	
	
	/*
	用户的信息获取
	@param unknown 
	*/
    public function User_info(){
		
       $name=session('username');  
	  
	   $password=session('password'); 
	   $User = M("Users"); // 实例化User对象
	   $info=$User->where("username='$name' AND password='$password'")->find(); 
		if($info){
			
			return $info;
			
			
		}else{
			$this->redirect("Home/User/login");
		}
	   
	   
    }
	/*
		登录
	*/
	
	 public function login(){
		
		if($_POST['action']==1){
			
			if(strcasecmp($_POST['code'],session('code')) == 0){
				$name=trim($_POST['name']);
				$password=md5(trim($_POST['password']));
				$User = M("Users"); // 实例化User对象
				$info=$User->where("username='$name' AND password='$password'")->find(); 
				if($info){
					$msg=array('error'=>0,'info'=>'登录成功,正在跳转！');
					session('username',$name);  //设置session
					session('password',$password);  //设置session
					session('system_id',$info['system_id']);  //设置session
				}else{
					$msg=array('error'=>2,'info'=>'用户名称或者密码错误！');
				}
				
			}else{
				$msg=array('error'=>1,'info'=>'验证码错误');
			}
			
			echo json_encode($msg);exit;
		}
		
        $this->display("login");
    }
	
	
	
	/*
	 退出
	*/
	 public function Login_out(){
		 session('username',null);
		 session('password',null);
		 session('system_id',null);
		echo json_encode(array('error'=>0,'info'=>'退出成功，请重新登录！'));
	 }
	 
	 
	public function ValidateCode(){
		
        import('Common/ORG/ValidateCode');
		$_vc = new \ValidateCode();		//实例化一个对象
		$_vc->doimg();
		
    }
	/*
	视图末班的头部 和左侧的菜单
	*/
	public function Main(){
		
		//系统信息
		$my_info=self::User_info();
		$system=M('system');
		$info=$system->where(array('id'=>$my_info['system_id']))->find();
		//菜单
		$func=M('function');
		$cateRow=$func->where(array('state'=>'1'))->select();
		
		import('Common/ORG/Tree');
		$treeObj = new \Tree();//引用Tree类
        $menus = $treeObj->getTree($cateRow,$pid = 0, $col_id = 'id', $col_pid = 'ups', $col_cid = '');//$col_id,$col_pid,$col_cid对应分类表category中的字段
		
		
		if(CONTROLLER_NAME == 'Index' && ACTION_NAME=='index')
		{
			
			$CONTROLLER_NAME='System';
			$ACTION_NAME='index';
		}else{
			$CONTROLLER_NAME='Index';
			$ACTION_NAME='index';
		}
	
		$this->assign('menus',$menus); 
		$this->assign('info',$info); 
		$this->assign('CONTROLLER_NAME',$CONTROLLER_NAME); 
		$this->assign('ACTION_NAME',$ACTION_NAME);
		$this->display("User/Head");
    }
	
	
	/*
	视图末班的头部 和左侧的菜单
	*/
	
	public function Iframe(){
		//面包屑
		import('Common/ORG/Tree');
		$treeObj = new \Tree();//引用Tree类
		
       $this->redirect("Home/".$_REQUEST['CONTROLLER_NAME']."/".$_REQUEST['ACTION_NAME']);
		// $this->display($_REQUEST['CONTROLLER_NAME']."/".$_REQUEST['ACTION_NAME']);
    }
	
	
	
	
	/*公司员工列表*/
	public function users(){
		$action=$_GET['action']?$_GET['action']:$msg=array('error'=>999,'info'=>'没效指令，无法寻找员工！');
		switch($action)
		{
			case 'all'://寻找所有员工
				$data=M('users')->where(array('system_id'=>1,'state'=>1))->select();
				if($data) 
					$return=array('error'=>0,'info'=>$data);
				else
					$return=array('error'=>1,'info'=>'亲爱的，没有找到员工！');
				break;
			default:
				break;
		}
		$this->ajaxReturn($return,'json');
	}
	
	
	
	/*清除提示*/
	public function del_System_need(){
		cookie('System_need',null);
		$this->success('处理成功！', '/');
		
	}
}