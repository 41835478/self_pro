<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>全部订单</title>
    <style>
        html {
            padding-bottom: 4rem;;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="dingdx_1">
        <span><?php echo $output['store']['store_name'];?></span>
        <a style='color:#f83600;text-decoration:underline;' href="?act=order&op=xiaofeiqingdan&order_id=<?php echo $output['order']['order_id'];?>" ><span>消费清单</span></a>
    </div>
    <div class="dingdx_2">
        <div class="dingdx_2_1">
             <div class="dingdx_2_1_a">
                <img src="<?php echo $output['store']['store_logo'];?>"/>
            </div>
            <div class="dingdx_2_1_b">
                <div><?php echo $output['store']['store_xx_address'];?></div>
                <p>入场时间：<?php echo date('Y-m-d H:i',$output['order']['start_time']);?>~<?php echo date('m-d H:i',$output['order']['end_time']);?></p>
                <p>合计：&yen;<span><?php echo $output['order']['over_price'];?></span>&nbsp;押金：&yen;<span><?php echo $output['order']['deposit'];?></span></p>
            </div>
        </div>
        <div class="dingdx_2_2">
            <span class="dingdx_2_2_a">状态:已取消</span>
            <span class="dingdx_2_2_b">
                <i></i>
                下单时间：<e><?php echo date('Y-m-d H:i:s',$output['order']['create_time']);?></e>
            </span>
        </div>
        <div class="dingdx_2_3">
            订单编号：<span><?php echo $output['order']['order_no'];?></span>
        </div>
    </div>
    <div class="dingdx_3">
        联系人信息
    </div>
    <div class="dingdx_4">
        <div>
            姓名：<span><?php echo $output['order']['safe_name'];?></span>
        </div>
        <div>
            手机号：<span><?php echo $output['order']['mobile'];?></span>
        </div>
    </div>
    <div class="dingdx_3">
        别墅信息
    </div>
    <div class="dingdx_5">
        <div>
            店名：<span>黑眼圈潮趴馆【<?php echo $output['store']['store_name'];?>】</span>
        </div>
        <div>
            地址：<span><?php echo $output['store']['store_xx_address'];?></span>
        </div>
        <div>
            联系电话：<span>400-888-9610</span>
        </div>
    </div>
    <div class="dingdx_6">
        <div>温馨提示：</div>
        <div>需<span><?php echo date('Y-m-d H:i',$output['order']['start_time']);?></span>办理入场,早到可能需要等待</div>

        <div>需<span><?php echo date('Y-m-d H:i',$output['order']['end_time']);?></span>之前办理退场,如有延迟请于工作人员进行协商。别墅保留到<span><?php echo date('m-d H:i',$output['order']['end_time']);?></span>,如不能及时到场,请联系黑眼圈潮趴馆</div>
    </div>
    <div class="dingdx_7">
        <span class="zaici">再次订购</span>
    </div>

<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
	var store_id = '<?php echo $output['order']['store_id'];?>';
	$('.zaici').click(function(){
		window.location.href = '?act=order&op=reserve&store_id=' + store_id;
	});
</script>