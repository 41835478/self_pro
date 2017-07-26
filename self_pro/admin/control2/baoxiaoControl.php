<?php
/* 友情链接
*  
*/
if(!defined('PROJECT_NAME')) die('project empty');
class baoxiaoControl extends systemControl{
	
	public function baoxiao_list(){
		
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$baoxiao = M('baoxiao')->page($page,$num)->order('create_time desc')->select();
		$count = M('baoxiao')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($baoxiao)){
			foreach($baoxiao as $key => $val){
				if($val['is_use'] == 0){
					$baoxiao[$key]['is_use'] = '已提交';
				}
				if($val['is_use'] == 1){
					$baoxiao[$key]['is_use'] = '已通过';
				}
				if($val['is_use'] == 2){
					$baoxiao[$key]['is_use'] = '未通过';
				}
			}
		}
		self::output('data',$baoxiao);
		
		self::display('baoxiao_list');
	}
	//已提交
	public function yitijiao(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$baoxiao = M('baoxiao')->page($page,$num)
				->where(array('is_use' => 0))
				->order('create_time desc')->select();
		$count = M('baoxiao')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($baoxiao)){
			foreach($baoxiao as $key => $val){
				if($val['is_use'] == 0){
					$baoxiao[$key]['is_use'] = '已提交';
				}
				if($val['is_use'] == 1){
					$baoxiao[$key]['is_use'] = '已通过';
				}
				if($val['is_use'] == 2){
					$baoxiao[$key]['is_use'] = '未通过';
				}
			}
		}
		self::output('data',$baoxiao);
		
		self::display('baoxiao_list');
	}
	
	//已通过
	public function yibaoxiao(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$baoxiao = M('baoxiao')->page($page,$num)
				->where(array('is_use' => 1))
				->order('create_time desc')->select();
		$count = M('baoxiao')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($baoxiao)){
			foreach($baoxiao as $key => $val){
				if($val['is_use'] == 0){
					$baoxiao[$key]['is_use'] = '已提交';
				}
				if($val['is_use'] == 1){
					$baoxiao[$key]['is_use'] = '已通过';
				}
				if($val['is_use'] == 2){
					$baoxiao[$key]['is_use'] = '未通过';
				}
			}
		}
		self::output('data',$baoxiao);
		
		self::display('baoxiao_list');
	}
	
	//未通过
	public function weibaoxiao(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$baoxiao = M('baoxiao')->page($page,$num)
				->where(array('is_use' => 2))
				->order('create_time desc')->select();
		$count = M('baoxiao')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($baoxiao)){
			foreach($baoxiao as $key => $val){
				if($val['is_use'] == 0){
					$baoxiao[$key]['is_use'] = '已提交';
				}
				if($val['is_use'] == 1){
					$baoxiao[$key]['is_use'] = '已通过';
				}
				if($val['is_use'] == 2){
					$baoxiao[$key]['is_use'] = '未通过';
				}
			}
		}
		self::output('data',$baoxiao);
		
		self::display('baoxiao_list');
	}
	
	public function baoxiao_edit(){
		$b_id = $_GET['b_id'];
		$is_use = $_GET['is_use'];
		if($b_id > 0){
			$res = M('baoxiao')->where(array('b_id' => $b_id))->update(array('is_use' => $is_use));
			if($res){
				show_message('操作成功','html','-1');
			}else{
				show_message('操作失败','html','-1');
			}
		}
	}
	
	//添加或修改
	public function link_edit(){
		if($_POST){
			$data = array();
			$data['link_name'] = !empty($_POST['link_name'])?$_POST['link_name']:show_message('请填写名称','html','-1');
			$data['link_url']  = !empty($_POST['link_url'])?$_POST['link_url']:show_message('请填写链接地址','html','-1');
			$data['link_sort'] = !empty($_POST['link_sort'])?intval($_POST['link_sort']):'0';
			$link_img = new FileUpload();
			$path = BasePath.DS.'uploads'.DS.'link_img'.DS;
			$link_img->set('path',$path);
			$link_img->upload('link_img');
			$img_name = $link_img->getFileName();
			if(!empty($img_name)){
				$data['link_img'] = $img_name;
			}
			$link_id = isset($_POST['link_id'])?$_POST['link_id']:'0';
			if($link_id > 0){
				$res = M('link')->where(array('link_id'=>$link_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('link')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=link&op=link_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		if( isset($_GET['link_id']) && intval($_GET['link_id']) >0 ){
			$link_id = $_GET['link_id'];
			$link = M('link')->where(array('link_id'=>$link_id))->find();
			$link['link_img'] = '/uploads'.DS.'link_img'.DS.$link['link_img'];
			self::output('data',$link);
		}
		
		self::display('link_edit');
	}
	
	public function link_del(){
		$link_id = isset($_GET['link_id'])?intval($_GET['link_id']):0;
		if($link_id > 0){
			$link = M('link')->where(array('link_id'=>$link_id))->find();
			$link['link_img'] = '/uploads'.DS.'link_img'.DS.$link['link_img'];
			rm_file($link['link_img']);
			$res = M('link')->where(array('link_id'=>$link_id))->del();
			if($res){
				show_message('删除成功','html','?act=link&op=link_list');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('删除失败','html','-1');
		}
	}
	
	/*
	//用户列表
	public function user_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 2;
		$admin_id = $_SESSION['admin_id'];
		$my = M('admin')->where(array('admin_id'=>$admin_id))->find();
		$my['d_admin'] = s_trim(',',$my['d_admin']);
		$admin = M('admin');
		if(!empty($my['d_admin'])){
			$where = array(
				'admin_id' => 'in '.$my['d_admin'],
			);
			$admin->where($where);
		}
		$users = $admin->page($page,$num)->select();
		$pages = M('admin');
		if(!empty($my['d_admin'])){
			$where = array(
				'admin_id' => 'in '.$my['d_admin'],
			);
			$pages->where($where);
		}
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
	
	//删除用户
	/*
	public function user_del(){
		$admin_id = isset($_GET['id'])?intval($_GET['id']):'';
		$my = M('admin')->where(array('admin_id'=>$_SESSION['admin_id']))->find();
		$my['d_admin'] = s_trim(',',$my['d_admin']);
		$my['d_admin'] = explode(',',$my['d_admin']);
		if(!in_array($admin_id,$my['d_admin'])){
			show_message('没有该权限','html','-1');
		}
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
				$data['password'] = MD5($_POST['password']);
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
			$data['add_time'] = time();
			$res = M('admin')->where(array('admin_id'=>$admin_id))->update($data);
			M('adminlog',true)->update_log();
			if($res){
				show_message('编辑成功','html','-1');
			}else{
				show_message('编辑失败','html','-1');
			}
		}
		if( isset($_GET['id']) && intval($_GET['id']) > 0 ){
			$admin_id = $_GET['id'];
			$admin = M('admin',true);
			//是否是下级管理员
			$admin->is_d_admin($admin_id,$_SESSION['admin_id']);
				
			$data = $admin->get_admin($admin_id);
			$my = $admin->get_admin($_SESSION['admin_id']);
			self::output('data',$data);
			//不能更改自己的权限,和不是自己创建的账号
			if($admin_id != $_SESSION['admin_id']){
				//获取下级管理员的权限，
				$weight = $admin->get_weight($data);
				$my_weight = $admin->get_weight($my);
				$weight = $admin->get_d_weight($weight,$my_weight);
				self::output('weight',$weight);
			}
		}
		self::output('is_edit',true);
		self::display('user_edit');
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
			$data['password'] = MD5($_POST['password']);
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
			$this->update_upadmin($new_admin['admin_id'],$new_admin['admin_id']);
			
			M('adminlog',true)->add_log();
			if($res){
				show_message('添加成功','html','?act=user&op=user_list');
			}else{
				show_message('添加失败','html','-1');
			}
		}
		//获取自己的属性
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
	/*
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
	*/
}
?>