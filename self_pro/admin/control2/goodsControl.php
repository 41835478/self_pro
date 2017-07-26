<?php
if(!defined('PROJECT_NAME')) die('project empty');
class goodsControl extends systemControl{
	//商品列表
	public function goods_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$goods_list = M('goods')->page($page,$num)->select();
		$count = M('goods')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$goods_list);
		self::display('goods');
	}
	//添加和修改
	public function goods_edit(){
		if($_POST){
			$goods_id = (isset($_POST['goods_id']) && $_POST['goods_id'] > 0)?intval($_POST['goods_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit();
			
			if(!empty($goods_id)){
				$res = M('goods')->where(array('goods_id'=>$goods_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('goods')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=goods&op=goods_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
			
		
		//查询是否有该商品
		if(isset($_GET['goods_id']) && intval($_GET['goods_id'])){
			$goods_id = intval($_GET['goods_id']);
			$data = M('goods',true)->get_goods_info($goods_id);
			self::output('data',$data);	
		}
		
		//获取分类
		$category_list = M('public',true)->get_category();
		self::output('category_list',$category_list);
		//获取富文本编辑器
		$baidu_text = file_get_contents(BasePath.DS.PLUGINS.DS.'textarea'.DS.'index.php');
		//echo $baidu_text;die;
		self::output('baidu_text',$baidu_text);
		
		self::display('goods_edit');
	}
	
	//商品删除
	public function goods_del(){
		$goods_id = $_GET['goods_id'];
		if(intval($goods_id) > 0 ){
			//拿商品
			$goods = M('goods',true)->get_goods_info($goods_id,'path');
			if(!empty($goods['goods_img'])){
				rm_file($goods['goods_img']);
			}
			if(!empty($goods['goods_images']) && count($goods['goods_images']) > 0){
				foreach($goods['goods_images'] as $key => $val){
					rm_file($val);
				}
			}
			$res = M('goods')->where(array('goods_id'=>$goods_id))->del();
			if($res){
				show_message('删除成功','html','-1');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
	//商品提交
	public function commit(){
		$data['goods_name'] = !empty($_POST['goods_name'])?$_POST['goods_name']:show_message('请填写商品名称','html','-1');
		
		//商品价格
		$data['goods_price'] = empty($_POST['goods_price'])?show_message('请填写商品价格','html','-1')
			:intval($_POST['goods_price'])>0?intval($_POST['goods_price']):show_message('请填写正确的价格','html','-1');
		
		if(!empty($_POST['goods_jdesc'])){
			$data['goods_jdesc'] = $_POST['goods_jdesc'];  //简单描述
		}
		
		if(isset($_POST['goods_label'])){
			$data['goods_label'] = $_POST['goods_label'];  //标记
		}
		
		//是否显示
		$data['is_show'] = isset($_POST['is_show'])?1:2;
		
		//是否预售
		$data['is_yushou'] = isset($_POST['is_yushou'])?1:2;
		
		$data['cat_id']   	 = $_POST['cat_id']; 	 	//分类id
		$data['brand_id']    = $_POST['brand_id'];  	//品牌id
		$data['supplied']    = $_POST['supplied'];  	//供货商
		$data['goods_style'] = $_POST['goods_style']; 	//商品属性
		$data['goods_spec']  = $_POST['goods_spec']; 	//商品规格
		
		$data['is_new']  		= isset($_POST['is_new'])?1:2;
		$data['is_boutique']  	= isset($_POST['is_boutique'])?1:2;
		$data['is_recommend']   = isset($_POST['is_recommend'])?1:2;
		$data['is_hot']  		= isset($_POST['is_hot'])?1:2;
		
		//折扣
		$_POST['discount'] = (intval($_POST['discount'] * 100))/100;
		if($_POST['discount'] < 0 || $_POST['discount'] > 1){
			show_message('折扣只能填写0-1之间（可以带两位小数点）','html','-1');
		}
		$data['discount']  		= $_POST['discount'];  
		
		//开始时间
		if(!empty($_POST['start_day']) && !empty($_POST['start_hour'])){
			$data['start_time'] = date_en($_POST['start_day'],$_POST['start_hour']);
		}else if(empty($_POST['start_day']) && !empty($_POST['start_hour'])){
			$_POST['start_day'] = date('Y-m-d');
			$data['start_time'] = date_en($_POST['start_day'],$_POST['start_hour']);
		}else if(!empty($_POST['start_day']) && empty($_POST['start_hour'])){
			$data['start_time'] = date_en($_POST['start_day'],0);
		}else{
			$data['start_time'] = 0;
		}
		//结束时间
		if(!empty($_POST['end_day']) && !empty($_POST['end_hour'])){
			$data['end_time'] = date_en($_POST['end_day'],$_POST['end_hour']);
		}else if(empty($_POST['end_day']) && !empty($_POST['end_hour'])){
			$_POST['end_day'] = date('Y-m-d');
			$data['end_time'] = date_en($_POST['end_day'],$_POST['end_hour']);
		}else if(!empty($_POST['end_day']) && empty($_POST['end_hour'])){
			$data['end_time'] = date_en($_POST['end_day'],0);
		}else{
			$data['end_time'] = 0;
		}
		
		if($data['start_time'] > $data['end_time'] && $data['start_time'] != 0){
			show_message('开始时间不能在结束时间之后','html','-1');
		}
		//评分
		if($_POST['goods_score'] < 0 || $_POST['goods_score'] > 5){
			show_message('默认评分不正确','html','-1');
		}
		$data['goods_score'] = $_POST['goods_score'];
		
		$data['is_dscore'] 	 = !empty($_POST['is_dscore'])?1:2;
		
		if($_POST['pay_points'] < -1){
			show_message('赠送消费积分填写错误','html','-1');
		}
		$data['pay_points']  = $_POST['pay_points'];
		
		if($_POST['pay_bonus'] < -1){
			show_message('赠送等级积分填写错误','html','-1');
		}
		$data['pay_bonus']  = $_POST['pay_bonus'];
		
		//商品数量限制
		if(intval($_POST['goods_num']) <= 0 || intval($_POST['goods_num']) > 100000000000){
			show_message('商品数量填写错误','html','-1');
		}
		$data['goods_num'] = $_POST['goods_num'];
		
		//商品警告数量
		if(intval($_POST['goods_warning_num']) < 0 || intval($_POST['goods_warning_num']) > intval($_POST['goods_num'])){
			show_message('商品警告数量填写错误','html','-1');
		}
		$data['goods_warning_num'] = $_POST['goods_warning_num'];
		
		$logo = new FileUpload();
		$path = BasePath.DS.'uploads/goods/'.date('Ymd').'/';
		$logo->set('path',$path);
		$logo->upload('goods_img');
		$goods_img = $logo->getFileName();
		if(!empty($goods_img)){
			$data['goods_img'] = $goods_img;
		}
		
		//多文件上传
		$goods_images = new FileUpload();
		$images_path = BasePath.DS.'uploads/goods/'.date('Ymd').'/';
		if(!empty($_FILES['goods_images'])){
			foreach($_FILES['goods_images']['name'] as $key => $val){
				if(empty($_FILES['goods_images']['name'][$key])){
					unset($_FILES['goods_images']['name'][$key]);
				}
			}
		}
		$goods_images->set('path',$images_path);
		$goods_images->upload('goods_images');
		$goods_arr = $goods_images->getFileName();
		if(!empty($goods_arr)){
			if(isset($_GET['goods_id']) && intval($_GET['goods_id']) > 0){
				$goods = M('goods')->field('goods_images')->where(array('goods_id'=>$_GET['goods_id']))->find();
				if(!empty($goods['goods_images'])){
					$goods['goods_images'] = $goods['goods_images'].','.implode(',',$goods_arr);
					$data['goods_images'] = $goods['goods_images'];
				}else{
					$data['goods_images'] = implode(',',$goods_arr);
				}
			}else{
				if(!is_array($goods_arr)){
					$data['goods_images'] = $goods_arr;
				}else{
					$data['goods_images'] = implode(',',$goods_arr);
				}
			}
		}
		
		/*
		if(isset($_POST['goods_id']) && $_POST['goods_id'] > 0){
			$data['add_time'] = time();
		}
		*/
		
		//商品描述 (百度富文本)
		if(isset($_POST['editorValue']) && !empty($_POST['editorValue'])){
			//$_POST['editorValue'] = str_replace_baidu($_POST['editorValue']);  //str_replace_baidu此函数是反转
			$data['editorValue'] = $_POST['editorValue'];
		}
		//更新时间
		$data['update_time'] = time();
		//var_dump($data);die;
		return $data;
	}
	
	public function goods_images_del(){
		if(intval($_POST['goods_id']) > 0){
			$goods_id = intval($_POST['goods_id']);
			$image = $_POST['image'];
			$goods = M('goods')->field('goods_images')->where(array('goods_id'=>$goods_id))->find();
			$goods['goods_images'] = explode(',',$goods['goods_images']);
			if(!empty($goods['goods_images'])){
				foreach($goods['goods_images'] as $key => $val){
					if($val == $image){
						rm_file(BasePath.DS.'uploads/goods/'.substr($image,0,19).DS.$image);
						unset($goods['goods_images'][$key]);
					}
				}
			}
			$goods['goods_images'] = implode(',',$goods['goods_images']);
			
			M('goods')->where(array('goods_id'=>$goods_id))->update($goods);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
}