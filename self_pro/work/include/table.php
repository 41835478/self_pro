<?php
if(!defined('PROJECT_NAME')) die('project empty');
class table{
	private $table = '';
	private $field = array();
	private $auto_key = '';
	private $state = false;
	private $where = array();
	private $unique = array();
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
				$this->field[$val] = isset( $_POST[$val] ) ? $_POST[$val] : '';
			}
		}
		return $this;
	}
	
	//设置字段的类型
	public function type($field , $type = 'varchar'){
		if(!empty($type)){
			switch($type){
				case 'time':
				$this->field[$field] = strtotime(str_replace('&nbsp',' ',$this->field[$field]));
				break;
				case 'unique':
				$this->unique[$field] = isset($this->field[$field]) ? $this->field[$field] : (isset($_POST[$field]) ? $_POST[$field] : '');
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
				$res = M($this->table)->where($this->unique,array('and','or'))->find();
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
	
	public function get_state(){
		return $this->state;
	}
}
?>