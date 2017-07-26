<?php
if(!defined('PROJECT_NAME')) die('project empty');
class userControl extends systemControl{
	
	//用户列表
	public function user_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$admin_id = $_SESSION['admin_id'];
		$my = M('admin')->where(array('admin_id'=>$admin_id))->find();
		$admin = M('admin');
		$pages = M('admin');
		$admin->page($page,$num);
		if(!empty($my['admin_id'])){
			$where = array(
			//	'admin_pid' => 'in '.$my['admin_id'],
				'admin_id' => '!= '.$my['admin_id'],
			);
			if($my['admin_state'] == '1'){
				$where = '';
				$where['admin_id'] = '!= '.$my['admin_id'];
			}
			$admin->where($where);
			$pages->where($where);
		}
		$admin->field('__AFFIX__admin.*,__AFFIX__store.store_name');
		$admin->join('left __AFFIX__store','__AFFIX__admin.store_id = __AFFIX__store.store_id');
		$users = $admin->select();
		$count = $pages->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($users)){
			foreach($users as $key => $val){
				switch($val['admin_state']){
					case 1:
						$users[$key]['admin_state'] = '超级管理员';
						break;
					case 2:
						$users[$key]['admin_state'] = '管理员';
						break;
					case 3:
						$users[$key]['admin_state'] = '禁止登陆';
						break;
					default:
						$users[$key]['admin_state'] = '未知？';
						break;
				}
				if($val['admin_type'] == 0){
					$users[$key]['admin_type'] = '';
				}
				if($val['admin_type'] == 1){
					$users[$key]['admin_type'] = '店铺账号';
				}
				if($val['admin_type'] == 2){
					$users[$key]['admin_type'] = '管家账号';
				}
				if($val['admin_type'] == 3){
					$users[$key]['admin_type'] = '报销账号';
				}
				$users[$key]['add_time'] = date('Y-m-d H:i',$val['add_time']);
			}
		}
		
		self::output('data',$users);
		self::display('user');
	}
	
	//编辑用户
	/*
	public function user_edit(){
		if(isset($_GET['admin_id'])){
			
		}
	}
	*/
	public function member_order_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : '';
		if($user_id > 0){
			$user = M('user')->where(array('user_id' => $user_id))->find();
			$where = array(
				'is_settlement' => 1,
				'yaoqingma' => $user['invitation'],
			);
			$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
			$keyword_where = '';	
			if(!empty($keywords)){
				$keyword_where = search('order_no|order_name|mobile|city|safe_name');
				$keywords_url = str_replace('&keywords='.urlencode($keywords),'',$_SERVER['REQUEST_URI']);
				self::output('keywords',$keywords);
			//	self::output('keywords_url',$keywords_url);
				$keywords = '&keywords='.$keywords;
			}
			if(!empty($keywords_url)){
				$keywords_url = str_replace('&page='.$_GET['page'],'',$keywords_url);
				self::output('keywords_url',$keywords_url);
			}
			$store_id = isset($_GET['store_id'])?$_GET['store_id']:'';
			$where2 = array();
			if(!empty($store_id)){
				$where2['store_id'] = $store_id;
				self::output('store_id',$store_id);
			}
			$order_list = M('order')
					->where($where)
					->where($keyword_where)
					->page($page,$num)
					->order('create_time desc')
					->select();
			$count = M('order')
					->where($where)
					->where($keyword_where)
					->count();
			$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}'.$keywords,10);
			$page->conf = 345;
			self::output('page',$page->show());
			self::output('data',$order_list);
			self::display('order_list2');
		}
	}
	//删除用户
	public function user_del(){
		$admin_id = isset($_GET['id'])?intval($_GET['id']):'';
		$my = M('admin')->where(array('admin_id'=>$_SESSION['admin_id']))->find();
		/*
		if($admin_id != $my['admin_id']){
			show_message('没有该权限','html','-1');
		}
		*/
		if($admin_id > 0){
			$res = M('admin')->where(array('admin_id'=>$admin_id))->del();
		}
		if($res){
			show_message('删除成功','html','-1');
		}else{
			show_message('删除失败','html','-1');
		}
	}
	
	//编辑用户
	public function user_edit(){
		global $config;
		if($_POST){
			
			$admin_id = $_POST['admin_id'];
			$data = array();
			if($admin_id != $_SESSION['admin_id']){
				$data['username'] = !empty($_POST['username'])?$_POST['username']:show_message('账户不能为空','html','-1');
			}
			//判断密码
			if(!empty($_POST['password']) && $_POST['password'] == $_POST['password2']){
				$data['password'] = MD5($_POST['password'].KEY);
			}else if( !empty($_POST['password']) && $_POST['password'] != $_POST['password2']
				|| !empty($_POST['password2']) && $_POST['password'] != $_POST['password2']
			){
				show_message('两次输入的密码不一致','html','-1');
			}
			if(!empty($_POST['admin_name'])){
				$data['admin_name'] = $_POST['admin_name'];
			}
			if(!empty($_POST['email'])){
				$data['email'] = $_POST['email'];
			}
				
			$weight = $this->auto_weight($_POST);
			if($weight){
				$data['con_weight'] = $weight;
			}
			
			//上传图片
			$img = $this->up_logo();
			if(!empty($img)){
				$data['admin_logo'] = $img;
				//下面是删除图片
				$edit_admin = M('admin')->where(array('admin_id'=>$admin_id))->find();
				$admin_log = get_path($edit_admin['admin_logo'],'admin_logo');
				$r = rm_file($admin_log);
			}
			
			$data['admin_type'] = intval($_POST['admin_type']);
			$data['store_id'] = intval($_POST['store_id']);
			
			$data['add_time'] = time();
			$res = M('admin')->where(array('admin_id'=>$admin_id))->update($data);
			M('adminlog',true)->update_log();
			if($res){
				show_message('编辑成功','html','-1');
			}else{
				show_message('编辑失败','html','-1');
			}
		}
		
		$where = array(
			'store_state' => 1,
			'is_open' => 1,
		);
		$store_list = M('store')->where($where)->select();
		if(!empty($store_list)){
			self::output('store_list',$store_list);
		}
		
		if( isset($_GET['id']) && intval($_GET['id']) > 0 ){
			$admin_id = $_GET['id'];
			$admin = M('admin',true);
			//是否是下级管理员
		//	$admin->is_d_admin($admin_id,$_SESSION['admin_id']);
		//	$admin->is_d_admin($admin_id,$_SESSION['admin_id']);
				
			$data = $admin->get_admin($admin_id);
		//	$my = $admin->get_admin($_SESSION['admin_id']);
			self::output('data',$data);
			//不能更改自己的权限,和不是自己创建的账号
			/*
			if($admin_id != $_SESSION['admin_id']){
				//获取下级管理员的权限，
				$weight = $admin->get_weight($data);
				$my_weight = $admin->get_weight($my);
				$weight = $admin->get_d_weight($weight,$my_weight);
				self::output('weight',$weight);
			}
			*/
		}
		self::output('is_edit',true);
		self::display('user_edit');
	}
	
	//修改自己的
	public function self_admin_edit(){
		global $config;
		if($_POST){
			$admin_id = $_POST['admin_id'];
			$data = array();
			if($admin_id != $_SESSION['admin_id']){
				$data['username'] = !empty($_POST['username'])?$_POST['username']:show_message('账户不能为空','html','-1');
			}
			//判断密码
			if(!empty($_POST['password']) && $_POST['password'] == $_POST['password2']){
				$data['password'] = md5($_POST['password'].KEY);
			}else if( !empty($_POST['password']) && $_POST['password'] != $_POST['password2']
				|| !empty($_POST['password2']) && $_POST['password'] != $_POST['password2']
			){
				show_message('两次输入的密码不一致','html','-1');
			}
			
			if(!empty($_POST['admin_name'])){
				$data['admin_name'] = $_POST['admin_name'];
			}
			if(!empty($_POST['email'])){
				$data['email'] = $_POST['email'];
			}
			
			//上传图片
			$img = $this->up_logo();
			if(!empty($img)){
				$data['admin_logo'] = $img;
				//下面是删除图片
				$edit_admin = M('admin')->where(array('admin_id'=>$admin_id))->find();
				if(!empty($edit_admin['admin_logo'])){
					$admin_log = get_path($edit_admin['admin_logo'],'admin_logo');
					$r = rm_file($admin_log);
				}
			}
			$data['add_time'] = time();
			$res = M('admin')->where(array('admin_id'=>$admin_id))->update($data);
			M('adminlog',true)->update_log();
			if($res){
				show_message('编辑成功','html','?act=user&op=user_list');
			}else{
				show_message('编辑失败','html','-1');
			}
		}
		if( isset($_SESSION['admin_id']) && intval($_SESSION['admin_id']) > 0 ){
			$admin_id = intval($_SESSION['admin_id']);
			$data = M('admin',true)->get_admin($admin_id);
			self::output('data',$data);
		}
		self::output('is_edit',true);
		self::display('user_self_edit');
	}
	
	//添加用户
	public function user_add(){
		if($_POST){
			$data = array();
			$data['username'] = !empty($_POST['username'])?$_POST['username']:show_message('账户不能为空','html','-1');
			$user = M('admin')->where(array('username'=>$data['username']))->find();
			if(!empty($user)){
				show_message('用户名已存在','html','-1');
			}
			if(empty($_POST['password'])){
				show_message('请填写密码','html','-1');
			}
			if($_POST['password'] != $_POST['password2']){
				show_message('两次输入的密码不一致','html','-1');
			}
			$data['password'] = md5($_POST['password'].KEY);
			if(!empty($_POST['admin_name'])){
				$data['admin_name'] = $_POST['admin_name'];
			}
			if(!empty($_POST['email'])){
				$data['email'] = $_POST['email'];
			}
			//修改这里不能top
		
			$weight = $this->auto_weight($_POST);
			if($weight){
				$data['con_weight'] = $weight;
			}
			if(isset($_POST['group_id']) && $_POST['group_id'] > 0){
				$data['group_id'] = $_POST['group_id'];
			}
			if(isset($_POST['is_group'])){
				$data['is_group'] = $_POST['is_group'];
			}
			$data['admin_type'] = intval($_POST['admin_type']);
			$data['store_id'] = intval($_POST['store_id']);
			//上传图片
			$img = $this->up_logo();
			if(!empty($img)){
				$data['admin_logo'] = $img;
			}
			$data['admin_pid'] = $_SESSION['admin_id'];
			$data['add_time'] = time();
			$res = M('admin')->insert($data);
			$new_admin = M('admin')->order('admin_id desc')->find();
			
			//递归更新自己的上级以及上上级用户，是递归的
		//	$this->update_upadmin($new_admin['admin_id'],$new_admin['admin_id']);
			
			M('adminlog',true)->add_log();
			if($res){
				show_message('添加成功','html','?act=user&op=user_list');
			}else{
				show_message('添加失败','html','-1');
			}
		}
		$where = array(
			'store_state' => 1,
			'is_open' => 1,
		);
		$store_list = M('store')->where($where)->select();
		if(!empty($store_list)){
			self::output('store_list',$store_list);
		}
		//获取自己的属性
		/*
		if( isset($_SESSION['admin_id']) && intval($_SESSION['admin_id']) > 0 ){
			$admin_id = $_SESSION['admin_id'];
			$admin = M('admin',true);
			$data = $admin->get_admin($admin_id);
			//获取权限
			$weight = M('admin',true)->get_weight($data);
		//	$group = M('group')->where(array('admin_id'=>$admin_id))->select();
			if(!empty($group)){
				self::output('group',$group);
			}
			self::output('weight',$weight);
		}
		*/
		//添加账户
		self::output('is_add',true);
		self::display('user_edit');
	}
	/*
	public function get_weight($data){
		$where = array(
			'admin_list' => 'like %,'.$data['admin_id'].',%',
		);
		$group_weight = M('group')->where($where)->find();
		if(!empty($group_weight)){  //先拿组控制
			$weight = $group_weight['con_weight'];
			return $weight;
		}
		if($data['admin_pid'] > 0){
			$data['con_weight'] = unserialize($data['con_weight']);
			$menu = read_language('menu');
			$my_weight = array();
			if(!empty($data['con_weight'])){
				foreach($data['con_weight']['top'] as $key => $val){
					$my_weight['top'][$val] = $menu['top'][$val];
				}
				foreach($data['con_weight']['left'] as $k => $v){
					$list = explode(',',$v);
					foreach($list  as $lk => $lv){
						$my_weight['left'][$k][$lv] = $menu['left'][$k][$lv];
					}
				}
			}
			return $my_weight;
		}
		if($data['admin_pid'] == 0){
			$weight = read_language('menu');
			return $weight;
		}
		return false;
	}
	*/
	public function up_logo($data = array()){
		$img = new FileUpload();
		$path = BasePath.DS.'uploads'.DS.'img'.DS;
		$img->set('path',$path);
		$img->upload('admin_logo');
		$img_name = $img->getFileName();
		return $img_name;
	}
	
	public function auto_weight($data){
		if(empty($data)){
			return false;
		}
		$weight = array();
		$menu = read_language('menu');
		foreach($menu['left'] as $key => $val){
			if(isset($_POST['t'.$key])){
				$left = implode(',',$_POST['t'.$key]);
				$weight['top'][] = $key;
				$weight['left'][$key] = $left;
			}
		}
		if(!empty($weight)){
			return serialize($weight);
		}
		return false;
	}
	
	//更新d_admin字段
	public function update_upadmin($admin_id,$new_admin_id){
		$p_admin = M('admin')->where(array('admin_id'=>$admin_id))->find();
		if(empty($p_admin['d_admin'])){
			$update['d_admin'] = ','.$new_admin_id.',';
		}else{
			$p_admin['d_admin'] = s_trim(',',$p_admin['d_admin']);
			$p_admin['d_admin'] = explode(',',$p_admin['d_admin']);
			$p_admin['d_admin'][] = $new_admin_id;
			$update['d_admin'] = implode(',',$p_admin['d_admin']);
			$update['d_admin'] = ','.$update['d_admin'].',';
		}
		M('admin')->where(array('admin_id'=>$p_admin['admin_id']))->update($update);
		if($p_admin['admin_pid'] != 0){
			$this->update_upadmin($p_admin['admin_pid'],$new_admin_id);
		}
	}
	//会员列表
	public function member_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		
		$start_day 	= isset($_GET['start_day']) ? strtotime($_GET['start_day']) : '';   //开始时间
		$end_day 	= isset($_GET['end_day']) ? strtotime($_GET['end_day']) : '';		//结束时间
		$keywords 	= isset($_GET['keywords'])? trim($_GET['keywords']):'';						//关键字
		$order_pay 	= isset($_GET['pay'])? trim($_GET['pay']):'';						//关键字
		$keywords_url = $_SERVER['REQUEST_URI'];
		$keyword_where = '';	
		$where = array();
		if(!empty($start_day)){
			$keywords_url = str_replace('&start_day='.$_GET['start_day'],'',$keywords_url);
			self::output('start_day',$_GET['start_day']);
			$where['add_time'] = '>'.$start_day;
		}
		
		if(!empty($end_day)){
			if($start_day > $end_day){
				show_message('时间设置错误','html','-1');
			}
			$keywords_url = str_replace('&end_day='.$_GET['end_day'],'',$keywords_url);
			self::output('end_day',$_GET['end_day']);
			$where['__AFFIX__user.add_time'] = '<'.($end_day +86400);
		}
		if(!empty($keywords)){
			$keyword_where = search('nickname|phone');  //ands是左边是否有链接
			$keywords_url = str_replace(array('&keywords='.urlencode($keywords)),array(''),$keywords_url);  //把页面和关键字去掉
			self::output('keywords',$keywords);
			$keywords = '&keywords='.$keywords;
		}
		if(!empty($keywords_url)){
			$keywords_url = str_replace('&page='.$_GET['page'],'',$keywords_url);
			self::output('keywords_url',$keywords_url);
		}
		
		$member = M('user')->where($keyword_where)->page($page,$num)->select();
		$count = M('user')->where($keyword_where)->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		foreach($member as $key => $val){
			if($val['user_state'] == 1){
				$member[$key]['user_state'] = '允许';
			}else if($val['user_state'] == 2){
				$member[$key]['user_state'] = '冻结';
			}else{
				$member[$key]['user_state'] = '禁止';
			}
			$member[$key]['add_time'] = date('Y-m-d H:i',$val['add_time']);
		}
		self::output('data',$member);
		self::display('member_list');
	}
	
	//会员编辑
	public function member_edit(){
		if($_POST){
			$data = array();
			$data['true_name'] 	   = $_POST['true_name'];
			$data['user_gold'] 	   = $_POST['user_gold'];
			$data['frozen_gold']   = $_POST['frozen_gold'];
			$data['user_integral'] = $_POST['user_integral'];
			$data['user_sex'] 	   = $_POST['user_sex'];
			$data['user_state']    = $_POST['user_state'];
			$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0 ;
			if($user_id > 0){
				$res = M('user')->where(array('user_id'=>$user_id))->update($data);
			}else{
				$res = M('user')->insert($data);  //添加
			}
			if($res){
				show_message('操作成功','html','?act=user&op=member_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		if(isset($_GET['user_id']) && intval($_GET['user_id']) > 0){
			$user_id = intval($_GET['user_id']);
			$user = M('user')->where(array('user_id'=>$user_id))->find();
			$user['add_time'] = date('Y-m-d H:i:s',$user['add_time']);
			self::output('data',$user);
		}
		
		self::display('member_edit');
	}
	
	public function member_level(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$user_level = M('user_level')->page($page,$num)->select();
		$count = M('user_level')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($user_level)){
			foreach($user_level as $key => $val){
				$user_level[$key]['add_time'] = date('Y-m-d H:i',$val['add_time']);
			}
		}
		
		self::output('data',$user_level);
		self::display('level_list');
	}
	
	//用户等级设置
	public function level_edit(){
		if($_POST){
			$data = array();
			$data['level_name']    = $_POST['level_name'];
			$data['integral'] 	   = intval($_POST['integral']);
			$data['level']  	   = intval($_POST['level']);
			$data['label'] 		   = intval($_POST['label']);
			
			$icon = new FileUpload();
			$path = BasePath.DS.'uploads/user_level/';
			$icon->set('path',$path);
			$icon->upload('icon');
			$icon_img = $icon->getFileName();
			if(!empty($icon_img)){
				$data['icon'] = $icon_img;
			}
			
			$level_id = isset($_POST['level_id']) ? intval($_POST['level_id']) : 0 ;
			if($level_id > 0){
				$res = M('user_level')->where(array('level_id'=>$level_id))->update($data);
			}else{
				$orwhere = array();
				$orwhere['level_name']    = $_POST['level_name'];
				$orwhere['integral'] 	   = intval($_POST['integral']);
				$orwhere['level']  	   = intval($_POST['level']);
				$is_exist = M('user_level')->where($orwhere,'or')->find();
				if(!empty($is_exist)){
					foreach($is_exist as $key => $val){
						if($val['level_name'] == $orwhere['level_name']){
							show_message('名称已存在','html','-1');
						}
						if($val['integral'] == $orwhere['integral']){
							show_message('需要的积分值已存在','html','-1');
						}
						if($val['level'] == $orwhere['level']){
							show_message('等级已存在','html','-1');
						}
					}
				}
				$data['add_time'] = time();
				$res = M('user_level')->insert($data);  //添加
			}
			if($res){
				show_message('操作成功','html','?act=user&op=member_level');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		if(isset($_GET['level_id']) && intval($_GET['level_id']) > 0){
			$level_id = intval($_GET['level_id']);
			$level = M('user_level')->where(array('level_id'=>$level_id))->find();
			if(!empty($level['icon'])){
				$level['icon'] = '/uploads/user_level/'.$level['icon'];
			}
			
			$level['add_time'] = date('Y-m-d H:i:s',$level['add_time']);
			self::output('data',$level);
		}
		self::display('level_edit');
	}
	
	public function level_del(){
		$level_id = isset($_GET['level_id']) && intval($_GET['level_id']) > 0 ? $_GET['level_id'] : 0; 
		if($level_id > 0){
			$res = M('user_level')->where(array('level_id'=>$level_id))->del();
			if($res){
				show_message('删除成功','html','?act=user&op=member_level');
			}else{
				show_message('删除失败','html','-1');
			}
		}
	}
}
?>