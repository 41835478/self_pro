<?php
if(!defined('PROJECT_NAME')) die('project empty');
class testControl extends sysControl{
	
	public function test1(){   //编辑
		$admin = M('admin')->where(array('id' => 1))->find();
		$admin['imagesab'] = '/uploads/default/20170715/1ab18430ae52a4c1ea8434fe451d4cb0.jpg,/uploads/default/20170715/b15c4b1a78f46eae4389ddb7ba60ca0b.jpg';
		$admin['imagesabc'] = '/uploads/default/20170715/1ab18430ae52a4c1ea8434fe451d4cb0.jpg,/uploads/default/20170715/b15c4b1a78f46eae4389ddb7ba60ca0b.jpg,/uploads/default/20170715/05b3119a66f4c3308e91f31ff983dba2.jpg';
		$admin['content1'] = '你好富文本';
		$admin['content2'] = '唐果';
		$admin['content3'] = '你好富文本唐果';
		$admin['start_time'] = '1491461251';
		$admin['end_time'] = '1491461251';
		self::form("",array(
			array('text','id','用户名'),
			array('password','password','密码'),
			array('hidden','id','用户名'),
			array('label','password','标签'),
			array('textarea','username','用户名'),
			array('time','start_time','开始时间'),
			array('time','end_time','开始时间'),
			array('radio','id','单选',array('a','b','c')),
			array('checkbox','id','多选',array('aa','bb','cc')),
			array('selected','id','下拉',array('aa','bb','cc')),
			array('file','logo','图片',array('jpg','png','jpep','bmp'),array('style'=>'max-width:300px;max-height:300px;'),$size = 2,'upload_file.php'),
			array('file','logo2','图片',array('jpg','png','jpep','bmp'),'',$size = 2,'upload_file.php'),
			array('files','imagesab','文件',array('jpg','png','jpep','bmp'),$size=2,'upload_file.php'),
			array('files','imagesabc','文件',array('jpg','png','jpep','bmp'),$size=2,'upload_file.php'),
			array('editor','content1','描述'),
			array('editor','content2','描述'),
			array('editor','content3','描述'),
			
		),$admin,'post','public_form');
	}
	
	public function test2(){   //列表
		$selected = selected(array('type','type2'));
		
		$admin = M('admin')->select();
		foreach($admin as $key => $val){
			$admin[$key]['image'] = '/uploads/default/20170715/1ab18430ae52a4c1ea8434fe451d4cb0.jpg';
		}
		//如果有post——page就用post的，不然就判断get-page 默认第一页
		$page= isset($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) ? intval($_GET['page']) : 1);
		$count = 500; //总数
		$num = 5;  //显示的数量
		$page_obj = new page($count,$num,$page,'javascript:;',5);
		$page_obj ->page_attr();
		$page_obj ->conf = 23456;
		self::output('page',$page_obj ->show());
	//	self::output('currect_page',$page);
		
		self::form_top(array(
			'selected' => array(	//下拉选择
				$selected['type'] => array( 	//字段二
					'1' => 'a',
					'2' => 'b',
					'3' => 'c',
				),
				$selected['type2'] => array( 	//字段二
					'1' => '中国',
					'2' => '中国1',
					'3' => '中国2',
				),
			),
			'start_time' => strtotime(str_replace('&nbsp',' ',$_POST['start_time'])),
			'end_time' => strtotime(str_replace('&nbsp',' ',$_POST['end_time'])),
			'keyword' => $_POST['keyword'],
			'all_del' => 'url',	//批量删除
			'add',
			'search',
			'export' => 'url',
			'self' => array('自定义按钮','',''),
		));
		
		self::form_list(array(
			array('checkbox','id','ID',array('style'=>'max-width:300px;max-height:300px;')),
			array('label','username','用户名'),
			array('label','password','密码'),
			array('time','add_time','时间'),
			array('image','image','图片'),
			array('menu',array(
					array('编辑','javascript::',array('style'=>'background:#FF5722')),
					array('删除','javascript::',),
					),'操作'),
		),$admin,'id');
		
	}
	
	public function test3(){
		$chengdu_url 	= 'http://cd.58.com/ershoufang/?key=别墅';
		$wuhan_url 		= 'http://wh.58.com/ershoufang/?key=别墅';
		$chongqing_url 	= 'http://cq.58.com/ershoufang/?key=别墅';
		$xiamen_url 	= 'http://xm.58.com/ershoufang/?key=别墅';
		$url = array(
			'chengdu.php' => $chengdu_url,
			'wuhan.php' =>$wuhan_url,
			'chongqing.php' =>$chongqing_url,
			'xiamen.php' =>$xiamen_url,
		);
		foreach($url as $key => $val){
			$html = file_get_contents($val);
			file_put_contents(BasePath.DS.'pachong'.DS.$key,$html);
		}
		
		self::display();
	}
	
	public function test4(){
		$url = 'http://cd.58.com';
		self::output('uuu',$url);
		self::setfooter('pachong');
		self::display('pachong/chengdu');
	}
	
	public function test5(){
		$mulu = scandir(BasePath.DS.'admin/tpl/pc/pachong'.DS.'list/');
		self::output('mulu',$mulu);
		self::display('pachong/index');
	}
	
	public function test6(){
		$page = isset($_GET['page']) ? $_GET['page'] :'';
		$page = '20170722115055190142';
		self::setfooter('pachong2');
		self::display('pachong/list/'.$page);
	}
	public function test7(){
		set_time_limit(3000);
		$city = array('广州');
		$city = implode('|',$city);
		for($i = 0 ; $i < 1000 ;$i ++){
			$i = 24630651;
			$html = file_get_contents('https://www.dianping.com/shop/'.$i);
			$r = preg_match('/'.$city.'/',$html);
			if($r){
				$str = preg($html,'<div class="breadcrumb">','<div class="action">');
				echo $html;
			}
		}
	}
}
?>