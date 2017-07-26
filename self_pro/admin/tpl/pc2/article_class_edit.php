<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">文章分类</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="class_id" value="<?php echo isset($_GET['class_id'])?intval($_GET['class_id']):'';?>" >
		<p>分类名称</p>
		<input type="text" name="class_name" value="<?php echo isset($output['data']['class_name'])?$output['data']['class_name']:'';?>" class="form-control m-b-10" placeholder="请填写分类名称">
		<p>分类简标题</p>
		<input type="text" name="class_jname" value="<?php echo isset($output['data']['class_jname'])?$output['data']['class_jname']:'';?>" class="form-control m-b-10" placeholder="分类简标题">
		
		<p>上级分类</p>
		<select class="select" name="class_pid">
			<option value="0" >请选择。。。</option>	
			<?php $class_pid = $output['data']['class_pid'];$class_id = $output['data']['class_id'];?>
			<?php if(isset($output['class_list']) && is_array($output['class_list'])){ ?>
			<?php 
				function show_class($arr,$class_pid,$class_id){
					foreach($arr as $key => $val){ ?>
						<?php if($class_id == $val['class_id']){ continue; } //这句是去掉自己 ?>
						
						<option <?php if($class_pid != 0 && $class_pid == $val['class_id']){ ?> selected="selected" <?php }?> value="<?php echo $val['class_id'];?>" ><?php echo $val['class_name'];?></option>
						
						<?php
						if(!empty($val['list'])){ //递归
							show_class($val['list'],$class_pid,$class_id);
						}
					}
				}
				show_class($output['class_list'],$class_pid,$class_id);
			?>
			<?php } ?>
		</select>
		<p>分类图片上传（类似与分类图标）</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['class_img'])){ ?>
					<img id="img_<?php echo substr(basename($output['data']['class_img']),0,19);?>" src="<?php echo $output['data']['class_img'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="class_img" />
				</span>
				<?php if(!empty($output['data']['class_img'])){ ?>
					<a style="display:inline-flex" class="btn fileupload-exists btn-sm" onclick="delete_images(<?php echo intval($_GET['class_id']);?>,'<?php echo substr(basename($output['data']['class_img']),0,19);?>')" >删除</a>
				<?php }else{ ?>
					<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
				<?php } ?>
			</div>
		</div>
		<p>分类标记</p>
		<input type="text" name="class_label" value="<?php echo isset($output['data']['class_label'])?$output['data']['class_label']:'';?>" class="form-control m-b-10" placeholder="标记">
		
		<p>是否显示：</p>
        <div class="make-switch switch-mini">
			<input name="is_show" <?php if(isset($output['data']['is_show']) && $output['data']['is_show']==1 || !isset($output['data']['is_show'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<!--
		<p>首页是否显示：</p>
        <div class="make-switch switch-mini">
			<input name="is_home_show" <?php if(isset($output['data']['is_home_show']) && $output['data']['is_home_show']==1 || !isset($output['data']['is_home_show'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		-->
		<div class="form-group m-b-15">
			<label>分类描述</label>
			<textarea name="class_desc" class="input-sm validate[required] form-control" placeholder=""><?php echo isset($output['data']['class_desc'])?$output['data']['class_desc']:'';?></textarea>
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
	function delete_images(class_id,hide_id){
		url = "?act=article&op=article_images_del";
		$.post(url,{class_id:class_id},function(state){
			if(state.code == 1){
				$('#img_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
	}
</script>