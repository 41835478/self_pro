$(function () {
    var baseurl = "http://www.125898.com";
    var userModel = JSON.parse(sessionStorage.userModel);
    // var userModel = {"userId":"4","userName":"水牛","sign":"GIKyEZOf1R5z0KhCd35GgSY_eG57I0B0hMU9y2JeiHYqxF5KfABHuLhBqCCKm59","userIcon":"http://www.125898.com/uploads/default/20170920/6a0aae056a027f8aec52d9433f893ad0.png","phone":"18939892726","recomCode":"f2da0e","openId":null,"userSex":null};

    if (userModel) {
        console.log(userModel);
        if (userModel.userIcon)
            $('#avaters-img').attr("src", userModel.userIcon);
        $('.userName').text(userModel.userName);
        if (userModel.userSex == 1) {
            $('.userSex').text("男");
        } else if (userModel.userSex == 2) {
            $('.userSex').text("女");
        } else {
            $('.userSex').text("保密");
        }
        $('.intro-textarea').val(userModel.userDesc);
        //个人照片
        var imagesHtml = "";
        var imagesArr = userModel.images.split(",");
        console.log(imagesArr);
        for (var i=0 ;i<imagesArr.length ;i++) {
            imagesHtml += '<img src="' + baseurl + imagesArr[i] + '">'
        }
        document.getElementById("photos").innerHTML = imagesHtml;
    }

    //返回上个页面
    $(".left_img").click(function () {
        var userStr = JSON.stringify(userModel);
        sessionStorage.userModel = userStr;
        window.history.back(-1);
    });

    //更新用户头像
    var fileInput = document.getElementById("upfile");
    var fileImage = document.getElementById("avaters-img");
    //监听change事件
    fileInput.addEventListener('change',function(){
        //清空预览区背景图片
        fileImage.src = '';

        //获取file的引用
        var file = fileInput.files[0];

        //读取文件
        var reader = new FileReader();
        reader.onload = function(e){
            var data = e.target.result;
            fileImage.src = data;
            // console.log(data);

            $.ajax({
                type:'POST',
                url:baseurl + '/api/api.php?commend=avater',
                dataType: 'json',
                data:{u_id:userModel.userId,sign:userModel.sign,image:data},
                success:function (data) {
                    console.log(data);
                    var url = baseurl + data.data.image;
                    userModel.userIcon = url;
                }
            });
        }
        // 以DataURL的形式读取文件:
        reader.readAsDataURL(file);
        console.log(file);

    });

    $(".avater-box").click(function() {
        fileInput.click();
    });

    // 修改昵称
    $(".member-name").click(function () {
        $(".name_alert")[0].style.display = 'block';
    });

    // 修改性别
    $(".member-sex").click(function () {
        $(".sex_alert")[0].style.display = 'block';
    });

    //点击取消
    $(".cancel").click(function () {
        $(".member_tip").hide();
    });


    //修改昵称
    $("#nick").click(function () {
        var nickStr = $(".nick-input").val();
        console.log(nickStr);
        $.ajax({
            type:'POST',
            url:baseurl + '/api/api.php?commend=avater',
            data:{u_id:userModel.userId,sign:userModel.sign,name:nickStr},
            success:function(data){
                console.log(data);
                if (data.code == 1) {
                    $(".member_tip").hide();
                    $('.userName').text(nickStr);
                    userModel.userName = data.data.name;
                }
            }
        });
    });

    //修改性别
    $(".sex-com").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });
    var member_sex='';
    $("#sex").click(function () {
        var sexStr = $(".sex_box .active").text();
        if(sexStr == '男'){
            member_sex=1;
        }else if(sexStr == '女'){
            member_sex=2;
        }
        console.log(userModel.userId,userModel.sign,member_sex);
        $.ajax({
            type:'POST',
            url:baseurl + '/api/api.php?commend=avater',
            data:{u_id:userModel.userId,sign:userModel.sign,u_sex:member_sex},
            success:function(data){
                console.log(data);
                if (data.code == 1) {
                    $(".member_tip").hide();
                    $('.userSex').text(sexStr);
                    userModel.userSex = data.data.u_sex;
                } else {
                    alert(data.msg);
                }
            }
        });
    });
});
