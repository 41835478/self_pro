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
            height:100%;
        }
        body{
            height:100%;
        }
		.saoma{
            position: absolute;
            top:12%;
            left:15%;
            width:70%;
            padding:.2rem 0 1rem;
            background-color:#fff;
            border-radius: .07rem;
			z-index:10;
        }
        .saoma111{
            margin: auto;
            width:4rem;
            height:4rem;
            border-radius: .07rem;
        }
		.saoma111 img{
            margin: auto;
            width:4rem;
            height:4rem;
            border-radius: .07rem;
        }
        .saoma222{
            font-size: .4rem;
            width:4rem;
            background-color:#ffc603;
            margin: auto;
            text-align: center;
            border-radius: .1rem;
            margin-top:1rem;
            padding:.2rem 0;
            color:#fff;
            font-weight: bold;
        }
		.saoma000{
			font-size:.5rem;
			text-align:right;
			padding-right:.3rem;
			margin-bottom:.2rem;
			font-weight:bold;
		}
    </style>
</head>
<body>
	
	
	<div class="ttttttttt">
        <div class="ttttttttt_1">
			
            <div class="ttttttttt_2"></div>
            <div class="ttttttttt_3">扫码,开启轰趴之旅</div>
        </div>
    </div>
	
	<!--
    <div class="fangjtz">
        <div class="fangjtz_1">
            <div class="fangjtz_1_a">
				<!--
                <div>Nickname</div>
                <div>早上好</div>
				
                <div>欢迎来到黑眼圈潮趴馆</div>
                <div>祝您玩得愉快！</div>
            </div>
        </div>
        <div class="fangjtz_2">我 的 服 务</div>
        <div class="fangjtz_3">
            <ul class="fangjtz_3_ul">
                <a href="">
					<li class="fangjtz_3_all fangjtz_3_a">
						<div>呼叫管家</div>
					</li>
				</a>
                <li class="fangjtz_3_all fangjtz_3_b">
                    <div>启动娃娃机</div>
                </li>
				<a href="?act=order&op=fangxiao2&order_id=<?php echo $output['order']['order_id']?>">
					<li class="fangjtz_3_all fangjtz_3_c">
						<div>房间消费</div>
					</li>
				</a>
                <li class="fangjtz_3_all fangjtz_3_d">
                    <div>连接wifi</div>
                </li>
            </ul>
        </div>
    </div>
	-->

    <!--<div class="fangjtz_wifi fade">
        <div class="fangjtz_cha">×</div>
        <div class="clear"></div>
        <div class="fangjtz_wifi_f01">账号 ：xiongmao2017</div>
        <div class="fangjtz_wifi_f01">密码 ：123456789</div>
        <div class="fangjtz_wifi_img"></div>
        <div class="fangjtz_wifi_f02">使用360免费wifr扫一扫</div>
        <div class="fangjtz_wifi_f02">即可自动连接上无线网</div>
    </div>-->
	<div class="saoma fade">
		<div class="saoma000">×</div>
        <div class="saoma111"><?php echo isset($output['img']) ? $output['img'] : '<img src="'.IMG.'/wechat.jpg'.'">' ;?></div>
		<?php if(isset($output['img'])){ ?>
		<div class="saoma222">点击进入 ﹥</div>
		<?php } ?>
       
    </div>
	<footer class="footer">
			<div class="table fs12 bt bgf tc footer_wrap">
				<a style="text-decoration:none;" href="index.php" class="table-cell vm on"><i class="ft-icon-plan" style="margin-left:1.03rem"></i></a>
		<!--		<a style="text-decoration:none;" href="?act=user&op=fangjian" class="table-cell vm"><i class="ft-icon-notice"></i>房间</a> -->
				<a style="text-decoration:none;" href="?act=user&op=person_info" class="table-cell vm" ><i class="ft-icon-friends" style="margin-left:2.28rem"></i></a>
			</div>
			<div style="height:1.2rem;width:0.9rem;position:absolute;top:-0.22rem;left:3.3rem;background: url(<?php echo IMG;?>/circleadd.png) no-repeat center;background-size:cover "><a href="?act=user&op=fangjian" style="display:block;height:1.2rem;width:0.9rem;"></a></div>
		</footer>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<style>
	.footer_wrap a{
		color:#000;
	}
</style>
<script>
$('.ttttttttt_3').on('click',function(){
	$('.saoma').removeClass('fade');
})
$('.saoma000').on('click',function(){
	$('.saoma').addClass('fade');
})
var order_id = "<?php echo $output['order']['order_id'];?>";
$('.saoma222').on('click',function(){
	window.location.href = "?act=user&op=fangjian&order_id=" + order_id;
})
</script>