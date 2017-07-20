<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>我的押金</title>
    <style>
        html {
            padding-bottom: 5rem;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="myy_1">
        <div class="myym">
            <div class="myy_l_l">
                <i></i>
                <p>黑眼圈潮趴</p>
            </div>
            <div class="myy_l_m"></div>
            <div class="myy_l_r">
                <i></i>
                <p>付款账户</p>
            </div>
        </div>
    </div>
    <div class="myy_2">
        <div class="myy_2_1">退款中</div>
        <div class="myy_2_2">押金将在1-3个工作日内返还</div>
        <div class="myy_2_3">
            <span class="is_ok">好的</span>
        </div>
        <div class="myy_2_4">
            <span class="tuikuanjilu">退款记录</span>
        </div>
    </div>

<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
	$('.is_ok').click(function(){
		window.location.href = "?act=user&op=person_info";
	})
	$('.tuikuanjilu').click(function(){
		window.location.href = "?act=order&op=tuim";
	})
</script>