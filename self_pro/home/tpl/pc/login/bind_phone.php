<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>绑定手机号</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="<?php echo TPL;?>/login/css/register.css">
	<script type="text/javascript" src="<?php echo TPL;?>/js/zepto-1.2.0.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL;?>/js/common.js"></script>
</head>
<body>
<!-- head -->
<div class="head">
    <div class="head_box col-xs-12">
        <div class="left_img col-xs-2 fl"><a href="javascript:;"><img src="<?php echo TPL;?>/login/img/back.png"/></a></div>
        <div class="head_txt col-xs-8 fl">绑定手机号</div>
        <div class="right_img col-xs-2 fl"></div>
    </div>
</div>
<div class="grayMargin"></div>

<!-- phone-number -->
<div class="phone-number-box col-xs-12">
    <div class="phone-num">
        <img class="fl" src="<?php echo TPL;?>/login/img/shouji.png"/>
        <input type="text" id="tel-num-input" placeholder="请输入手机号码">
    </div>
    <div class="phone-code">
        <img class="fl" src="<?php echo TPL;?>/login/img/yanzma.png"/>
        <input type="text" placeholder="请输入验证码" id="tel_number_code" class="fl">
        <button type="button" class="get-code fr" id="get-code">获取验证码</button>
    </div>
    <div class="passwd">
        <img class="fl" src="<?php echo TPL;?>/login/img/mima.png"/>
        <input type="password" id="password-input" class="col-xs-8" placeholder="请输入密码">
        <img class="pwd-img col-xs-2 fr" src="<?php echo TPL;?>/login/img/eyeopen.png"/>
    </div>
    <!--注册协议-->
    <div class="agreement">
        <span class="agreement-img"><img src="<?php echo TPL;?>/login/img/btnSelected.png"></span>
        <span class="read-text">我已阅读并同意</span>
        <span><a class="clause" href="/home/tpl/pc/login/agreement.html">娱社联服务协议</a></span>
    </div>
    <div class="phone-test" id="register-btn">绑定</div>
</div>
</body>
</html>
<script>
baseurl = '';
var id = "<?php echo $output['data']['id']?>";
//验证手机号
function checkMobile(phone) {
	if(!/^(13[0-9]|15[0-9]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(phone)){
		$("#tel-num-input").css('border-color','#f00');
		return false;
	}else{
		$("#tel-num-input").css('border-color','#e6e6e6');
		return true;
	}
}
//点击获取验证码
$("#get-code").click(function(){
	var $tel_num = $("#tel-num-input").val();
	if (!checkMobile($tel_num)) {
		alert("请输入正确的手机号");
	} else {
		$.ajax({
			type: 'POST',
			url: baseurl + '/api/api.php?commend=send_message',
			dataType: 'json',
			data: {phone: $tel_num},
			success: function (data) {
				console.log(data);
				if (data.code == "-1")
					alert(data.msg);
				else {
					codeTime();
				}
			}
		});
	}
});

//倒计时
function codeTime(){
	$(".get-code").css("background","#555");
	$(".get-code").text("60s重新发送");
	$(".get-code").attr('disabled',"true");
	var count = 60;
	var countId = setInterval(function(){
		count--;
		$(".get-code").text(count+'s 重新获取');
		if(count<0){
			clearInterval(countId);
			$(".get-code").css("background","#0E8EF9");
			$(".get-code").text("获取验证码");
			$(".get-code").removeAttr("disabled");
		}
	},1000);
}

//提交注册
$("#register-btn").click(function () {
	var $userpassword = $('#password-input').val();
	var $phone = $('#tel-num-input').val();
	var $captcha = $("#tel_number_code").val();
	if (!checkMobile($phone)) {
		alert("请输入正确的手机号");
	} else if ($captcha.length < 1) {
		alert("请输入验证码");
	} else if ($userpassword.length < 1) {
		alert("请输入密码");
	}  else {
		console.log($userpassword,$phone,$captcha);
		$.ajax({
			type:'POST',
			url:baseurl + '/api/api.php?commend=phone_register2',
			data:{u_id:id,phone:$phone,phone_code:$captcha,password:$userpassword},
			success:function (data) {
				console.log(data);
			//	alert(data.msg);
				if(data.code == "1"){
					setTimeout(function(){
						window.location.href = "?act=user&op=personal";
					},2000);
				}
				if (data.code == "-1"){
					alert(data.msg);
				}
			}
		});
	}
});
</script>