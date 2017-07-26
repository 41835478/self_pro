
<?php
if(!defined('PROJECT_NAME')) die('project empty');
class articleControl extends systemControl{
	
	private $article = null;
	
	public function __construct(){
		parent::__construct();
		$this->article = M('article');
	}
	//文章列表
	public function article_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$article_list = M('article')->page($page,$num)->select();
		$count = M('article')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$article_list);
		self::display('article_list');
	}
	//文章编辑
	public function article_edit(){
		if($_POST){
			$data = array();
			$data['title'] 				= !empty($_POST['title']) ? $_POST['title'] : show_message('请填写文章标题','html','-1');
			$data['keyword'] 			= $_POST['keyword'];
			$data['j_title'] 			= $_POST['j_title'];
			$data['label'] 				= $_POST['label'];
			$data['article_class_id'] 	= $_POST['article_class_id'];
			$data['is_show'] 			= !empty($_POST['is_show'])?1:2;
			if(isset($_POST['editorValue']) && !empty($_POST['editorValue'])){
				$data['editorValue'] 			= $_POST['editorValue'];
			}
			$data['update_time'] 		= time();
			$article_id = isset($_POST['article_id']) && intval($_POST['article_id']) > 0 ? intval($_POST['article_id']) : 0 ;
			if($article_id > 0){
				$res = M('article')->where(array('article_id'=>$article_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('article')->insert($data);
			}
			if($res){
				show_message('操作成功','html','?act=article&op=article_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		if(isset($_GET['article_id']) && intval($_GET['article_id']) > 0){
			$article_id = intval($_GET['article_id']);
			$article = M('article')->where(array('article_id' => $article_id))->find();
			
			self::output('data',$article);
		}
		//文章分类列表
		$class_list = M('public',true)->get_article();
		self::output('class_list',$class_list);
		
		//获取富文本编辑器
		$baidu_text = file_get_contents(BasePath.DS.PLUGINS.DS.'textarea'.DS.'index.php');
		//echo $baidu_text;die;
		self::output('baidu_text',$baidu_text);
		
		self::display('article_edit');
	}
	
	//文章分类列表
	public function article_class_list(){
		
		//获取子分类
		$article_list = M('public',true)->get_article();
		
		self::output('data',$article_list);
		self::display('article_class_list');
	}
	
	//添加或修改分类
	public function article_class_edit(){
		if($_POST){
			$class_id = (isset($_POST['class_id']) && $_POST['class_id'] > 0)?intval($_POST['class_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit();
			
			if(!empty($class_id)){
				$res = M('article_class')->where(array('class_id'=>$class_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('article_class')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=article&op=article_class_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		//获取子分类
		$article_list = M('public',true)->get_article();
			
		self::output('article_list',$article_list);	
		
		
		//查询是否有该分类
		if(isset($_GET['class_id']) && intval($_GET['class_id'])){
			$class_id = intval($_GET['class_id']);
			$data = M('article_class',true)->get_article_info($class_id);
			self::output('data',$data);	
		}
		
		self::display('article_class_edit');
	}
	
	//获取分类
	/*
	public function get_article($arr,$arr2){
	//	$res = $this->article->field('article_id,article_name,article_pid')->where(array('article_pid'=>$arr['article_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->article->field('article_id,article_name,article_pid')->where(array('article_pid'=>$arr['article_id']))->select();
		}else{
			if(isset($arr2[$arr['article_id']])){
				$res = $arr2[$arr['article_id']];
			}
		}
		
		if(!empty($res)){
			foreach($res as $k => $v){
				if(isset($arr['nbsp'])){
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$res[$k]['article_name'] = $v['nbsp'].'┝&nbsp;'.$v['article_name'];
				}else{
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$res[$k]['article_name'] = $v['nbsp'].'┝&nbsp;'.$v['article_name'];
				}
				$res[$k]['list'] = $this->get_article($v,$arr2);
			}
		}
		return $res;
	}
	*/
	
	//删除
	public function article_class_del(){
		$class_id = $_GET['class_id'];
		if(intval($class_id) > 0 ){
			//拿商品
			$article = M('article_class',true)->get_article_info($class_id,'path');
			if(!empty($article['class_img'])){
				rm_file($article['class_img']);
			}
			$res = M('article_class')->where(array('class_id'=>$class_id))->del();
			if($res){
				show_message('删除成功','html','-1');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
	public function commit(){
		$data['class_name'] 		= !empty($_POST['class_name'])?$_POST['class_name']:show_message('请填写分类名称','html','-1');
		$data['class_jname'] 		= $_POST['class_jname'];
		$data['class_pid'] 		= intval($_POST['class_pid']);
		$data['class_label'] 		= intval($_POST['class_label']);
		$data['is_show'] 		= isset($_POST['is_show'])?1:2;
	//	$data['is_home_show'] 	= isset($_POST['is_home_show'])?1:2;
		$data['class_desc'] 		= intval($_POST['class_desc']);

		$logo = new FileUpload();
		$path = BasePath.DS.'uploads/article/'.date('Ymd').'/';
		$logo->set('path',$path);
		$logo->upload('class_img');
		$class_img = $logo->getFileName();
		if(!empty($class_img)){
			$data['class_img'] = $class_img;
		}
		return $data;
	}
	
	//删除分类图片
	public function article_images_del(){
		if(intval($_POST['class_id']) > 0){
			$article_id = intval($_POST['class_id']);
			$class = M('article_class')->field('class_img')->where(array('class_id'=>$class_id))->find();
			rm_file(BasePath.DS.'uploads/article/'.substr($goods['class_img'][$num],0,19).DS.$goods['class_img']);
			$class['class_img'] = '';
			M('article_class')->where(array('class_id'=>$class_id))->update($class);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
}