<?php
class mysql{
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
		$this->sql    = '';
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
			if(!empty($table)){
				$this->table = $this->config['affix'].$table;
			}
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
			'__AFFIX__',
		  );
		  $replace1 = array(
			' LEFT JOIN ',
			' RIGHT JOIN ',
			$this->affix,
		  );
		  $table = str_replace($search1,$replace1,$table);
		  $link = str_replace('__AFFIX__',$this->affix,$link);
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
		//空的直接返回
		if(empty($where)){
			return $this;
		}
		if(is_string($where)){
			if($join_where == 'or' || $join_where == 'OR'){
				$this->where .= ' OR '.$where;
			}else{
				$this->where .= ' AND '.$where;
			}
		}
		//如果是数组,非空并且长度是两个
		$join_where_flag = 0;
		if(!empty($join_where) && is_array($join_where) && count($join_where) == 2){
			$w = array();
			$w[] = reset($join_where);
			$w[] = end($join_where);
			$join_where = $w;
			$join_where_flag = 1;
		}
		$table = '';
	//	if(!empty($this->table)){
	//		$table = $this->table.'.';
	//	}
		$link = '';
		if(is_array($where)){
			foreach($where as $k => $v){
				if(empty($join_where)){
					$link = ' AND ';
				}else if($join_where == 'and' || $join_where == 'AND'){
					$link = ' AND ';
				}else if($join_where == 'or' || $join_where == 'OR'){
					$link = ' OR ';
				}
				
				if($join_where_flag == 1){
					if($join_where[0] == 'and' || $join_where[0] == 'AND'){
						$link = ' AND ';
					}
					if($join_where[0] == 'or' || $join_where[0] == 'OR'){
						$link = ' OR ';
					}
					$join_where_flag ++;
				}
				if($join_where_flag > 1){
					if($join_where[1] == 'and' || $join_where[1] == 'AND'){
						$link = ' AND ';
					}
					if($join_where[1] == 'or' || $join_where[1] == 'OR'){
						$link = ' OR ';
					}
				}
				$this->where .= $link;  //$link 可能是and或者or连接
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
		$this->where = str_replace('__AFFIX__',$this->affix,$this->where);
	//	$this->where = str_replace($table,'',$this->where);
		if($join_where=='1'){
			show_message($this->where);
		}
		return $this;
	}
	/*
	* 插入
	*/
	public function insert($data,$t=''){
		
		/*
		if(!is_array($data)){
			return false;
		}
		*/
		if(is_string($data)){
			$this->sql = $data;
		}
		if(is_array($data)){
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
		}
		if($t == 'return' || $t == 'back' ){
			return $this->sql;
		}
		if($t){
			show_message($this->sql);
		//	return $this->sql;
		}
		
		$res = mysql_query($this->sql);
		$this->reset();
		if($res){  //返回主键id
			return mysql_insert_id();
		}
		return $res;
	}
	/*
	* 插入
	*/
	public function add($data,$t=''){
		return $this->insert($data,$t);
	}
	
	/*
	* 插入
	*/
	public function insert_all($data,$t=''){
		if(!is_array($data)){
			return false;
		}
		$str1 = '(';
		$str2 = ' VALUES(';
		$num = 1;
		foreach($data as $k => $v){
			if(is_array($v)){
				foreach($v as $kk => $vv){
					if($num == 1){
						$str1 .= '`'.$kk.'`,';
					}
					$str2 .= '\''.$vv.'\',';
				}
				$str2 = substr($str2,0,(strlen($str2)-1));
				$str2 .= '),(';
				$num ++;
			}
		}
		$str1 = substr($str1,0,(strlen($str1)-1));
		$str2 = substr($str2,0,(strlen($str2)-2));
		$str1 .= ')';
	//	$str2 .= ')';
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
		$this->field = str_replace('__AFFIX__',$this->affix,$this->field);
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
		$order = str_replace('__AFFIX__',$this->affix,$order);
		$this->order = ' ORDER BY '.$order;
		return $this;
	}
	public function select($t=''){
		$this->sql = 'SELECT '.$this->field.' FROM '.$this->table.$this->join.$this->where.$this->order.$this->limit;
		if($t == 'return' || $t == 'back' ){
			return $this->sql;
		}
		if($t){
			show_message($this->sql);
		}
		$res = mysql_query($this->sql);
		!$res?show_message($this->sql.' error'):'';
		$this->reset();
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
		!$res?show_message($this->sql.' error'):'';
		$this->reset();
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
	/*
		$t 用return返回sql
	*/
	public function update($data=array(),$t=''){
		if(is_string($data)){
			$this->sql = $data;
		}else{
			$this->data($data);
			$this->sql = 'UPDATE ' . $this->table.' SET '.$this->data . $this->where;
		}
		
		if($t == 'return' || $t == 'back'){
			return $this->sql;
		}
		if($t){
			show_message($this->sql);
		}
		
		$res = mysql_query($this->sql);
		$this->reset();
		return $res;
	}
	
	/*
		直接执行sql select,insert,update,delete或者其它
		反正用mysql_query函数
	*/
	public function query($sql,$t =''){
		if(empty($sql) || !is_string($sql)){
			return false;
		}
		$sql = str_replace('__AFFIX__',$this->affix,$sql);
		$query_method = substr($sql,0,6);
		if($query_method == 'insert' || $query_method == 'INSERT'){
			return $this->insert($sql,$t);
		}else if($query_method == 'delete' || $query_method == 'DELETE'){
			return $this->del($sql,$t);
		}else if($query_method == 'update' || $query_method == 'UPDATE'){
			return $this->update($sql,$t);
		}else if($query_method == 'select' || $query_method == 'SELECT'){
			$this->sql = $sql;
			return $this->select($t);
		}else{
			$res = mysql_query($sql);
		}
		return $res;
	}
	
	//更新
	public function save($data=array(),$t=''){
		return $this->update($data,$t);
	}
	
	//删除
	public function del($where=array(),$t = ''){
		if(!empty($where) && is_string($where) && $where != 'return' && $where != 'back'){
			$this->sql = $where;
		}else{
			$this->where($where);
			$this->sql = 'DELETE FROM '.$this->table.$this->where;
		}
		
		if($where == 'return' || $where == 'back' || $t == 'return' || $t == 'back' ){
			return $this->sql;
		}
		
		if(intval($where) > 0 || intval($t) > 0 ){ //显示sql
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