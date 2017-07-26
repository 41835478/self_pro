<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">商品管理</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="goods_id" value="<?php echo isset($_GET['goods_id'])?intval($_GET['goods_id']):'';?>" >
		<p>商品名称</p>
		<input type="text" name="goods_name" value="<?php echo isset($output['data']['goods_name'])?$output['data']['goods_name']:'';?>" class="form-control m-b-10" placeholder="请填写商品名称">
		<p>商品简单描述</p>
		<input type="text" name="goods_jdesc" value="<?php echo isset($output['data']['goods_jdesc'])?$output['data']['goods_jdesc']:'';?>" class="form-control m-b-10" placeholder="请填写商品名称(可不填)">
		<p>商品标记（如使用，请使用大于0以上的整数）</p>
		<input type="text" name="goods_label" value="<?php echo isset($output['data']['goods_label'])?$output['data']['goods_label']:'';?>" class="form-control m-b-10" placeholder="用于标记商品">
		<p>商品真实价格：(所有商品显示的价格一切以此数字为准)</p>
		<input type="text" name="goods_price" value="<?php echo isset($output['data']['goods_price'])?$output['data']['goods_price']:'';?>" class="form-control m-b-10" placeholder="商品真实价格">
		<p>是否显示(商品是否会被搜索到)：</p>
        <div class="make-switch switch-mini">
			<input name="is_show" <?php if(isset($output['data']['is_show']) && $output['data']['is_show']==1 || !isset($output['data']['is_show'])){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
        <p>是否是预售商品：</p>
        <div class="make-switch switch-mini">
			<input name="is_yushou" <?php if(isset($output['data']['is_yushou']) && $output['data']['is_yushou']==1 ){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>          
		<p>商品分类</p><a class="btn btn-xs" >添加分类</a>
		<select class="select" name="cat_id">
			<option value="0" >请选择。。。</option>	
			<?php $cat_id = $output['data']['cat_id'];?>
			<?php if(isset($output['category_list']) && is_array($output['category_list'])){ ?>
			<?php 
				function show_cat($arr,$cat_id = 0){
					foreach($arr as $key => $val){ ?>
						<option <?php if($cat_id == $val['cat_id']){ ?> selected="selected" <?php }?> value="<?php echo $val['cat_id'];?>" ><?php echo $val['cat_name'];?></option>
						<?php
						if(!empty($val['list'])){ //递归
							show_cat($val['list'],$cat_id);
						}
					}
				}
				show_cat($output['category_list'],$cat_id);
			?>
			<?php } ?>
		</select>
		
		<p>商品品牌</p><a class="btn btn-xs" >添加品牌</a>
		<select class="select" name="brand_id">
			<option value="1" >Default</option>
			<option>Toyota Avalon</option>
			<option>Toyota Crown</option>
			<option>Lexus LX570</option>
		</select>
		<p>选择供货商</p>
		<select class="select" name="supplied">
			<option value="1" >Default</option>
			<option>Toyota Avalon</option>
			<option>Toyota Crown</option>
			<option>Lexus LX570</option>
		</select>
		<p>商品属性</p>
		<select class="select" name="goods_style">
			<option>Default</option>
			<option>Toyota Avalon</option>
			<option>Toyota Crown</option>
			<option>Lexus LX570</option>
		</select>
		<p>商品规格</p>
		<select class="select" name="goods_spec">
			<option>Default</option>
			<option>Toyota Avalon</option>
			<option>Toyota Crown</option>
			<option>Lexus LX570</option>
		</select>
		<div style="margin-top:20px;">
			<label class="checkbox-inline">
				<input name="is_new" type="checkbox">
				新品
			</label>
			<label class="checkbox-inline">
				<input name="is_boutique" type="checkbox">
				精品
			</label>
			<label class="checkbox-inline">
				<input name="is_recommend" type="checkbox">
				推荐
			</label>
			<label class="checkbox-inline">
				<input name="is_hot" type="checkbox">
				热销
			</label>
		</div>
		<p>商品折扣：（0-1之间<带小数点最多两位>）列如(真实价格80元。填写0.8就是折扣8折,那么显示的折扣价格是100元)</p>
		<input type="text" name="discount" value="<?php echo isset($output['data']['discount'])?$output['data']['discount']:'0.85';?>" class="form-control m-b-10" placeholder="填写折扣">
		
		<p>商品出售时间（不填写代表没有限制）(开始)</p>
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
		<p>商品出售时间（不填写代表没有限制）(结束)</p>
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
		<p>商品默认评分</p>
		<input type="text" name="goods_score" value="<?php echo isset($output['data']['goods_score'])?:'3.6';?>" class="form-control m-b-10" >
		<p>是否动态评分（此项如果开启就不会动态改变默认评分值，商品评分就会按照默认评分调用）</p>
        <div class="make-switch switch-mini">
			<input name="is_dscore" <?php if(isset($output['data']['is_dscore']) && $output['data']['is_dscore']==1 ){ ?>checked="checked"<?php } ?> type="checkbox">
		</div>
		<p>赠送消费积分（-1代表赠送积分商品价格一样）</p>
		<input type="text" name="pay_points" class="form-control m-b-10" value="<?php echo isset($output['data']['pay_points'])?$output['data']['pay_points']:'-1';?>" placeholder="">
		<p>赠送等级积分（-1代表赠送积分商品价格一样）</p>
		<input type="text" name="pay_bonus" class="form-control m-b-10" value="<?php echo isset($output['data']['pay_bonus'])?$output['data']['pay_bonus']:'-1';?>" placeholder="">
		<p>商品库存数量</p>
		<input type="text" name="goods_num" class="form-control m-b-10" placeholder="" value="<?php echo isset($output['data']['goods_num'])?$output['data']['goods_num']:'10000';?>">
		<p>商品警告数量</p>
		<input type="text" name="goods_warning_num" class="form-control m-b-10" placeholder="" value="<?php echo isset($output['data']['goods_warning_num'])?$output['data']['goods_warning_num']:'5';?>">
		<!--
		<p>是否按百分比数量警告：</p>
        <div class="make-switch switch-mini">
			<input name="is_goods_warning" type="checkbox">
		</div>
		-->
		<p>商品主图片上传1（请尽量不要上传超过2M以上的图片，可能会导致商品加载过慢）</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['goods_img'])){ ?>
					<img src="<?php echo $output['data']['goods_img'];?>">
				<?php } ?>
			</div>
			<div>
				<span class="btn btn-file btn-alt btn-sm">
					<span class="fileupload-new">上传图片</span>
					<span class="fileupload-exists">重新选择</span>
					<input type="file" name="goods_img" />
				</span>
				<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
			</div>
		</div>
		<!--
		<p>备用图片上传2</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-new thumbnail small form-control"></div>
			<div class="fileupload-preview form-control fileupload-exists thumbnail small"></div>
			<span class="btn btn-file btn-alt btn-sm">
				<span class="fileupload-new">上传图片</span>
				<span class="fileupload-exists">重新选择</span>
				<input type="file" />
			</span>
			<a href="#" class="btn-sm btn fileupload-exists" data-dismiss="fileupload">删除</a>
		</div>
		<p>备用图片上传3</p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="fileupload-new thumbnail small form-control"></div>
			<div class="fileupload-preview form-control fileupload-exists thumbnail small"></div>
			<span class="btn btn-file btn-alt btn-sm">
				<span class="fileupload-new">上传图片</span>
				<span class="fileupload-exists">重新选择</span>
				<input type="file" />
			</span>
			<a href="#" class="btn-sm btn fileupload-exists" data-dismiss="fileupload">删除</a>
		</div>
		-->
		<!--
		<a class="btn btn-xs" onclick="add_img()" >添加图片数量（1）</a>       
		<a class="btn btn-xs" onclick="add_img()" >删除图片数量（1）</a>
		-->	
		<p>组图上传</p>
		<div class="upload_imgs">
			<?php $i = 0; ?>
			<?php for($i ; $i < 10; $i++){ ?>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-preview thumbnail form-control">
				<?php if(!empty($output['data']['goods_images'][$i])){ ?>
					<img id="imgs_<?php echo substr(basename($output['data']['goods_images'][$i]),0,19);?>" src="<?php echo $output['data']['goods_images'][$i];?>">
				<?php } ?>
				</div>
				<div>
					<span class="btn btn-file btn-alt btn-sm">
						<span class="fileupload-new">上传图片</span>
						<span class="fileupload-exists">重新选择</span>
						<input type="file" name="goods_images[]" />
					</span>
					<?php if(!empty($output['data']['goods_images'][$i])){ ?>
						<a style="display:inline-flex" class="btn fileupload-exists btn-sm" onclick="delete_images(<?php echo intval($_GET['goods_id']);?>,'<?php echo basename($output['data']['goods_images'][$i]);?>','<?php echo substr(basename($output['data']['goods_images'][$i]),0,19);?>')" >删除</a>
					<?php }else{ ?>
						<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">删除</a>
					<?php } ?>
					
				</div>
			</div>
			<?php } ?>
		</div>
		<p>商品描述（使用的是百度编辑器，不兼容的情况请使用内核ie8以上的浏览器，插件速度较慢，请耐心等待）</p>
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
<script>
	function delete_images(goods_id,image,hide_id){
		url = "?act=goods&op=goods_images_del";
		$.post(url,{goods_id:goods_id,image:image},function(state){
			if(state.code == 1){
				$('#imgs_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
		
	}
</script>
