<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	角色
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
			'selected' => array(	//下拉选择
				$selected['is_open'] => array( 	//字段二
					'0' => '请选择',
					'1' => '允许',
					'2' => '禁止',
				),
			),
			'keyword' => I('keyword'),
			'add' => '?act=role&op=role_edit',
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','角色名称'),
			array('label','lv','等级'),
			array('label','exp','经验值'),
			array('label','gang','帮派'),
			array('label','profession','职业'),
			array('label','acer','元宝'),
			array('label','gold','金币'),
			array('time','create_time','创建时间'),
			array('radio','sex','是否启用',array('1' => '男' , '2' => '女')),
			array('radio','is_open','是否启用',array('1' => '允许' , '2' => '禁止')),
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
		$profession = array();
		$profession[0] = '无职业';
		$p_data = M('profession')->select();
		if(!empty($p_data)){
			foreach($p_data as $key => $val){
				$profession[$val['id']] = $val['name'];
			}
		}
		$gang = array();
		$gang[0] = '无帮派';
		$g_data = M('gang')->select();
		if(!empty($g_data)){
			foreach($g_data as $key => $val){
				$gang[$val['id']] = $val['name'];
			}
		}
		$services = array();
		$s_data = M('services')->select();
		if(!empty($s_data)){
			foreach($s_data as $key => $val){
				$services[$val['id']] = $val['name'];
			}
		}
		
		$title = array();
		$title[0] = '无称号';
		$t_data = M('title')->select();
		if(!empty($t_data)){
			foreach($t_data as $key => $val){
				$title[$val['id']] = $val['name'];
			}
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','角色名称'),
			array('text','vip','vip等级'),
			array('selected','title','称号',$title),
			array('selected','gang','帮派',$gang),
			array('selected','profession','职业',$profession),
			array('text','acer','元宝'),
			array('text','gold','金币'),
			array('text','spirit','体力'),
			array('selected','s_id','所属服务器',$services),
			array('text','lv','等级'),
			array('text','exp','经验'),
			array('radio','sex','男女角色',array('1' => '男','2' => '女')),
			array('radio','is_open','是否允许登录',array('1' => '允许' , '2' => '不允许')),
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
		if(empty($_POST['is_open'])){
			show_message(array('code' => '-1' , 'msg' => '是否允许登录？'),'json');
		}
		$field = array('id','name','exp','lv','s_id','spirit','gold','acer','profession','gang','vip','title','sex','is_open');
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
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了角色,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('role')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了角色,id是'.intval($_POST['id']);
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