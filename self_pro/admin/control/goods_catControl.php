<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	资源分类
*/
class goods_catControl extends sysControl{
	
	public function goods_cat_list(){
		$selected = selected(array('is_show'));
		$Mgoods_cat = M('goods_cat');
		$is_del = array('is_del' => '0');
		$Mgoods_cat->where($is_del);	//显示的数量
		$where = search('name');
		$where2 = array();
		
		if($selected['is_show']){
			$is_show = explode('/',$selected['is_show']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_show' => $is_show[1],
				);
			}
		}
		if(!empty($where) || !empty($where2)){
			$goods_cat_list = $Mgoods_cat
						->where($where)
						->where($where2)
						->select();
		}else{
			$where2['pid'] = '0'; 
			$where3['pid'] = '>0'; 
			$list = $Mgoods_cat
					->where($is_del)
					->where($where)
					->where($where2)
					->select();
			$list2 = $Mgoods_cat->where($where3)->select();
			$goods_cat_list = array();
			if(!empty($list2)){
				foreach($list2 as $key => $val){
					$this->goods_cat_list_d[$val['pid']][] = $val;
				}	
			}
			if(!empty($list)){
				foreach($list as $key => $val){
					$this->goods_cat_list[] = $val;
					$li = M('goods_cat')
						  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
						  ->select();
					$this->get_goods_cat_list2($li , 0);
					
				}
				if(!empty($this->goods_cat_list)){
					foreach($this->goods_cat_list as $key => $val){
						
						$goods_cat_list[$key] = $val;
						
					}
				}
			}	
		}
		
		self::output('count',count($goods_cat_list));
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
			'add' => '?act=goods_cat&op=goods_cat_edit',
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
		//	array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
			array('label','c_sort','排序'),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=goods_cat&op=goods_cat_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=goods_cat&op=goods_cat_del&id=__ID__')")),
					),'操作'),
		),$goods_cat_list,'id');
	}
	//分类编辑
	public function goods_cat_edit(){
		if($_POST){
			$this->commit();
		}
		$goods_cat = '';
		$goods_cat_id = 0;
		$add = true; //判断是添加的时候
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$goods_cat_id = intval($_GET['id']);
			$goods_cat = M('goods_cat')->where(array('id' => $goods_cat_id))->find();
			$add = false;
		}
		$goods_cat_list = array(
			'0' => '顶级分类',
		);
		$goods_cat_where = array(
			'is_del' => '0',
			'pid' => '0',
		);
		$goods_cat_where2 = array(
			'is_del' => '0',
			'pid' => '>0',
		);
		$list = M('goods_cat')->where($goods_cat_where)->select();
		$list2 = M('goods_cat')->where($goods_cat_where2)->select();
		if(!empty($list2)){
			foreach($list2 as $key => $val){
				$this->goods_cat_list_d[$val['pid']][] = $val;
			}	
		}
		if(!empty($list)){
			foreach($list as $key => $val){
				if($goods_cat_id > 0 && $goods_cat_id != $val['id'] || $add){
					$this->goods_cat_list[$val['id']] = $val['name'];
					$li = M('goods_cat')
						  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
						  ->select();
					$this->get_goods_cat_list($li , 0);
				}
			}
			if(!empty($this->goods_cat_list)){
				foreach($this->goods_cat_list as $key => $val){
					if($goods_cat_id > 0 && $goods_cat_id != $key || $add){
						$goods_cat_list[$key] = $val;
					}
				}
			}
		}
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','分类名称'),
			array('selected','pid','上级分类',$goods_cat_list),
			array('text','c_sort','排序'),
			array('radio','is_show','是否显示',array('1'=>'显示','2'=>'不显示')),
		),$goods_cat,'post','public_form');
	}
	
	//删除
	public function goods_cat_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('goods_cat')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private $goods_cat_list = array();
	private $goods_cat_list_d = array();  //未了吥连续查询
	//编辑页面递归
	private function get_goods_cat_list($li,$num){
		if(!empty($li)){
			foreach($li as $key => $val){
				$str = '--';
				for($i = 0 ; $i < $num ; $i++){
					$str .= '--';
				}
				$this->goods_cat_list[$val['id']] = $str.$val['name'];
				$d = '';
				
				if(isset($this->goods_cat_list_d[$val['id']])){
					$d = $this->goods_cat_list_d[$val['id']];
				}
			//	$d = M('goods_cat')->where(array( 'pid' => $val['id'] ,'is_del' => '0'))->select();
				if(!empty($d)){
					$num++;
					$s = $num;
					$this->get_goods_cat_list($d , $s);
				}
			}
		}
	}
	//列表递归
	private function get_goods_cat_list2($li,$num){
		if(!empty($li)){
			foreach($li as $key => $val){
				$str = '--';
				for($i = 0 ; $i < $num ; $i++){
					$str .= '--';
				}
				$val['name'] = $str.$val['name'];
				$this->goods_cat_list[] = $val;
				$d = '';
				if(isset($this->goods_cat_list_d[$val['id']])){
					$d = $this->goods_cat_list_d[$val['id']];
				}
			//	$d = M('goods_cat')->where(array( 'pid' => $val['id'] ,'is_del' => '0'))->select();
				if(!empty($d)){
					$num++;
					$s = $num;
					$this->get_goods_cat_list2($d , $s);
				}
			}
		}
	}
	//提交
	private function commit(){
		
		$field = array('id','name','pid','c_sort','pid');
		$table = new table('goods_cat');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time()))  //添加的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if($res){
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			//记录操作日志
			if($data['M'] == 'add'){
				$log['other'] = $_SESSION['admin']['username'].'添加了分类,分类id是'.$res;
			}else if($data['M'] == 'update'){
				$log['other'] = $_SESSION['admin']['username'].'修改了分类,分类id是'.intval($_POST['id']);
			}
			M('admin_log')->add($log);
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作成功'),'json');
		}
	}
}
?>