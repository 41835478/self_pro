<?php
/* 友情链接
*  
*/
if(!defined('PROJECT_NAME')) die('project empty');
class roleControl extends systemControl{
	
	public function role_list(){
		
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$role = M('role')->join('left __AFFIX__group','__AFFIX__group.group_id = __AFFIX__role.group_id')
						 ->page($page,$num)
						 ->select();
		$count = M('role')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$role);
		
		self::display('role_list');
	}
	
	//添加或修改
	public function role_edit(){
		if($_POST){
			$data = array();
			$data['username'] = !empty($_POST['username'])?$_POST['username']:show_message('请填写用户名称','html','-1');
			$data['group_id'] = !empty($_POST['group_id'])?intval($_POST['group_id']):'0';
			$username = M('admin')->where(array('username'=>$data['username']))->find();
			if(empty($username)){
				show_message('不存在的管理员','html','-1');
			}
			$group = M('group')->where(array('group_id'=>$data['group_id']))->find();
			if(empty($group) || $data['group_id'] == 0){
				show_message('错误的组权限','html','-1');
			}
			$role_id = isset($_POST['role_id'])?$_POST['role_id']:'0';
			if($role_id > 0){
				$res = M('role')->where(array('role_id'=>$role_id))->update($data);
			}else{
				$role = M('role')->where(array('username'=>$data['username']))->find();
				if(empty($role)){
					$data['add_time'] = time();
					$res = M('role')->insert($data);
				}else{
					$res = M('role')->where(array('username'=>$data['username']))
									->update(array('group_id'=>$data['group_id']));
				}
			}
			
			if($res){
				show_message('操作成功','html','?act=role&op=role_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		if( isset($_GET['role_id']) && intval($_GET['role_id']) >0 ){
			$role_id = $_GET['role_id'];
			$role = M('role')->where(array('role_id'=>$role_id))->find();
			self::output('data',$role);
		}
		
		$group = M('group')->select();
		self::output('group',$group);
		self::display('role_edit');
	}
	
	public function role_del(){
		$role_id = isset($_GET['role_id'])?intval($_GET['role_id']):0;
		if($role_id > 0){
			$res = M('role')->where(array('role_id'=>$role_id))->del();
			if($res){
				show_message('删除成功','html','?act=role&op=role_list');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('删除失败','html','-1');
		}
	}
	
}
?>