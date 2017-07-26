<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">一元购物活动</h3>
	<p>活动规则:</p>
	<p>本活动是以下面填写的价格为基准售卖，商品一旦申请成功将会生成此类价格是商品（默认价格为一元，运费按照商品运费计算，或者使用标准运费）</p>
	<p>即便是一元的价格也可能需要产生运费，由商家自己决定</p>
	<p>时间可以是无限制的，也可以是规定时间的</p>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="one_id" value="<?php echo isset($_GET['one_id'])?intval($_GET['one_id']):'';?>" >
		<p>名称（此名称只做后台识别）</p>
		<input type="text" name="name" value="<?php echo isset($output['data']['name'])?$output['data']['name']:'';?>" class="form-control m-b-10" placeholder="请填写分类名称">
		<p>一元购标题</p>
		<input type="text" name="title" value="<?php echo isset($output['data']['title'])?$output['data']['title']:'';?>" class="form-control m-b-10" placeholder="">
		<p>一元购副标题</p>
		<input type="text" name="title2" value="<?php echo isset($output['data']['title2'])?$output['data']['title2']:'';?>" class="form-control m-b-10" placeholder="">
		<p>一元购价格（使用此价格标准）</p>
		<input type="text" name="one_price" value="<?php echo isset($output['data']['one_price'])?$output['data']['one_price']:'1';?>" class="form-control m-b-10" placeholder="">
		<p>一元购排序（如果相同商品申请了不同的一元购，以此数值大者为准）</p>
		<input type="text" name="one_sort" value="<?php echo isset($output['data']['one_sort'])?$output['data']['one_sort']:'';?>" class="form-control m-b-10" placeholder="">
		
		<p>一元购图片</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['one_img'])){ ?>
					<img id="img_<?php echo substr(basename($output['data']['one_img']),0,19);?>" src="<?php echo $output['data']['one_img'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="one_img" />
				</span>
				<?php if(!empty($output['data']['one_img'])){ ?>
					<a style="display:inline-flex" class="btn fileupload-exists btn-sm" onclick="delete_images(<?php echo intval($_GET['one_img']);?>,'<?php echo substr(basename($output['data']['one_img']),0,19);?>')" >删除</a>
				<?php }else{ ?>
					<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
				<?php } ?>
			</div>
		</div>
		
		<p>一元购（不填写代表没有限制）(开始)</p>
		<!-- Date Time Picker -->
		<div class="row">
			<div class="col-md-4 m-b-15">
				<p>日期</p>
				<div class="input-icon datetime-pick date-only">
					<input data-format="yyyy-MM-dd" name="start_day" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['start_day'])?$output['data']['start_day']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
			<div class="col-md-4 m-b-15">
				<p>小时</p>
				<div class="input-icon datetime-pick time-only">
					<input data-format="hh:mm:ss" name="start_hour" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['start_hour'])?$output['data']['start_hour']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
		</div>
		<p>一元购（不填写代表没有限制）(结束)</p>
		<!-- Date Time Picker -->
		<div class="row">
			<div class="col-md-4 m-b-15">
				<p>日期</p>
				<div class="input-icon datetime-pick date-only">
					<input data-format="yyyy-MM-dd" name="end_day" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['end_day'])?$output['data']['end_day']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
			<div class="col-md-4 m-b-15">
				<p>小时</p>
				<div class="input-icon datetime-pick time-only">
					<input data-format="hh:mm:ss" name="end_hour" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['end_hour'])?$output['data']['end_hour']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
		</div>
		
		<p>是否审核</p>
        <div class="make-switch switch-mini">
			<input name="is_review" <?php if(isset($output['data']['is_review']) && $output['data']['is_review']==1 || !isset($output['data']['is_review'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<div class="form-group m-b-15">
			<label>一元购描述</label>
			<textarea name="one_desc" class="input-sm validate[required] form-control" placeholder=""><?php echo isset($output['data']['one_desc'])?$output['data']['one_desc']:'';?></textarea>
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
		url = "?act=category&op=category_images_del";
		$.post(url,{cat_id:cat_id},function(state){
			if(state.code == 1){
				$('#img_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
	}
</script>