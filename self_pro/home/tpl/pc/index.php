<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title>黑眼圈潮趴馆</title>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/swiper-3.4.0.min.css">
		<link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/homepage.css">
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
		<script type="text/javascript" src="<?php echo JS;?>/swiper-3.4.0.min.js"></script>
	</head>
	<script>
		(function (doc, win) {
	        var docEl = doc.documentElement,
	            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
	            recalc = function () {
	                var clientWidth = docEl.clientWidth;
	                if (!clientWidth) return;
	                if(clientWidth>=750){
	                    docEl.style.fontSize = '100px';
	                }else{
	                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
	                }
	            };
	
	        if (!doc.addEventListener) return;
	        win.addEventListener(resizeEvt, recalc, false);
	        doc.addEventListener('DOMContentLoaded', recalc, false);
	    })(document, window);  
	    
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
			//$('.superbox-current-img').attr('src', imgData_first);  	
			$('.superbox-list').on('click','.superbox-img',function() {
				var imgData = $(this).attr('data-img');
				$(this).parent().eq(0).siblings().eq(0).find('.superbox-current-img').attr('src', imgData);
				$(this).css('box-shadow','3px 5px 5px #888888').siblings().css('box-shadow','none')
			})
		  })
	</script>
	<body style='background:#fafafa'>
		<div class="swiper-container">
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
		<div class="place_search" style="width:100%;overflow:hidden;">
			<div></div>
			<div></div>
			<div></div>
		</div>
		<div class="room">
			<div class="room_head">轰趴聚会</div>
			<div class="room_body">
				<div class="room_body_content">
					<?php if(isset($output['store_list']) && !empty($output['store_list'])){ ?> 
					<?php foreach($output['store_list'] as $key => $val){ ?>
					<div class="superbox">
						<?php if($val['store_id'] == 2){ ?>
						<!--
						<a href="javascript:alert('店铺升级中，敬请期待！');" >
						-->
						<a href="?act=order&op=reserve&store_id=<?php echo $val['store_id']?>" >
						<?php }else{ ?>
						<a href="?act=order&op=reserve&store_id=<?php echo $val['store_id']?>" >
							
						<?php } ?>
							<div class="superbox-show">
							  <!-- 	<div class="superbox-show-more" style="background:url(<?php echo IMG;?>/home_more.png) no-repeat center ;background-size: 1.6rem 0.4rem;">&nbsp;点击查看</div>
								<div class="superbox-show-location">
									<div class="superbox_model"></div>
									<div class="superbox-show-location_content">
											<div style="font-size: 15px;font-family:'黑体';"><?php echo $val['store_name'];?></div>
											<div style="font-size: 12px;font-family: '微软雅黑';overflow: hidden;">
												<div class="superbox-show-l" style="background: url(<?php echo IMG;?>/home_location.png) no-repeat left center; background-size: 7px 10px;"><?php echo $val['store_xx_address'];?></div>
												<div class="superbox-show-r">￥ <?php echo $val['price'];?></div>
											</div>
									</div>
								</div>		-->						
								<img src="<?php echo $val['store_imgs'][0];?>" class="superbox-current-img">
								<div style="overflow:hidden;width:100%;background:#fff">
										<div style="font-size:0.32rem;color:#333;float:left;padding-top:0.18rem;padding-left:0.12rem;font-family: '微软雅黑';"><?php echo $val['store_name'];?></div>
										<div style="font-size:0.32rem;color:#ff5464;float:right;padding-top:0.18rem;padding-right:0.12rem;font-family: '微软雅黑';">￥ <?php echo $val['price'];?>.00</div>
									
								</div>
								<?php if(isset($val['store_label']) && !empty($val['store_label'])){ ?>
								
								<div style="padding:0.12rem 0.12rem;overflow:hidden;background:#fff">
									<?php foreach($val['store_label'] as $k => $v){ ?>
									<p style='line-height:0.4rem;float:left;margin-right:0.2rem;text-align:center;border-radius:0.06rem;width:1rem;height:0.4rem;font-size:0.24rem;color:#999;border:1px solid #ccc;padding:0 2px'><?php echo $v;?></p>
									<?php } ?>
								</div>
								<?php } ?>
								
							</div>
						</a>
				     <!--    
						<div class="superbox-list">
				            <img src="<?php echo $val['store_imgs'][0];?>" data-img="<?php echo $val['store_imgs'][0];?>" alt="" class="superbox-img">
				            <img src="<?php echo $val['store_imgs'][1];?>" data-img="<?php echo $val['store_imgs'][1];?>" alt="" class="superbox-img">
				            <img src="<?php echo $val['store_imgs'][2];?>" data-img="<?php echo $val['store_imgs'][2];?>" alt="" class="superbox-img">
				        </div>
						-->
				    </div>
					<?php } ?>
					<?php } ?>
					
					
				</div>
			</div>
		</div>
		<footer class="footer">
			<div class="table fs12 bt bgf tc footer_wrap">
				<a style="text-decoration:none;" href="" class="table-cell vm on"><i class="ft-icon-plan" style="margin-left:1.03rem"></i></a>
		<!--		<a style="text-decoration:none;" href="?act=user&op=fangjian" class="table-cell vm"><i class="ft-icon-notice"></i>房间</a> -->
				<a style="text-decoration:none;" href="?act=user&op=person_info" class="table-cell vm" ><i class="ft-icon-friends" style="margin-left:2.28rem"></i></a>
			</div>
			<div style="height:1.2rem;width:0.9rem;position:absolute;top:-0.22rem;left:3.3rem;background: url(<?php echo IMG;?>/circleadd.png) no-repeat center;background-size:cover "><a href="?act=user&op=fangjian" style="display:block;height:1.2rem;width:0.9rem;"></a></div>
		</footer>
	</body>
</html>
