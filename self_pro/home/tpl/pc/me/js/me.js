$(function () {
    var baseurl = "http://www.125898.com";

    var userModel = JSON.parse(sessionStorage.userModel);
    if (userModel.userIcon)
        $(".user-icon img").attr("src", userModel.userIcon);
    $(".name").text(userModel.userName);
    $(".intro").text(userModel.userDesc);
    console.log(userModel.userRole);
    switch (parseInt(userModel.userRole)) {
        case 2: {$("#zhiwei .sub-title").text("组长"); break; }
        case 3: {$("#zhiwei .sub-title").text("服务侠"); break; }
        case 4: {$("#zhiwei .sub-title").text("副社长"); break; }
        case 5: {$("#zhiwei .sub-title").text("社长"); break; }
        default: {$("#zhiwei .sub-title").text("社员"); }
    }
    var community = localStorage.community;
    $('#shequ .sub-title').text(community);

    //返回上个页面
    $(".left_img").click(function () {
        // window.history.back(-1);
        window.location.href = baseurl;
    });

    //获取用户信息
    $.ajax({
        type: "POST",
        dataType: "json",
        url: baseurl + "/api/api.php?commend=get_user_info",
        data: {u_id:userModel.userId,sign:userModel.sign},
        success: function (data) {
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
            }
        }
    });

    //退出登录
    $(".logout").click(function () {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: baseurl + "/api/api.php?commend=logout",
            data: {u_id:userModel.userId,sign:userModel.sign},
            success: function (data) {
                console.log(data);
                sessionStorage.removeItem('userModel');
                window.location.href = "../index.html";
            }
        });
    });

});
