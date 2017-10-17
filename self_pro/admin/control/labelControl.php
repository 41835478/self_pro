<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	链接
*/
class labelControl extends sysControl{
	
	public function user_label_list(){
		$selected = selected(array('is_show'));
		$Muser_label = M('user_label');
		$is_del = array('is_del' => '0');
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('name');
		$where2 = array();
		if(!empty($where) || !empty($where2)){
			$label_list = $Muser_label	
						->where($where)
						->where($where2)
						->select();
		}else{
			$where2['pid'] = '0'; 
			$where3['pid'] = '>0'; 
			$list = $Muser_label					
					->where($is_del)
					->where($where)
					->where($where2)
					->select();
			$list2 = $Muser_label
					->where($is_del)
					->where($where3)
					->select();
			$label_list = array();
			if(!empty($list2)){
				foreach($list2 as $key => $val){
					$this->label_list_d[$val['pid']][] = $val;
				}	
			}
			if(!empty($list)){
				foreach($list as $key => $val){
					$this->label_list[] = $val;
					$li = M('user_label')
						  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
						  ->select();
					$this->get_label_list2($li , 0);
				}
				if(!empty($this->label_list)){
					foreach($this->label_list as $key => $val){
						
						$label_list[$key] = $val;
						
					}
				}
			}	
		}
		$count = count($label_list);
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
		$li = array();
		$len = ($page-1) * $num + $num;
		for($i = ($page-1) * $num ; $i < $len ; $i++){
			if(isset($label_list[$i])){
				$li[] = $label_list[$i];
			}
		}
		$label_list = $li;
		self::form_top(array(
			'add' => '?act=label&op=user_label_edit',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=label&op=user_label_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=label&op=user_label_del&id=__ID__')")),
					),'操作'),
		),$label_list,'id');
	}
	
	public function user_label_edit(){
		if($_POST){
			$this->commit();
		}
		$user_label = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$user_label = M('user_label')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		$label = '';
		$label_id = 0;
		$add = true; //判断是添加的时候
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$label_id = intval($_GET['id']);
			$label = M('user_label')->where(array('id' => $label_id))->find();
			$add = false;
		}
		$label_list = array(
			'0' => '顶级分类',
		);
		$label_where = array(
			'is_del' => '0',
			'pid' => '0',
		);
		$label_where2 = array(
			'is_del' => '0',
			'pid' => '>0',
		);
		$list = M('user_label')->where($label_where)->select();
		$list2 = M('user_label')->where($label_where2)->select();
		if(!empty($list2)){
			foreach($list2 as $key => $val){
				$this->label_list_d[$val['pid']][] = $val;
			}	
		}
		if(!empty($list)){
			foreach($list as $key => $val){
				if($label_id > 0 && $label_id != $val['id'] || $add){
					$this->label_list[$val['id']] = $val['name'];
					$li = M('user_label')
						  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
						  ->select();
					$this->get_label_list($li , 0);
				}
			}
			if(!empty($this->label_list)){
				foreach($this->label_list as $key => $val){
					if($label_id > 0 && $label_id != $key || $add){
						$label_list[$key] = $val;
					}
				}
			}
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('selected','pid','上级分类',$label_list),
			array('text','name','名称'),
		),$user_label,'post','public_form');
	}
	
	private $label_list = array();
	private $label_list_d = array();  //未了吥连续查询
	//编辑页面递归
	private function get_label_list($li,$num){
		if(!empty($li)){
			foreach($li as $key => $val){
				$str = '--';
				for($i = 0 ; $i < $num ; $i++){
					$str .= '--';
				}
				$this->label_list[$val['id']] = $str.$val['name'];
				$d = '';
				
				if(isset($this->label_list_d[$val['id']])){
					$d = $this->label_list_d[$val['id']];
				}
			//	$d = M('label')->where(array( 'pid' => $val['id'] ,'is_del' => '0'))->select();
				if(!empty($d)){
					$num++;
					$s = $num;
					$this->get_label_list($d , $s);
				}
			}
		}
	}
	
	//列表递归
	private function get_label_list2($li,$num){
		if(!empty($li)){
			foreach($li as $key => $val){
				$str = '--';
				for($i = 0 ; $i < $num ; $i++){
					$str .= '--';
				}
				$val['name'] = $str.$val['name'];
				$this->label_list[] = $val;
				$d = '';
				if(isset($this->label_list_d[$val['id']])){
					$d = $this->label_list_d[$val['id']];
				}
			//	$d = M('label')->where(array( 'pid' => $val['id'] ,'is_del' => '0'))->select();
				if(!empty($d)){
					$num++;
					$s = $num;
					$this->get_label_list2($d , $s);
				}
			}
		}
	}
	
	public function user_label_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('user_label')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		$field = array('id','name','pid');
		$table = new table('user_label');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time()))  //添加的时候附加的值	//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('user_label')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了友情链接,链接id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('user_label')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了友情链接,链接id是'.intval($_POST['id']),
			);
			M('admin_log')->add($log);
		}
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
}
?>