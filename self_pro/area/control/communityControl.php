<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	社区
*/
class communityControl extends sysControl{
	
	//地区权限
	public function area_weight(){
		$weight = array('is_del' => '0' , 'c_type' => 1);
		$admin_id = $_SESSION['admin']['id'];
		$admin = M('admin')->where(array('id' => $admin_id))->find();
		if($admin['area_id'] > 0){ //如果有地区就设置地区
			$area = M('area')->where(array('id' => $admin['area_id']))->find();
			if(!empty($area)){
				$weight['pname'] = $area['name'];
			}
		}
		return $weight;
	}
	
	public function community_list(){
		$selected = selected(array('pname'));
		$Mcommunity = M('community');
		$where0 = $this->area_weight();
		
		$Mcommunity->where($where0);
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('name');
		$where2 = array();
		if($selected['pname']){
			$is_show = explode('/',$selected['pname']);
			if(isset($pname[1]) && !empty($pname[1])){
				$area = M('area')->where(array('id' => $pname[1]))->find();
				$where2['pname'] = $area['name'];
			}
		}
		
		$community = $Mcommunity
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)->select();
		$count = $Mcommunity
				 ->where($where0)
				 ->where($where)
				 ->where($where2)
				 ->count();
		
		$area = array();
		$area_list = array();
		$area = M('area')->where(array('is_del' => '0'))->select();
		$area_list[] = '请选择地区';
		if(!empty($area)){
			foreach($area as & $val){
				$area_list[$val['id']] = $val['name']; 
			}
		}
		self::output('count',$count);
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
	//	$_POST['keyword'] = isset($_POST['keyword']) ? $_POST['keyword'] : '';
		
		$top = array(
			'selected' => array(	//下拉选择
				$selected['pname'] => $area_list,
			),
			
			'keyword' => I('keyword'),
		//	'add' => '?act=community&op=community_edit',
			'search',
		);
		
		if(isset($where0['pname'])){
			unset($top['selected']);
		}
		
		self::form_top($top);  //设置头部
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
			array('image','image','图片'),
			array('label','pname','省'),
			array('label','address','地址'),
			array('label','type','类型'),
			
