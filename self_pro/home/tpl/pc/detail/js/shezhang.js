$(function () {
    var baseurl = "http://www.125898.com";

    var url = window.location.href;
    var shezhangID = url.split("?")[1];

    var userModel;
    var u_id = "";
    if (sessionStorage.userModel) {
        userModel = JSON.parse(sessionStorage.userModel);
        u_id = userModel.userId;
    }

    //返回上个页面
    $(".left_img").click(function () {
        window.history.back(-1);
    });

    //切换分类状态
    $(".group-state-box ul li").click(function () {
        $(this).addClass("active").siblings().removeClass("active");
        $(".main-content").empty();
    })

    console.log(shezhangID,u_id);
    //获取社长详情数据
    $.ajax({
        type: "POST",
        dataType: "json",
        url: baseurl + "/api/api.php?commend=get_president",
        data: {id:shezhangID,u_id:u_id},
        success: function (data) {
            console.log(data);
            $(".name").text(data.data.name);
            $(".level").text("等级："+data.data.lv);
            $(".desc").text(data.data.u_desc);
            $(".avater img").attr('src',data.data.image);
            if (data.data.is_guanzhu == "1")
                $(".fav").text("已关注");

            var tagStr = data.data.u_label2 + "," + data.data.u_label;
            var tagArr = tagStr.split(",");
            var tagHtml = "";
            for (var i = 0 ; i < tagArr.length ; i++) {
                tagHtml += '<span class="tag">' + tagArr[i] + '</span>';
            }
            document.getElementById("member-tag-box").innerHTML = tagHtml;

            //资源列表
            var resourceArr = data.data.goods;
            var resourceHtml = "";
            for (var j = 0 ; j < resourceArr.length ; j ++) {
                resourceHtml += '<li class="resource clearfix"><div class="fl user-icon"><img src="' +
                                data.data.image + '"></div><div class="fl col-xs-7 title">' + resourceArr[j].name +
                                '</div><div class="fl col-xs-7 time">' + resourceArr[j].create_time +
                                '</div><div class="fr col-xs-2 price">' + resourceArr[j].price + '</div><div class="fr content">';
                var imagesArr = resourceArr[j].images;
                for (var k = 0 ; k < imagesArr.length ; k++) {
                    resourceHtml += '<img src="' + baseurl + imagesArr[k] + '">';
                }
                resourceHtml += '<div class="res-desc">' + resourceArr[j].content + '</div></div></li>';
            }
            document.getElementById("main-content").innerHTML = resourceHtml;
        }
    });


    //关注该社长
    $(".fav").click(function () {
        //已登录
        if (userModel) {
            var favStr = $(".fav").text();
            var type = "1";
            if (favStr == "已关注")
                type = "2";
            $.ajax({
                type: "POST",
                dataType: "json",
                url: baseurl + "/api/api.php?commend=follow",
                data: {p_id:shezhangID,u_id:u_id,sign:userModel.sign,type:type},
                success: function (data) {
                    console.log(data);
                    if (favStr == "关注")
                        $(".fav").text("已关注");
                    else
                        $(".fav").text("关注");
                }
            });
        } else {
            window.location.href = baseurl + "/home/tpl/pc/login/login.html";
        }
    });
});