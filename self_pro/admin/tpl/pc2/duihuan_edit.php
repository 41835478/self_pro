<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">兑换码编辑</h3>
		<form class="from_box" action="" method="post" enctype="multipart/form-data" style="padding-bottom: 10px;" >
		<input type="hidden" name="d_id" value="<?php echo isset($_GET['d_id'])?intval($_GET['d_id']):'';?>">
		
		<p>金额</p>
		<input type="text" name="d_price" value="<?php echo isset($output['data']['d_price'])?$output['data']['d_price']:'';?>" class="form-control m-b-10" placeholder="">
		
		<input type="submit" value="确认" class="btn btn-lg m-r-5">
		<input type="submit" value="确认" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">
		</form>
		<!-- 轮播广告 -->
</section>
<!--content内容结束-->

