<?php
class mysqli{
	private $config = '';
	private $where  = ' WHERE 1 ';
	public $affix   = '';
	private $limit  = ''; //默认查500个吧
	private $table  = '';
	private $join   = '';
	private $sql    = '';
	private $order  = '';
	private $count  = '';
	private $field  = '*';
	private $data   = '';
	private $page   = '1';
	private $num    = '20';
	
	public function __construct($table=''){
		$this->table($table);
	}
	
	//重置
	public function reset(){
		$this->where  = ' WHERE 1 ';
		$this->limit  = '';
		$this->join   = '';
		$this->sql   = '';
		$this->order  = '';
		$this->count  = '';
		$this->field  = '*';
		$this->data   = '';
		$this->page   = '1';
		$this->num    = '20';
	}
	
	//表
	public function table($table=''){
		global $config;
		$this->config = & $config;
		if(!empty($this->config['left_affix'])){
			$this->table = $this->config['left_affix'].$table;
			$this->affix = $this->config['left_affix'];
		}else if(!empty($this->config['right_affix'])){
			$this->table = $table.$this->config['right_affix'];
			$this->affix = $this->config['right_affix'];
		}else{
			$this->table = $this->config['affix'].$table;
			$this->affix = $this->config['affix'];
		}
		return $this;
	}
	/* 
	*	表连接 要加表前缀 不好用自己修改
	*	例如 $m->affix.'表名'
	*   join('left '.$m->affix.'store',$m->affix.'goods.store_id='.$m->affix.'store.store_id')
	*/
	public function join($table='',$link=''){
		if(is_string($table) && is_string($link)){
		  $search1 = array(
			'left',
			'right',
		  );
		  $replace1 = array(
			' LEFT JOIN ',
			' RIGHT JOIN ',
		  );
		  $table = str_replace($search1,$replace1,$table);
		  $this->join .= ' '.$table . ' ON ' . $link;
		}
		return $this;
	}
	
