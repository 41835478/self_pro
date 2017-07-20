<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
	<script type="text/javascript" src="<?php echo JS;?>/jquery-2.1.4.min.js" ></script>
    <title>待入住</title>
    <style>
        html {
            padding:0 .35rem;
            padding-bottom: 4rem;
            background-color:#FAFAFA;
        }
		.none{
		display: none;
		width:100%;
		height:105px;
		position: absolute;
		top: 270px;
		text-align: center;
		color:#ccc;
		font-size:15px ;
		padding-top: 80px;
		font-family: "微软雅黑";
	}
    </style>
	<script>
	$(function(){
		disnone();
		function disnone(){
			if($("body").has(".dairz_1").length == 0){
				$('.none').show();
			}
		}
		})
	</script>
</head>
<body>
	<?php if(isset($output['order']) && !empty($output['order'])){ ?>
	<?php foreach($output['order'] as $key => $val){ ?>
    <div class="dairz_1">
        <div class="dairz_1_a" style="background:url(<?php echo $val['store_logo'];?>) no-repeat center;background-size:100% 100%"></div>
        <div class="dairz_1_b">
            <p>【黑眼圈潮趴】<?php echo $val['store_name'];?></p>
            <p><?php echo $val['store_xx_address'];?></p>
            <p><?php echo $val['changci'] == 1 || $val['changci'] == 3 ? '白场' : '夜场';?>:<span><?php echo date('Y-m-d H:i',$val['start_time']);?>~<?php echo date('m-d H:i',$val['end_time']);?></span></p>
        </div>
    </div>
	<?php } ?>
	<?php } ?>
	<div class="none" style="background: url(<?php echo IMG;?>/none.png) no-repeat center top;background-size: 63px 75px;">
		您暂无待入住的订单
	</div>

<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>