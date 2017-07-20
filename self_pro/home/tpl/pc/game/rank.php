<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0" />
		<title></title>
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
	</script>
<style>
	html{
		width:100%;
		height:100%;
	}
	*{
		margin: 0;
		padding: 0;
	}
</style>
	<body style="width:100%;height:80%;padding-top:20%;background: url(<?php echo TPL;?>/game/rankbg.png) center; background-size:cover;overflow: hidden;">
		<div style="margin:0 auto;width:5.34rem; height:8.40rem;padding-top:0.2rem;background: url(<?php echo TPL;?>/game/rankbg_head.png) center; background-size:cover;">
			<div style="margin:0 auto;margin-bottom:0.1rem;width: 90%; height: 2rem;background: url(<?php echo TPL;?>/game/rankbg_rua.png) center; background-size:cover;"></div>
			<?php if(isset($output['data']) && !empty($output['data'])){ ?>
			<?php foreach($output['data'] as $key => $val){ ?>
			<div style="position:relative;margin:0 auto;margin-bottom:0.1rem;border-radius:0.5rem;width: 90%; height: 1rem ; background-color:#eaeaea">
				<div style="position:absolute;left:0.1rem;border-radius:50%;width:0.8rem;height:0.8rem;"><img style="width:100%;height:100%;border-radius: 50%;" src="<?php echo $val['user_logo'];?>"/></div>
				<div style="position:absolute;top:0.14rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fe0000">NO.<?php echo $key+1;?></div>
				<div style="position:absolute;top:0.54rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:"><?php echo $val['nickname'];?></div>
				<div style="position:absolute;top:0.3rem;right:0.4rem;width:0.8rem;height:0.4px;font-size:0.24rem;font-family: '微软雅黑';line-height: 0.4rem;color:#fe0000"><?php echo $val['num'];?>关</div>
			</div>
			<?php } ?>
			<?php } ?>
			<!--
			<div style="position:relative;margin:0 auto;margin-bottom:0.1rem;border-radius:0.5rem;width: 90%; height: 1rem ; background-color:#eaeaea">
				<div style="position:absolute;top:0.1rem;left:0.1rem;border-radius:50%;width:0.8rem;height:0.8rem;background-color:black;"><img src=""/></div>
				<div style="position:absolute;top:0.14rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fe0000">NO.1</div>
				<div style="position:absolute;top:0.54rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:"></div>
				<div style="position:absolute;top:0.3rem;right:0.4rem;width:0.8rem;height:0.4px;font-size:0.24rem;font-family: '微软雅黑';line-height: 0.4rem;color:#fe0000">20关</div>
			</div>
			<div style="position:relative;margin:0 auto;margin-bottom:0.1rem;border-radius:0.5rem;width: 90%; height: 1rem ; background-color:#eaeaea">
				<div style="position:absolute;top:0.1rem;left:0.1rem;border-radius:50%;width:0.8rem;height:0.8rem;background-color:black;"><img src=""/></div>
				<div style="position:absolute;top:0.14rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fe0000">NO.1</div>
				<div style="position:absolute;top:0.54rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:">李凯</div>
				<div style="position:absolute;top:0.3rem;right:0.4rem;width:0.8rem;height:0.4px;font-size:0.24rem;font-family: '微软雅黑';line-height: 0.4rem;color:#fe0000">20关</div>
			</div>
			<div style="position:relative;margin:0 auto;margin-bottom:0.1rem;border-radius:0.5rem;width: 90%; height: 1rem ; background-color:#eaeaea">
				<div style="position:absolute;top:0.1rem;left:0.1rem;border-radius:50%;width:0.8rem;height:0.8rem;background-color:black;"><img src=""/></div>
				<div style="position:absolute;top:0.14rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fe0000">NO.1</div>
				<div style="position:absolute;top:0.54rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:">李凯</div>
				<div style="position:absolute;top:0.3rem;right:0.4rem;width:0.8rem;height:0.4px;font-size:0.24rem;font-family: '微软雅黑';line-height: 0.4rem;color:#fe0000">20关</div>
			</div>
			<div style="position:relative;margin:0 auto;margin-bottom:0.1rem;border-radius:0.5rem;width: 90%; height: 1rem ; background-color:#eaeaea">
				<div style="position:absolute;top:0.1rem;left:0.1rem;border-radius:50%;width:0.8rem;height:0.8rem;background-color:black;"><img src=""/></div>
				<div style="position:absolute;top:0.14rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fe0000">NO.1</div>
				<div style="position:absolute;top:0.54rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:">李凯</div>
				<div style="position:absolute;top:0.3rem;right:0.4rem;width:0.8rem;height:0.4px;font-size:0.24rem;font-family: '微软雅黑';line-height: 0.4rem;color:#fe0000">20关</div>
			</div>
			-->
			<div style="position:relative;margin:0 auto;margin-bottom:0.1rem;border-radius:0.5rem;width: 90%; height: 1rem ;background-color:#fe0000;border:1px solid #000">
				<div style="position:absolute;left:0.1rem;border-radius:50%;width:0.8rem;height:0.8rem;"><img style="width:100%;height:100%;border-radius: 50%;" src="<?php echo $output['my']['user_logo'];?>"/></div>
				<div style="position:absolute;top:0.14rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fff">NO.<?php echo !empty($output['my_rank'])?$output['my_rank']:'?';?></div>
				<div style="position:absolute;top:0.54rem;left:1.1rem;width:2rem;height:0.36rem;font-size:0.18rem;font-family: '微软雅黑';line-height:0.36rem;color:#fff"><?php echo $output['my']['nickname'];?></div>
				<div style="position:absolute;top:0.3rem;right:0.4rem;width:0.8rem;height:0.4px;font-size:0.24rem;font-family: '微软雅黑';line-height:0.4rem;color:#fff"><?php echo !empty($output['my']['num'])?$output['my']['num']:'0';?>关</div>
			</div>
		</div>
	</body>
</html>
