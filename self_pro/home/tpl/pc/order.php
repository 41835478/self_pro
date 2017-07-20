<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>订单填写</title>
	<style>
		.h_6_jt{
			float:right;
			width:.3rem;
			height:.3rem;margin-top:.4rem;
		}
	</style>
</head>
<body>

<div class="rd">
    <div class="h_1">
        <!--<img class="img" src="<?php echo IMG;?>/bigimg1.png" style="height:200px"/>-->
		<img class="img" src="<?php echo $output['goods']['goods_img'];?>"/>
    </div>
    <div class="hed h_2">
        <div class="h_2_fotd">预付</div>
        <div class="h_2_fotx">
            <span class="h_2_fotx_1">入场：<?php echo $output['start_time'];?></span>
            <span class="h_2_fotx_2">离场：<?php echo $output['end_time'];?></span>
        </div>
    </div>
    <div class="hed h_3">
        <div class="h_3_rs">入驻人数</div>
        <div class="h_3_jj">
            <span class="cu1">- </span>
            <span class="h_3_jj_s"><?php echo !empty($output['order']['people_num'])?$output['order']['people_num']:1;?></span>人
            <span class="cu2">+</span>
        </div>
    </div>
    <div class="hed h_4">
        <div class="h_4_rzr">入驻人姓名</div>
        <input class="h_4_hyq" type="text" placeholder='请输入姓名' value="<?php echo $output['order']['safe_name'];?>"/>
    </div>
    <div class="hed h_5">
        <div class="h_5_ph">入驻人手机号</div>
        <div class="h_5_hm">
            <!--<img src="<?php echo IMG;?>/idx_p.gif"/>-->
            <input class="h_5_hm_ph" type="number" value="<?php echo $output['order']['mobile'];?>" placeholder='请输入手机号'/>
        </div>
    </div>
	<div class="hed h_4" style='margin-top:.2rem;'>
        <div class="h_4_rzr">身份证号码</div>
        <input class="h_4_hyq shenfenzheng"  placeholder='请输入身份证号码' value="<?php echo $output['order']['id_cart'];?>"/>
    </div>
	<div class="hed h_4" style='border:0;'>
        <div class="h_4_rzr">学生证号或团购号</div>
        <input class="h_4_hyq xueshengzheng"  placeholder='请输入学生证号码或团购号' value="<?php echo $output['order']['st_cart'];?>"/>
    </div>
	<a href="?act=order&op=fangxiao&order_id=<?php echo $output['order_id']?>">
		<div class="hed h_6">
			<span>房间消费</span>
			<img class="h_6_jt" src='<?php echo IMG;?>/sa54d5a4ds.png'>
		</div>
	</a>
    <div class="hed h_7">
        <span>押金（离房当日退）</span>
        <span class="h_7_jt">&yen; <?php echo $output['yajin'];?></span>
    </div>
    <div class="hed h_8">
        <span>邀请码</span>
        <input class="h_8_ma" type="text" placeholder='请输入邀请码' value="<?php echo $output['order']['yaoqingma'];?>"/>
    </div>
	<?php if(isset($output['youhuijuan']) && $output['youhuijuan'] > 0){ ?>
	<a href="?act=user&op=coupon&user_id=<?php echo $output['user']['user_id']?>&order_id=<?php echo $output['order']['order_id'];?>">
		<div class="hed h_08">
			<span>优惠券</span>
			<span class="h_08_jt"><span class="h_08_jt1000">- &yen;<?php echo $output['youhuijuan'];?></span> ></span>
		</div>
	</a>
	<?php } ?>
	<a href="?act=order&op=dingdanbz&order_id=<?php echo $output['order']['order_id'];?>">
		<div class="hed h_09">
			<span>订单备注</span>
			<span class="h_09_jt">需准备的物品等&nbsp;<img class="h_6_jt" src='<?php echo IMG;?>/sa54d5a4ds.png'></span>
		</div>
	</a>
    <div class="h_9">
        <div class="h_9_1">订单总价：<span>&yen;<span class="h_9_1_l_xg"><?php echo $output['over_price'];?></span>元</span>
            <a href="?act=order&op=xiaofeiqingdan2&order_id=<?php echo $output['order']['order_id'];?>">房间消费明细</a>
        </div>
        <div class="h_9_2">
            房间总价：<span>&yen;<?php echo $output['price'];?>元</span>
            <s>原价：&yen;<?php echo $output['yuanjia'];?>元</s>
        </div>
        <div class="h_9_3">
            押金：<span>&yen;<?php echo $output['yajin'];?>元</span>
        </div>
        <div class="h_9_4">
            房间消费：<span>&yen;<?php echo $output['room_price'];?>元</span>
        </div>
		<?php if(isset($output['youhuijuan']) && $output['youhuijuan'] > 0){ ?>
			<div class="h_9_5">
				优惠券减免：<span>房价-<?php echo $output['youhuijuan'];?>元</span>
			</div>
		<?php } ?>
        <div  class="h_9_6"><!-- 会员预订及整场预定可享受8.8折优惠 --></div>
    </div>
    <div class="h_10">
        <div class="h_10_1">         如果取消订单或没有入驻，预付定金不予退还。到场需出示身份证和两张及以上学生证，如果不符合所填写的证件信息，将从押金里扣除折扣价。
        </div>
        <div class="h_10_2">
            <label for='is_tongyi' class="agr">
                <input id="is_tongyi" type="checkbox" style=''/>&nbsp;我同意
            </label>
            <span>
                <a href="#">《会员公约》</a>
                <!--<a href="#"><?php if(isset($output['store']['editorValue'][4])){ echo $output['store']['editorValue'][4];};?></a>--></span>
        </div>
    </div>
	
	<!-- 替换 -->
	<!--<?php if(isset($output['store']['editorValue'][4])){ echo $output['store']['editorValue'][4];};?>-->
	<!-- 替换 -->
	
    <div class="btm">
        <div class="btm_lft">
            <p class="btm_lft_1" style='color:#F83600' >&yen;<?php echo $output['over_price'];?></p>
            <p class="btm_lft_2">需支付</p>
        </div>
        <div class="btm_btm dingdantijiaozhifu">下一步</div>
    </div>
