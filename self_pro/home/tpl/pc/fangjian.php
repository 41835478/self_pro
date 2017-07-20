<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>房间</title>
    <style>
        html {
            background-color:#FAFAFA;
            height:110%;
        }
        body{
            height:110%;
        }

    </style>
</head>
<body>
   
    <div class="fangjtz">
        <div class="fangjtz_1">
            <div class="fangjtz_1_a">
				<!--
                <div>Nickname</div>
                <div>早上好</div>
				-->
                <div>欢迎来到黑眼圈潮趴馆</div>
                <div>祝您玩得愉快！</div>
            </div>
        </div>
        <div class="fangjtz_2">我 的 服 务</div>
        <div class="fangjtz_3">
            <ul class="fangjtz_3_ul">
                <!--<a href="?act=guanjia&op=hujiaoguanjia&order_id=<?php echo $output['order']['order_id']?>">-->
                <a href="tel:<?php if(isset($output['guanjia']) && !empty($output['guanjia']['guanjia_phone'])){ echo $output['guanjia']['guanjia_phone']; }else{ echo '18317035582'; } ?>">
					<li class="fangjtz_3_all fangjtz_3_a" style='border-right:0.01rem solid #c1c1c1;'>
						<div>呼叫管家</div>
					</li>
				</a>
                <li class="fangjtz_3_all fangjtz_3_b">
                    <div>启动娃娃机</div>
                </li>
				<a href="?act=order&op=fangxiao2&order_id=<?php echo $output['order']['order_id']?>">
					<li class="fangjtz_3_all fangjtz_3_c" style='border-right:0.01rem solid #c1c1c1;'>
						<div>房间消费</div>
					</li>
				</a>
                <li class="fangjtz_3_all fangjtz_3_d" style='border-bottom:0.01rem solid #c1c1c1;'>
                    <div>连接wifi</div>
                </li>
				<a href="?act=goods&op=shangpinzulin&store_id=<?php echo $output['order']['store_id'];?>&order_id=<?php echo $output['order']['order_id']?>">
					<li class="fangjtz_3_all fangjtz_3_ccc" style='border-bottom:0.01rem solid #c1c1c1;border-right:0.01rem solid #c1c1c1;'>
						<div>商品租赁</div>
					</li>
				</a>
            </ul>
        </div>
    </div>

    <div class="fangjtz_wifi fade">
        <div class="fangjtz_cha">×</div>
        <div class="clear"></div>
        <div class="fangjtz_wifi_f01">账号 ：<?php echo $output['store']['wifi_user']?></div>
        <div class="fangjtz_wifi_f01">密码 ：<?php echo $output['store']['wifi_pass']?></div>
        <div class="fangjtz_wifi_img" style="background:url(<?php echo $output['store']['wifi_logo']?>) no-repeat;background-size:100% 100%"></div>
        <div class="fangjtz_wifi_f02">使用360免费wifi扫一扫</div>
        <div class="fangjtz_wifi_f02">即可自动连接上无线网</div>
    </div>
	<footer class="footer">
		<div class="table fs12 bt bgf tc footer_wrap">
			<a style="text-decoration:none;" href="index.php" class="table-cell vm "><i class="ft-icon-plan"></i>首页</a>
			<a style="text-decoration:none;" href="" class="table-cell vm on"><i class="ft-icon-notice"></i>房间</a>
			<a style="text-decoration:none;" href="?act=user&op=person_info" class="table-cell vm" ><i class="ft-icon-friends"></i>我的</a>
		</div>
	</footer>
	<div class='fangjwwj_111 fade'></div>
	<div class='fangjwwj fade'>
		<div class='fangjwwj_cha'>×</div>
		<ul style='height:100%;'>
			<li style='background-color:#fafafa;height:65%;'>
				<a href='http://www.huake-weixin.com/o2oali/index.php/addon/YiKaTong/Deposit/wxl?C=1020170317000622' style='display:inline-block;width:100%;height:100%;'>
					<div style='font-size:.4rem;margin-top:.1rem;'>大娃</div>
					<div style='font-size:.3rem;'>(厕所旁)</div>
				</a>
			</li style='background-color:#fff;height:65%;'>
			<li>
				<a href='http://www.huake-weixin.com/o2oali/index.php/addon/YiKaTong/Deposit/wxl?C=1020170317000616' style='display:inline-block;width:100%;height:100%;'>
					<div style='font-size:.4rem;margin-top:.1rem;'>二娃</div>
					<div style='font-size:.3rem;'>(窗户旁)</div>
				</a>
			</li>
		</ul>
	</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<style>
a{
    text-decoration:none;
	color:#323232;
}
a:active{
	color:#323232;
    text-decoration:none;
}
a:focus{
	color:#323232;
    text-decoration:none;
}
	.footer_wrap a{
		color:#000;
	}
	.fangjwwj_111{
		position:fixed;
		top:0;
		left:0;
		width:100%;
		height:100%;
		background-color:black;
		opacity:.3;
	}
	.fangjwwj{
		position:fixed;
		top:40%;
		left:10%;
		width:80%;
		height:15%;
		background-color:#fff;
		z-index:99999;
		border-radius:0.07rem;
	}
	.fangjwwj ul li{
		float:left;
		width:50%;
		text-align:center;
		font-size:.4rem;
	}
	.fangjwwj_cha{
		font-size:.5rem;
		padding-right:.1rem;
		text-align:right;
		height:35%;
		background-color:#ffc603;
	}
</style>
<script>

$('.fangjtz').css({
	opacity:1,
	transition:'opacity 1s linear'
})
$('.ttttttttt').css({
	opacity:0,
	transition:'opacity 1s linear'
})

/* 娃娃机 */

$('.fangjtz_3_b').on('click',function(){
	$('.fangjwwj_111').removeClass('fade');
	$('.fangjwwj').removeClass('fade');
})
$('.fangjwwj_cha').on('click',function(){
	$('.fangjwwj_111').addClass('fade');
	$('.fangjwwj').addClass('fade');
})
</script>