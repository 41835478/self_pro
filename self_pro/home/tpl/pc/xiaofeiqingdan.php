<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>消费清单</title>
	<style>
		.xiao_3333333{
			text-align:center;
			color:#fff;
			background-color:#ffc603;
			margin:auto;
			padding:.2rem 0;
			font-size:.4rem;
			font-weight: bold;
			position:absolute;
			bottom:0;
			left:0;
			width:100%;
		}
	</style>
</head>
<body>
<div class="xiao_1">
    <div class="xiao_1_1">&yen;<?php echo $output['top_price'];?></div>
    <div class="xiao_1_2"><?php echo $output['store']['store_name'];?></div>
</div>
<div class="xiao_2 fangxiao_1">
	<?php if(isset($output['room_price']) && $output['room_price'] > 0){ ?>
    <div class="xiao_font">
        <span>房间总价</span>
        <span>&yen;<?php echo $output['room_price'];?></span>
    </div>
	<?php } ?>
	<?php if(isset($output['room_but']) && !empty($output['room_but'])){ ?>
	<?php foreach($output['room_but'] as $key => $val){ ?>
	<div class="xiao_font">
        <span><?php echo $val['goods_name']?></span>
        <span>&yen;<?php echo $val['price'];?></span>
        <span>x<?php echo $val['goods_num'];?></span>
    </div>
	<?php } ?>
	<?php } ?>
	<?php if(isset( $output['order']['youhui']) && !empty( $output['order']['youhui'])){ ?>
		 <div class="xiao_font">
        <span>优惠券减免(房间总价)</span>
			<span class="xfqd_yhjjp">-&yen;<?php echo $output['order']['youhui']?></span>
		</div>
	<?php } ?>
   
</div>
<div class="xiao_3">
    <span>实付 &yen;<?php echo $output['bottom_price'];?></span>
</div>

<div class="xiao_3333333">返 回</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
	$('.xiao_3333333').click(function(){
		history.go(-1);
	})
</script>