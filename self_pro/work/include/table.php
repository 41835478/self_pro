<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	time 	2017-10-12
	auth	李凯
*/
class table{
	private $table = '';
	private $field = array();
	private $auto_key = '';
	private $state = false;
	private $where = array();
	private $unique = array();
	private $unique2 = array();
	private $other_data = array();

	private $r_id = false;
	
	public function __construct($table = ''){
		
		if(empty($table)){
			show_message('请填写表名','html','-1');
		}
		
		$this->table = $table;
	}
	
	//设置字段
	public function field($field = array()){
		if( is_array( $field ) && !empty( $field )){
			foreach ( $field as $key => $val ){
				if(!empty($this->auto_key) && $this->auto_key == $key){
					continue;
				}
				if($val == 'url' && !empty($_POST[$val])){
					$_POST[$val] = 'http://'.str_replace('http://','',$_POST[$val]);
				}
				$this->field[$val] = isset( $_POST[$val] ) ? $_POST[$val] : '';
			}
		}
		return $this;
	}
	
	//设置字段的类型
	public function type($field , $type = 'varchar' , $where = array()){
		if(!empty($type)){
			switch($type){
				case 'time':
				$this->field[$field] = strtotime(str_replace('&nbsp',' ',$this->field[$field]));
				break;
				case 'unique':
				$this->unique[$field] = isset($this->field[$field]) ? $this->field[$field] : (isset($_POST[$field]) ? $_POST[$field] : '');
				if(!empty($where)){
					$this->unique2[$field] = $where;
				}
				
				break;
				case 'auto_key':
				$this->where[$field] = isset($this->field[$field]) ? $this->field[$field] : (isset($_POST[$field]) ? $_POST[$field] : '');
				if(!empty($this->where[$field])){
					$this->auto_key = $field;
				}
				
				if(isset($this->field[$field])){
					unset($this->field[$field]);
				}
				break;
			}
		}
		return $this;
	}
	
	public function commit($t = ''){
		$res = '';
		if(!empty($this->auto_key)){
			//update
			if(isset($this->other['update']) && !empty($this->other['update'])){
				$this->field = array_merge($this->other['update'],$this->field);
			}
			$res = M($this->table)->where($this->where)->update($this->field,$t);
			$this->state['M'] = 'update';
		}else{
			//add
			if(!empty($this->unique)){
				$tab =  M($this->table);
				if(!empty($this->unique)){
					foreach($this->unique as $key => $val){
						$w1 = array();
						$w2 = array();
						if(isset($this->unique2[$key]) && !empty($this->unique2[$key])){
							foreach($this->unique2[$key] as $k => $v){
								$w2[$k] = $v;
							}
						}
						$w1[$key] = $val;
						$tab->where($w2,array('or','and'));
						$tab->where($w1);
					}
				}
				$res = $tab->find();
				if($res){
					$msg = array(
						'msg' => '已存在的数据,请勿重复添加',
						'code' => '-1',
					);
					show_message($msg,'json');
				}
			}
			if(isset($this->other['add']) && !empty($this->other['add'])){
				$this->field = array_merge($this->other['add'],$this->field);
			}
			
			$res = M($this->table)->add($this->field,$t);
			$this->state['M'] = 'add';
			$this->state['id'] = $res;
		}
		$this->state['res'] = $res;
		return $res;
	}
	
	public function other($type = '', $data = array()){
		if($type == 'add' && !empty($data)){
			foreach($data as $key => $val){
				$this->other['add'][$key] = $val;
			}
		}
		if($type == 'update' && !empty($data)){
			foreach($data as $key => $val){
				$this->other['update'][$key] = $val;
			}
		}
		return $this;
	}
	
	//post字段处理一下
	public function set_field($field , $type){
		$str = $_POST[$field];
		if(!empty($str) && !empty($type)){
			switch($type){
				case 'time':	//时间戳格式
				$str = str_replace('&nbsp',' ',$str);
				$str = strtotime($str);
				$_POST[$field] = $str;
				break;
				case 'date':	//Y-m-d H:i:s格式
				$str = date('Y-m-d H:i:s',$str);
				$_POST[$field] = $str;
				break;
			}
		}
		
		return $this;
	}
	
	public function get_state(){
		return $this->state;
	}
}
?>