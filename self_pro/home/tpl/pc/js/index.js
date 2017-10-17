$(function () {
    var baseurl = "http://www.125898.com";
    var localStorage = window.localStorage;
    if (localStorage.hasOwnProperty('community')) {
        var community = localStorage.community;
        $('#community').text(community);
    }

    var userStr = sessionStorage.userModel;
    if (userStr) {
        var userModel = JSON.parse(userStr);
        if (userModel.userIcon)
            $('.left_img img').attr("src", userModel.userIcon);
    }

    getSwiperData();


    //获取首页的数据
    function getSwiperData() {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: baseurl + "/api/api.php?commend=home",
            success: function (data) {
                console.log(data);

                //轮播图
                var advArr = data.data.adv;
                var html = "";
                var swiper_wrapper = document.getElementById("swiper-wrapper");
                for (var i = 0; i < advArr.length; i++) {
                    html += '<div class="swiper-slide w100"><a href="' + advArr[i].url + '"><img class="w100" src=' +baseurl + advArr[i].image + '></a></div>';
                    // console.log(advArr.name);
                }
                swiper_wrapper.innerHTML = html;
                //轮播图
                var mySwiper = new Swiper('.swiper-container', {
                    direction: 'horizontal',
                    loop: true,
                    autoplay: 2000,
                    speed:1000,
                    pagination: '.swiper-pagination',
                    autoplayDisableOnInteraction: false   //滑动后仍然会自动轮播，注意此参数，默认为true
                });


                //分类
                var navArr = data.data.nav;
                var navHtml = "";
                var nav_wrapper = document.getElementById("cate-list");
                for (var j = 0; j < navArr.length; j++) {
                    navHtml += '<li class="fl"><a href="' + navArr[j].url + '"><img class="w100" src=' +baseurl + navArr[j].image + '><div class="name">' + navArr[j].name + '</div></a></div></li>';
                    // console.log(navArr[j].name);
                }
                nav_wrapper.innerHTML = navHtml;


                //社长资源
                var sheArr = data.data.president;
                var shezhangHtml = "";
                var shezhang_wrapper = document.getElementById("shezhang_ul");
                for (var k = 0 ; k < sheArr.length; k++) {
                    if (sheArr[k].u_label2.length == 0) {
                        sheArr[k].u_label2 = ["德州扑克","指纹锁"];
                    }
                    shezhangHtml += '<li class="shezhang_li fl"><a href="' + "/home/tpl/pc/detail/shezhang.html?" + sheArr[k].id + '">' +
                        '<div><img src="' + sheArr[k].image + '"></div><div class="name">' + sheArr[k].name +
                        '</div><div class="tag"><span>' + sheArr[k].u_label2[0] + '</span></div><div class="tag"><span>' + sheArr[k].u_label2[1] + '</span></div></a></div></li>';
                }
                shezhang_wrapper.innerHTML = shezhangHtml;


                //精选资源
                var resourceArr = data.data.boutique;
                var resourceHtml = "";
                var resource_wrapper = document.getElementById("resource");
                for (var m = 0 ; m < resourceArr.length ; m++) {
                    if(m==0) {
                        resourceHtml += '<ul class="clearfix">';
                    }
                    if(m==2) {
                        resourceHtml += '</ul><ul class="clearfix">';
                    }
                    resourceHtml += '<a href="' + "/home/tpl/pc/detail/resource.html?" + resourceArr[m].id + '"><li class="fl"><img class="fl" src="' + baseurl+resourceArr[m].image + '"><div class="fl resource-name">' +
                                    resourceArr[m].name + '</div></li></a>'
                }
                resourceHtml += '</ul>';
                resource_wrapper.innerHTML = resourceHtml;
            }
        });
    }


    //社长滚动
    //异步加载DOM造成的高度问题致使iScroll不能滚动
    var resultContentH = $(".shezhang").height();
    if (resultContentH > 0) {
        setTimeout(function () {
            var myScroll=new IScroll(".shezhang",{
                scrollX:true,
                scrollY:false,
                preventDefault:false,
                hideScrollbar: false //是否隐藏滚动条
            });
        },100)
    };

    list_nav_width();
    function list_nav_width(){
        var new_width=0;
        $(".shezhang ul li").each(function(){
            new_width+=$(this).innerWidth()+15;
        });
        console.log(screen.width,new_width);
        if (new_width > screen.width) {
            $(".shezhang ul").css({"width":new_width+1});
        } else
            $(".shezhang ul").css({"width":screen.width});
    }

    //跳转到个人中心
    $(".left_img").click(function () {
        var userModel = sessionStorage.userModel;
        if (userModel) {
            // window.location.href = "/home/tpl/pc/me/me.html";
            window.location.href = baseurl + "?act=user&op=personal";
        } else {
            window.location.href = "/home/tpl/pc/login/login.html";
        }
    });

    $(".right_img").click(function () {
        window.location.href = "/home/tpl/pc/search.html";
    });
    
});


