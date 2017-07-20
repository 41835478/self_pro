<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title></title>
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-2.1.4.min.js"></script>
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
		<form id="commit_duihuanma" action="?act=user&op=get_duihuanma" method="post">
		<input name="d_code" type="text" placeholder="请输入优惠卷兑换码" style='height:0.9rem;width:97%;border: none;outline: none;font-size: 0.3rem;font-family:"黑体";color:#323232;padding-left:3%;'/>
		</form>
		<div class="bangding get_duihuanma" style='height: 0.7rem;width:7.1rem;margin: 0 auto;font-size: 0.3rem;font-family:"黑体";color:#ffffff;background: #ffc603;text-align: center;line-height: 0.7rem;margin-top: 0.4rem;}'>立即兑换</div>
	</body>
</html>
<script>
	$('.get_duihuanma').click(function (){
		$('#commit_duihuanma').submit();
	});
</script>