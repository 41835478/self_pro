<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>upload/webuploader.css">
<!--引入JS-->
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>upload/webuploader.js"></script>

<div style="display:none" id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
		<!--
	   <div id="picker">选择文件</div>
	   -->
    </div>
</div>
<script>

var BASE_URL = './';
$list = $('#thelist');
//上传文件地址
var upload_url = '?act=upload&op=web_upload';
jQuery(function() {
	var uploader = WebUploader.create({

		// swf文件路径
		swf: BASE_URL + 'upload/Uploader.swf',

		// 文件接收服务端。
		server: upload_url,  

		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick:{id:'.file_abcdefghijkl',multiple:false} ,
		
		auto:true, //自动上传
		
		//multiple:true,  //多文件上传
		
		chunkRetry : 3,  //失败会重新上传3次为上限
				
		method :'POST',   //post上传模式
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
	uploader.on( 'uploadSuccess', function( file , res) {
	//	console(uploader.click_obj);
		$('.file_abcdefghijkl').each(function(){
			var current_image = $(this).attr('current_image');
			if(current_image == '2'){
				var current_id = $(this).attr('id');
				$('#img_' + current_id).attr('src',res.path);
				$('#i' + current_id).attr('value',res.path);
			}
		});
		$( '#'+file.id ).find('p.state').text('已上传');
	});

	uploader.on( 'uploadError', function( file ) {
		$( '#'+file.id ).find('p.state').text('上传出错');
	});

	uploader.on( 'uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress').fadeOut();
		$('.file_abcdefghijkl').attr('current_image','1')
	});
});

//多文件上传
jQuery(function() {
	var uploaders = WebUploader.create({

		// swf文件路径
		swf: BASE_URL + 'upload/Uploader.swf',

		// 文件接收服务端。
		server: upload_url,  

		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick:{id:'.file_abcdefghijklmn',multiple:true} ,
		
		auto:true, //自动上传
		
		//multiple:true,  //多文件上传
		
		chunkRetry : 3,  //失败会重新上传3次为上限
				
		method :'POST',   //post上传模式
		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false
	});

	// 当有文件被添加进队列的时候
	uploaders.on( 'fileQueued', function( file ) {
		$list.append( '<div id="' + file.id + '" class="item">' +
			'<h4 class="info">' + file.name + '</h4>' +
			'<p class="state">等待上传...</p>' +
		'</div>' );
	});

	// 文件上传过程中创建进度条实时显示。
	uploaders.on( 'uploadProgress', function( file, percentage ) {
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
	var rep_images_text = '<?php echo isset($output['images_abcdefghijklmnopqdasdsa'])? $output['images_abcdefghijklmnopqdasdsa'] :'';?>';
	uploaders.on( 'uploadSuccess', function( file , res) {
	//	console(uploader.click_obj);
		$('.file_abcdefghijklmn').each(function(){
			var current_image = $(this).attr('current_image');
			if(current_image == '2'){
				var current_id = $(this).attr('id');
				var image_is_empty = $('#i' + current_id).attr('value');
				var img = rep_images_text;
				img = img.replace(/___IMAGES___/g,res.path);
				$('#image_'+current_id+'_box').append(img);
				if(image_is_empty == ''){
					$('#i' + current_id).attr('value',res.path);
				}else{
					$('#i' + current_id).attr('value',image_is_empty + ',' + res.path);
				}
			}
			
		});
		$( '#'+file.id ).find('p.state').text('已上传');
	});

	uploaders.on( 'uploadError', function( file ) {
		$( '#'+file.id ).find('p.state').text('上传出错');
	});

	uploaders.on( 'uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress').fadeOut();
		$('.file_abcdefghijklmn').attr('current_image','1');
	});
});
</script>
<style>
.image_deahjkl{
	max-width:20px;
	text-align:center;
	background:#393D49;
	color:#fff;
}
</style>
<script>

function image_delqwertyuiopasdfghjklzxcvbnm(file_path,obj){
	$.post('?act=upload&op=image_del',{file_path:file_path},function(state){
		if(state.code == true){
			obj.parentNode.style.display ="none";
		}
	},'json');
}
</script>