<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">账号管理</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<!--admin_id-->
		<input type="hidden" name="admin_id" value="<?php echo isset($output['data']['admin_id'])?$output['data']['admin_id']:'';?>" >
		<?php if(isset($output['is_add'])){ ?>
		<p>账号</p>
		<input type="text" name="username" value="<?php echo isset($output['data']['username'])?$output['data']['username']:'';?>" class="form-control m-b-10" placeholder="账号">
		<?php } ?>
		<?php if(isset($output['is_edit'])){ ?>
		<p>账号</p>
		<input type="text" name="username" disabled="disabled" value="<?php echo isset($output['data']['username'])?$output['data']['username']:'';?>" class="form-control m-b-10" >
		<input type="hidden" name="username" value="<?php echo isset($output['data']['username'])?$output['data']['username']:'';?>" class="form-control m-b-10" >
		<?php } ?>
		<p>密码</p>
		<input type="password" name="password" class="form-control m-b-10" placeholder="密码">
		<p>确认密码</p>
		<input type="password" name="password2" class="form-control m-b-10" placeholder="确认密码">
		<p>真实姓名</p>
		<input type="text" name="admin_name" value="<?php echo isset($output['data']['admin_name'])?$output['data']['admin_name']:'';?>" class="form-control m-b-10" placeholder="姓名">
		<p>邮箱</p>
		<input type="text" name="email" value="<?php echo isset($output['data']['email'])?$output['data']['email']:'';?>" class="form-control m-b-10" placeholder="邮箱">
		<p>管理员类型</p>
		<?php $admin_type = array('无','店铺管理员','管家账号','报销帐号'); ?>
		<select class="select" name="admin_type">
			<!--<option value="0">无</option>-->
			<?php foreach($admin_type as $key => $val){ ?>
			<option value="<?php echo $key;?>" <?php if(isset($output['data']['admin_type']) && $output['data']['admin_type'] == $key){ ?> selected="selected" <?php }?>  ><?php echo $val;?></option>
			<?php } ?>
		</select>
		<p>店铺</p>
		<?php $store_list = $output['store_list'];?>
		<select class="select" name="store_id">
			<option value="0">请选择店铺</option>
			<?php foreach($store_list as $key => $val){ ?>
			<option value="<?php echo $val['store_id'];?>" <?php if(isset($output['data']['store_id']) && $output['data']['store_id'] == $val['store_id']){ ?> selected="selected" <?php }?>  ><?php echo $val['store_name'];?></option>
			<?php } ?>
		</select>
		
		<?php if(isset($output['group']) && !empty($output['group'])){ ?>
		<p>是否使用组控制：</p>
        <div class="make-switch switch-mini">
			<input name="is_group" <?php if(isset($output['data']['is_group']) && $output['data']['is_group']==1 ){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<select class="select" name="group">
			<option value="0">请选择</option>
			<?php foreach($output['group'] as $key => $val){ ?>
			<option value="<?php echo $val['group_id']?>" ><?php echo $val['group_name']?></option>
		</select>
		<?php } ?>
		<?php } ?>
		<p>图标设置</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(isset($output['data']['admin_logo'])){ ?>
					<img src="<?php echo $output['data']['admin_logo'];?>" >
				<?php } ?>
			</div> 
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="admin_logo" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
		</div>
		<?php if(isset($output['weight']) && !empty($output['weight']) 
			//有控制器
			&& isset($output['weight']['top']) && !empty($output['weight']['top'])
			//方法
			&& isset($output['weight']['left']) && !empty($output['weight']['left'])
		){ ?>
		<p>权限:</p>
		<!--有权限-->
		<table>
		<?php foreach($output['weight']['top'] as $key => $val){ ?>
			<tr>
				<th>
					<div  class="select_weight <?php echo $key;?>" onclick="all_weight(<?php echo $key;?>)" ></div>
					<?php echo $val[0];?>：
					<input type="hidden" id="all_<?php echo $key;?>" name="t[]" value="<?php echo $key;?>" >
					<!--
					<label class="checkbox-inline">
						<?php echo $val[0];?>：
					</label>
					-->
				</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr class="op<?php echo $key;?>">
				<td></td><!--这个空一格-->
				<?php foreach($output['weight']['left'][$key] as $k => $v){ ?>
					<?php if($k%5 == 0 && $k != 0){ ?>
					<tr class="op<?php echo $key;?>" >
					<td></td><!--这个空一格-->
					<?php } ?>
					<td>
						<label class="checkbox-inline">
							<input <?php if(isset($v[2]) && $v[2] == true){ ?> checked="checked" <?php } ?> name="t<?php echo $key;?>[]" value="<?php echo $k;?>" type="checkbox">
							<?php echo $v[0];?>&nbsp
						</label>
					</td>
					<?php if($k%5 == 0 && $k != 0){ ?>
					<?php } ?>
				<?php } ?>
			</tr>
		<?php } ?>
		<?php } ?>
		</table>
		<div style="width:100%;height:1px;">
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
<script>
	var select = true;
	function all_weight(num){
		if(select){
			$('#all_'+num).attr('value',num);
			$('.op'+num+' input').attr('checked','checked');
			$('.op'+num+' div').attr('aria-checked','true');
			$('.op'+num+' div').attr('class','icheckbox_minimal checked');
			$('.select_weight.'+num).css('background','rgba(255, 255, 255,0.6)');
		}else{
			$('#all_'+num).attr('value','');
			$('.op'+num+' input').attr('checked','none');
			$('.op'+num+' div').attr('aria-checked','false');
			$('.op'+num+' div').attr('class','icheckbox_minimal');
			$('.select_weight.'+num).css('background','none');
		}
		select = !select;
	}
</script>
<style>
.select_weight{
	display: inline-block;
    vertical-align: middle;
    padding: 0;
    width: 15px;
    height: 15px;
    border: 1px solid rgba(255,255,255,0.4);
    float: left;
    cursor: pointer;
	margin-right:5px;
	background : rgba(255, 255, 255,0.6);
}
</style>