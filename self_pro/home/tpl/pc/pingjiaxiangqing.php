<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>评价详情</title>
    <style>
        html {
            padding:0 .35rem;
            padding-bottom: 4rem;;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="pingjxq_1">
        <span><?php echo $output['user']['nickname'];?></span>
        <span><?php echo date('Y-m-d H:i:s',$output['user_evaluate']['create_time']);?></span>
    </div>
    <div class="pingjxq_2">
        <div class="pingjxq_2_x">
			<?php for($i = 0 ;$i < $output['user_evaluate']['evaluation_num'] ; $i ++ ){ if($i == 5){ break ;}; ?>
				 <i></i>
			<?php } ?>
        </div>
        <div class="clear"></div>
        <div class="pingjxq_2_f"><?php echo $output['user_evaluate']['message'];?></div>
    </div>

<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>