<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title>订单确认</title>
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
	</head>
<body>
	<div class="main_model" style="display:none;height:100%;background: #000000;filter: alpha(opacity=30);opacity: 0.3;position:fixed;left:0px;top:0px;width:100%;height:100%;z-index: 1;"></div>
	<div class="main">
		<form id="form" action="" method="post">
			<div class="main_phone">手机号：<?php echo isset($output['order']['mobile'])?$output['order']['mobile']:''?></div>
			<input type="hidden" id="order_id" name="order_id" value="<?php echo isset($output['order']['order_id'])?$output['order']['order_id']:''?>">
			<input type="hidden" id="sign" name="sign" value="<?php echo isset($output['order']['sign'])?$output['order']['sign']:''?>">
			<input type="hidden" id="phone" name="phone" value="<?php echo isset($output['order']['mobile'])?$output['order']['mobile']:''?>">
			<input type="hidden" id="user_id" name="user_id" value="<?php echo isset($output['order']['user_id'])?$output['order']['user_id']:''?>">
			<div class="main_code">
				<input name="yanzhengma" value="" />
				<div class="kedianji" onclick="send_phone_code()" id="send_phone_code">发送验证码</div>
			</div>
			<div style='text-align:center; margin-bottom:10px'>收不到验证码？<div onclick="voice_code_send()"><span class="voice_code" style="color:#ffc603">点此获取语音验证码</span></div></div>
			<div style='text-align:center'>请拨打客服电话 <a href="tel:4008889610">400-888-9610</a></div>
			<div class="main_code code_show">
				<div style="text-align:center;margin-bottom:15px;font-family:'微软雅黑';">图形验证码</div>
				<div style="overflow:hidden;margin-bottom:15px">
					<input id="tupianyanzhengma" name="tupianyanzhengma"  placeholder="请输入验证码" />
					<img id="captcha"  src="index.php?act=<?php echo $_GET['act'];?>&op=captcha" onclick="this.src='index.php?act=<?php echo $_GET['act'];?>&op=captcha&'+Math.random();">
				</div>
				<div class="queding" style="border-radius:5px;width:80%;background:#ffc603; height:35px; line-height:35px;text-align:center;color:white;font-size:20px;margin:0 auto">确定</div>
			</div>
			<div class="main_press" onclick="enter()" >确认</div>
		</form>
	</div>
</body>
</html>
<style>
	a{
		text-decoration:none;
		color:#000000;
	}
	*{
		margin:0;
		padding:0;
	}
	body,html{
		      width: 100%;
	       	 height: 100%;
	}
	body{
		background:url('<?php echo IMG;?>/hyq_bg.png') no-repeat top center;
		background-size:200px 200px;
	}
	.main{
		padding-top:50%;
	}
	.main_phone{
		text-align:center;
		font-size:20px;
	}
	.main_code{
		overflow:hidden;
		width:70%;
		margin:0 auto;
		margin-top:35px;
		margin-bottom:20px;
	}
	.main_code input{
		float:left;
		width:50%;
		height:25px;
	}
	.main_code .kedianji{
		float:right;
		width:45%;
		height:25px;
		line-height:25px;
		font-size:14px;
		text-align:center;
		color:#ffffff;
	}
	.main_code img{
		width:35%;
		float:right;
		height:35px;
	}
	.main_press{
		position:fixed;
		background:#ffc603;
		width:100%;
		color:#ffffff;
		text-align:center;
		border-radius:2px;
		bottom:0;
		height:50px;
		font-size:20px;
		line-height:50px
	}
	.kedianji{
		background:#ffc603;
	}
	.bukedianji{
		background:#cccccc;
	}
	.code_show{
		display:none;
		position:absolute;
		width:60%;
		background:#ffffff;
		padding:5%;
		left:15%;
		top:25%;
		z-index:2;
		border-radius:5px;
	}
	.code_show input{
		height:35px;
		border-radius:3px;
		outline:none;
		padding:2px;
		width:55%;
		font-family:"微软雅黑";
	}
</style>
<script>
	
	function send_phone_code(){
		$('#captcha').attr('src','index.php?act=<?php echo $_GET['act'];?>&op=captcha&'+Math.random())
		$('.code_show').show();
	}
	$('.queding').click(function(){
		$('.code_show').hide();
		var url = '/api/api.php?commend=is_captcha';
		var captcha = $('#tupianyanzhengma').val();
		$.post(url,{captcha:captcha},function(data){
			if(data.msg.code == '1'){
				post_phone_code();
			}else{
				alert(data.msg.msg);
			}
		},'json');
	});
	var flag = true;
	function post_phone_code(){
		
		if(flag){
			flag = false;
			var uri = '/api/api.php?commend=send_phone_code';
			var time = 60;
			var phone = $('#phone').val();
			var sign = $('#sign').val();
			var order_id = $('#order_id').val();
			var user_id = $('#user_id').val();
			var captcha = $('#tupianyanzhengma').val();
			$.post(uri,{phone:phone,order_id:order_id,sign:sign,user_id:user_id,captcha:captcha},function(state){
				if(state.msg.code == 1){
					var send = setInterval(function(){
						if(time <= 0){
							flag  = true;
							clearInterval(send);
							$('#send_phone_code').html('重新发送');
							voice_code.html("点此获取语音验证码");
							$('#send_phone_code').removeClass('bukedianji');
							is_voice = true;
						}else{
							$('#send_phone_code').html('重新发送（'+ time +'）');
							voice_code.html("点此获取语音验证码(" + time + ")");
							$('#send_phone_code').addClass('bukedianji');
						}
						time--;
					},1000);
				}
			},'json');
		}
	}
	function enter(){
		$('#form').submit();
	}
	
	var is_voice = false;
	var time_num = 60;
	voice_code = $('.voice_code');
	function voice_code_send(){
		if(is_voice){
			is_voice = false;
			var send_v = setInterval(function(){
				time_num--;
				if(time_num < 0){
					is_voice = true;
					clearInterval(send_v);
					time_num = 60;
					voice_code.html("点此获取语音验证码");
				}else{
					voice_code.html("点此获取语音验证码(" + time_num + ")");
				}
			},1000);
			$.post('/api/api.php?commend=send_voice_code','',function(data){
				
			},'json');
		}
		return false;
	};
</script>
