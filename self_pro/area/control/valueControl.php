<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	 系统变量
*/
class valueControl extends sysControl{
	
	public function value_list(){
		$selected = selected(array('is_show'));
		$Mconfig = M('config');
		$c_type = array('c_type' => '1' , 'is_del' => 0);  //变量类型
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		
		$config = $Mconfig
				 ->where($c_type)
				 ->page($page,$num)->select();
		$count = $Mconfig
				 ->where($c_type)
				 ->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
		self::form_top(array(
			'add' => '?act=value&op=value_edit',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('label','value','地址'),
			array('time','update_time','时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=value&op=value_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=value&op=value_del&id=__ID__')")),
					),'操作'),
		),$config,'id');
	}
	
	public function value_edit(){
		if($_POST){
			$this->commit();
		}
		$config = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$config = M('config')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','名称'),
			array('text','value','值'),
		),$config,'post','public_form');
	}
	
	public function value_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('config')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		$field = array('id','name','value');
		$table = new table('config');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique')		//主键
			  ->other('add',array('update_time' => time(),'c_type' => 1))  //添加的时候附加的值	//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('config')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了系统变量,变量id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('config')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了系统变量,变量id是'.intval($_POST['id']),
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