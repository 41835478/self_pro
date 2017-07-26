<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>

<?php
	$output['data']['xiaofei_text'] = str_replace(array('#','hr'),
												  array('&nbsp;&nbsp;&nbsp;','<hr></hr>'),
												  $output['data']['xiaofei_text']);
?>
<?php echo $output['data']['xiaofei_text'];?>
<div class="qianming" >
	<div>电子签名，交易有保障</div>
	<img src="<?php echo str_replace(' ','+',$output['data']['image']);?>">
</div>
</div>	
</section>

<style>
	table{
		width:95%;
		
	}
	.qianming{
		margin:0 auto;
		width:95%;
	}
</style>
