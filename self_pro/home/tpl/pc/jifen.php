<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>我的积分</title>
    <style>
        html {
            padding-bottom: 5rem;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="fen_1">
        <div class="fen_1_1">
            <div class="fen_1_1_l">
                <p>当前可用积分</p>
                <p><?php echo $output['dangqiankeyong'];?></p>
            </div>
            <div class="fen_1_1_r">
                <p>本月新增积分</p>
                <p><?php echo $output['benyuexinzeng'];?></p>
            </div>
        </div>
    </div>
    <div class="magtp fen_what">
        <div>什么是积分？</div>
        <div class="text-justify">积分是黑眼圈潮趴馆会员在黑眼圈潮趴微信公众号及网站进行预订或参与活动给予的奖励。积分只能在本账号内进行累积，不可转让或兑换。</div>
		<div>积分的获得：</div>
        <div class="text-justify">会员完成一次别墅轰趴之旅后，会在账户内获得一定的积分。预订白天场可获得1积分；预订夜晚场可获得1.5积分；预订全天场可获得2积分。当积分大于等于20积分时，会员再次下单时即享受9.5折优惠。</div>
    </div>
	<?php if(isset($output['list']) && !empty($output['list'])){ ?>
	<?php foreach($output['list'] as $key => $val){ ?>
    <div class="brtp fen_detail">收支明细</div>
	<div class="brtp fen_detail_1">
        <div class="fen_detail_1_l">
            <p><?php echo $val['jifen_desc'];?></p>
            <p><?php echo date('Y年m月d日',$val['use_time']);?></p>
        </div>
        <div class="fen_detail_1_r"><?php echo $val['jifen'];?></div>
    </div>
	<?php } ?>
	<?php } ?>
	<!--
    <div class="brtp fen_detail_1">
        <div class="fen_detail_1_l">
            <p>订单积分</p>
            <p>2017年4月1日</p>
        </div>
        <div class="fen_detail_1_r">+200</div>
    </div>
    <div class="brtp fen_detail_1">
        <div class="fen_detail_1_l">
            <p>房费抵扣</p>
            <p>2017年4月1日</p>
        </div>
        <div class="fen_detail_1_r_blk fen_detail_1_r">-100</div>
    </div>
	-->
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>