		//	array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('查看','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_edit('编辑','?act=community&op=community_edit&id=__ID__','','1024','768')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=community&op=community_del&id=__ID__')")),
					),'操作'),
		),$community,'id');
	}
	
	public function community_edit(){
		if($_POST){
		//	$this->commit();
		}
		$community = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$community = M('community')->where(array('id' => intval($_GET['id'])))->find();
			self::output('data',$community);
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
			array('text','name','名称'),
			array('selected','cat_type','社区分类',$cat_list),
			array('text','address','地址'),
			array('text','pname','省'),
			array('text','cityname','市'),
			array('text','adname','县'),
			array('text','type','社区类型'),
			array('text','posx','X坐标'),
			array('text','posy','Y坐标'),
			array('file','image','图片'),
			array('hidden','gu_id','谷歌id'),
			array('hidden','citycode','城市编号'),
			array('hidden','adcode','adcode'),
		//	array('selected','is_type','社区类别',array('1' => '实体' , '2' => '虚拟')),
			array('selected','c_type','社区类别',array('1' => '实体' )),
		),$community,'post','community_edit');
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
	
	public function community_del(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('community')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function commit(){
		if(!empty($_POST['type'])){
			$type = array('商务住宅','楼宇','写字楼','商务写字楼','住宅区','住宅小区','公司企业','办公区');
			$type2 = explode(';',$_POST['type']);
			
			$is = false;
			foreach($type2 as $key => $val){
				foreach($type as $k => $v){
					if($val == $v){
						
						$is = true;
						break;
					}
				}
				if($is){
					break;
				}
			}
			if(!$is){
				show_message(array('code' => '-1' , 'msg' => '社区类型错误！只允许'.implode(',',$type)),'json');
			}
		}
		if($_POST['cat_type'] == 0){
			show_message(array('code' => '-1' , 'msg' => '请选择社区分类' ),'json');
		}
		if($_POST['image'] == ''){
			show_message(array('code' => '-1' , 'msg' => '请设置图片'),'json');
		}
		$field = array('id','name','image','c_type','cat_type','address','gu_id','pname','cityname','adname','type','posx','posy','citycode','adcode');
		$table = new table('community');
		
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique',array('is_del' => '0'))		//唯一
			  ->other('add',array('s_type' => 'admin','create_time' => time() , 'update_time' => time()))  //添加的时候附加的值
			  ->other('update',array( 'update_time' => time()))						//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$this->add_area();
			$u = M('community')->where(array('id' => $res))->find();
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了社区,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('community')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了社区,id是'.intval($_POST['id']);
		}
		M('admin_log')->add($log);
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
	
	//添加市区
	public function add_area(){
		$data = array();
		$data['name'] = $_POST['pname'];
		$is = M('area')->where($data)->where(array('is_del' => '0'))->find();
		$p_id = 0;
		$pp_id = 0;
		if(empty($is)){
			$data['create_time'] = time();
			$id = M('area')->add($data);
			$p_id = $id;
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了省级别,id是'.$id;
			M('admin_log')->add($log);
		}
		$data = array();
		$data['name'] = $_POST['cityname'];
		$is = M('area')->where($data)->where(array('is_del' => '0'))->find();
		if(empty($is)){
			$data['create_time'] = time();
			$data['p_id'] = $p_id;
			$id = M('area')->add($data);
			$pp_id = $id;
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了市级别,id是'.$id;
			M('admin_log')->add($log);
		}
		$data = array();
		$data['name'] = $_POST['adname'];
		$is = M('area')->where($data)->where(array('is_del' => '0'))->find();
		if(empty($is)){
			$data['create_time'] = time();
			if($pp_id == 0){  //如果市级没有直接用省级别的
				$data['p_id'] = $p_id;
			}else{
				$data['p_id'] = $pp_id;
			}
			
			$id = M('area')->add($data);
			
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了县级别,id是'.$id;
			M('admin_log')->add($log);
		}
	}
	
	//虚拟社区
	public function community_flist(){
		$selected = selected(array('c_type'));
		$Mcommunity = M('community');
		$is_del = array('is_del' => '0' , 'c_type' => '2');
		$Mcommunity->where($is_del);
		$page= isset($_POST['page']) && !empty($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) && !empty($_GET['page']) ? intval($_GET['page']) : 1);
		$num = 10;  	//显示的数量
		$where = search('name|pname');
		$where2 = array();
		if($selected['c_type']){
			$is_show = explode('/',$selected['c_type']);
			if(isset($c_type[1]) && !empty($c_type[1])){
				$where2 = array(
					'c_type' => $c_type[1],
				);
			}
		}
		
		
		
		$community = $Mcommunity
				 ->where($where)
				 ->where($where2)
				 ->page($page,$num)->select();
		$count = $Mcommunity
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
				$selected['c_type'] => array( 	//字段二
					'0' => '请选择',
					'1' => '实体',
					'2' => '虚拟',
				),
			),
			*/
			'keyword' => I('keyword'),
			'add' => '?act=community&op=community_fedit',
			'search',
		));
		
		self::form_list(array(
			array('label','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','name','名称'),
		//	array('radio','is_show','是否显示',array('1' => '显示' , '2' => '不显示')),
			array('time','create_time','创建时间'),
			array('menu',array(
					array('编辑','javascript:;',array('style'=>'background:#FF5722','onclick' => "question_fedit('编辑','?act=community&op=community_fedit&id=__ID__','','1024','768')")),
					array('删除','javascript:;',array('onclick' => "question_del(this,'?act=community&op=community_fdel&id=__ID__')")),
					),'操作'),
		),$community,'id');
	}
	
	//虚拟社区编辑
	public function community_fedit(){
		if($_POST){
			$this->fcommit();
		}
		$community = '';
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$community = M('community')->where(array('id' => intval($_GET['id'])))->find();
			self::output('data',$community);
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
			array('text','name','名称'),
			array('selected','cat_type','社区分类',$cat_list),
		//	array('selected','is_type','社区类别',array('1' => '实体' , '2' => '虚拟')),
			array('selected','c_type','社区类别',array('2' => '虚拟' )),
		),$community,'post');
	}
	
	//虚拟社区删除
	public function community_fdel(){
		$id = intval($_GET['id']);
		if($id){
			$res = M('community')->where(array('id' => $id))->update(array('is_del' => '1'));
			if($res){
				show_message(array('code' => '1' , 'msg' => '删除成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '删除失败'),'json');
			}
		}
	}
	
	private function fcommit(){
		
		$field = array('id','name','c_type','cat_type');
		$table = new table('community');
		
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique',array('is_del' => '0'))		//唯一
			  ->other('add',array('s_type' => 'admin','create_time' => time() , 'update_time' => time()))  //添加的时候附加的值
			  ->other('update',array( 'update_time' => time()))						//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
		);
		
		if(!empty($data) && $data['M'] == 'add'){
			$this->add_area();
			$u = M('community')->where(array('id' => $res))->find();
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了虚拟社区,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('community')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了虚拟社区,id是'.intval($_POST['id']);
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