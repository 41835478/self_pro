<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	角色权限管理
*/
class roleControl extends sysControl{
	
	public function role_list(){
		$selected = selected(array('is_open'));
		$Mrole = M('role');
		$is_del = array('is_del' => '0');
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 20;  	//显示的数量
		$where = search('name');
		$where2 = array();
		if($selected['is_open']){
			$is_show = explode('/',$selected['is_open']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_open' => $is_show[1],
				);
			}
		}
		
		$role = $Mrole
				 ->where($is_del)
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)->select();
		$count = $Mrole
				 ->where($is_del)
				 ->where($where)
				 ->where($where2)
				 ->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
	//	$_POST['keyword'] = isset($_POST['keyword']) ? $_POST['keyword'] : '';
		self::form_top(array(
			/*
			'selected' => array(	//下拉选择
				$selected['is_open'] => array( 	//字段二
					'0' => '请选择',
					'1' => '允许',
					'2' => '禁止',
				),
			),
			*/
			'keyword' => I('keyword'),
			'add' => '?act=role&op=role_edit',
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','type','类型'),
			array('label','name','名称'),
			array('radio','is_comm','是否添加/修改社区',array('1' => '允许' , '2' => '不允许')),
			array('radio','is_goods','是否添加修改资源',array('1' => '允许' , '2' => '不允许')),
		//	array('radio','is_area','是否控制地区' 	,array('1' => '允许' , '2' => '不允许')),
			array('radio','is_user','是否修改子社员',array('1' => '允许' , '2' => '不允许')),
			array('radio','is_default','默认注册属性',array('1' => '否' , '2' => '是')),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=role&op=role_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=role&op=role_del&id=__ID__')")),
					),'操作'),
		),$role,'id');
	}
	
	public function role_edit(){
		if($_POST){
			$this->commit();
		}
		$role = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$role = M('role')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','名称'),
			array('text','type','类型'),
			array('radio','is_comm','是否添加/修改社区',array('1' => '允许' , '2' => '不允许')),
			array('radio','is_goods','是否添加修改资源',array('1' => '允许' , '2' => '不允许')),
		//	array('radio','is_area','是否控制地区' 	,array('1' => '允许' , '2' => '不允许')),
			array('radio','is_user','是否修改子社员',array('1' => '允许' , '2' => '不允许')),
			array('radio','is_default','注册默认属性',array('1' => '否' , '2' => '是')),
		),$role,'post','public_form');
	}
	public function role_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('role')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		if($_POST['is_comm'] == 0){
			show_message(array('code' => '-1' , 'msg' => '是否可以添加修改社区' ),'json');
		}
		if($_POST['is_goods'] == 0){
			show_message(array('code' => '-1' , 'msg' => '是否可以添加修改资源' ),'json');
		}
		/*
		if($_POST['is_area'] == 0){
			show_message(array('code' => '-1' , 'msg' => '是否可以添加修改子社员地区' ),'json');
		}
		*/
		if($_POST['is_user'] == 0){
			show_message(array('code' => '-1' , 'msg' => '是否可以设置子社员权限' ),'json');
		}
		if($_POST['is_default'] == 0){
			show_message(array('code' => '-1' , 'msg' => '注册是是否是此属性' ),'json');
		}
		if($_POST['is_default']==2){
			M('role')->update(array('is_default' => '1'));
		}
		$field = array('id','name','type','is_comm','is_goods','is_default','is_user');
		$table = new table('role');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time() , 'update_time' => time()))  //添加的时候附加的值
			  ->other('update',array( 'update_time' => time()))						//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('role')->where(array('id' => $res))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了角色权限,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('role')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了角色权限,id是'.intval($_POST['id']);
		}
		M('admin_log')->add($log);
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
}
?>