$(function () {
    var baseurl = "http://www.125898.com";

    //返回上个页面
    $(".left_img").click(function () {
        window.history.back(-1);
    });
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

    //密码隐藏与可见
    $('.pwd-img').click(function(){
        var attr = $(this).attr("src");
        if(attr == 'img/eyeclose.png'){
            $(this).attr("src","img/eyeopen.png");
            $("#passwd").attr('type','password');
        }else{
            $(this).attr("src","img/eyeclose.png");
            $("#passwd").attr('type','text');
        }
    });

    //登陆
    $("#login-btn").click(function () {
        var $userpassword = $('#passwd').val();
        var $phone = $('#tel-number').val();
        if (!checkMobile($phone)) {
            alert("请输入正确的手机号");
        } else if ($userpassword.length < 1) {
            alert("请输入密码");
        } else {
            // console.log($userpassword,$phone);
            $.ajax({
                type:'POST',
                url:baseurl + '/api/api.php?commend=login',
                data:{phone:$phone,password:$userpassword},
                success:function (data) {
                    console.log(data);
                    if (data.code == "-1")
                        alert(data.msg);
                    else {
                        //保存用户信息
                        var userModel = {userId:data.data.id,
                            userName:data.data.name,
                            sign:data.data.sign,
                            userIcon:data.data.image,
                            images:data.data.images,
                            phone:data.data.phone,
                            recomCode:data.data.recomm_code,
                            openId:data.data.openid,
                            userSex:data.data.u_sex,
                            userDesc:data.data.u_desc,
                            userRole:data.data.role_id};
                        var userStr = JSON.stringify(userModel);
                        sessionStorage.userModel = userStr;
                        // window.history.back(-1);
                        window.location.href = baseurl + "/?act=user&op=personal"
                    }
                }
            });
        }
    });

    //微信登陆
    $(".weixin-login").click(function () {

    });
});