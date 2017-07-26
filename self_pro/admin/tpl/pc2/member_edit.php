<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">用户管理</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="user_id" value="<?php echo isset($_GET['user_id'])?intval($_GET['user_id']):'';?>" >
		<p>会员名</p>
		<input type="text" value="<?php echo isset($output['data']['user_name'])?$output['data']['user_name']:'';?>" class="form-control m-b-10" placeholder="">
		<p>用户真实姓名</p>
		<input type="text" name="true_name" value="<?php echo isset($output['data']['true_name'])?$output['data']['true_name']:'';?>" class="form-control m-b-10" placeholder="">
		<p>手机号</p>
		<input type="text" value="<?php echo isset($output['data']['phone'])?$output['data']['phone']:'';?>" class="form-control m-b-10" placeholder="">
		<p>邮箱</p>
		<input type="text" value="<?php echo isset($output['data']['user_email'])?$output['data']['user_email']:'';?>" class="form-control m-b-10" placeholder="">
		<p>站内金币</p>
		<input type="text" name="user_gold" value="<?php echo isset($output['data']['user_gold'])?$output['data']['user_gold']:'';?>" class="form-control m-b-10" placeholder="">
		<p>冻结资金</p>
		<input type="text" name="frozen_gold" value="<?php echo isset($output['data']['frozen_gold'])?$output['data']['frozen_gold']:'';?>" class="form-control m-b-10" placeholder="">
		<p>用户积分</p>
		<input type="text" name="user_integral" value="<?php echo isset($output['data']['user_integral'])?$output['data']['user_integral']:'';?>" class="form-control m-b-10" placeholder="">
		<p>性别</p>
		<?php $user_sex = array('1'=>'男','2'=>'女','3'=>'未知');?>
		<div class="radio">
			<?php foreach($user_sex as $key => $val){ ?>
			<label class="user_sex" for="user_sex_<?php echo $key;?>" style="float:left">
			<input <?php if(isset($output['data']['user_sex']) && $output['data']['user_sex'] == $key){ ?>checked<?php } ?> id="user_sex_<?php echo $key;?>" type="radio" name="user_sex" value="<?php echo $key;?>" >
				<?php echo $val;?>
			</label>	
			<?php } ?>
		</div>
		<?php $user_state = array('1'=>'允许','2'=>'冻结资金','3'=>'禁止登陆'); ?>
		<p>用户状态</p>
		<select class="select" name="user_state">
			<?php foreach($user_state as $key => $val){ ?>
				<option value="<?php echo $key;?>" <?php if(isset($output['data']['user_state']) && $output['data']['user_state'] == $key){ ?>selected="selected"<?php } ?> ><?php echo $val;?></option>
			<?php } ?>
		</select>
		
		<p>注册日期</p>
		<input type="text" value="<?php echo isset($output['data']['add_time'])?$output['data']['add_time']:'';?>" class="form-control m-b-10" placeholder="">
		<p>会员图标</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['user_logo'])){ ?>
					<img src="<?php echo $output['data']['user_logo'];?>">
				<?php } ?>
			</div>
			<!--
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="user_logo" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
			-->
		</div>
		<!--空盒子-->
		<div class="empty_box" style="width:100%;margin-top:30px;float:left" ></div>
		
		<a onclick="enter()" class="btn btn-lg m-r-5">确认</a>
		<a onclick="enter()" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">确认</a>
	</form>
</section>
<!--content内容结束-->
<script>
	function enter(){
		$('.from_box').submit();
	}
</script>
<style>
	.user_sex{
		margin-right:20px;
	}
</style>
