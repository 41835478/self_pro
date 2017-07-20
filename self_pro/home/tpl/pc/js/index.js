/*$('.agr input').on('click',function(){
    if($('.agr input').is(':checked')==false){
        $('.btm_lft_1').css('color','#ccc');
        $('.btm_btm').css('background','#ccc');
    }else{
        $('.btm_lft_1').css('color','#F83600');
        $('.btm_btm').css('background','#F83600');
    }
})*/
$(function(){
    var n=1;
    $('.cu1').on('click',function(){
        n--;
        if(n>=1){
            $('.h_3_jj_s').html(n);
        }else{
            $('.h_3_jj_s').html('1');
            n=1;
        }
    })
    $('.cu2').on('click',function(){
        n++;
        $('.h_3_jj_s').html(n);
    })
})

/* 优惠券 */

$('.you_1_y').on('click',function(){
    $('.you_1_y').css({
        borderBottom:'.04rem solid #FFC603',
        color:'#FFC603'})
    $('.you_1_n').css({
        borderBottom:'0',
        color:'#323232'
    })
    $('.you_1_y_btm').removeClass('fade');
    $('.you_1_n_btm').addClass('fade');
})
$('.you_1_n').on('click',function(){
    $('.you_1_n').css({
        borderBottom:'.04rem solid #FFC603',
        color:'#FFC603'})
    $('.you_1_y').css({
        borderBottom:'0',
        color:'#323232'
    })
    $('.you_1_y_btm').addClass('fade');
    $('.you_1_n_btm').removeClass('fade');
})
$('.you_1_y_btm_1').on('click',function(){
    $(this).toggleClass('redgou');
    $(this).siblings().removeClass('redgou');
    if($(this).attr('class')=="you_1_y_btm_1 redgou"){
        $('.you_2').css('backgroundColor','#ffc603');
    }
   if($(this).attr('class')=="you_1_y_btm_1"){
        $('.you_2').css('backgroundColor','#ccc');
    }
})

/* 用户点评 */

$('.dianp_lft').on('click',function(){
    $(this).children().addClass('dianp_lft_dian');
    $(this).siblings().children().removeClass('dianp_lft_dian');
	$('.zhaopian1').show();
	$('.zhaopian2').hide();
})
$('.dianp_rht').on('click',function(){
    $(this).children().addClass('dianp_lft_dian');
    $(this).siblings().children().removeClass('dianp_lft_dian');
	$('.zhaopian1').hide();
	$('.zhaopian2').show();
})
$('.xiangp_pic_ul').on('click',function(){
    $('.userbigtu').css({
        opacity:1,
        zIndex:'10'
    });
})
$('.userbigtu').on('click',function(){
    $('.userbigtu').css({
        opacity:0,
        zIndex:'-10'
    });
})

/* 房间消费 */

$('.fangx_nav_ul li').on('click',function(){
    $(this).css('color','#f83600');
    $(this).siblings().css('color','#323232');
})
$(function(){
    var fjxfzonghe = $('.fangx_btm_z').html();
	if(fjxfzonghe == ''){
		fjxfzonghe = 0;
	}else{
		fjxfzonghe = parseInt(fjxfzonghe);
	}
    $('.shop_jia').on('click',function(){
        fjxfzonghe++;
        var fjxfshu1=parseInt($(this).next().html());
        $(this).next().removeClass('fade').html(fjxfshu1+1);
        $(this).next().next().removeClass('fade');
        $('.fangx_btm_z').html(fjxfzonghe);
    })
    $('.shop_jian').on('click',function(){
        fjxfzonghe--;
        var fjxfshu2=parseInt($(this).prev().html());
        $(this).prev().removeClass('fade').html(fjxfshu2-1);
        $(this).prev().prev().removeClass('fade');
        $('.fangx_btm_z').html(fjxfzonghe);
        if(fjxfshu2==1){
            //$(this).prev().addClass('fade');
            $(this).addClass('fade');
        }
    })
	//清空购物车
	$('.clear_goods').click(function(){
		$('.shop_fo').html('0');
		$('.fangx_btm_z').html('0');
		$('.fangjian_price').html('0');
		$('.shop_jian').hide();
		fangjianxiaofei = {};
		fjxfzonghe = 0;
		$('.gouwuche_box').html('');
	});
})

/*window.onscroll=function() {
    //console.log($('body').scrollTop());
    if($('body').scrollTop()>='176'){
        $('.fangx_hua_top').removeClass('fade');
    }
    if($('body').scrollTop()<='175'){
        $('.fangx_hua_top').addClass('fade');
    }
}*/

window.onscroll=function() {
    //console.log($('body').scrollTop());
    if($('body').scrollTop()>='176'){
        $('.fangx_nav').addClass('fangx_navfangx_nav');
		console.log('1');
    }
    if($('body').scrollTop()<='175'){
        $('.fangx_nav').removeClass('fangx_navfangx_nav');
		console.log('2');
    }
}

