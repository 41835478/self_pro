<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	链接
*/
class activityControl extends sysControl{
	
	public function activity_list(){
		$selected = selected(array('is_show'));
		$Mactivity = M('activity');
		$is_del = array('is_del' => '0' , 'u_id' => $_SESSION['area']['id']);
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		
		$activity = $Mactivity
				 ->where($is_del)
				 ->page($page,$num)->select();
		$count = $Mactivity
				 ->where($is_del)
				 ->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
		self::form_top(array(
			'add' => '?act=activity&op=activity_edit',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','title','名称'),
			array('label','address','活动位置'),
			array('time','start_time','开始时间'),
			array('time','end_time','结束时间'),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=activity&op=activity_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=activity&op=activity_del&id=__ID__')")),
					),'操作'),
		),$activity,'id');
	}
	
	public function activity_edit(){
		if($_POST){
			$this->commit();
		}
		$activity = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$activity = M('activity')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','title','活动名称'),
			array('text','address','活动位置'),
			array('file','image','活动图片'),
			array('time','start_time','活动开始时间'),
			array('time','end_time','活动结束时间'),
			array('editor','content','活动内容'),
		),$activity,'post','public_form');
	}
	
	public function activity_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('activity')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		$_POST['start_time'] = strtotime(str_replace('&nbsp',' ',$_POST['start_time']));	
		$_POST['end_time'] = strtotime(str_replace('&nbsp',' ',$_POST['end_time']));
		if($_POST['start_time'] < time()){
			show_message(array('code' => '-1' , 'msg' => '开始时间不能小于当前时间'),'json');
		}
		if($_POST['start_time'] >= $_POST['end_time']){
			show_message(array('code' => '-1' , 'msg' => '开始时间不能在结束时间后面'),'json');
		}
		$field = array('id','title','image','start_time','end_time','content','address');
		$table = new table('activity');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('u_id' => $_SESSION['area']['id'] , 'create_time' => time()))  //添加的时候附加的值	//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('activity')->where(array('id' => $res))->find();
			$log = array(
				'u_id' => $_SESSION['area']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['area']['name'].'在'.date('Y-m-d H:i:s').'时添加了活动,id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('activity')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'u_id' => $_SESSION['area']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['area']['name'].'在'.date('Y-m-d H:i:s').'时修改了活动,id是'.intval($_POST['id']),
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