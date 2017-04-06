<?php
/**
 * [���޷ּ���]
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
     * ���޷ּ�
     * @access  public
     * @param   array     &$data      ���ݿ���ȡ�õĽ���� ��ַ����
     * @param   integer   $pid        ����id��ֵ
     * @param   string    $col_id     ����id�ֶ�������Ӧ&$data����ֶ�����
     * @param   string    $col_pid    �����ֶ�������Ӧ&$data����ֶ�����
     * @param   string    $col_cid    �Ƿ�����Ӽ��ֶ�������Ӧ&$data����ֶ�����
     * @return  array     $childs     ��������õ�����
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
	  * ��ȡ��ǰid����ID
	  * @param array $data ԭʼ����
	  * @param int $pid ��IDΪ��ǰ�����id
	  * @param int $level ��ǰ�㼶
	  * @param var $col_cid ��ǰ����
	  * @param var $col_pid array(name=>,value=��)
	 */
	 static function genCate($data, $pid = 0, $level = 0 ,$col_cid,$col_pid)
	 {
		 if($level == 10) break;
		 $l        = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level);
		 $l        = $l.'��';
		 static $option ;
		
		// $arrcat    = empty($level) ? array() : $arrcat;
		 foreach($data as $k => $row)
		 {
			 
			 if(isset($col_pid['value'])){
				  /**
				  * �ҳ���ǰ���� ���ϼ�
				  */
				  if($row[$col_cid]==$col_pid['value']){
					   //�����ǰ������id��Ϊ��
					 $option[]= array(
									'id'=>$row['id'],
									'lv'=>$level,
									'info'=>$row['name']
								);

					
					self::genCate($data,0,0,$col_cid,array('name'=>$col_pid['name'],'value'=>$row['ups']));//�ݹ����
				  }
			 }else{
				 /**
				  * �����IDΪ��ǰ�����id
				  */
				 if($row[$col_cid] == $pid)
				 {
					 //�����ǰ������id��Ϊ��
					 $option[]= array(
									'id'=>$row[$col_pid['name']],
									'lv'=>$level,
									'info'=>$row['name']
								);

					
					self::genCate($data, $row[$col_pid['name']], $level+1,$col_cid,$col_pid);//�ݹ����
				 }
			 }
			 
		 }
		 return $option;
	 }
	}
	
	
	