<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">支付编辑</h3>
	<!-- 支付宝支付 开始 -->
	<?php if(isset($output['pay_type']) && $output['pay_type'] == 'ali'){ ?>
		<form class="from_box" action="" method="post" enctype="multipart/form-data" >
			<input type="hidden" name="id" value="<?php echo isset($_GET['id'])?intval($_GET['id']):'';?>" >
			<p>支付名称</p>
			<input type="text" name="name" value="<?php echo isset($output['data']['name'])?$output['data']['name']:'';?>" class="form-control m-b-10" placeholder="名称">
			<p>中文名称</p>
			<input type="text" name="chinese_name" value="<?php echo isset($output['data']['chinese_name'])?$output['data']['chinese_name']:'';?>" class="form-control m-b-10" placeholder="">
			<p>是否开启</p>
			<div class="make-switch switch-mini">
				<input name="is_open" <?php if(isset($output['data']['is_open']) && $output['data']['is_open']==1 || !isset($output['data']['is_open'])){ ?>checked="checked"<?php } ?> type="checkbox">
			</div>
			<p>app_id</p>
			<input type="text" name="app_id" value="<?php echo isset($output['data']['app_id'])?$output['data']['app_id']:'';?>" class="form-control m-b-10" placeholder="">
			<p>商户私钥，您的原始格式RSA私钥</p>
			<input type="text" name="merchant_private_key" value="<?php echo isset($output['data']['merchant_private_key'])?$output['data']['merchant_private_key']:'';?>" class="form-control m-b-10" placeholder="">
			<p>支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。</p>
			<input type="text" name="alipay_public_key" value="<?php echo isset($output['data']['alipay_public_key'])?$output['data']['alipay_public_key']:'';?>" class="form-control m-b-10" placeholder="">
			<p>支付完成跳转地址（可不填）</p>
			<input type="text" name="return_url" value="<?php echo isset($output['data']['return_url'])?$output['data']['return_url']:'';?>" class="form-control m-b-10" placeholder="">
			
			<!--空盒子-->
			<div class="empty_box" style="width:100%;margin-top:30px;float:left" ></div>
			
			<!-- 数组 -->
			<input type="hidden" name="data_array" value="app_id|merchant_private_key|alipay_public_key|return_url" class="form-control m-b-10" placeholder="">
			
			<a onclick="enter()" class="btn btn-lg m-r-5">确认</a>
			<a onclick="enter()" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">确认</a>
		</form>
	<?php } ?>
	<!-- 支付宝支付 结束 -->
</section>
<!--content内容结束-->
<script>
	function enter(){
		$('.from_box').submit();
	}
</script>

