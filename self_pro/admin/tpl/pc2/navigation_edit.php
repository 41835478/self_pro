<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">导航操作</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="cat_id" value="<?php echo isset($_GET['cat_id'])?intval($_GET['cat_id']):'';?>" >
		<p>导航名称</p>
		<input type="text" name="cat_name" value="<?php echo isset($output['data']['cat_name'])?$output['data']['cat_name']:'';?>" class="form-control m-b-10" placeholder="请填写分类名称">
		<p>导航简标题</p>
		<input type="text" name="cat_jname" value="<?php echo isset($output['data']['cat_jname'])?$output['data']['cat_jname']:'';?>" class="form-control m-b-10" placeholder="分类简标题">
		<p>链接地址</p>
		<input type="text" name="cat_url" value="<?php echo isset($output['data']['cat_url'])?$output['data']['cat_url']:'';?>" class="form-control m-b-10" placeholder="分类简标题">
		
		<p>上级分类</p>
		<select class="select" name="cat_pid">
			<option value="0" >请选择。。。</option>	
			<?php $cat_pid = $output['data']['cat_pid'];$cat_id = $output['data']['cat_id'];?>
			<?php if(isset($output['cat_list']) && is_array($output['cat_list'])){ ?>
			<?php 
				function show_cat($arr,$cat_pid,$cat_id){
					foreach($arr as $key => $val){ ?>
						<?php if($cat_id == $val['cat_id']){ continue; } //这句是去掉自己 ?>
						
						<option <?php if($cat_pid != 0 && $cat_pid == $val['cat_id']){ ?> selected="selected" <?php }?> value="<?php echo $val['cat_id'];?>" ><?php echo $val['cat_name'];?></option>
						
						<?php
						if(!empty($val['list'])){ //递归
							show_cat($val['list'],$cat_pid,$cat_id);
						}
					}
				}
				show_cat($output['cat_list'],$cat_pid,$cat_id);
			?>
			<?php } ?>
		</select>
		<p>导航图片上传（类似与导航图标）</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['cat_img'])){ ?>
					<img id="img_<?php echo substr(basename($output['data']['cat_img']),0,19);?>" src="<?php echo $output['data']['cat_img'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="cat_img" />
				</span>
				<?php if(!empty($output['data']['cat_img'])){ ?>
					<a style="display:inline-flex" class="btn fileupload-exists btn-sm" onclick="delete_images(<?php echo intval($_GET['cat_id']);?>,'<?php echo substr(basename($output['data']['cat_img']),0,19);?>')" >删除</a>
				<?php }else{ ?>
					<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
				<?php } ?>
			</div>
		</div>
		<p>导航标记</p>
		<input type="text" name="cat_label" value="<?php echo isset($output['data']['cat_label'])?$output['data']['cat_label']:'';?>" class="form-control m-b-10" placeholder="标记">
		<p>是否显示：(此项不显示，首页也不会显示)</p>
        <div class="make-switch switch-mini">
			<input name="is_show" <?php if(isset($output['data']['is_show']) && $output['data']['is_show']==1 || !isset($output['data']['is_show'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<p>首页是否显示：</p>
        <div class="make-switch switch-mini">
			<input name="is_home_show" <?php if(isset($output['data']['is_home_show']) && $output['data']['is_home_show']==1 || !isset($output['data']['is_home_show'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<div class="form-group m-b-15">
			<label>导航描述</label>
			<textarea name="cat_desc" class="input-sm validate[required] form-control" placeholder=""><?php echo isset($output['data']['cat_desc'])?$output['data']['cat_desc']:'';?></textarea>
		</div>
		
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
	function delete_images(cat_id,hide_id){
		url = "?act=navigation&op=navigation_images_del";
		$.post(url,{cat_id:cat_id},function(state){
			if(state.code == 1){
				$('#img_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
	}
</script>