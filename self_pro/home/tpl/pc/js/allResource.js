
$(function () {
    //切换分类状态
    $(".group-state-box ul li").click(function () {
        $(this).addClass("active").siblings().removeClass("active");
        $(".main-content").empty();
    })
});
