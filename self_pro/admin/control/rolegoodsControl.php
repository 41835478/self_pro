<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	帮派
*/
class rolegoodsControl extends sysControl{
	
	public function rolegoods_list(){
		$selected = selected(array('r_type','is_transaction','is_destory'));
		$Mrolegoods = M('rolegoods');
		$is_del = array('is_del' => '0');
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 20;  	//显示的数量
		$where = search('name');
		$where2 = array();
		if($selected['r_type']){
			$is_show = explode('/',$selected['r_type']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'r_type' => $is_show[1],
				);
			}
			$is_show = explode('/',$selected['is_transaction']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_transaction' => $is_show[1],
				);
			}
			$is_show = explode('/',$selected['is_destory']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_destory' => $is_show[1],
				);
			}
		}
		
		$rolegoods = $Mrolegoods
				 ->where($is_del)
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)->select();
		$count = $Mrolegoods
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
		$goodstype = M('rolegoodstype')->select();
		$r_type = array();
		$r_type['0'] = '请选择';
		if(!empty($goodstype)){
			foreach($goodstype as $key => $val){
				$r_type[$val['id']] = $val['name'];
			}
		}
		self::form_top(array(
			'selected' => array(	//下拉选择
				$selected['r_type'] => $r_type,
				$selected['is_transaction'] => array( 	//字段二
					'0' => '请选择是否允许交易',
					'1' => '允许',
					'2' => '不允许',
				),
				$selected['is_destory'] => array( 	//字段二
					'0' => '请选择是否允许销毁',
					'1' => '允许',
					'2' => '不允许',
				),
			),
			
			'keyword' => I('keyword'),
			'add' => '?act=rolegoods&op=rolegoods_edit',
			'search',
		));
		unset($r_type[0]);
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('image','image','图片'),
			array('radio','is_transaction','是否允许交易',array('1' => '允许' , '2' => '不允许')),
			array('radio','is_destory','是否允许销毁',array('1' => '允许' , '2' => '不允许')),
			array('radio','r_type',' 物品类型',$r_type),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=rolegoods&op=rolegoods_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=rolegoods&op=rolegoods_del&id=__ID__')")),
					),'操作'),
		),$rolegoods,'id');
	}
	
	public function rolegoods_edit(){
		if($_POST){
			$this->commit();
		}
		$rolegoods = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$rolegoods = M('rolegoods')->where(array('id' => intval($_GET['id'])))->find();
		}
		$goodstype = M('rolegoodstype')->select();
		$r_type = array();
	//	$r_type['0'] = '请选择';
		if(!empty($goodstype)){
			foreach($goodstype as $key => $val){
				$r_type[$val['id']] = $val['name'];
			}
		}
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','物品名称'),
			array('file','image','图片',array('jpg','png','jpep','bmp'),'',$size = 2,'upload_file.php'),
			array('radio','is_transaction','是否允许交易',array('1' => '允许' , '2' => '不允许')),
			array('radio','is_destory','是否允许销毁',array('1' => '允许' , '2' => '不允许')),
			array('selected','r_type','物品类型',$r_type),
		),$rolegoods,'post','public_form');
	}
	
	public function rolegoods_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('rolegoods')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		if(empty($_POST['r_type'])){
			show_message(array('code' => '-1' , 'msg' => '请选择类型'),'json');
		}
		if(empty($_POST['is_transaction'])){
			show_message(array('code' => '-1' , 'msg' => '是否允许交易'),'json');
		}
		if(empty($_POST['is_destory'])){
			show_message(array('code' => '-1' , 'msg' => '是否允许销毁'),'json');
		}
		$field = array('id','name','image','r_type','is_transaction','is_destory');
		$table = new table('rolegoods');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time() ))  //添加的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('rolegoods')->where(array('id' => $res))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了物品,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('rolegoods')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了物品,id是'.intval($_POST['id']);
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