/* 订单备注 */


$(document).ready(function() {
    var nbr=0;
    var htt='';
    $(".bz_1_ipt").keyup(function() {
        nbr=$('.bz_1_ipt').val().length;
        $('.bz_1_bj_nbr').html(nbr);
    });
    $('.bz_2_22').on('click','li',function(){
        var hht=$(".bz_1_ipt").val();
        console.log(hht);
        htt=$(this).html();
        if(nbr>='50'){
            $('.bz_2_2').removeClass('bz_2_22');
            $('.bz_1_bj_nbr').html(50);
            return;
        }
        hht=hht+htt;
        $('.bz_1_ipt').val(hht);
        nbr=nbr+4;
        if(nbr>='50'){
            $('.bz_1_bj_nbr').html(50);
            return;
        }
        $('.bz_1_bj_nbr').html(nbr);
    })
});


/* 未开发票 */

/* 发票选择 */
$('.weifa_2_ul_1').on('click',function(){
    $('.weifa_2_ul_1').addClass('weifa_2_ul_bdcl');
    $('.weifa_2_ul_2').removeClass('weifa_2_ul_bdcl');
    $('.weifa_6').removeClass('fade');
    $('.weifa_5').addClass('fade');
    $('.weifa_4_btm span').css('backgroundColor', '#ccc');
    $(".in_1").val('').html('');
    $(".in_2").val('').html('');
    $(".in_3").val('').html('');
    $(".in_4").val('').html('');
    $(".in_5").val('').html('');
    $(".in_11").val('').html('');
    $(".in_12").val('').html('');
    $('.weifa_3_1_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
    $('.weifa_3_2_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');

    ////////////////////
    /* 打钩 */
    $(".inputt2").keyup(function() {
        if ($('.in_2').val().length>='1'&&$('.in_3').val().length>='1'&&$('.in_4').val().length>='1'&&$('.in_5').val().length>='1') {
            console.log("a");
            $('.weifa_4_btm span').css('backgroundColor','#ffc603');
            console.log("a");
        }else{
            console.log("b");
            $('.weifa_4_btm span').css('backgroundColor','#ccc')
        }
    });
    /*111*/

    $('.weifa_3_1').on('click',function(){
        $('.weifa_3_1_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
        $('.weifa_3_2_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');
        $('.in_1').val('');
        $(".inputt").keyup(function() {
            console.info('fc2');
            console.log('--2--'+$('.in_2').val());
            console.log('--3--'+$('.in_3').val());
            if ($('.in_2').val().length>='1'&&$('.in_3').val().length>='1'&&$('.in_4').val().length>='1'&&$('.in_5').val().length>='1') {
                console.log("a");
                $('.weifa_4_btm span').css('backgroundColor','#ffc603');
                console.log("a");
            }else{
                console.log("b");
                $('.weifa_4_btm span').css('backgroundColor','#ccc')
            }
        });
    })



    /*222*/
    $('.weifa_3_2').on('click',function(){
        $('.weifa_4_btm span').css('backgroundColor', '#ccc');

        $('.weifa_3_2_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
        $('.weifa_3_1_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');

        if($('.weifa_3_2 i').attr('class')==='weifa_3_2_iii weifa_3_1_gou'){
            $('.inputt').keyup(function() {
                console.log('--2--'+$('.in_2').val());
                console.log('--3--'+$('.in_3').val());

                if ($('.in_1').val().length>='1'&&$('.in_2').val().length>='1'&&$('.in_3').val().length>='1'&&$('.in_4').val().length>='1'&&$('.in_5').val().length>='1') {
                    $('.weifa_4_btm span').css('backgroundColor', '#ffc603');
                    console.log(111);
                } else {
                    $('.weifa_4_btm span').css('backgroundColor', '#ccc')
                }
            })
        }
    })

})
$('.weifa_2_ul_2').on('click',function(){
    $('.weifa_2_ul_2').addClass('weifa_2_ul_bdcl');
    $('.weifa_2_ul_1').removeClass('weifa_2_ul_bdcl');
    $('.weifa_5').removeClass('fade');
    $('.weifa_6').addClass('fade');
    $('.weifa_4_btm span').css('backgroundColor', '#ccc');
    $(".in_1").val('').html('');
    $(".in_2").val('').html('');
    $(".in_3").val('').html('');
    $(".in_4").val('').html('');
    $(".in_5").val('').html('');
    $(".in_11").val('').html('');
    $(".in_12").val('').html('');
    $('.weifa_3_1_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
    $('.weifa_3_2_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');
/////////////////////////////////////////////////

    /* 打钩 */
    /*111*/
    $(".inputt2").keyup(function() {
        console.info('fc2');
        console.log('--2--'+$('.in_2').val());
        console.log('--3--'+$('.in_3').val());
        if ($('.in_11').val().length>='1'&&$('.in_12').val().length>='1') {
            console.log("a");
            $('.weifa_4_btm span').css('backgroundColor','#ffc603');
            console.log("a");
        }else{
            console.log("b");
            $('.weifa_4_btm span').css('backgroundColor','#ccc')
        }
    });

    $('.weifa_3_1').on('click',function(){
        $('.weifa_3_1_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
        $('.weifa_3_2_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');
        $('.in_1').val('');
        $(".inputt").keyup(function() {
            console.info('fc');
            if ($('.in_11').val().length>='1'&&$('.in_12').val().length>='1') {
                $('.weifa_4_btm span').css('backgroundColor', '#ffc603')
            }else{
                $('.weifa_4_btm span').css('backgroundColor', '#ccc')
            }
        });
    })



    /*222*/
    $('.weifa_3_2').on('click',function(){
        $('.weifa_4_btm span').css('backgroundColor', '#ccc');

        $('.weifa_3_2_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
        $('.weifa_3_1_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');

        if($('.weifa_3_2 i').attr('class')==='weifa_3_2_iii weifa_3_1_gou'){
            $('.inputt').keyup(function() {
                if ($('.in_1').val().length>='1'&&$('.in_11').val().length>='1'&&$('.in_12').val().length>='1') {
                    //if ($('.in_1').val().length >= '1') {
                    $('.weifa_4_btm span').css('backgroundColor', '#ffc603');
                    console.log(111);
                } else {
                    $('.weifa_4_btm span').css('backgroundColor', '#ccc')
                }
            })
        }
    })


})
/* 打钩 */
$(".inputt2").keyup(function() {
    if ($('.in_2').val().length>='1'&&$('.in_3').val().length>='1'&&$('.in_4').val().length>='1'&&$('.in_5').val().length>='1') {
        console.log("a");
        $('.weifa_4_btm span').css('backgroundColor','#ffc603');
        console.log("a");
    }else{
        console.log("b");
        $('.weifa_4_btm span').css('backgroundColor','#ccc')
    }
});
/*111*/

$('.weifa_3_1').on('click',function(){
    $('.weifa_3_1_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
    $('.weifa_3_2_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');
    $('.in_1').val('');
    $(".inputt").keyup(function() {
        console.info('fc2');
        console.log('--2--'+$('.in_2').val());
        console.log('--3--'+$('.in_3').val());
        if ($('.in_2').val().length>='1'&&$('.in_3').val().length>='1'&&$('.in_4').val().length>='1'&&$('.in_5').val().length>='1') {
            console.log("a");
            $('.weifa_4_btm span').css('backgroundColor','#ffc603');
            console.log("a");
        }else{
            console.log("b");
            $('.weifa_4_btm span').css('backgroundColor','#ccc')
        }
    });
})



/*222*/
$('.weifa_3_2').on('click',function(){
    $('.weifa_4_btm span').css('backgroundColor', '#ccc');

    $('.weifa_3_2_iii').addClass('weifa_3_1_gou').removeClass('weifa_3_1_bdbtm');
    $('.weifa_3_1_iii').removeClass('weifa_3_1_gou').addClass('weifa_3_1_bdbtm');

    if($('.weifa_3_2 i').attr('class')==='weifa_3_2_iii weifa_3_1_gou'){
        $('.inputt').keyup(function() {
            console.log('--2--'+$('.in_2').val());
            console.log('--3--'+$('.in_3').val());

            if ($('.in_1').val().length>='1'&&$('.in_2').val().length>='1'&&$('.in_3').val().length>='1'&&$('.in_4').val().length>='1'&&$('.in_5').val().length>='1') {
                    $('.weifa_4_btm span').css('backgroundColor', '#ffc603');
                    console.log(111);
                } else {
                    $('.weifa_4_btm span').css('backgroundColor', '#ccc')
                }
        })
    }
})
/* 全部订单 */

$(".all_4_5 span").click(function(){
    $('html,body').addClass('ovfHiden'); //使网页不可滚动
    $(".all_5").removeClass('fade');
    $(".all_6").removeClass('fade');
})
$(".all_5_3 div").click(function(){
    $('html,body').removeClass('ovfHiden'); //使网页恢复可滚
    $(".all_5").addClass('fade');
    $(".all_6").addClass('fade');
})



$('.fangjtz_3_d').on('click',function(){
    $('.fangjtz_wifi').removeClass('fade');
    //$('.fangjtz').addClass('fade');

})
$('.fangjtz_cha').on('click',function(){
    $('.fangjtz_wifi').addClass('fade');

})


