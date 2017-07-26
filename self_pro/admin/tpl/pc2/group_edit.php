<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/goods.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">组操作</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="group_id" value="<?php echo isset($output['data']['group_id'])?$output['data']['group_id']:'';?>" >
		<p>组名称</p>
		<input type="text" name="group_name" value="<?php echo isset($output['data']['group_name'])?$output['data']['group_name']:'';?>" class="form-control m-b-10" placeholder="请填写组名称">
        <p>组权限:</p>
		<!--有权限-->
		<?php if(isset($output['weight']) && !empty($output['weight']) 
			//有控制器
			&& isset($output['weight']['top']) && !empty($output['weight']['top'])
			//方法
			&& isset($output['weight']['left']) && !empty($output['weight']['left'])
		){ ?>
		<table>
		<?php foreach($output['weight']['top'] as $key => $val){ ?>
			<tr>
				<th>
					<div class="select_weight <?php echo $key;?> <?php if($val[2] == 1){ ?>weiselected<?php }?>" onclick="all_weight(<?php echo $key;?>)" ></div>
					<?php echo $val[0];?>：
					<input type="hidden" id="all_<?php echo $key;?>" name="t[]" <?php if($val[2] == 1){ ?> value="<?php echo $key;?>" <?php }else{ ?> data="selected"<?php } ?> >
					<!--
					<label class="checkbox-inline">
						<input value="<?php echo $key;?>" name="t[]" type="checkbox">
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
					</tr>
					<tr class="op<?php echo $key;?>" >
					<td></td><!--这个空一格-->
					<?php } ?>
					<td>
						<label class="checkbox-inline">
							<div class="one_weight <?php echo $key;?>_<?php echo $k;?> <?php if(isset($v[2]) && $v[2] == 1){ ?>weiselected<?php } ?>" onclick="one_weight(<?php echo $key;?>,<?php echo $k;?>)" ></div>
							<input type="hidden" data2="<?php echo $k;?>" class="t_<?php echo $key;?>" id="t_<?php echo $key;?>_<?php echo $k;?>"  name="t_<?php echo $key;?>[]"  <?php if(isset($v[2]) && $v[2] == 1){ ?> value="<?php echo $k;?>" <?php } ?> >
							<!--
							<input name="t<?php echo $key;?>[]" value="<?php echo $k;?>" type="checkbox">
							-->
							<?php echo $v[0];?>&nbsp
						</label>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
        <?php } ?>
        </table>
		<div style="width:100%;height:1px;">
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
	var select = [];
	function all_weight(num){
		var selected = $('#all_'+num).attr('data');
		if(selected == 'selected'){
			$('#all_'+num).removeAttr('data');
			
			$('#all_'+num).attr('value',num);
			$('.op'+num+' input').attr('checked','checked');
			$('.op'+num+' div').attr('aria-checked','true');
			$('.op'+num+' div').addClass('weiselected');
		//	$('.op'+num+' input').attr('data','selected');
			$('.select_weight.'+num).attr('class','select_weight ' + num + ' weiselected');
			
			var list = $('.t_'+num);
			
			var len = list.length;
		//	console.log(len);
			for(var i = 0 ; i < len ; i++){
				list[i].value = $('#t_'+num+'_'+i).attr('data2');
			}
		}else{
			$('#all_'+num).attr('data','selected');
			
			$('#all_'+num).attr('value','');
			//必须移出
			$('.op'+num+' input').removeAttr('checked');
			$('.op'+num+' div').attr('aria-checked','none');
			$('.op'+num+' div').removeClass('weiselected');
			$('.select_weight.' +num+ '.weiselected').attr('class','select_weight '+num);
			
			$('.t_'+num).removeAttr('value');
		}
	}
	
	var select1 = [];
	var select2 = [];
	var select_d = [];
	function one_weight(num1,num2){
		var selected = $('#t_'+num1+'_'+num2).attr('data');
		if(selected == 'selected'){
			$('#t_'+num1+'_'+num2).removeAttr('data');
			$('#t_'+num1+'_'+num2).attr('value',num2);
			$('#t_'+num1+'_'+num2).attr('data2',num2);
			select2[num2] = true;
			select1[num1] = select2;
			$('.one_weight.'+num1+'_'+num2).attr('class','one_weight ' + num1+'_'+num2 + ' weiselected');
		}else{
			$('#t_'+num1+'_'+num2).attr('data','selected');
			$('#t_'+num1+'_'+num2).removeAttr('value',num2);
			$('#t_'+num1+'_'+num2).attr('data2',num2);
			select2[num2] = false;
			select1[num1] = select2;
			$('.one_weight.' +num1+'_'+num2+ '.weiselected').attr('class','one_weight '+num1+'_'+num2);
		}
	}
</script>

