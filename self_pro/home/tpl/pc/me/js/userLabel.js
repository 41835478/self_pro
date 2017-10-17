
$(function () {
    var baseurl = "http://www.125898.com";
    // var userModel = JSON.parse(sessionStorage.userModel);
    var userModel = {"userId":"4","userName":"水牛","sign":"nb8Sp7vAawfUYe7vAXvsszrx-rbcpZg7gBauqVW_EuorcRqbrAlgzOZ7uNiNcfJ","userIcon":"http://wx.qlogo.cn/mmopen/PiajxSqBRaEKUb0XIJXZElXHRyyx90Q0l8qibic5a7lCLmbtXxXoclc57MBHE8LmZPW52hTfV1UfiaMEOPLIEfAxvw/0","phone":"18939892726","recomCode":"2f6dcd","openId":"oW6q7wmGs7ZiAZzxTvwjKHKXfg_0","userSex":"2","userDesc":"你猜我好不好ab"};

    //返回上个页面
    $(".left_img").click(function () {
        var userStr = JSON.stringify(userModel);
        sessionStorage.userModel = userStr;
        window.history.back(-1);
    });

    //获取标签列表
    $.ajax({
        type:'GET',
        url:baseurl + '/api/api.php?commend=get_label',
        dataType: 'json',
        success:function (data) {
            console.log(data);
            if (data.code == "1") {
                updateTag(data.data);
            } else
                alert(data.msg);
        }
    });

    //更新标签列表数据
    function updateTag(data) {
        var html = '';
        for (var i=0; i<data.length; i++) {
            console.log(data[i].name);
            html += '<li class="tag-list">' + '<div class="parent">' + data[i].name + '</div>';
            if (data[i].child.length > 0) {
                //有子分类
                html += '<div class="child">';
                for (var j=0; j<data[i].child.length; j++) {
                    html += '<span id="'+ data[i].child[j].id +'">' + data[i].child[j].name + '</span>';
                }
            }
            html += '</div></li>';
        }
        $('.tag-category ul').append(html);

        //添加某一个标签到池子里
        $('.child span').click(function () {
            var idArray = new Array();
            $('.span-wrapper span').each(function () {
                idArray.push($(this).attr('id'));
            });
            // console.log(idArray);
            if (idArray.length > 3) {
                alert("最多设置四个选定标签");
            } else {
                if ($.inArray($(this).attr('id'),idArray) >= 0) {

                } else {
                    var tagHtml = '<span id="' + $(this).attr('id') + '">' + $(this).text() + '</span>';
                    $('.span-wrapper').append(tagHtml);
                }
            }
        });

    }

    //删除池子里的标签，动态绑定的元素用on-click绑定事件
    $(".span-wrapper").on("click","span", function() {
        console.log("111");
        $(this).remove();
    });

    //保存用户标签
    $(".sendBtn").click(function () {
        var tag1 = $('#tag1').val();
        var tag2 = $('#tag2').val();
        var string = "";
        $('.span-wrapper span').each(function (index,val) {
            console.log( index, val, this );
            string += $(this).attr("id") + ",";
        });
        string = string.substr(0,string.length-1);
        console.log(string);

        if (tag1.length == 0 && tag2.length == 0) {
            alert("请输入自定义标签");
        } else {
            $.ajax({
                type:'POST',
                url:baseurl + '/api/api.php?commend=set_label',
                dataType: 'json',
                data: {u_id:userModel.userId,sign:userModel.sign,
                    label1:tag1,
                    label2:tag2,
                    labels:string},
                success:function (data) {
                    console.log(data);
                }
            });
        }
    });
});