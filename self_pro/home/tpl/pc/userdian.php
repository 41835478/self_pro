<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/swiper-3.4.2.min.css">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>用户点评</title>
    <style>
        html,body  {
            height: 100%;
            width:100%;
            margin:0;
            padding:0;
        }
        html{
            padding-bottom:5rem;
        }
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body>
<div class="ymark">
    <div class="ymark_1">
        <div class="ymark_1_f">
            <div class="ymark_1_f_zhong">
                <p class="ymark_1_f_zhong_1"><?php echo $output['pinfen'];?></p>
                <p class="ymark_1_f_zhong_2">评分</p>
            </div>
        </div>
        <div class="ymark_1_s">
            <div class="ymark_1_s_zhong">
                <p class="ymark_1_s_zhong_1"><?php echo $output['dianpinshu'];?></p>
                <p class="ymark_1_s_zhong_2">点评数</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="ymark_2">
        <ul class="ymark_2_ul">
			<?php foreach($output['store']['store_label'] as $key => $val){ if($key >= 5){break;}?>
				<li><span><?php echo $val;?></span></li>
			<?php } ?>
        </ul>
    </div>
</div>
<div class="dianp">
    <div class="dianp_lft">
        <span class="dianp_lft_dian">总点评</span>
    </div>
    <div class="dianp_rht">
        <span>晒照片(<span><?php echo $output['shaizhaopan'];?></span>)</span>
    </div>
</div>
<div class="zhaopian1">
<?php if(isset($output['user_evaluate_list']) && !empty($output['user_evaluate_list'])) { ?>
<?php foreach($output['user_evaluate_list'] as $key => $val){ ?>
<div class="xiangp_tu xiangp">
    <div class="xiangp_tp">
        <div class="xiangp_tp_hd">
            <img src="<?php echo $val['user_logo'];?>">
        </div>
        <div class="xiangp_tp_fnt">
            <p><?php echo $val['nickname'];?></p>
            <p><?php echo date('m月d日',$val['create_time']);?></p>
            <p class="xiangp_tp_fnt_xxx">
               <?php for($i = 0 ; $i < $val['evaluation_num'] ; $i ++) { ?>
				   <i></i>
			  <?php } ?>
            </p>
        </div>
    </div>
    <div class="xiangp_btmfnt"><?php echo $val['message'];?></div>
	<?php if (isset($val['images']) && !empty($val['images'])){ ?>
	<?php $img = explode(',',$val['images']);?>
    <div class="xiangp_pic">
        <ul class="xiangp_pic_ul">
			<?php foreach($img as $k => $v){ ?>
			 <li class="xiangp_pic_ul_1"><img src="<?php echo $v;?>"/></li>
			<?php } ?>
        </ul>
    </div>
	<?php } ?>
</div>
<?php } ?>
<?php } ?>
</div>

<div class="zhaopian2" style="display:none">
<?php if(isset($output['shaizhaopan_list']) && !empty($output['shaizhaopan_list'])) { ?>
<?php foreach($output['shaizhaopan_list'] as $key => $val){ ?>
<div class="xiangp_tu xiangp">
    <div class="xiangp_tp">
        <div class="xiangp_tp_hd">
            <img src="<?php echo $val['user_logo'];?>">
        </div>
        <div class="xiangp_tp_fnt">
            <p><?php echo $val['nickname'];?></p>
            <p><?php echo date('m月d日',$val['create_time']);?></p>
            <p class="xiangp_tp_fnt_xxx">
               <?php for($i = 0 ; $i < $val['evaluation_num'] ; $i ++) { ?>
				   <i></i>
			  <?php } ?>
            </p>
        </div>
    </div>
    <div class="xiangp_btmfnt"><?php echo $val['message'];?></div>
	<?php if (isset($val['images']) && !empty($val['images'])){ ?>
	<?php $img = explode(',',$val['images']);?>
    <div class="xiangp_pic">
        <ul class="xiangp_pic_ul">
			<?php foreach($img as $k => $v){ ?>
			 <li class="xiangp_pic_ul_1"><img src="<?php echo $v;?>"/></li>
			<?php } ?>
        </ul>
    </div>
	<?php } ?>
</div>
<?php } ?>
<?php } ?>
</div>
<!-- Swiper -->


</body>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/swiper-3.4.2.jquery.min.js"></script>
<script src="<?php echo JS;?>/swiper-3.4.2.min.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
<script>
    window.onload = function() {
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 30,
            effect: 'fade'
        });
    }
	
		
	$('.xiangp_pic_ul li').on('click',function(){
		var index=$(this).index();
		$('body').append('<div class="userbigtu swiper-container swiper-container-horizontal swiper-container-fade" style="opacity: 1; z-index: 10;"><div class="swiper-wrapper"><div class="swiper-slide111 swiper-slide swiper-slide-active" style="width: 1536px; opacity: 1; transform: translate3d(0px, 0px, 0px);"></div><div class="swiper-slide222 swiper-slide swiper-slide-next" style="width: 1536px; opacity: 0; transform: translate3d(-1536px, 0px, 0px);"></div><div class="swiper-slide333 swiper-slide" style="width: 1536px; opacity: 0; transform: translate3d(-3072px, 0px, 0px);"></div></div><div class="swiper-pagination swiper-pagination-white swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div><div class="swiper-button-next swiper-button-white"></div><div class="swiper-button-prev swiper-button-white swiper-button-disabled"></div></div>')
		  var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 30,
            effect: 'fade',
			initialSlide:index
        });
	
		var abcdfrg111=$(this).parent().children("li:first").children('img').attr('src');
		var abcdfrg222=$(this).parent().children("li:first").next().children('img').attr('src');
		var abcdfrg333=$(this).parent().children("li:last").children('img').attr('src');
		console.log($(this).children("li:first").children('img').attr('src'));
		$('.swiper-slide111').css('backgroundImage','url("'+abcdfrg111+'")');
		$('.swiper-slide222').css('backgroundImage','url("'+abcdfrg222+'")');
		$('.swiper-slide333').css('backgroundImage','url("'+abcdfrg333+'")');	


	})
	
	$('body').on('click','.userbigtu',function(){
		$('.userbigtu').remove();
	})
	
	
	
</script>
</html>