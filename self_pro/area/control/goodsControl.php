<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	产品
*/
class goodsControl extends sysControl{
	
	
	public function goods_list(){
		$selected = selected(array('is_show','comm_id','c_id'));
		$Mgoods = M('goods');
		$is_del = array('__AFFIX__goods.is_del' => '0');
		$Mgoods->where($is_del);
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('__AFFIX__goods.name');
		$where2 = array();
		if($selected['is_show']){
			$comm_id = explode('/',$selected['comm_id']);
			if(isset($comm_id[1]) && !empty($comm_id[1])){
				$where2['comm_id'] = $comm_id[1];
			}
			$c_id = explode('/',$selected['c_id']);
			if(isset($c_id[1]) && !empty($c_id[1])){
				$where2['c_id'] = $c_id[1];
			}
			//显示
			$is_show = explode('/',$selected['is_show']);
			if(isset($is_show[1]) && !empty($is_show[1])){
				$where2['is_show'] = $is_show[1];
			}
		}
		//获取社区
		$comm = array();
		$comm_list = array();
		$comm_where = array(
			'is_del' => '0'
		);
		$admin_id = $_SESSION['admin']['id'];
		$admin = M('admin')->where(array('id' => $admin_id))->find();
		$area_where = false;
		$goods_area_where = array();
		if($admin['area_id'] > 0){ //如果有地区就设置地区
			$area = M('area')->where(array('id' => $admin['area_id']))->find();
			if(!empty($area)){
				$comm_where['pca'] = 'like %'.$area['name'].'%';
				$area_where = true;
			}
		}
		
		$comm = M('community')
				->field('id,name')
				->where($comm_where)
				->select();
		$comm_list[] = '请选择社区';
		if(!empty($comm)){
			foreach($comm as & $val){
				$comm_list[$val['id']] = $val['name'];
				if($area_where){
					$goods_area_where[] = $val['id'];
				}
			}
		}
		
		$Mgoods ->field('__AFFIX__goods.*,__AFFIX__community.name as community')
				->join('left __AFFIX__community','__AFFIX__goods.comm_id = __AFFIX__community.id')
				->where($where)
				->where($where2);
				if(!empty($goods_area_where)){
					$goods_area_where = array('comm_id' => 'in '.implode(',',$goods_area_where));
					$Mgoods->where($goods_area_where);
				}
				
		$goods = $Mgoods
				 ->page($page,$num)
				 ->select();
		$Mgoods
				 ->where($is_del)
				 ->where($where)
				 ->where($where2);
				 if($area_where){
					 $Mgoods->where($area_where);
				 }
				 
		$count = $Mgoods->count();
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
	//	$_POST['keyword'] = isset($_POST['keyword']) ? $_POST['keyword'] : '';
		
		
		//获取分类
		$goods_cat_list = array(
			'0' => '请选择分类',
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
				$this->goods_cat_list[$val['id']] = $val['name'];
				$li = M('goods_cat')
					  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
					  ->select();
				$this->get_goods_cat_list($li , 0);
			
			}
			if(!empty($this->goods_cat_list)){
				foreach($this->goods_cat_list as $key => $val){
					$goods_cat_list[$key] = $val;
				}
			}
		}
		
		self::form_top(array(
			'selected' => array(	//下拉选择
				$selected['comm_id'] => $comm_list,
				$selected['c_id'] => $goods_cat_list,
			),
			'keyword' => I('keyword'),
			'add' => '?act=goods&op=goods_edit',
			'search',
		));
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('label','community','社区'),
			array('image','image','图片'),
			array('label','price','价格'),
			array('label','num','数量'),
		//	array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
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
		
		$goods_cat_list = array(
			'0' => '请选择',
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
				$this->goods_cat_list[$val['id']] = $val['name'];
				$li = M('goods_cat')
					  ->where(array( 'pid' => $val['id'] , 'is_del' => '0'))
					  ->select();
				$this->get_goods_cat_list($li , 0);
			
			}
			if(!empty($this->goods_cat_list)){
				foreach($this->goods_cat_list as $key => $val){
					$goods_cat_list[$key] = $val;
				}
			}
		}
		
		$form = array(
			array('hidden','id','ID'),
			array('text','name','资源名称'),
			array('text','num','数量'),
			array('text','price','金额'),
			array('file','image','图片',array('jpg','png','jpep','bmp'),'',$size = 2,'upload_file.php'),
			array('files','images','组图',array('jpg','png','jpep','bmp'),'',$size = 2,'upload_file.php'),
			array('radio','type','资源类别',array('1' => '出售' , '2' => '出租' , '3' => '物品交换'  , '4' => '非交易资源' )),
			array('selected','c_type','资源分类',$goods_cat_list),
			array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
			array('editor','content','文本内容'),
		);
		
		if($_SESSION['area']['role_id'] == 5){  //是社长
			$form[] = array('radio','boutique','是否是精品',array('1' => '是' , '2' => '否'));
		}
		
		self::form("this" , $form ,$goods,'post','public_form');
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
		$field = array('id','name','num','price','type','image','images','content','c_type');
		if(isset($_POST['boutique'])){
			$field[] = 'boutique';
		}
		$table = new table('goods');
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->other('add',array('comm_id' => $_SESSION['area']['c_id'] , 'u_id' => $_SESSION['area']['id'] , 'create_time' => time() , 'update_time' => time()))  //添加的时候附加的值
			  ->other('update',array( 'update_time' => time()))						//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'u_id' => $_SESSION['area']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('goods')->where(array('id' => $res))->find();
			$log['other'] =  $_SESSION['area']['name'].'在'.date('Y-m-d H:i:s').'时添加了资源,产品id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('goods')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['area']['name'].'在'.date('Y-m-d H:i:s').'时修改了资源,产品id是'.intval($_POST['id']);
		}
		M('admin_log')->add($log);
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
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
}
?>