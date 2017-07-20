<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>退款记录</title>
    <style>
        html {
            padding:0 .35rem;
            padding-bottom: 5rem;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
	<?php if(isset($output['tuiyajin']) && !empty($output['tuiyajin'])){ ?>
	<?php foreach($output['tuiyajin'] as $key => $val){ ?>
	<div class="tuim_w">
        <div class="tuim_w_1 tuim_w_1_bdbtm">
            <ul class="tuim_w_1_ul">
                <li class="tuim_w_1_ul_1">&yen;<?php echo $val['t_price'];?></li>
                <li class="tuim_w_1_ul_2"><?php echo $val['t_type'];?></li>
            </ul>
        </div>
        <div class="tuim_w_1">
            <ul class="tuim_w_1_ul">
                <li class="tuim_w_1_ul_1222 tuim_w_1_ul_1">退款发起</li>
                <li class="tuim_w_1_ul_1222 tuim_w_1_ul_2"><?php echo date('Y-m-d H:i:s',$val['create_time']);?></li>
            </ul>
        </div>
    </div>
	<?php } ?>
	<?php } ?>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>