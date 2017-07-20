<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
	
<link rel="stylesheet" href="<?php echo CSS;?>/weui.min.css" />
    <title>全部订单</title>
    <style>
        html {
            padding-bottom: 4rem;;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="dingdx_0">
        当前订单正在等待付款，请尽快付款
    </div>
    <div class="dingdx_1">
        <span><?php echo $output['store']['store_name'];?></span>
        <a style='color:#f83600;text-decoration:underline;' href="?act=order&op=xiaofeiqingdan&order_id=<?php echo $output['order']['order_id'];?>"><span>消费清单</span></a>
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
            <span class="dingdx_2_2_a">状态:未支付</span>
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
    <div class="dingdx_702">
        <ul>
            <li class="dingdx_702_a">
                <span class="cancel_order">取消订单</span>
            </li>
            <li class="dingdx_702_b">
                <span class="lijizhifu">立即支付</span>
            </li>
        </ul>
    </div>

<div class="weui_dialog_confirm" style="display: none; font-family: '微软雅黑';">
    <div class="weui_mask"></div>
    <div class="weui_dialog">
        <div class="weui_dialog_hd"><strong class="weui_dialog_title">你确定要取消订单吗？</strong></div>
        <div class="weui_dialog_ft">
            <a href="#" class="weui_btn_dialog default">取消</a>
            <a href="#" class="weui_btn_dialog primary">确定</a>
        </div>
    </div>
</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
function loadStyles(url) {
        var link = document.createElement("link");
        link.type = "text/css";
        link.rel = "stylesheet";
        link.href = url;
        document.getElementsByTagName("head")[0].appendChild(link);
    }
    // 测试
	$(function(){
		loadStyles("<?php echo CSS;?>/bootstrap.css");
		loadStyles("<?php echo CSS;?>/index.css");
	});
	
	$('.lijizhifu').click(function(){
		window.location.href = '?act=order&op=dingdanzhifu&order_id=' + order_id;
	});
</script>

<script>
		var order_no = '<?php echo $output['order']['order_no'];?>';
		var order_id = '<?php echo $output['order']['order_id'];?>';
		var sign = '<?php echo $output['order']['sign'];?>';
		$(function(){
			
			$('.cancel_order').click(function(){
				$('.weui_dialog_confirm').show()
			})
			$('.weui_dialog_confirm .default').click(function(){
				$('.weui_dialog_confirm').hide()
			})
			$('.weui_dialog_confirm .primary').click(function(){
				var url = '/api/api.php?commend=quxiaodingdan';
				$.post(url,{order_id:order_id,order_no:order_no,sign:sign},function(data){
					if(data.msg.code == '1'){
						alert(data.msg.msg);
						window.location.href = '?act=user&op=person_info';
					}else{
						alert(data.msg.msg);
					}
				},'json');
				$('.weui_dialog_confirm').hide();
			})
		});
</script>