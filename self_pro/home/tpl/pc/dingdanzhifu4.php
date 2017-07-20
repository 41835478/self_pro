<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>订单支付</title>
    <style>
        html {
            background-color:#FAFAFA;
        }
        .dingdzf_1{
            height:2rem;
            width:100%;
            border-bottom:0.01rem solid #ccc;
            background-color:#fff;
            color:#323232;
            font-weight: bold;
            font-size: .3rem;
        }
        .dingdzf_1_a{
            float:left;
            height:100%;
            width:1.25rem;
            background:url("<?php echo IMG;?>/dingdzf_gou.png") no-repeat .3rem center;
            background-size: .95rem .95rem;
        }
        .dingdzf_1_b{
            float:left;
            height:100%;
            margin-left:.25rem;
        }
        .dingdzf_1_b>div{
            height:25%
        }
        .dingdzf_2{
            height:1rem;
            line-height:1rem;
            background-color:#fff;
            width:100%;
            color:#323232;
            padding:0 .3rem;
        }
        .dingdzf_2 e,.dingdzf_2 span{
            color:#FFC603;
            font-size: .35rem;
            font-weight: bold;
        }
        .dingdzf_3{
            height:1rem;
            line-height:1rem;
            width:100%;
            color:#ccc;
            padding:0 .3rem;
        }
        .dingdzf_4{
            width:100%;
            height:1.2rem;
            padding:.2rem .3rem;
            background-color:#fff;
        }
        .dingdzf_4_a{
            float:left;
            width:.76rem;
            height:100%;
            background:url('<?php echo IMG;?>/dingdzf_wx.png') no-repeat center;
            background-size: .76rem .76rem;
            margin-right:.25rem;
        }
		.zhifubao_4_a{
            float:left;
            width:.76rem;
            height:100%;
            background:url('<?php echo IMG;?>/zhifubao.jpg') no-repeat center;
            background-size: .76rem .76rem;
            margin-right:.25rem;
        }
        .dingdzf_4_b{
            float:left;
        }
        .dingdzf_4_b p{
            font-size: .3rem;
        }
        .dingdzf_4_b div{
            font-size: .25rem;
            color:#646464;
        }
        .dingdzf_4_c{
            float:right;
            font-size: .7rem;
            line-height:1rem;
            color:#ccc
        }
    </style>
</head>
<body>
    <div class="dingdzf_1">
        <div class="dingdzf_1_a"></div>
        <div class="dingdzf_1_b">
            <div></div>
            <div>提交订单完成,请尽快完成付款！</div>
            <div>订单为您保留10分钟,请及时付款。</div>
        </div>
    </div>
    <div class="dingdzf_2">
        支付金额： <e>&yen;</e><span><?php echo $output['order']['over_price']?></span>
    </div>
    <div class="dingdzf_3">
        支付方式
    </div>
    <div class="dingdzf_4" onclick="callpay()" >
        <div class="dingdzf_4_a"></div>
        <div class="dingdzf_4_b">
            <p>微信支付</p>
            <div>微信钱包快捷付款,需要5.0及以上版本</div>
        </div>
        <div class="dingdzf_4_c">＞</div>
    </div>
	
	<a href="?act=payment&op=ali_order_bujia&b_id=<?php echo $output['order_bujia']['b_id'];?>">
	<div class="dingdzf_4"  >
        <div class="zhifubao_4_a"></div>
        <div class="dingdzf_4_b">
            <p>支付宝支付</p>
            <div>支付宝支付需要从浏览器中打开</div>
        </div>
        <div class="dingdzf_4_c">＞</div>
    </div>
	</a>
	
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
	var out_trade_no = "<?php echo $output['order']['out_trade_no'];?>";
	var order_id = "<?php echo $output['order']['order_id'];?>";
	var sign = "<?php echo $output['order']['sign'];?>";
	setInterval(function(){
		var url = '/api/api.php?commend=order_bujia';
		$.post(url,{out_trade_no:out_trade_no},function(data){
			if(data.msg.code == 1){
				alert(data.msg.msg);
				window.location.href = '?act=user&op=person_info';
			}
		},'json');
	},2000);
</script>