<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">编辑文章</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="article_id" value="<?php echo isset($_GET['article_id'])?intval($_GET['article_id']):'';?>" >
		<p>文章名称</p>
		<input type="text" name="title" value="<?php echo isset($output['data']['title'])?$output['data']['title']:'';?>" class="form-control m-b-10" placeholder="文章名称" >
		<p>关键字</p>
		<input type="text" name="keyword" value="<?php echo isset($output['data']['keyword'])?$output['data']['keyword']:'';?>" class="form-control m-b-10" placeholder="关键字" >
		<p>文章简标题</p>
		<input type="text" name="j_title" value="<?php echo isset($output['data']['j_title'])?$output['data']['j_title']:'';?>" class="form-control m-b-10" placeholder="简标题" >
		
		<p>分类标记</p>
		<input type="text" name="label" value="<?php echo isset($output['data']['label'])?$output['data']['label']:'';?>" class="form-control m-b-10" placeholder="标记">
		
		<p>文章分类</p><a class="btn btn-xs" >添加分类</a>
		<select class="select" name="article_class_id">
			<option value="0" >请选择。。。</option>	
			<?php $article_id = $output['data']['article_id'];?>
			<?php if(isset($output['class_list']) && is_array($output['class_list'])){ ?>
			<?php 
				function show_class($arr,$article_id = 0){
					foreach($arr as $key => $val){ ?>
						<option <?php if($article_id == $val['class_id']){ ?> selected="selected" <?php }?> value="<?php echo $val['class_id'];?>" ><?php echo $val['class_name'];?></option>
						<?php
						if(!empty($val['list'])){ //递归
							show_class($val['list'],$article_id);
						}
					}
				}
				show_class($output['class_list'],$article_id);
			?>
			<?php } ?>
		</select>
		
		<p>是否显示：</p>
        <div class="make-switch switch-mini">
			<input name="is_show" <?php if(isset($output['data']['is_show']) && $output['data']['is_show']==1 || !isset($output['data']['is_show'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<p>文章内容（使用的是百度编辑器，不兼容的情况请使用内核ie8以上的浏览器，插件速度较慢，请耐心等待）</p>
		<div class="baidu_text" style="width:100%;float:left">
			<?php echo $output['baidu_text'];?>
			<?php if(!empty($output['data']['editorValue'])){ ?>
			<script>
				setTimeout(function(){
					UE.getEditor('editor').setContent('<?php echo $output['data']['editorValue'];?>');
				},200);
				setTimeout(function(){
					UE.getEditor('editor').setContent('<?php echo $output['data']['editorValue'];?>');
				},500);
				setTimeout(function(){
					UE.getEditor('editor').setContent('<?php echo $output['data']['editorValue'];?>');
				},800);
			</script>
			<?php } ?>
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