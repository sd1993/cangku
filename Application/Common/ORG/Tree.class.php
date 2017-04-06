<?php
/**
 * [无限分级类]
 * @Author mls
 * @version v1.0
 * @time    2016-12-19
 */
// +----------------------------------------------------------------------


class Tree {

    static public function findChild(&$data, $pid = 0, $col_pid = 'parent') {
        $rootList = array();
		
        foreach ($data as $key => $val) {
            if ($val[$col_pid] == $pid) {
                $rootList[]   = $val;
                unset($data[$key]);
            }
        }
        return $rootList;
    }

    /**
     * 无限分级
     * @access  public
     * @param   array     &$data      数据库里取得的结果集 地址引用
     * @param   integer   $pid        父级id的值
     * @param   string    $col_id     自增id字段名（对应&$data里的字段名）
     * @param   string    $col_pid    父级字段名（对应&$data里的字段名）
     * @param   string    $col_cid    是否存在子级字段名（对应&$data里的字段名）
     * @return  array     $childs     返回整理好的数组
	 (cateRow,$pid = 0, $col_id = 'id', $col_pid = 'ups', $col_cid = '')
     */
    static public function getTree(&$data, $pid = 0, $col_id = '', $col_pid = '', $col_cid = '') {
        $childs = self::findChild($data, $pid, $col_pid);
        if (empty($childs)) {
            return null;
        }
		
        foreach ($childs as $key => $val) {
            if ($val[$col_cid] || empty($col_cid)) {
                $treeList = self::getTree($data, $val[$col_id], $col_id, $col_pid, $col_cid);
                if ($treeList !== null) {
                    $childs[$key]['childs'] = $treeList;
                }
            }
        }
        return $childs;
    }
	
	
	
	/**
	  * 获取当前id的子ID
	  * @param array $data 原始数组
	  * @param int $pid 父ID为当前传入的id
	  * @param int $level 当前层级
	  * @param var $col_cid 当前基层
	  * @param var $col_pid array(name=>,value=》)
	 */
	 static function genCate($data, $pid = 0, $level = 0 ,$col_cid,$col_pid)
	 {
		 if($level == 10) break;
		 $l        = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level);
		 $l        = $l.'└';
		 static $option ;
		
		// $arrcat    = empty($level) ? array() : $arrcat;
		 foreach($data as $k => $row)
		 {
			 
			 if(isset($col_pid['value'])){
				  /**
				  * 找出当前基数 的上级
				  */
				  if($row[$col_cid]==$col_pid['value']){
					   //如果当前遍历的id不为空
					 $option[]= array(
									'id'=>$row['id'],
									'lv'=>$level,
									'info'=>$row['name']
								);

					
					self::genCate($data,0,0,$col_cid,array('name'=>$col_pid['name'],'value'=>$row['ups']));//递归调用
				  }
			 }else{
				 /**
				  * 如果父ID为当前传入的id
				  */
				 if($row[$col_cid] == $pid)
				 {
					 //如果当前遍历的id不为空
					 $option[]= array(
									'id'=>$row[$col_pid['name']],
									'lv'=>$level,
									'info'=>$row['name']
								);

					
					self::genCate($data, $row[$col_pid['name']], $level+1,$col_cid,$col_pid);//递归调用
				 }
			 }
			 
		 }
		 return $option;
	 }
	}
	
	
	