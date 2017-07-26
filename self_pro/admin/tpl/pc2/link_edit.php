<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">友情链接</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="link_id" value="<?php echo isset($_GET['link_id'])?intval($_GET['link_id']):'';?>" >
		<p>链接名称</p>
		<input type="text" name="link_name" value="<?php echo isset($output['data']['link_name'])?$output['data']['link_name']:'';?>" class="form-control m-b-10" placeholder="名称">
		<p>链接地址</p>
		<input type="text" name="link_url" value="<?php echo isset($output['data']['link_url'])?$output['data']['link_url']:'';?>" class="form-control m-b-10" placeholder="地址">
		<!--
		<p>是否按百分比数量警告：</p>
        <div class="make-switch switch-mini">
			<input name="is_goods_warning" type="checkbox">
		</div>
		-->
		<p>连接图片（如有需要可以上传图片）</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['link_img'])){ ?>
					<img src="<?php echo $output['data']['link_img'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="link_img" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
		</div>
		<p>排序（如果不使用这个排序就会按照添加时间排序）</p>
		<input type="text" name="link_sort" value="<?php echo isset($output['data']['link_sort'])?$output['data']['link_sort']:'';?>" class="form-control m-b-10" placeholder="">
		
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
