<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>我的建议</title>
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="<?php echo CSS;?>/advice.css" />
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
		<link rel="stylesheet" href="<?php echo CSS;?>/webuploader.css" />
		<script type="text/javascript" src="<?php echo JS;?>/webuploader.js" ></script>
	</head>
	<script>
		(function (doc, win) {
	        var docEl = doc.documentElement,
	            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
	            recalc = function () {
	                var clientWidth = docEl.clientWidth;
	                if (!clientWidth) return;
	                if(clientWidth>=750){
	                    docEl.style.fontSize = '100px';
	                }else{
	                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
	                }
	            };
	
	        if (!doc.addEventListener) return;
	        win.addEventListener(resizeEvt, recalc, false);
	        doc.addEventListener('DOMContentLoaded', recalc, false);
	    })(document, window); 
			    
		$(document).ready(function() {
		    var nbr=0;
		    var htt='';
		    $(".bz_1_ipt").keyup(function() {
		        nbr=$('.bz_1_ipt').val().length;
		        $('.bz_1_bj_nbr').html(nbr);
		    });
		    $('.bz_2_22').on('click','li',function(){
		        var hht=$(".bz_1_ipt").val();
		        console.log(hht);
		        htt=$(this).html();
		        if(nbr>='500'){
		            $('.bz_2_2').removeClass('bz_2_22');
		            $('.bz_1_bj_nbr').html(500);
		            return;
		        }
		        hht=hht+htt;
		        $('.bz_1_ipt').val(hht);
		        nbr=nbr+4;
		        if(nbr>='500'){
		            $('.bz_1_bj_nbr').html(500);
		            return;
		        }
		        $('.bz_1_bj_nbr').html(nbr);
		    })
		    $('.advice_body_tip div').click(function(){
		    	$(this).css('borderColor',"#F83600");
		    	$(this).css('color',"#F83600");
		    	$(this).siblings().css('borderColor',"black");
		    	$(this).siblings().css('color',"#000000");
		    })
		});
	</script>
	<body>
	<div id="uploader" class="wu-example" style="display:none">
		<!--用来存放文件信息-->
		<div id="thelist" class="uploader-list"></div>
		<div class="btns">
			<button id="ctlBtn" class="btn btn-default">开始上传</button>
		</div>
	</div>
		<div class="advice_head">反馈问题类型</div>
		<div class="advice_body_tip">
			<div>功能异常</div>
			<div>体验问题</div>
			<div>新功能建议</div>
			<div>其他</div>
		</div>
		<div class="bz_1">
		    <textarea maxlength="500" class="bz_1_ipt" placeholder="请输入备注,也可不填"></textarea>
		    <div class="bz_1_bj">
		        <span class="bz_1_bj_nbr">0</span>/500
		    </div>
		</div>
		<div class="advice_body_photo">
			<div id="picker" class="advice_body_photo_take" style="border: 1px solid black; border-radius:2px;background: url(<?php echo IMG;?>/photo.png) no-repeat center; background-size: 0.84rem 0.64rem;"></div>
			<div class="advice_body_photo_take limg1"></div>
			<div class="advice_body_photo_take limg2"></div>
			<div class="advice_body_photo_take limg3"></div>
		</div>
		<div class="advice_zhu">注：订单相关问题请拨打400-888-9610获得及时帮助</div>
		<div class="advice_phone">
			<div>手机号：</div>
			<input class="phone" type="text"/>
		</div>
		<div class="advice_button">确定</div>
	</body>
</html>
<script>
	
	$('.advice_button').click(function(){
		var images = {};
		var data = {};
		for(x in img){
			images[x] = img[x];
		}
		
		$('.advice_body_tip div').each(function(i){
			if($(this).css('borderColor') == 'rgb(248, 54, 0)'){
				data.y_type = $(this).html(); 
			}
		})
		data.y_info  = $('.bz_1_ipt').val();
		data.y_phone = $('.phone').val();
		data.y_images = images;
		data.user_id = "<?php echo $output['user']['user_id']?>";
		var url = '/api/api.php?commend=yijianfankui';
		$.post(url,{data:data},function(state){
			if(state.msg.code == 1){
				alert(state.msg.msg);
			}else{
				alert(state.msg.msg);
			}
		},'json');
	//	console.log(data);
	});
	
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
#picker .webuploader-pick{
	background:url(<?php echo IMG;?>/photo.png) no-repeat center; background-size: 0.84rem 0.64rem;
	padding:0;
	left:0px;
	margin-left:0px;
	width:100%;
	height:100%
}
.advice_body_photo_take {
	border: 0px solid #000;
	border-radius: 2px;
}
</style>