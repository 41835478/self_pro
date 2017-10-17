$(function () {
    var baseurl = "http://www.125898.com";

    //返回上个页面
    $(".left_img").click(function () {
        window.history.back(-1);
    });

    $("right-img").click(function () {
        $.ajax({
            type:'POST',
            url:baseurl + '/api/api.php?commend=search',
            dataType: 'json',
            data: {keyword:"呵呵"},
            success:function (data) {

            }
        });
    });
});
