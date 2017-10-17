<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	链接
*/
class advControl extends sysControl{
	
	public function adv_list(){
		$selected = selected(array('is_show'));
		$Madv = M('adv');
		$is_del = array('is_del' => '0');
		if($_SESSION['admin']['pid'] > 0){
			$is_del['a_id'] = $_SESSION['admin']['id'];
		}
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		
		$adv = $Madv
				 ->where($is_del)
				 ->page($page,$num)->select();
		$count = $Madv
				 ->where($is_del)
				 ->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
		self::form_top(array(
			'add' => '?act=adv&op=adv_edit',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('image','image','图片'),
			array('label','url','地址'),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=adv&op=adv_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=adv&op=adv_del&id=__ID__')")),
					),'操作'),
		),$adv,'id');
	}
	
	public function adv_edit(){
		if($_POST){
			$this->commit();
		}
		$adv = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$adv = M('adv')->where(array('id' => intval($_GET['id'])))->find();
		}
		$edit = array(
			array('hidden','id','ID'),
			array('text','name','名称'),
			array('file','image','图片'),
			array('text','url','地址'),
			array('selected','type','类型',array('0' => '首页轮播图')),
		);
		if($_SESSION['admin']['pid'] == 0){
			$edit[] = array('radio','is_open','是否显示',array('1' => '开启' , '2' => '不显示'));
		}
		self::form("this",$edit,$adv,'post','public_form');
	}
	
	public function adv_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('adv')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		$field = array('id','name','image','url','type');
		if(isset($_POST['is_open'])){
			$field[] = 'is_open';
		}
		$table = new table('adv');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('a_id' => $_SESSION['admin']['id'],'create_time' => time()))  //添加的时候附加的值	//更新的时候附加的值
			  ->other('update',array('update_time' => time()))  //添加的时候附加的值	//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('adv')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了广告,id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('adv')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了广告,id是'.intval($_POST['id']),
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