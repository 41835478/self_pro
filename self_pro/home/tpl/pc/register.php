<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<!-- 样式 -->
<link rel="stylesheet" href="<?php echo CSS?>/register.css">
   
	<!-- 普通类型注册 -->
	<?php if(isset($output['pt_register'])){ ?> 
	<form action="" method="" >
		<input type="hidden" id="register_type" name="register_type" value="pc">
		<input type="hidden" id="register_type2" name="register_type2" value="user">
		<span id="msg">出错信息</span>
		用户名：<input id="user_name" type="text" name="user_name" placeholder="用户名">
		密码：<input id="password" type="password" name="user_password" placeholder="密码">
		手机号：<input id="phone" type="text" name="phone" placeholder=""><a id="phone_yz" onclick="phone_yz()" ><span id="phone_send">手机号验证</span></a>
		手机验证码：<input id="phone_captcha" type="text" name="phone_captcha" placeholder="手机验证码">
		验证码：<input id="captcha" type="text" name="captcha" placeholder="">
		<img id="yzm" onclick="yzm_rep()" src="api/api.php?commend=captcha&type=register"  ><a id="no_see" onclick="yzm_rep()">看不清，换一张</a>
		<a id="register" onclick="register()" >注册</a><a id="login" href="?act=login&op=index">已有账号，登陆</a>
	</form>
	<?php } ?>
	<!-- 普通类型注册 -->
	
	<!-- 邮箱类型注册 -->
	<?php if(isset($output['email_register'])){ ?> 
	<form action="" method="" >
		<input type="hidden" id="register_type" name="register_type" value="pc">
		<input type="hidden" id="register_type2" name="register_type2" value="email">
		<span id="msg">出错信息</span>
		邮箱：<input id="user_name" type="text" name="user_name" placeholder="请输入邮箱">
		密码：<input id="password" type="password" name="user_password" placeholder="密码">
		手机号：<input id="phone" type="text" name="phone" placeholder=""><a id="phone_yz" onclick="phone_yz()" ><span id="phone_send">手机号验证</span></a>
		手机验证码：<input id="phone_captcha" type="text" name="phone_captcha" placeholder="手机验证码">
		验证码：<input id="captcha" type="text" name="captcha" placeholder="">
		<img id="yzm" onclick="yzm_rep()" src="api/api.php?commend=captcha&type=register"  ><a id="no_see" onclick="yzm_rep()">看不清，换一张</a>
		<a id="register" onclick="register()" >注册</a><a id="login" href="?act=login&op=index">已有账号，登陆</a>
	</form>
	<?php } ?>
	<!-- 邮箱类型注册 -->
	
	<!-- 手机类型注册 -->
	<?php if(isset($output['mobile_register'])){ ?> 
	<form action="" method="" >
		<input type="hidden" id="register_type" name="register_type" value="pc">
		<input type="hidden" id="register_type2" name="register_type2" value="mobile">
		<span id="msg">出错信息</span>
		手机号：<input id="phone" type="text" name="phone" placeholder=""><a id="phone_yz" onclick="phone_yz()" ><span id="phone_send">手机号验证</span></a>
		<input id="user_name" type="hidden" name="user_name" placeholder="">
		手机验证码：<input id="phone_captcha" type="text" name="phone_captcha" placeholder="手机验证码">
		密码：<input id="password" type="password" name="user_password" placeholder="密码">
		验证码：<input id="captcha" type="text" name="captcha" placeholder="">
		<img id="yzm" onclick="yzm_rep()" src="api/api.php?commend=captcha&type=register"  ><a id="no_see" onclick="yzm_rep()">看不清，换一张</a>
		<a id="register" onclick="register()" >注册</a><a id="login" href="?act=login&op=index">已有账号，登陆</a>
	</form>
	<?php } ?>
	<!-- 手机类型注册 -->
<script>
	function yzm_rep(){
		//onclick="this.src='api/api.php?commend=captcha&type=register&num='+Math.random();"
		var src = 'api/api.php?commend=captcha&type=register&num='+Math.random();
		$('#yzm').attr('src',src);
	}
	
	var reg_user = /^[a-zA-Z0-9\.@]+$/;
	var reg_pass = /^[a-zA-Z0-9]+$/;
	var reg_phone = /^[0-9]{11}$/;
	function register(){
		//邮箱注册
		<?php if(isset($output['email_register'])){ ?>
			reg_user = /[\w+]@[\w+]{1,3}\.[\w+]{1,4}/;  
		<?php } ?>
		//手机注册
		<?php if(isset($output['mobile_register'])){ ?>
			reg_user = /^[0-9]{11}$/;  
			phone = $('#phone').val();
			$('#user_name').val(phone);
		<?php } ?>
		var user_name = $('#user_name').val();
		var password = $('#password').val();
		var phone = $('#phone').val();
		var captcha = $('#captcha').val();
		var phone_captcha = $('#phone_captcha').val();
		//用户名验证
		if(user_name == ''){
			$('#msg').html('请输入用户名');
			return false;
		}
		if(!reg_user.exec(user_name)){
			$('#msg').html('用户名输入不正确');
			return false;
		}
		if(password == ''){
			$('#msg').html('请输入密码');
			return false;
		}
		if(!reg_pass.exec(password)){
			$('#msg').html('请输入字母加数字的组合');
			return false;
		}
		if(phone == ''){
			$('#msg').html('请输入手机号');
			return false;
		}
		if(!reg_phone.exec(phone)){
			$('#msg').html('手机输入错误');
			return false;
		}
		if(captcha == ''){
			$('#msg').html('请输入验证码');
			return false;
		}
		if(phone_captcha == ''){
			$('#msg').html('请输入手机验证码');
			return false;
		}
		
		var url = 'api/api.php?commend=register';
		var data = {};
		data.user_name = user_name;
		data.password = password;
		data.phone = phone;
		data.captcha = captcha;
		data.phone_captcha = phone_captcha;
		data.register_type =  $('#register_type').val();
		data.register_type2 =  $('#register_type2').val();
		console.log(data);
		$.post(url,data,function (state){
			if(state.code == 200 && state.data == 200){
				//注册成功
				var success_href = '?act=user&op=index';
				window.location.href = success_href;
			}else{
				$('#msg').html(state.msg);
			}
		},'json');
		
	}
	
	var time_num = 300;
	var time_speel = 0;
	var default_str = '手机号验证';
	var time_bool = true;	
	function phone_yz(){
		var phone = $('#phone').val();
		if(time_bool){
			//请求手机号
			var return_bool = false; 
			if(phone == ''){
				$('#msg').html('请输入手机号');
				return return_bool;
			}
			if(!reg_phone.exec(phone)){
				$('#msg').html('手机号输入错误');
				return return_bool;
			}
			var date = [];
			var url = 'api/api.php?commend=send_phone';
			$.post(url,{type:'register',phone:phone},function(state){
				if(state.code == 200){
					time_bool = false;
					time_speel = time_num;
					var time_send = setInterval(function(){
						time_speel--;
						$('#phone_send').html(time_speel);
						if(time_speel <= 0){
							time_speel = time_num;
							time_bool = true;
							$('#phone_send').html(default_str);
							clearInterval(time_send); //清除自己
						}
					},1000);
				}
			}
			,'json');
		}
	}
	 
</script>
</body>
</html>
