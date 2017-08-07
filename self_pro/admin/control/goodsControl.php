<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	产品
*/
class goodsControl extends sysControl{
	
	public function goods_list(){
		$selected = selected(array('is_show'));
		$Mgoods = M('goods');
		$is_del = array('is_del' => '0');
		$Mgoods->where($is_del);
		$page= isset($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('name|title|keywords');
		$where2 = array();
		if($selected['is_show']){
			$is_show = explode('/',$selected['is_show']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2 = array(
					'is_show' => $is_show[1],
				);
			}
		}
		
		$goods = $Mgoods
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)->select();
		$count = $Mgoods
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
				$selected['is_show'] => array( 	//字段二
					'0' => '请选择',
					'1' => '显示',
					'2' => '不显示',
				),
			),
			'keyword' => I('keyword'),
			'add' => '?act=goods&op=goods_edit',
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','产品名称'),
			array('image','image','图片'),
			array('label','price','价格'),
			array('label','num','数量'),
			array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=goods&op=goods_edit&id=__ID__','','','')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=goods&op=goods_del&id=__ID__')")),
					),'操作'),
		),$goods,'id');
	}
	
	public function goods_edit(){
		if($_POST){
			$this->commit();
		}
		$goods = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$goods = M('goods')->where(array('id' => intval($_GET['id'])))->find();
		}
		
		$cat_list = array(
			'0' => '请选择',
		);
		$cat_where = array(
			'is_del' => '0',
			'pid' => '0',
		);
		$cat_where2 = array(
			'is_del' => '0',
			'pid' => '>0',
		);
		$list = M('cat')->where($cat_where)->select();
		$list2 = M('cat')->where($cat_where2)->select();
		if(!empty($list2)){
			foreach($list2 as $key => $val){
				$this->cat_list_d[$val['pid']][] = $val;
			}	
		}
		if(!empty($list)){
			foreach($list as $key => $val){
				$this->cat_list[$val['id']] = $val['name'];
				$li = M('cat')
					  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
					  ->select();
				$this->get_cat_list($li , 0);
			
			}
			if(!empty($this->cat_list)){
				foreach($this->cat_list as $key => $val){
					$cat_list[$key] = $val;
				}
			}
		}
		
		self::form("this",array(
			array('hidden','id','ID'),
			array('text','name','商品名称'),
			array('text','title','简标题'),
			array('text','price','价格'),
			array('text','num','数量'),
			array('selected','cat_id','分类',$cat_list),
			array('text','jifen','积分'),
			array('text','keywords','关键字'),
			array('text','label','标签(数字)'),
			array('file','image','图片',array('jpg','png','jpep','bmp'),'',$size = 2,'upload_file.php'),
			array('files','images','组图',array('jpg','png','jpep','bmp'),'',$size = 2,'upload_file.php'),
			array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
		//	array('selected','user_type','品牌',array('1' => '超级管理员', '2' => '普通管理员')),
			array('editor','g_desc','商品描述'),
		),$goods,'post','public_form');
	}
	
	private $cat_list = array();
	private $cat_list_d = array();  //未了吥连续查询
	//编辑页面递归
	private function get_cat_list($li,$num){
		if(!empty($li)){
			foreach($li as $key => $val){
				$str = '--';
				for($i = 0 ; $i < $num ; $i++){
					$str .= '--';
				}
				$this->cat_list[$val['id']] = $str.$val['name'];
				$d = '';
				
				if(isset($this->cat_list_d[$val['id']])){
					$d = $this->cat_list_d[$val['id']];
				}
			//	$d = M('cat')->where(array( 'pid' => $val['id'] ,'is_del' => '0'))->select();
				if(!empty($d)){
					$num++;
					$s = $num;
					$this->get_cat_list($d , $s);
				}
			}
		}
	}
	
	public function goods_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('goods')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		if(empty($_POST['is_show'])){
			show_message(array('code' => '-1' , 'msg' => '是否显示'),'json');
		}
		$field = array('id','name','title','price','num','jifen','keywords','label','image','images','is_show','g_desc','cat_id');
		$table = new table('goods');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('create_time' => time() , 'update_time' => time()))  //添加的时候附加的值
			  ->other('update',array( 'update_time' => time()))						//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('goods')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了产品,产品id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('goods')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了产品,产品id是'.intval($_POST['id']),
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