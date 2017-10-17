
$(function () {
    var baseurl = "http://www.125898.com";

    var url = window.location.href;
    var resourceID = url.split("?")[1];

    //返回上个页面
    $(".left_img").click(function () {
        window.history.back(-1);
    });

    var userModel;
    var u_id = "";
    var sign = "";
    var shezhangID = "";
    if (sessionStorage.userModel) {
        userModel = JSON.parse(sessionStorage.userModel);
        u_id = userModel.userId;
        sign = userModel.sign;
    }

    $.ajax({
        type:'POST',
        url:baseurl + '/api/api.php?commend=get_goods',
        dataType: 'json',
        data: {id:resourceID,u_id:u_id,sign:sign},
        success:function (data) {
            console.log(data);

            //资源主图
            $(".main-image img").attr("src",baseurl + data.data.goods.image);

            //关注社长和收藏资源
            if (data.data.is_guanzhu == "1")
                $(".fav").text("已关注");
            else
                $(".fav").text("关注");
            if (data.data.is_collection == "1")
                $(".collect div").text("已收藏");
            else
                $(".collect div").text("收藏");

            //社长信息
            var shezhang = data.data.user;
            $(".shezhang-title .user-icon img").attr("src",shezhang.image);
            $(".shezhang-title .title").text(shezhang.name);
            $(".shezhang-title .time").text(data.data.goods.create_time2);
            shezhangID = shezhang.id;

            // 资源信息
            var resource = data.data.goods;
            $(".resource-title .title").text(resource.name);
            $(".resource-title .price").text("¥" + resource.price);

            var content = data.data.goods.content;
            content = content.replace(/&nbsp/g," ");
            content = content.replace(/src="/g,'src="' + baseurl);
            // console.log(content);

            if (content.indexOf("img") > 0) {
                //pc端上传的资源
                // var contentStr = "<iframe frameBorder=0 marginwidth=0 marginheight=0 scrolling=no style='width: 100%'> <div>" + content + "</div></iframe>";
                $(".content").append(content);
            } else {
                //手机端上传的资源
                var images = data.data.goods.images;
                var html = "";
                $.each(images,function () {
                    html += '<img src="' + baseurl + this + '"/>';
                    // console.log(html);
                });
                $(".content").append(content);
                $(".pictures").append(html);
            }
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

    //收藏该资源
    $(".collect").click(function () {
        //已登录
        if (userModel) {
            //type	固定值 2 代表收藏
            //is_open	1或者2  1已收藏 2取消收藏
            var colStr = $(".collect div").text();
            var type = "1";
            if (colStr == "已收藏")
                type = "2";
            $.ajax({
                type: "POST",
                dataType: "json",
                url: baseurl + "/api/api.php?commend=set_goods_collection",
                data: {g_id:resourceID,u_id:u_id,sign:userModel.sign,type:"2",is_open:type},
                success: function (data) {
                    console.log(data);
                    if (colStr == "收藏")
                        $(".collect div").text("已收藏");
                    else
                        $(".collect div").text("收藏");
                }
            });
        } else {
            window.location.href = baseurl + "/home/tpl/pc/login/login.html";
        }
    });
});