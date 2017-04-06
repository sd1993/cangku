<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public $my_info;
	
	public function _initialize(){
		
        $this->my_info=UserController::User_info();
		$head_data=UserController::Head_data();
		$this->assign('head_data',$head_data);
    }
	
	
	
	public function index(){
		 
		 UserController::Main();
		// $this->display('Index/index');
		
    }
   /*
   *处理完  index 方法 后 自动执行
   */
	
	public function _after_index(){
		
		
		// UserController::Main();
    }
	
	
	
}