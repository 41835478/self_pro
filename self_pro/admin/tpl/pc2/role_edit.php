<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">用户权限</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="role_id" value="<?php echo isset($_GET['role_id'])?intval($_GET['role_id']):'';?>" >
		<p>用户名称</p>
		<input type="text" name="username" value="<?php echo isset($output['data']['username'])?$output['data']['username']:'';?>" class="form-control m-b-10" placeholder="名称">
		<p>权限名称</p>
		<select class="select" name="group_id">
			<option value="0" >请选择。。</option>
			<?php if(isset($output['group']) && !empty($output['group'])){}{ ?>
			<?php foreach($output['group'] as $key => $val){ ?>
				<option <?php if(isset($output['data']['group_id']) && $val['group_id'] == $output['data']['group_id']){ ?>selected="selected"<?php } ?> value="<?php echo $val['group_id'];?>" ><?php echo $val['group_name']?></option>
			<?php }?>
			<?php }?>
		</select>
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
