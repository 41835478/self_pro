<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>/order_over.css">
	</head>
	<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
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
	    $(function(){
		    var imp_width=window.screen.width;
		    imp_height_head=imp_width*420/750;
		    $('.order_over_head').css("height",imp_height_head);  
	    })
	</script>
	<body>
		<div class="order_over_head" style="background:url(<?php echo IMG;?>/order_over_head.jpg) no-repeat center; background-size:cover;">
			<div class="order_over_head_success" style="background: url(<?php echo IMG;?>/order_success.png) no-repeat center; background-size:cover;"></div>
		</div>
		<div class="order_over_body">
			<div class="order_over_body_head">订单交易成功</div>
			<div class="order_over_body_body">
				<a href="?act=order&op=order_list"><div class="order_over_body_body_l">查看订单</div></a>
				<a href="index.php"><div class="order_over_body_body_r">返回首页</div></a>
			</div>
		</div>
		<div class="order_over_footer">
			<p>安全提醒</p>
			<p>付款成功后，黑眼圈潮趴馆不会以付款异常、卡单、系统升级为由联系您。请勿泄露银行卡号、手机验证码，否则会造成欠款损失。谨防电话诈骗！<p>
			<?php if($output['order']['store_id'] == 2){ ?>
			<div class="order_over_footer_ptg">
			<p>黑眼圈潮趴馆用户预订须知（下沙大学店）</p>
			<p>黑眼圈潮趴馆保利江语海店依傍在黄埔江畔，坐落在保利江语海别墅区8栋。由于保利江语海是高档别墅区，居住着很多年纪大的爷爷奶奶。为了更好的爱护老人，保持别墅区宁静优美的居住环境，预定黑眼圈潮趴馆的用户需遵守以下别墅区规定，如对您造成不便，敬请谅解。</p>
			<p>1.进入别墅区后请尽量不要再公共区域发出大的声响，以免打扰到其他住户休息（PS：别墅区有很多可爱的老爷爷和老奶奶，请在外面保存体力，安静的进入轰趴馆后放飞自我）</p>
			<p>2.如用户开车进来，请尽量停在小区门口停车场，如需开入别墅，请提前联系管家（PS：别墅里面都是私人停车位，容量有限，请各位大大谅解我们的不易）
				尊敬的黑眼圈潮趴馆用户，如果您有任何需求或有任何问题，请及时联系我们的管家，祝您在黑眼圈潮趴馆获得极致的娱乐体验，还有神秘礼品赠送哦~~</p>
				</div>
			<?php } ?>
			<?php if($output['order']['store_id'] == 5){ ?>
		<div class="order_over_footer_ptg">
			<p>黑眼圈潮趴馆用户预订须知（越都名府店）</p>
<p>黑眼圈潮趴馆越都名府店毗邻柯岩风景区，坐落在柯岩大道310号越都名府别墅区寓林园5区7号。由于越都名府别墅区是高档别墅区，居住着很多年纪大的爷爷奶奶。为了更好的爱护老人，保持别墅区宁静优美的居住环境，预定黑眼圈潮趴馆的用户需遵守以下别墅区规定，如对您造成不便，敬请谅解。</p>
			<p>1.进入别墅区需登记您的身份证，在门卫处录入您的身份证号。（PS:别墅区录入身份证号也是为了能够确保进出别墅人员的安全，请用户们谅解门卫大叔的一番苦心）</p>
			<p>2.进入别墅区后请尽量不要再公共区域发出大的声响，以免打扰到其他住户休息（PS：别墅区有很多可爱的老爷爷和老奶奶，请在外面保存体力，到了轰趴馆再放飞自我）</p>
			<p>3.如用户开车进来，请尽量停在小区门口停车场，如需开入别墅，请提前联系管家（PS：别墅里面都是私人停车位，容量有限，请各位大大谅解我们的不易）
			尊敬的黑眼圈潮趴馆用户，如果您有任何需求或有任何问题，请及时联系我们的管家，祝您在黑眼圈潮趴馆获得极致的娱乐体验</p>
			</div>
			<?php } ?>
		</div>
	</body>
</html>
