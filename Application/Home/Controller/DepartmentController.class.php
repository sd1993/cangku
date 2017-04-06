<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
class DepartmentController extends Controller {
	
	public function _initialize(){		
	
		
		
    }
	
	
	
	/*公司部门列表*/
	public function index(){
		$my_info=UserController::User_info();
		
		$error_log=array(
			'ups'=>'上级部门',
			'name'=>'部门名称',
			'post'=>'岗位分级',
			'principal_id'=>'部门负责人'
		);
		$time=time();
		if($_POST){
			
			$id=$_POST['id']?$_POST['id']:0;
			$ups=$_POST['ups']?$_POST['ups']: 0;
			$name=$_POST['name']?$_POST['name']: $error[]=$error_log['name'];
			$principal_id=$_POST['principal_id']?$_POST['principal_id']: $error[]=$error_log['principal_id'];
			//岗位不是 必填 ,如果有项目 则必须填写
			if(is_array($_POST['post'])){
				foreach($_POST['post'] as $v){
					if(trim($v)){
						$post[]=array('name'=>$v,
									  'create_id'=>$my_info['id'],
									  'create_time'=>$time,
									  'update_id'=>$my_info['id'],
									  'update_time'=>$time
									  );
					}else{
						$error[]=$error_log['post'];
					}
				}
				
			}
			
			
			if(is_array($error)){
					$msg=array('error'=>1,'info'=>implode(',',$error).'不能为空！');
			}else{
				if($id>0){
					#############################修改部门############################
					
					$department_id=M('department')->where(array('id'=>$id))->save(
							array(
							  'ups'=>$ups,
							  'name'=>$name,
							  'principal_id'=>$principal_id,							  
							  'update_id'=>$my_info['id'],
							  'update_time'=>$time
							  )
							);
					if($department_id){
						M('department_post')->where(array('department_id'=>$id))->delete();
						if(is_array($post)){						
							foreach($post as $k=>$v) $post[$k]['department_id']=$id;//赋值 部门的ID
							if(M('department_post')->addAll($post)){
								$msg=array('error'=>0,'info'=>'修改公司部门成功!');
							}else{
								$msg=array('error'=>2,'info'=>'岗位分级创建失败，请稍后再试！');
							}
						}else{
							$msg=array('error'=>0,'info'=>'修改公司部门成功!');
						}
					}else{
						$msg=array('error'=>2,'info'=>'网络不稳定，请稍后再试！');
					}
				}else{
					#############################插入部门############################
					
						$department_id=M('department')->add(
							array('ups'=>$ups,
							  'name'=>$name,
							  'principal_id'=>$principal_id,
							  'create_id'=>$my_info['id'],
							  'create_time'=>$time,
							  'update_id'=>$my_info['id'],
							  'update_time'=>$time
							  )
							);
						if($department_id){	
							if(is_array($post)){
								foreach($post as $k=>$v) $post[$k]['department_id']=$department_id;//赋值 部门的ID
								if(M('department_post')->addAll($post)){
									$msg=array('error'=>0,'info'=>'新增公司部门成功!');
								}else{
									$msg=array('error'=>2,'info'=>'岗位分级创建失败，请稍后再试！');
								}
							}else{
								$msg=array('error'=>0,'info'=>'新增公司部门成功!');
							}
						}else{								
							 $msg=array('error'=>2,'info'=>'网络不稳定，请稍后再试！');
							
									
						}
					}
			}
			$this->ajaxReturn($msg,'json');exit;
		}else{
			$department_state=array(
					1=>'启用',
					2=>'停用'
			);
			$count=M('department as a')
					->join(C('DB_PREFIX').'department_post as b on a.id =b.department_id','LEFT')
					->join(C('DB_PREFIX').'users as c on c.id =a.principal_id','LEFT')
					->join(C('DB_PREFIX').'department as d on d.id =a.ups','LEFT')
					->field('a.*,GROUP_CONCAT(b.name separator "，") as post_name ,c.username as principal_name,d.name as ups_name')
					->where(array('a.state'=>1))
					->group('a.id')
					->order('a.update_time desc,b.update_time desc')
					->count();
			
			$Page= new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show = $Page->show();// 分页显示输出
			$list=M('department as a')
					->join(C('DB_PREFIX').'department_post as b on a.id =b.department_id','LEFT')
					->join(C('DB_PREFIX').'users as c on c.id =a.principal_id','LEFT')
					->join(C('DB_PREFIX').'department as d on d.id =a.ups','LEFT')
					->field('a.*,GROUP_CONCAT(b.name separator "，") as post_name ,c.username as principal_name,d.name as ups_name')
					->where(array('a.state'=>1))
					->group('a.id')
					->order('a.update_time desc,b.update_time desc')
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
			//var_dump(M()->getlastsql());
			$this->assign('department_state',$department_state);
			$this->assign('list',$list);
			$this->assign('page',$show);// 赋值分页输出
		}
		$this->display("Department/index");
	}
	
	/*异步获取部门列表*/
	public function department_ajax(){
		
		$action=$_POST['action'];
		$info_id=$_POST['info_id'];
		$table=M('department');
		switch($action){
			case 'department'://上级部门
				
				$departments=$table->where(array('state'=>1))->order('update_time desc')->select();
				import('Common/ORG/Tree');
				$treeObj = new \Tree();//引用Tree类
				$data=$treeObj->genCate($departments,0,0,'ups',array('name'=>'id'));	
				//var_dump(M()->getlastsql());				
				
				break;
			case 'infos'://内容
				$data=M('department as a')
					->join(C('DB_PREFIX').'department_post as b on a.id =b.department_id','LEFT')
					->join(C('DB_PREFIX').'users as c on c.id =a.principal_id','LEFT')
					->field('a.*,GROUP_CONCAT(b.name) as post_name ,c.username as principal_name')
					->where(array('a.state'=>1,'a.id'=>$info_id))
					->group('a.id')
					->order('a.update_time desc,b.update_time desc')
					->find();
				
				break;
			case 'del'://删除部门 连同职位一并删除
				$sql="DELETE a.*, b.*
					FROM
						tp_department AS a
					LEFT JOIN tp_department_post AS b ON a.id = b.department_id 
					WHERE a. id in ($info_id) ";
					if(M()->execute($sql)){
						$msg=array('error'=>0,'info'=>'部门删除成功，岗位一并被清除了！');
					}else{
						$msg=array('error'=>1,'info'=>'无法获取部门资料，请稍后再试！');
					}
					$this->ajaxReturn($msg,'json');
				break;
			default:
				break;
		}
		
		if($data)
			$msg=array('error'=>0,'info'=>$data);
		else
			$msg=array('error'=>1,'info'=>'无法获取部门资料，请稍后再试！');
		//print_r($carr);
		$this->ajaxReturn($msg,'json');
		//	echo json_encode($carr);
		
	
	}
	
	
	
}