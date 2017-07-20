<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<html>
<head>
<title><?php echo $output['login']['login_title'];?></title>
</head>
<body>
<a href="?act=baoxiao&op=baoxiao" >申请报销</a>
<div class="baoxiao_list">
<?php if(isset($output['data']) && !empty($output['data'])){ ?>
<div>姓名</div>
<div>金额</div>
<div>类型</div>
<div>备注</div>
<div>是否通过</div>
<div>创建时间</div>
<div>审核时间</div>
<br>
<?php foreach($output['data'] as $key => $val){ ?>
	<div><?php echo $val['b_name'];?></div>
	<div><?php echo $val['b_price'];?></div>
	<div><?php echo $val['b_type'];?></div>
	<div><?php echo $val['b_beizhu'];?></div>
	<div><?php echo $val['is_use'];?></div>
	<div><?php echo date('Y-m-d H:i:s',$val['create_time']);?></div>
	<div><?php echo date('Y-m-d H:i:s',$val['update_time']);?></div>
	<br>
<?php } ?>
<?php } ?>
</div>
<?php echo $output['page'];?>
</body>
</html>
<style>
.baoxiao_list div{
	float:left;
	min-width:150px;
    overflow: hidden;
}
</style>
