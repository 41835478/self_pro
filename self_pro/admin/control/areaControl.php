<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	地区控制
*/
class areaControl extends sysControl{
	
	public function area_list(){
		$selected = selected(array('is_show'));
		$Marea = M('area');
		$is_del = array('is_del' => '0');
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('name');
		$area = $Marea
				 ->where($is_del)
				 ->where($where)
				 ->page($page,$num)->select();
		$count = $Marea
				 ->where($is_del)
				 ->where($where)
				 ->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
		self::form_top(array(
			//	'add' => '?act=area&op=area_edit',
			'keyword' => I('keyword'),
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('time','create_time','创建时间'),
			array('menu',array(
			//		array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=area&op=area_edit&id=__ID__','','','')")),
			//		array('删除','javascript:;',array('onclick' => "question_del(this,'?act=area&op=area_del&id=__ID__')")),
					),'操作'),
		),$area,'id');
	}
	
	public function area_edit(){
		if($_POST){
			$this->commit();
		}
		$area = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$area = M('area')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','名称'),
		),$area,'post','public_form');
	}
	
	public function area_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('area')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		$field = array('id','name');
		$table = new table('area');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique',array('is_del' => '0'))		
			  ->other('add',array('create_time' => time()))  //添加的时候附加的值	//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('area')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了地区名称,链接id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('area')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了地区名称,链接id是'.intval($_POST['id']),
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