
/**
 * Created by developer on 2017/10/14.
 */
$(function () {
    if (is_weixn()) {
        $(".head").css("display","none");
    }
    //判断是否是微信浏览器
    function is_weixn(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }
});