</div>
<div>

<?php if(isset($output['store']['editorValue'][4])){ echo $output['store']['editorValue'][4];};?>
</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
<style>
	.gongyue_biao_txt table{
		width:100%;
	}
	
	.gongyue_biao_txt table tr{
		height:.7rem;
	}
	.gongyue_biao_txt table th{
		font-size:.35rem;
	}
	.gongyue_biao_txt table td{
		font-size:.3rem;
	}
	.gongyue_biao_txt table th,.gongyue_biao_txt table tr{
		text-align:center;
	}
	.gongyue_txt{
		position:absolute;
		top:0;
		left:0;
		background-color:#fff;
		width:100%;
		height:100%;
		z-index:100000000;
	}
	.gongyue_txt_queren,.gongyue_biao_cha{
		font-size:.5rem;
		text-align:center;
		background-color:#ffc603;
		color:#fff;
		height:10%;
		line-height:1.15rem;
	}
	.gongyue_txt_txt,.gongyue_biao_txt{
		padding:.3rem;
		overflow:auto;
		height:90%;
	}
	.gongyue_txt_txt p{
		font-size:.35rem;
		line-height:.5rem;
		margin-bottom:0.2rem;
		text-align:justify; 
		text-justify:distribute-all-lines;
	}
	.gongyue_biao{
		position:absolute;
		top:0;
		left:0;
		background-color:#fff;
		width:100%;
		height:100%;
		z-index:100000001;
	}
	.gongyue_biao_cha{
		font-size:.7rem;
		text-align:center;
		background-color:#ffc603;
		color:#fff;
		height:10%;
		line-height:1.15rem;
	}
	.gongyue_biao_txt{
		padding:.3rem;
		height:90%;
	}
	
