<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<html>
<title></title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS;?>/header.css"/>
<body>

<div class="header" style="width:99.8%;height:19.1%;border:red 1px solid;">
<!--用户登录-->
<?php if(isset($_SESSION['user_state'])) { ?>
	<span>您好<?php echo $_SESSION['user_name'];?></span><a href="index.php?act=login&op=logout">退出</a>
<?php }else{ ?>
	<a href="index.php?act=login&op=index"><?php echo $output['header']['login'];?></a>
<?php } ?>

</div>