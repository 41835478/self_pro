<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title></title>
		<link rel="stylesheet" href="<?php echo CSS;?>/dakehu.css" />
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
		<script>
			$(function(){
				$('input').keyup(function(){
					if($('input').val()!=""){
						$('.bangding').css('background','#ffc603')
					}else{
						$('.bangding').css('background','#d3d3d3')
					}
				})							
			})
		</script>
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
		</script>
	</head>
	<body style="background: #fbfbfb">
		<input type="text" placeholder="企业/大客户代码"/>
		<div class="bangding">立即绑定</div>
		<div class="case">成为黑眼圈潮趴会员，可享受更多优惠</div>
	</body>
</html>
