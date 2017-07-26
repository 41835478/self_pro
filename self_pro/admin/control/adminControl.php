<?php
if(!defined('PROJECT_NAME')) die('project empty');
class adminControl extends sysControl{
	
	public function admin_list(){
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
}
?>