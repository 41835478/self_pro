<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<html>
<head>
<title><?php echo $output['login']['login_title'];?></title>
</head>
<body>
<form action="index.php?act=<?php echo $_GET['act'];?>&op=<?php echo$_GET['op'];?>" method="post">
	<input type="hidden" name="key" value="<?php echo $output['key'];?>">
	<span><?php echo $output['login']['login_user'];?>:</span><input type="text" id="username" name="username"><br>
	<span><?php echo $output['login']['login_pwd'];?>:</span><input type="password" id="password" name="password"><br>
	<!--验证码start-->
	<?php if($output['is_captcha'] == 1){ ?>
	<span><?php echo $output['login']['login_captcha'];?>:</span><input type="text" id="captcha" name="captcha"><br>
	<img id="captcha_img" src="index.php?act=<?php echo $_GET['act'];?>&op=captcha" onclick="this.src='index.php?act=<?php echo $_GET['act'];?>&op=captcha&'+Math.random();"></img>
	<br>
	<?php } ?>
	<!--验证码end-->
	<!--
	<a href="#"><?php echo $output['login']['forget_password'];?></a>
	-->
	<input type="submit" value="<?php echo $output['login']['login_login'];?>">
	<!--
	<a href="index.php?act=register&op=index"><?php echo $output['login']['login_register'];?></a>
	-->
</form>
</body>
</html>
