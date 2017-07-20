<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<html>
<head>
<title><?php echo $output['login']['login_title'];?></title>
<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="<?php echo CSS;?>/webuploader.css" />
<script type="text/javascript" src="<?php echo JS;?>/webuploader.js" ></script>
</head>
<body>
<form id="shenqingbaoxiao" action="" method="post">
	姓名：<input  type="text" name="username">   <br>
	金额：<input  type="text" name="price">		<br>
	类别：	<select name="leibie">
				<option value="其它" >其它</option>
				<option value="水费" >水费</option>
				<option value="电费" >电费</option>
				<option value="网费" >网费</option>
				<option value="油费" >油费</option>
				<option value="车费" >车费</option>
				<option value="进货" >进货</option>
				<option value="团建" >团建</option>
				<option value="火车票" >火车票</option>
				<option value="飞机票" >飞机票</option>
				<option value="清洁费" >清洁费</option>
				<option value="公关费" >公关费</option>
				<option value="日常用品" >日常用品</option>
			</select>
		<br>
	<!--
	类别：<input  type="text" name="leibie">		<br>
	-->
	备注：<input  type="text" name="beizhu">		<br>
	<input id="images" type="hidden" name="images" >		<br>
	<div class="advice_body_photo">
		<div id="picker" class="advice_body_photo_take" style="border: 1px solid black; border-radius:2px;background: url(<?php echo IMG;?>/photo.png) no-repeat center; background-size: 0.84rem 0.64rem;"></div>
		<div class="advice_body_photo_take limg1"></div>
		<div class="advice_body_photo_take limg2"></div>
		<div class="advice_body_photo_take limg3"></div>
	</div>
	<a class="register_baoxiao" onclick="register_baoxiao()" >申请报销</a>
</form>
</body>
</html>
<script>
var images = '';
function register_baoxiao(){
	images = '';
	if(img.length > 0){
		for(x in img){
			images += img[x] + ',';
		}
		images = images.slice(0,images.length-1);
	}
	$('#images').val(images);
	$('#shenqingbaoxiao').submit();
//	console.log(img);
}
var img = [];
jQuery(function() {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('#ctlBtn'),
        state = 'pending',
        uploader;
		var BASE_URL = './';
		var upload_url = '?act=upload&op=web_upload';
		//上传
		var uploader = WebUploader.create({

			// swf文件路径
			swf: BASE_URL + '/js/Uploader.swf',

			// 文件接收服务端。
			server: upload_url,

			// 选择文件的按钮。可选。
			// 内部根据当前运行是创建，可能是input元素，也可能是flash.
			pick: '#picker',
			
			auto:true,
			/*
			accept: {
				title: 'Images',
				extensions: 'gif,jpg,jpeg,bmp,png,JPG',
				mimeTypes: 'image/*'
			},
			*/
			chunkRetry : 3,
			
			method :'POST',
			
			multiple:'multiple',
			
		//	capture : 'cmaera',

			// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
			resize: false
		});
		// 当有文件被添加进队列的时候
		uploader.on( 'fileQueued', function( file ) {
			$list.append( '<div id="' + file.id + '" class="item">' +
				'<h4 class="info">' + file.name + '</h4>' +
				'<p class="state">等待上传...</p>' +
			'</div>' );
		});

		// 文件上传过程中创建进度条实时显示。
		uploader.on( 'uploadProgress', function( file, percentage ) {
			var $li = $( '#'+file.id ),
				$percent = $li.find('.progress .progress-bar');

			// 避免重复创建
			if ( !$percent.length ) {
				$percent = $('<div class="progress progress-striped active">' +
				  '<div class="progress-bar" role="progressbar" style="width: 0%">' +
				  '</div>' +
				'</div>').appendTo( $li ).find('.progress-bar');
			}

			$li.find('p.state').text('上传中');

			$percent.css( 'width', percentage * 100 + '%' );
		});
		
		uploader.on( 'uploadSuccess', function( file , res ) {
			img.unshift(res.path);
		//	console.log(img);
			$( '#'+file.id ).find('p.state').text('已上传');
			$( '#'+file.id ).find('p.state').text(res.path);
		});

		uploader.on( 'uploadError', function( file ) {
			$( '#'+file.id ).find('p.state').text('上传出错');
		});

		uploader.on( 'uploadComplete', function( file ) {
			if(img[0]){
				$('.limg1').css('background','url("'+ img[0] +'") no-repeat ');
				$('.limg1').css('backgroundSize','cover');
				$('.limg1').css('border','1px solid #000');
			}
			if(img[1]){
				$('.limg2').css('background','url("'+ img[1] +'") no-repeat ');
				$('.limg2').css('backgroundSize','cover');
				$('.limg2').css('border','1px solid #000');
			}
			if(img[2]){
				$('.limg3').css('background','url("'+ img[2] +'") no-repeat ');
				$('.limg3').css('backgroundSize','cover');
				$('.limg3').css('border','1px solid #000');
			}
			$( '#'+file.id ).find('.progress').fadeOut();
		});
});
</script>
<style>
html,body,ul,ol,li,p,h1,h2,h3,h4,h5,h6,form,fieldset,table,td,img,div{
margin:0;padding:0;border:0;
}
body{
    background:#fbfbfb;color:#333;font-size:12px;font-family:"SimSun","黑体","Arial Narrow";
}
ul,ol{
    list-style-type:none;
}
select,input,img,select{
    vertical-align:middle;
}
a{text-decoration:none;}
a:link{color:black;}
a:visited{color:black;}
a:hover,a:active,a:focus{color:black;} 

.advice_body_photo{
	height:130px;
	background: #ffffff;
	padding-top: 0.3rem;
	padding-right: 0.2rem;
	overflow:hidden;
	padding-bottom: 0.2rem;
}
.register_baoxiao{
	cursor:pointer;
	padding:10px 10px 5px 5px;
	background:#62c196;
	border-radius:6px;
}
.advice_body_photo div{
	margin-left: 0.2rem;
	float: left;
}
#picker .webuploader-pick{
	background:url(<?php echo IMG;?>/photo.png) no-repeat center; background-size: 0.84rem 0.64rem;
	padding:0;
	left:0px;
	margin-left:0px;
	width:100%;
	height:100%
}
.advice_body_photo_take{
	width: 100px;
	height: 100px;
}
.advice_body_photo_take {
	border: 0px solid #000;
	border-radius: 2px;
}
</style>
