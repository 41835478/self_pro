<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
	<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/swiper-3.4.0.min.css">
	<script type="text/javascript" src="<?php echo JS;?>/swiper-3.4.0.min.js"></script>
    <title>房间消费</title>
    <style>
        html {
            padding-bottom: 5rem;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="fangx_lun">
        <div class="swiper-container" style="height:100%">
		    <div class="swiper-wrapper">
				<?php if(isset($output['adv']) && !empty($output['adv'])){ ?>
				<?php foreach($output['adv'] as $key => $val){ ?>
				<div class="swiper-slide" style="background: url(<?php echo $val;?>) no-repeat center; background-size: cover;"></div>
				<?php } ?>
				<?php } ?>
		    </div>
		    <!-- 如果需要分页器 -->
		    <div class="swiper-pagination"></div>
		</div>
    </div>
    <div class="fangx_nav">
        <div class="fangx_nav_i"><i class="fangx_nav_z"></i></div>
        <div class="fangx_nav_i"><i class="fangx_nav_y"></i></div>
        <div class="fangx_nav_cont">
            <ul class="fangx_nav_ul">
				<?php if(isset($output['cat_list']) && !empty($output['cat_list'])){ ?>
				<?php foreach($output['cat_list'] as $key => $val){ ?>
				<li  data="<?php echo $val['cat_id'];?>" ><?php echo $val['cat_name'];?></li>
				<?php } ?>
				<?php } ?>
            </ul>
        </div>
    </div>
	<?php if(isset($output['goods_data']) && !empty($output['goods_data'])){ ?>
	<?php foreach($output['goods_data'] as $key => $val){?>
	<div class="fangx_shop_<?php echo $key;?> fangx_shop">
        <ul class="fangx_shop_ul">
			<?php foreach($val as $k => $v){?>
            <li>
                <div class="fangx_shop_dan" style='position:relative;'>
                    <div class="fangx_shop_dan_im">
                        <img src="<?php echo $v['goods_img'];?>"/>
                    </div>
                    <div class="fangx_shop_dan_fo">
                        <div class="fangx_shop_dan_fo_1"><?php echo $v['goods_name'];?></div>
                        <div class="fangx_shop_dan_fo_2"><?php echo $v['goods_jdesc'];?></div>
						<div style='position:absolute;bottom:0;left:0;width:100%;padding:.1rem;'>
							<div style='width:30%;float:left;'>
								<b>&yen;<?php echo $v['goods_price'];?></b>
							</div>
							<div style='width:40%;float:right;'>
								<i class="shop_jia"></i>
								<span data_id="<?php echo $v['goods_id'];?>" data_name="<?php echo $v['goods_name'];?>" data_price="<?php echo $v['goods_price'];?>" class="shop_fo"><?php echo $v['num']?></span>
								<i class="shop_jian fade"></i>
							</div>
						</div>
                    </div>
                </div>
            </li>
			<?php } ?>
            <div class="clear"></div>
        </ul>
    </div>
	<?php } ?>
	<?php } ?>
  

  
    <div class="fangx_btm">
        <div class="fangx_btm_z"><?php echo $output['shuliang']?></div>
        <div class="fangx_btm_l">
            <div class="fangx_btm_l_fo">
                &yen;<span class="fangjian_price">0</span>
            </div>
            <i class="fangx_btm_l_car"></i>
        </div>
        <div class="fangx_btm_r">确定</div>
    </div>

    <div class="fangx_btm_top">
        <div class="fangx_btm_top_1">
            <span class="">购物车</span>
            <span class="clear_goods">清空</span>
        </div>
		<!-- 购物车 -->
		<div class="gouwuche_box"></div>
        <div class="fangx_btm_top_2"></div>
    </div>
    <div class="fangx_btm_top_top fade"></div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/bootstrap.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
$(function(){
			var mySwiper = new Swiper ('.swiper-container', {
			direction: 'horizontal',
			loop: true,
		    autoplay : 2000,			    
			    // 如果需要分页器
			pagination: '.swiper-pagination',			    
			    // 如果需要前进后退按钮
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',			    
			    // 如果需要滚动条
			   // scrollbar: '.swiper-scrollbar',
			  	})  
			var imgData_first=$('.superbox-list').find('img').eq(0).attr('data-img')
			$('.superbox-current-img').attr('src', imgData_first);  	
			$('.superbox-list').on('click','.superbox-img',function() {
				var imgData = $(this).attr('data-img');
				$(this).parent().eq(0).siblings().eq(0).find('.superbox-current-img').attr('src', imgData);
				$(this).css('box-shadow','3px 5px 5px #888888').siblings().css('box-shadow','none')
			})
		  });

	$('.fangx_shop').addClass('fade');
	$('.fangx_shop_1').removeClass('fade');
    $('.fangx_nav_ul li:nth-child(1)').on('click',function(){
        $('.fangx_shop_1').removeClass('fade');
        $('.fangx_shop_2').addClass('fade');
        $('.fangx_shop_3').addClass('fade');
        $('.fangx_shop_4').addClass('fade');
    })
    $('.fangx_nav_ul li:nth-child(2)').on('click',function(){
        $('.fangx_shop_2').removeClass('fade');
        $('.fangx_shop_1').addClass('fade');
        $('.fangx_shop_3').addClass('fade');
        $('.fangx_shop_4').addClass('fade');
    })
    $('.fangx_nav_ul li:nth-child(3)').on('click',function(){
        $('.fangx_shop_3').removeClass('fade');
        $('.fangx_shop_2').addClass('fade');
        $('.fangx_shop_1').addClass('fade');
        $('.fangx_shop_4').addClass('fade');
    })
    $('.fangx_nav_ul li:nth-child(4)').on('click',function(){
        $('.fangx_shop_4').removeClass('fade');
        $('.fangx_shop_2').addClass('fade');
        $('.fangx_shop_3').addClass('fade');
        $('.fangx_shop_1').addClass('fade');
    })

    $('.fangx_btm_top_mid_jia').on('click',function(){
        var qweasdfgh1=parseInt($(this).next().html());
        $(this).next().html(qweasdfgh1+1);
    })
    $('.fangx_btm_top_mid_jian').on('click',function(){
        var qweasdfgh2=parseInt($(this).prev().html());
        $(this).prev().html(qweasdfgh2-1);
        if(qweasdfgh2==0){
            $(this).prev().html(0);
        }
    })
    $('.fangx_btm_l').on('click',function(){
    $('.fangx_btm_top').css({
            height:'auto'
        })

        var ccc=$('.fangx_btm_top').outerHeight();
        var ddd=$('.fangx_btm').outerHeight();
        var eee=document.documentElement.clientHeight;
//        console.log($('.fangx_btm_top').outerHeight());
//        console.log($('.fangx_btm').outerHeight());
//        console.log(document.documentElement.clientHeight);
        var aaa=eee-ccc-ddd;
//        console.log(aaa);
        $('.fangx_btm_top_top').css('height',aaa).removeClass('fade');
    })
    $('.fangx_btm_top_top').on('click',function(){
        $('.fangx_btm_top_top').addClass('fade');
        $('.fangx_btm_top').css({
            height:'0'
        })
    })
	
	$('.shop_jian').click(function(){
		setTimeout(function(){
				gouwuche();
		},100);
	});
	$('.shop_jia').click(function(){
		setTimeout(function(){
				gouwuche();
		},100);
	});
	var fangjianxiaofei = {};
	gouwuche();
	function gouwuche(){
		var str = '';
		var price = 0;
		$('.shop_fo').each(function(i){
			var shuliang = parseInt($(this).html());
			if(shuliang > 0){
				var ppp = (parseFloat($(this).attr('data_price')) * shuliang);
				str += '<div class="fangx_btm_top_mid"><span class="fangx_btm_top_mid_1">'+ $(this).attr('data_name') +'</span><span class="fangx_btm_top_mid_2"><span>&yen;价格：<e>' + ppp +'</e></span>数量：<e class="fangx_btm_top_mid_nbr" data_name="'+ $(this).attr('data_name') +'" data_price="'+ $(this).attr('data_price') +'">'+ shuliang +'</e></span></div>';
				var id =  $(this).attr('data_id');
				var ddd = {};
				ddd.price = $(this).attr('data_price');
				ddd.num = shuliang;
				ddd.z_price = ppp;
				fangjianxiaofei[id] = ddd;  //价格
				$('.gouwuche_box').html(str);
				price += ppp;
				$('.fangjian_price').html(price+'');
			}
		})
	}
	//确定
	$('.fangx_btm_r').click(function(){
		var order_id = "<?php echo $output['order_id'];?>";
		var sign 	 = "<?php echo $output['sign'];?>";
		var url = '/api/api.php?commend=fangjianxiaofeitianjiashangping';
		$.post(url,{order_id:order_id,sign:sign,data:fangjianxiaofei},function(data){
			if(data.msg.code == '1'){
				window.location.href = '?act=order&op=order&order_id=' + order_id;
			}else{
				alert(data.msg.msg);
			}
		},'json');
	});
</script>