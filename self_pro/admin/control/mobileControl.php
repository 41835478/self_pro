<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	手机相关
*/
class mobileControl extends sysControl{
	
	public function mobile_menu(){
		$selected = selected(array('is_show'));
		$Mmobile_menu = M('mobile_menu');
		$is_del = array();
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		
		$mobile_menu = $Mmobile_menu
				 ->where($is_del)
				 ->page($page,$num)->select();
		$count = $Mmobile_menu
				 ->where($is_del)
				 ->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
		self::form_top(array(
			'add' => '?act=mobile&op=mobile_menu_edit',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('image','image','图片'),
			array('label','url','地址'),
			array('label','m_sort','排序'),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=mobile&op=mobile_menu_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=mobile&op=mobile_menu_del&id=__ID__')")),
					),'操作'),
		),$mobile_menu,'id');
	}
	
	public function mobile_menu_edit(){
		if($_POST){
			$this->commit();
		}
		$mobile_menu = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$mobile_menu = M('mobile_menu')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','名称'),
			array('file','image','图标'),
			array('text','url','地址'),
			array('text','m_sort','排序'),
		),$mobile_menu,'post','public_form');
	}
	
	public function mobile_menu_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('mobile_menu')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		$field = array('id','name','image','url','m_sort');
		$table = new table('mobile_menu');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time()))  //添加的时候附加的值	//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('mobile_menu')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了手机菜单,id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('mobile_menu')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了手机菜单,id是'.intval($_POST['id']),
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