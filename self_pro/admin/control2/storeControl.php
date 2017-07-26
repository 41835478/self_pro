<?php
if(!defined('PROJECT_NAME')) die('project empty');
class storeControl extends systemControl{
	
	public function store_list(){
		$state = isset($_GET['type'])?intval($_GET['type']):'1';
		$where = $this->get_where($state); 
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 20;
		$store = M('store');
		if(!empty($where)){
			$store->where($where);
		}
		$store_list = $store->page($page,$num)->select();
		$count = $store->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$store_list);
		
		self::display('store_list');
	}
	
	public function store_state_submit(){
		$state = isset($_GET['state'])?intval($_GET['state']):'';
		$store_id = isset($_GET['store_id'])?intval($_GET['store_id']):'';
		$data = array();
		if($state > 0){
			switch($state){
				case 1:
					$data['is_open'] = 1;	
					break;
				case 2:
					$data['is_open'] = 2;				
					break;
				case 3:
					$data['is_open'] = 1;
					$data['store_state'] = 1;
					$store = M('store')->where(array('store_id'=>$store_id))->find();
					//如果已经改变过就不更新了，第一次会被更新
					if($store['close_time'] < time()){ 
						$web_config = M('setting',true)->get_web_config(); //store_day
						$data['close_time'] = time() + $web_config['store_day'];	
					}
					$data['open_time'] = time();
					break;
				case 4: 
					$data['store_state'] = 3;
					break;
				default : break;
			}
			$res = M('store')->where(array('store_id'=>$store_id))->update($data);
			if($res){
				show_message('操作成功','html','?act=store&op=store_list');
			}else{
				show_message('操作失败','html','?act=store&op=store_list');
			}
		}		
	}
	
	public function store_edit(){
		$store_id = isset($_GET['store_id'])?intval($_GET['store_id']):'0';
		
		//提交修改
		if($_POST){
			var_dump();die;
		}
		
		if($store_id > 0){
			$store = M('store')->where(array('store_id'=>$store_id))->find();
			if(!empty($store)){
				$store['card_id'] = hide_repalce($store['card_id'],4,4);
				$store['open_time'] = $store['open_time'] != 0 ? date('Y-m-d',$store['open_time']) : '';
				if($store['is_open'] == 1 && $store['store_state'] == 1 && $store['close_time'] > time()){
					$store['is_open'] = '开启';
				}else{
					$store['is_open'] = '关闭';
				}
				$store['store_logo'] = DS.UPLOADS.'store'.DS.$store['u_id'].DS.$store['store_logo'];
				$store['card_z'] = DS.UPLOADS.'store'.DS.$store['u_id'].DS.$store['card_z'];
				$store['card_f'] = DS.UPLOADS.'store'.DS.$store['u_id'].DS.$store['card_f'];
			//	$store['card_id'] = hide_repalce($store['card_id'],5,5);
				self::output('data',$store);
				self::display('store_edit');
			}else{
				show_message('店铺不存在','html','-1');
			}
		}else{
			show_message('店铺不存在','html','-1');
		}
	}
	
	//获取店铺状态
	public function get_where($state){
		$where = array();
		switch($state){
			case '1':   //全部
				$where = 1;
				break;
			case '2':	//开启的店铺，这个开启的是前台可以搜索到的店铺
				$where['is_open'] = 1;
				$where['store_state'] = 1;
				$where['close_time'] = '>'.time();
				break;
			case '3':	//关闭的店铺
				$where = 'is_open = 2 or close_time < '.time();
				break;
			case '4':	//审核通过的店铺
				$where['store_state'] = 1;
				break;
			case '5':	//审核中的店铺
				$where['store_state'] = 2;
				break;
			case '6':	//审核失败的店铺
				$where['store_state'] = 3;
				break;
			case '7':	//过期的店铺
				$where = 'close_time != 0 and close_time < '.time();
				break;
			default :
				return null;
				break;
		}
		return $where;
	}
}
?>