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
			height:100%;
        }
		body{
			height:100%;
		}
		.fangx2_song111{
			position:fixed;
			top:0;
			left:0;
			background-color:black;
			opacity:.3;
			width:100%;
			height:100%;
			z-index:99999999;
		}
		.fangx2_song{
			position: fixed;
			top:20%;
			left:15%;
			z-index:100000000;
			background-color:#fff;
			width:70%;
			padding:.3rem;
			padding-top:.07rem;
			border-radius: .07rem;
		}
		.fangx2_song img{
			float:left;
			width:.3rem;
			height:.3rem;
			margin-top:.05rem;
			margin-right:.2rem;
		}
		.fangx2_song_1{
			color:#ffc603;
			margin-bottom:.2rem;
		}
		.fangx2_songinput{
			margin-left:.5rem;    
			border-radius: .07rem;
			margin-top:.2rem;
			width:90%;
			border:0.01rem solid #ccc;
			padding:0.1rem;
		}
		.fangx2_songwan{
			text-align:center;
			background-color:#ffc603;
			width:100%;
			height:.8rem;
			line-height:.8rem;
			font-size:.3rem;
			color:#fff;
			margin-top:2rem;
		}
		
    </style>
</head>
<body>
<div class='fangx2_song111 fade'></div>
<div class="fangx2_song fade">
	<div class='fangxiao2_chacha' style='float:right;margin-right:.07rem;font-size:.5rem;'>×</div>
	<div class='clear'></div>
	<div style='text-align:center;font-size:.3rem;margin-bottom:.2rem;'>配送方式</div>
	<ul>
		<li style='font-size:.27rem;' class="fangx2_song_1">
			<img src='<?php echo IMG;?>/fangxiao2_gou.png'>自取
		</li>
		<li style='font-size:.27rem;' class="fangx2_song_2">
			<img src=''>管家配送
		</li>
	</ul>
	<input class='fangx2_songinput fade' type="text" placeholder="请详细描述您在本别墅的位置"/>
	<div class="fangx2_songwan">我 选 好 了</div>
</div>

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
                <div class="fangx_shop_dan">
                    <div class="fangx_shop_dan_im">
                        <img src="<?php echo $v['goods_img'];?>"/>
                    </div>
                    <div class="fangx_shop_dan_fo">
                        <div class="fangx_shop_dan_fo_1"><?php echo $v['goods_name'];?></div>
                        <div class="fangx_shop_dan_fo_2"><?php echo $v['goods_jdesc'];?></div>
                        <b>&yen;<?php echo $v['goods_price'];?></b>
                        <i class="shop_jia"></i>
                        <span data_id="<?php echo $v['goods_id'];?>" data_name="<?php echo $v['goods_name'];?>" data_price="<?php echo $v['goods_price'];?>" class="shop_fo fade"><?php echo $v['num']?></span>
                        <i class="shop_jian fade"></i>
                    </div>
                </div>
            </li>
			<?php } ?>
            <div class="clear"></div>
        </ul>
    </div>
	<?php } ?>
	<?php } ?>
  

    <div class="fangx_hua_top fangx_nav fade">
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
    <div class="fangx_btm">
        <div class="fangx_btm_z">0</div>
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
	//
	var fangjianxiaofei = {};
	//gouwuche();
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
	
	
	$('.fangx_btm_r').on('click',function(){
		$('.fangx2_song').removeClass('fade');
		$('.fangx2_song111').removeClass('fade');
		
	})
	$('.fangx2_songwan').on('click',function(){
		$('.fangx2_song').addClass('fade');
		var msg = $('.fangx2_songinput').val();
		var fujia = {};
		if(msg != ''){
			fujia.message = msg;
		}
	//	var order_id = "<?php echo $output['order_id'];?>";
	//	var sign 	 = "<?php echo $output['sign'];?>";
		var user_id  = "<?php echo $output['user']['user_id'];?>";
		var store_id  = "<?php echo $output['store_id'];?>";
		var url = '/api/api.php?commend=fangjianxiaofeitianjiashangping3';
		$.post(url,{user_id:user_id,store_id:store_id,data:fangjianxiaofei,fujia:fujia},function(data){
			if(data.msg.code == '1'){
				window.location.href = '?act=payment&op=fangjianxiaofeizhifu2&out_trade_no=' + data.msg.out_trade_no;
			}else{
				alert(data.msg.msg);
			}
		},'json');
	//	alert(msg);
	})
	
	$('.fangx2_song_1').on('click',function(){
		$('.fangx2_songinput').addClass('fade');
		$('.fangx2_song_1>img').attr('src','<?php echo IMG;?>/fangxiao2_gou.png');
		$('.fangx2_song_2>img').attr('src','');
		$('.fangx2_songwan').css('marginTop','2rem')
	})
	$('.fangx2_song_2').on('click',function(){
		$('.fangx2_songinput').removeClass('fade');
		$('.fangx2_song_2>img').attr('src','<?php echo IMG;?>/fangxiao2_gou.png');
		$('.fangx2_song_1>img').attr('src','');
		$('.fangx2_songwan').css('marginTop','1.15rem')
	})
	$('.fangxiao2_chacha').on('click',function(){
		$('.fangx2_song111').addClass('fade');
		$('.fangx2_song').addClass('fade');
	})
</script>