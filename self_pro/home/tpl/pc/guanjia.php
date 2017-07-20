<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>管家资料</title>
    <style>
        html {
            padding-bottom: 5rem;
        }
    </style>
</head>
<body>
<div class="guanj_1">
    <img src="<?php echo $output['data']['guanjia_logo']?>"/>

    <div class="guanj_1_f">
        <div><?php echo $output['data']['guanjia_name']?></div>
       <!-- <span><?php echo $output['data']['is_renzheng'] == 1 ? '已认证' : '未认证';?></span> -->
    </div>
</div>
<div class="guanj_2">
    <div class="guanj_2_1">
        <ul class="guanj_2_1_ul">
            <li>
                <span>性别：</span>
                <span><?php echo $output['data']['guanjia_xingbie'] == 2 ? '女':'男';?></span>
            </li>
            <li>
                <span>年龄：</span>
                <span><?php echo $output['data']['guanjia_age']?></span>
            </li>
        </ul>
    </div>
    <div class="guanj_2_1">
        <ul class="guanj_2_1_ul">
            <li>
                <span>星座：</span>
                <span><?php echo $output['data']['guanjia_xingzuo']?></span>
            </li>
            <li>
                <span>学历：</span>
                <span><?php echo $output['data']['guanjia_xueli']?></span>
            </li>
        </ul>
    </div>
    <div class="guanj_2_2">
        爱好：<span><?php echo str_replace('|',' ',$output['data']['guanjia_aihao'])?></span>
    </div>

    <div class="guanj_2_2">
        签名：<span><?php echo $output['data']['guanjia_qianming']?></span>
    </div>

    <div class="guanj_2_2">
       标签：<span><?php echo str_replace('|',' ',$output['data']['guanjia_biaoqian']);?></span>
    </div>
</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>