<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">报销列表</h3>
	
	<div class="table-responsive overflow">
		<table class="tile table table-bordered table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>姓名</th>
					<th>金额</th>
					<th>备注</th>
					<th>是否通过</th>
					<th>申请时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($output['data']) && !empty($output['data'])){ ?>
				<?php foreach($output['data'] as $key => $val){  ?>
					<tr class="show_images" images="<?php echo $val['b_images'];?>">
						<td><?php echo $val['b_id'];?></td>
						<td><?php echo $val['b_name'];?></td>
						<td><?php echo $val['b_price'];?></td>
						<td><?php echo $val['b_beizhu'];?></td>
						<td><?php echo $val['is_use'];?></td>
						<td><?php echo date('Y-m-d H:i:s',$val['create_time']);?></td>
						<td><a href="?act=baoxiao&op=baoxiao_edit&is_use=1&b_id=<?php echo $val['b_id'];?>" >通过</a>|<a href="?act=baoxiao&op=baoxiao_edit&is_use=2&b_id=<?php echo $val['b_id'];?>">不通过</a></td>
					</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<!--页码start-->
	<?php echo $output['page'];?>
	<!--页码end-->
	<div class="images" style="display:none;min-width:60%;margin-top:20px;">
</section>
<script>
	$('.show_images').click(function(){
		var img = $(this).attr('images');
		if(img != ''){
			var images = img.split(',');
			var str = '';
			str += "<a style='float:left;' class='btn' onclick='images_hide()'>确定</a><div style='width:100%;float:left' ></div>";
			for(x in images){
				str += '<div style="max-width:20%;float:left"><img  src="'+ images[x] +'"></div>';
			}
			$('.images').html(str);
			$('.images').show();
		}
	});
	function images_hide(){
		$('.images').hide();
	}
</script>