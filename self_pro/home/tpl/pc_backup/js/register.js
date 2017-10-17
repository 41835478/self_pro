$(function () {
	var url = 'http://www.125898.com';
	
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
    // //验证昵称
    // function checkName(name) {
    //     var reg = /^[\u4e00-\u9fa5_a-zA-Z0-9]+$/;
    //     if(!reg.test(name)){
    //         $("#username-input").css('border-color','#f00');
    //         return false;
    //     }else{
    //         $("#username-input").css('border-color','#e6e6e6');
    //         return true;
    //     }
    // }
    // //验证密码
    // function checkPasswd(pwd) {
    //     var reg = /^[a-zA-Z\d]+$/;
    //     if(!reg.test(pwd)){
    //         $("#password-input").css('border-color','#f00');
    //         return false;
    //     }else{
    //         $("#password-input").css('border-color','#e6e6e6');
    //         return true;
    //     }
    // }

    //密码隐藏与可见
    //密码可见
    $('.pwd-img').click(function(){
        var attr = $(this).attr("src");
        if(attr == 'images/eyeclose.png'){
            $(this).attr("src","images/eyeopen.png");
            $("#password-input").attr('type','password');
        }else{
            $(this).attr("src","images/eyeclose.png");
            $("#password-input").attr('type','text');
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

    var sign;
    //点击获取验证码
    $(".get-code").click(function(){
        var $tel_num = $("#tel-num-input").val();
        if (!checkMobile($tel_num)) {
            alert("请输入正确的手机号");
        } else {
            $.ajax({
                type: 'POST',
				//服务器接口地址这样写
                url: url+'/api/api.php?commend=send_message',
                dataType: 'json',
                data: {phone: $tel_num},
                success: function (data) {
                    console.log(data);
                    console.log(data.data);
                    codeTime();
                    sign = data.data.sign;
                }
            });
        }
    });

    //提交注册
    $(".phone-test").click(function () {
        var $username = $('#username-input').val();
        var $userpassword = $('#password-input').val();
        var $phone = $('#tel-num-input').val();
        var $captcha = $("#tel_number_code").val();
        if (!checkMobile($phone)) {
            alert("请输入正确的手机号");
        } else if ($captcha.length < 1) {
            alert("请输入验证码");
        } else if ($userpassword.length < 1) {
            alert("请输入密码");
        } else if ($username.length < 1) {
            alert("请输入昵称");
        } else {
            console.log($username,$userpassword,$phone,$captcha,sign);
            $.ajax({
                type:'POST',
                url:'/api/api.php?commend=phone_register',
                data:{phone:$phone,phone_code:$captcha,sign:sign,password:$userpassword,name:$username},
                success:function (data) {
                    console.log(data);
                }
            });
        }
    });
});
