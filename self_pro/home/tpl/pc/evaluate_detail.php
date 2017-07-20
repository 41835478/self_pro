<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>评价晒单</title>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/evaluate_detail.css">
		<script type="text/javascript" src="<?php echo JS;?>/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo JS;?>/star.js"></script>	
		<script type="text/javascript" src="<?php echo JS;?>/jquery.raty.min.js"></script>
		<link rel="stylesheet" href="<?php echo CSS;?>/webuploader.css" />
		<script type="text/javascript" src="<?php echo JS;?>/webuploader.js" ></script>
	</head>
	<div id="uploader" class="wu-example" style="display:none">
		<!--用来存放文件信息-->
		<div id="thelist" class="uploader-list"></div>
		<div class="btns">
			<button id="ctlBtn" class="btn btn-default">开始上传</button>
		</div>
	</div>
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
		});
	</script>
	<body style="background:#f5f5f5;">
		<div class="evaluate_head">
			<div class="evaluate_head_img"></div>
			<div class="evaluate_head_text">
				<div>评分<span>（满意请给5星哦）</span></div>
				<div class="demo">
		           <div id="click-demo" ttt="pingfen"></div>
		    	</div>
			</div>
		</div>
		<div class="bz_1">
		    <textarea maxlength="500" class="bz_1_ipt  message" placeholder="写下别墅轰趴体验和设施的使用感受来帮助其他小伙伴~超过20个字即有机会获得积分~"></textarea>
		    <div class="bz_1_bj">
		        <span class="bz_1_bj_nbr">0</span>/500
		    </div>
		</div>
		<div class="advice_body_photo">
			<div id="picker" class="advice_body_photo_take" ></div>
			<div class="advice_body_photo_take advice_body_photo_take_l limg1"></div>
			<div class="advice_body_photo_take advice_body_photo_take_l limg2"></div>
			<div class="advice_body_photo_take advice_body_photo_take_l limg3"></div>
		</div>
		<div class="evaluate_foot">
			<div class="evaluate_foot_1">管家服务评价<span>（满意请给5颗星哦）</span></div>
			<div class="evaluate_foot_2" style="overflow:hidden">
				<div style="float: left;">服务态度</div>
      			<div class="demo" style="float: left;margin-top: 0;">
           			<div ttt="taidu" id="taidu" class="star-off-and-star-on-demo"></div>
         		</div>
			</div>
		    <div class="evaluate_foot_2" style="overflow:hidden">
				<div style="float: left;">服务速度</div>
      			<div  class="demo" style="float: left;margin-top: 0;">
           			<div  ttt="sudu"  id="sudu" class="star-off-and-star-on-demo"></div>
         		</div>
			</div>
			<div class="evaluate_foot_2" style="overflow:hidden">
				<div style="float: left;">服务质量</div>
      			<div  class="demo" style="float: left;margin-top: 0;">
           			<div ttt="zhiliang"  id="zhiliang" class="star-off-and-star-on-demo"></div>
         		</div>
			</div>
		</div>
		<div class="bz_1">
		    <textarea maxlength="500" class="bz_1_ipt message2" placeholder="请你对管家的印象和服务做出评价，来帮助我们提升服务质量"></textarea>
		    <div class="bz_1_bj">
		        <span class="bz_1_bj_nbr">0</span>/500
		    </div>
		</div>
		
		<div class="evaluate_order">
			<div>晒单分享</div>
			<div onclick="tijiaopingjia()">提交评价</div>
		</div>
	</body>
</html>
<script>
var pingfen = {};
$(function() {
		
      $.fn.raty.defaults.path = '<?php echo IMG;?>';
      $('#click-demo').raty({
        click: function(score, evt) {
        //  console.info('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
		  pingfen[$(this).attr('ttt')] = score;
        }
      });
     $('#click-demo').css('width','4.8rem');
     $('.star-off-and-star-on-demo').raty({
	        path   : '<?php echo IMG;?>',
	        starOff: 'heart_off.png',
	        starOn : 'heart_on.png',
        	click: function(score, evt) {
		//	console.info('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
			pingfen[$(this).attr('ttt')] = score;
        }
      });
        $('.star-off-and-star-on-demo').css('width','4.8rem')
    });
</script>
<script>
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
var images = {};
function tijiaopingjia(){
	for(x in img){
		images[x] = img[x];
	}
	pingfen.message = $('.message').val();
	pingfen.message2 = $('.message2').val();
	pingfen.order_id = "<?php echo $output['order']['order_id'];?>";
	pingfen.user_id = "<?php echo $output['user']['user_id'];?>";
	pingfen.sign = "<?php echo $output['order']['sign'];?>";
	pingfen.images = images;
	var url = "/api/api.php?commend=shaidanpingfen";
	$.post(url,{data:pingfen},function(state){
		if(state.msg.code == 1){
			alert(state.msg.msg);
			window.location.href = '?act=user&op=person_info';
		}else{
			alert(state.msg.msg);
		}
	},'json');
}

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
</style>