	/*
	*  page
	*  page 当前页  num 查询数量
	*/
	public function page($page,$num=''){
		//$this->field .= ',COUNT(*) as count';
		if($num==''){
			$num = $this->num;
		}
		$page = ($page-1)*$num;
		$this->limit = ' limit '.$page.','.$num;
		return $this;
	}
	/*
	*  获取总数
	* 
	*/
	public function count($t=''){
		$this->sql = 'SELECT count(*) as num FROM '.$this->table.$this->join.$this->where.$this->order.$this->limit;
		if($t){
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		$this->reset();
		!$res?show_message($this->sql.' error'):'';
		$data = array();
		while($row = mysql_fetch_assoc($res)){
			$data[] = $row;
		}
		if(!empty($data)){
			return $data[0]['num'];
		}
		return null;
	}
	/*
	*   参数 $join_where = 1 时显示where子句
	*  
	*/
	public function where($where = array(),$join_where = array()){
		if(is_string($where)){
			$this->where .= $where;
		}
		$table = '';
		if(!empty($this->table)){
			$table = $this->table.'.';
		}
		if(is_array($where)){
			foreach($where as $k => $v){
				if($join_where == 'or' || $join_where == 'OR'){
					$this->where .= ' OR ';
				}else{
					$this->where .= ' AND ';
				}
				$num1 = substr($v,0,1);
				$num2 = substr($v,0,2);
				$num3 = substr($v,0,4);
				if($num1 == '<' || $num1 == '=' || $num1 == '>' ||
				   $num2 == '<=' || $num2 == '==' || $num2 == '>=' ||
				   $num2 == '!='
				){
					$this->where .= $table.$k.$v.' ';
				}else if($num3 == 'like' || $num3 == 'LIKE'){  //自己加百分号，更加灵活
					$str = explode(' ',$v);
					$this->where .= $table.$k.' LIKE \''.$str[1].'\'';
				}else if($num2 == 'in' || $num2 == 'IN'){
					$str = explode(' ',$v);
					$this->where .= $table.$k.' in ('.$str[1].')';
				}else{
					$this->where .= $table.$k.'=\''.$v.'\'';
				}
			}
		}
		
		if($join_where=='1'){
			show_message($this->where);
		}
		return $this;
	}
	/*
	* 插入
	*/
	public function insert($data,$t=''){
		if(!is_array($data)){
			return false;
		}
		$str1 = '(';
		$str2 = ' VALUES(';
		foreach($data as $k => $v){
			$str1 .= '`'.$k.'`,';
			$str2 .= '\''.$v.'\',';
		}
		$str1 = substr($str1,0,(strlen($str1)-1));
		$str2 = substr($str2,0,(strlen($str2)-1));
		$str1 .= ')';
		$str2 .= ')';
		$this->sql = 'INSERT INTO `'.$this->table.'`'.$str1.$str2;
		if($t){
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		$this->reset();
		return $res;
	}
	public function field($field){
		if($this->field == '*'){
			$this->field = $field;
		}else if(strlen($this->field) > 1){
			$this->field = str_replace('*,','',$this->field);
			$this->field .= ','.$field;
		}else{
			$this->field = str_replace('*,','',$this->field);
			$this->field .= $field;
		}
		return $this;
	}
	public function fields($field){
		$this->field($field);
		return $this;
	}	
	public function limit($v1,$v2=''){
		$v2 = !empty($v2)?','.$v2:'';
		$this->limit = ' limit '.$v1.$v2.' ';
		return $this;
	}
	public function order($order){
	//	$this->order = ' ORDER BY '.$this->table.'.'.$order;
		$this->order = ' ORDER BY '.$order;
		return $this;
	}
	public function select($t=''){
		$this->sql = 'SELECT '.$this->field.' FROM '.$this->table.$this->join.$this->where.$this->order.$this->limit;
		
		if($t){
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		$this->reset();
		!$res?show_message($this->sql.' error'):'';
		$data = array();
		while($row = mysql_fetch_assoc($res)){
			$data[] = $row;
		}
		if(!empty($data)){
			return $data;
		}
		return null;
	}
	public function find($t=''){
		$this->limit = ' limit 1 ';
		$this->sql = 'SELECT '.$this->field.' FROM '.$this->table.$this->join.$this->where.$this->order.$this->limit;
		if($t){
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		$this->reset();
		!$res?show_message($this->sql.' error'):'';
		$data = array();
		while($row = mysql_fetch_assoc($res)){
			$data[] = $row;
		}
		/*
		if(!empty($this->field)){
			$fie = '';
			if(strlen($this->field) > 1){
				$fie = explode(',',$this->field);
				if(!empty($data) && !empty($fie) && count($fie == 1)){
					$this->reset();
					return $data[0][$fie[0]];
				}
			}
		}
		*/
		if(!empty($data)){
			$this->reset();
			return $data[0];
		}
		
		return null;
	}
	
	public function column($t=''){
		$this->limit = ' limit 1 ';
		$this->sql = 'SELECT '.$this->field.' FROM '.$this->table.$this->join.$this->where.$this->order.$this->limit;
		if($t){
			show_message($this->sql);
		}
		
		$res = mysql_query($this->sql);
		!$res?show_message($this->sql.' error'):'';
		$data = array();
		while($row = mysql_fetch_assoc($res)){
			$data[] = $row;
		}
		if(!empty($this->field)){
			$fie = '';
			if(strlen($this->field) > 1){
				$fie = explode(',',$this->field);
				if(!empty($data) && !empty($fie) && count($fie) == 1){
					$this->reset();
					return $data[0][$fie[0]];
				}
			}
		}
		$this->reset();
		return null;
	}
	
	public function data($data = ''){
		if(!is_array($data)){
			return false;
		}
		$arr = array();
		foreach($data as $k => $v){
			$arr[] = $k.'=\''.$v.'\'';
		}
		$this->data = implode(',',$arr);
		return $this;
	}
	
	public function update($data=array(),$t=''){
		$this->data($data);
		$this->sql = 'UPDATE ' . $this->table.' SET '.$this->data . $this->where;
		if($t){
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		$this->reset();
		return $res;
	}
	
	public function del($where=array()){
		$this->where($where);
		$this->sql = 'DELETE FROM '.$this->table.$this->where;
		if(intval($where) > 0 ){ //显示sql
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		$this->reset();
		return $res;
	}
	public function delete($where=array()){
		return $this->del($where);
	}
	
}
?>