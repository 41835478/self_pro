<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	等级
*/
class lvControl extends sysControl{
	
	public function lv_list(){
		$selected = selected(array('is_show'));
		$Mlv = M('lv');
	
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('lv');
		$where2 = array();
		if($selected['is_show']){
			$is_show = explode('/',$selected['is_show']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_show' => $is_show[1],
				);
			}
		}
		
		$lv = $Mlv
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)
				 ->order('lv asc')
				 ->select();
		$count = $Mlv
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
				$selected['is_show'] => array( 	//字段二
					'0' => '请选择',
					'1' => '显示',
					'2' => '不显示',
				),
			),
			*/
			'keyword' => I('keyword'),
			'add' => '?act=lv&op=lv_edit',
			'all_del' => '?act=lv&op=lv_dels',
			'search',
			'self' => array('快速添加',array('onclick' => "question_edit('快速添加','?act=lv&op=lv_edits','','','')")),
			)
		);
		
		self::form_list(array(
			array('checkbox','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','lv','等级'),
			array('image','image','图标'),
			array('label','exp','经验值'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=lv&op=lv_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=lv&op=lv_del&id=__ID__')")),
					),'操作'),
		),$lv,'id');
	}
	
	//批量修改等级
	public function lv_edits(){
		if($_POST){
			$this->commits();
		}
		$lv = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$lv = M('lv')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('text','start_lv','开始等级'),
			array('text','end_lv','结束等级'),
			array('text','multiple','倍数'),
			array('file','image','图标'),
			array('text','first_exp','第一个经验值'),
		),$lv,'post','public_form');
	}
	//删除
	public function lv_dels(){
		$ids = $_POST['ids'];
		if(!empty($ids)){
			$ids = substr($ids,0,strlen($ids) - 1);
		};
		if($ids){
			$res = M('lv')->where(array('id' => 'in ' . $ids))->del();
			if($res){
				$log = array(
					'admin_id' => $_SESSION['admin']['id'],
					'create_time' => time(),
					'ip' => getIp(),
				);
				$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时删除了等级,id是'.$ids;
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	//编辑
	public function lv_edit(){
		if($_POST){
			$this->commit();
		}
		$lv = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$lv = M('lv')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','lv','等级'),
			array('text','exp','经验值'),
			array('file','image','图标'),
		),$lv,'post','public_form');
	}
	
	//删除
	public function lv_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('lv')->where(array('id' => $id))->del();
			if($res){
				$log = array(
					'admin_id' => $_SESSION['admin']['id'],
					'create_time' => time(),
					'ip' => getIp(),
				);
				$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时删除了等级,id是'.$id;
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	//提交
	private function commit(){
		$field = array('id','lv','exp','image');
		$table = new table('lv');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键					//更新的时候附加的值
			  ->type('lv','unique')			//唯一					//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('lv')->where(array('id' => $res))->find();
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了等级,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('lv')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了等级,id是'.intval($_POST['id']);
		}
		M('admin_log')->add($log);
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
	
	//批量提交
	private function commits(){
		if(intval($_POST['start_lv']) < 1){
			show_message('设置开始等级错误','-1','json');
		}
		if( intval($_POST['end_lv']) < intval($_POST['start_lv'])){
			show_message('设置结束等级错误','-1','json');
		}
		if( $_POST['multiple'] <= 0){
			show_message('倍数设置错误','-1','json');
		}
		if( $_POST['first_exp'] <= 0){
			show_message('第一个经验设置错误','-1','json');
		}
		$data = array();
		$exp = 0;
		$del_lv = array();
		$image = isset($_POST['image']) && !empty($_POST['image']) ? $_POST['image'] : '';
		for($i = $_POST['start_lv'];$i <= $_POST['end_lv'] ; $i++){
			$d['lv'] = $i;
			if($exp == 0){
				$exp = $_POST['first_exp'];
			}else{
				$exp = $exp * $_POST['multiple'];
			}
			$d['exp'] = $exp;
			if(!empty($image)){
				$d['image'] = $image;
			}
			$data[] = $d;
			$del_lv[] = $i;
		}
		$del_lv = implode(',',$del_lv);
		M('lv')->where(array('lv' => 'in '.$del_lv))->del();
		$res = M('lv')->insert_all($data);
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时批量添加了等级,id是'.$del_lv;
		
		M('admin_log')->add($log);
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
}
?>