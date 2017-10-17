<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	帮派
*/
class bindControl extends sysControl{
	
	public function bind_list(){
		$selected = selected(array('is_open'));
		$Mgang = M('bind_attr');
		$is_del = array('is_del' => '0');
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 20;  	//显示的数量
		$where = search('name|__AFFIX__attribute.name');
		$where2 = array();
		if($selected['is_open']){
			$is_show = explode('/',$selected['is_open']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_open' => $is_show[1],
				);
			}
		}
		
		$bind_attr = $Mgang
				 ->field('__AFFIX__bind_attr.*,__AFFIX__attribute.name')
				 ->join('left __AFFIX__attribute','__AFFIX__bind_attr.a_id = __AFFIX__attribute.id')
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)->select();
		$count = $Mgang
				 ->field('__AFFIX__bind_attr.*,__AFFIX__attribute.name')
				 ->join('left __AFFIX__attribute','__AFFIX__bind_attr.a_id = __AFFIX__attribute.id')
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
					'1' => '开启',
					'2' => '关闭',
				),
			),
			*/
			'keyword' => I('keyword'),
			'add' => '?act=bind&op=bind_add',
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','b_table','表名'),
		//	array('selected','b_table','表名',array('rolegoods' => '物品表')),
			array('label','b_id','表名里对应id'),
			array('label','a_id','属性表id'),
			array('label','name','属性表名称'),
			array('label','growup','成长值'),
			array('label','deviation','偏差值'),
			array('radio','b_type','成长类型',array('1' => '固定成长' , '2' => '百分比成长')),
			array('time','create_time','创建时间'),
			array('time','update_time','修改时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=bind&op=bind_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=bind&op=bind_del&id=__ID__')")),
					),'操作'),
		),$bind_attr,'id');
	}
	
	//添加
	public function bind_add(){
		if($_POST){
			$is_bind = M('bind_attr')->where(array('b_table' => $_POST['b_table'] , 'b_id' => $_POST['b_id'] , 'a_id' => $_POST['a_id']))->find();
			if(!empty($is_bind) && count($is_bind) >= 1){
				show_message(array('code' => '-1' , 'msg' => '已经绑定，请勿重新绑定'),'json');
			}
			$this->commit();
		}
		$bind_attr = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$bind_attr = M('bind_attr')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
		//	array('text','b_table','表名'),
			array('selected','b_table','表名',array('rolegoods' => '物品表')),
			array('text','b_id','表名里对应id'),
			array('text','a_id','属性表id'),
			array('text','growup','成长值'),
			array('text','deviation','偏差值'),
			array('radio','b_type','成长类型',array('1' => '固定成长' , '2' => '百分比成长' ))
		),$bind_attr,'post','public_form');
	}
	
	//编辑
	public function bind_edit(){
		if($_POST){
			$is_bind = M('bind_attr')->where(array('b_table' => $_POST['b_table'] , 'b_id' => $_POST['b_id'] , 'a_id' => $_POST['a_id']))->find();
		if(!empty($is_bind) && count($is_bind) >= 2){
			show_message(array('code' => '-1' , 'msg' => '已经绑定，请勿重新绑定'),'json');
		}
			$this->commit();
		}
		$bind_attr = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$bind_attr = M('bind_attr')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
		//	array('text','b_table','表名'),
			array('selected','b_table','表名',array('rolegoods' => '物品表')),
			array('text','b_id','表名里对应id'),
			array('text','a_id','属性表id'),
			array('text','growup','成长值'),
			array('text','deviation','偏差值'),
			array('radio','b_type','成长类型',array('1' => '固定成长' , '2' => '百分比成长' ))
		),$bind_attr,'post','public_form');
	}
	
	public function bind_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('bind_attr')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		if(empty($_POST['b_type'])){
			show_message(array('code' => '-1' , 'msg' => '成长类型'),'json');
		}
		
		$field = array('id','b_table','b_id','a_id','growup','growup','deviation','b_type');
		$is_table = M($_POST['b_table'])->where(array('id' => $_POST['b_id']))->find();
		$is_attr = M('attribute')->where(array('id' => $_POST['a_id']))->find();
		if(empty($is_table)){
			show_message(array('code' => '-1' , 'msg' => $_POST['b_table'].'表没有此id:'.$_POST['b_id']),'json');
		}
		if(empty($is_attr)){
			show_message(array('code' => '-1' , 'msg' => '属性表没有此id:'.$_POST['a_id']),'json');
		}
		
		$table = new table('bind_attr');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time() , 'update_time' => time() ))  //添加的时候附加的值
			  ->other('update',array('update_time' => time() ))  //添加的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('bind_attr')->where(array('id' => $res))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了物品绑定,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('bind_attr')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了物品绑定,id是'.intval($_POST['id']);
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