</style>
</html>
<script>
	window.onload=function(){
		if(window.localStorage){
			var site11 = localStorage.getItem("aaass11");
			var site22 = localStorage.getItem("aaass22");
			var site33 = localStorage.getItem("aaass33");
			var site44 = localStorage.getItem("aaass44");
			$('.h_4_hyq').val(site11);
			$(".h_5_hm_ph").val(site22);
			$('.shenfenzheng').val(site33);
			$(".xueshengzheng").val(site44);
		}
	}
	var xueshengzheng = '';
	$('.xueshengzheng').on('blur',function(){
		xueshengzheng = $('.xueshengzheng').val();
		if(xueshengzheng != ''){
			var url = '/api/api.php?commend=new_math_order_price';
			var order_id = '<?php echo $output['order_id'];?>';
			var store_id = '<?php echo $output['order']['store_id'];?>';
			var user_id = '<?php echo $output['order']['user_id'];?>';
			$.post(url,{order_id:order_id,store_id:store_id,user_id:user_id,st_cart:xueshengzheng},function(state){
				var yuan = $('.btm_lft_1').html(); //原来支付的价格
				if(parseInt(state.msg.over_price) > 0){
					$('.btm_lft_1').html(state.msg.over_price);
					$('.h_9_1_l_xg').html(state.msg.over_price);
				}
			},'json');
		}
	});
	
	$('.dingdantijiaozhifu').click(function(){
		localStorage.clear();
		
		var data = {};
		data.pop_num = $('.h_3_jj_s').html();  //人数
		data.name = $('.h_4_hyq').val();
		
		data.phone = $('.h_5_hm_ph').val();
		
		data.id_cart = $('.shenfenzheng').val();
		data.st_cart = $('.xueshengzheng').val();
		
		data.yaoqingma = $('.h_8_ma').val();
		data.coupon_id = "<?php echo $output['coupon_id'];?>";
		data.user_id = "<?php echo $output['user']['user_id'];?>";
		data.order_id = "<?php echo $output['order_id'];?>";
		data.sign = "<?php echo $output['sign'];?>";
		var url = '/api/api.php?commend=order_buquan';
		if(data.name == ''){
			alert('请填写姓名');
			return false;
		}
		if(data.phone == ''){
			alert('请填写手机号');
			return false;
		}
		if(!(/^1[34578]\d{9}$/.test(data.phone))){
			alert('手机号有误，请重填');
			return false;
		}
		if(data.id_cart == ''){
			alert('请填写身份证');
			return false;
		}
		if(!(/^\w{15,18}$/.test(data.id_cart))){
			alert('身份证填写有误');
			return false;
		}
		var is_tongyi = document.getElementById('is_tongyi');
		if(!is_tongyi.checked){
			alert('是否同意会员公约');
			return false;
		};
		
		$.post(url,{data:data},function(state){
			if(state.msg.code =='1'){
				window.location.href="?act=order&op=dingdanzhifu&order_id=" + data.order_id;
			}else{
				alert(state.msg.msg);
			}
		},'json');
		
		
	});
	
	
	$('.h_6').on('click',function(){
		var asdgfkg11=$(".h_4_hyq").val();
		var asdgfkg22=$(".h_5_hm_ph").val();
		var asdgfkg33=$(".shenfenzheng").val();
		var asdgfkg44=$(".xueshengzhengh").val();
		localStorage.setItem("aaass11", asdgfkg11);
		localStorage.setItem("aaass22", asdgfkg22);
		localStorage.setItem("aaass33", asdgfkg33);
		localStorage.setItem("aaass44", asdgfkg44);
	})
	$('.h_09').on('click',function(){
		var asdgfkg11=$(".h_4_hyq").val();
		var asdgfkg22=$(".h_5_hm_ph").val();
		var asdgfkg33=$(".shenfenzheng").val();
		var asdgfkg44=$(".xueshengzhengh").val();
		localStorage.setItem("aaass11", asdgfkg11);
		localStorage.setItem("aaass22", asdgfkg22);
		localStorage.setItem("aaass33", asdgfkg33);
		localStorage.setItem("aaass44", asdgfkg44);
	})
	
	$('.h_10_2>span').on('click',function(){
		$('.gongyue_txt').removeClass('fade');
		$('.rd').addClass('fade');
	})
	$('.gongyue_txt_queren').on('click',function(){
		$('.gongyue_txt').addClass('fade');
		$('.rd').removeClass('fade');
	})
	
	$('.gongyue_peichang').on('click',function(){
		$('.gongyue_biao').removeClass('fade');
		//$('body').css('overflow','visible');
		$('.gongyue_txt').addClass('fade');
	})
	$('.gongyue_biao_cha').on('click',function(){
		//$('.gongyue_txt').css('overflow','auto');
		$('.gongyue_biao').addClass('fade');
		$('.gongyue_txt').removeClass('fade');
	})
</script>