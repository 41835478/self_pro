<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<html>
<head>
<title><?php echo $output['login']['login_title'];?></title>
</head>
<body>
<form action="index.php?act=<?php echo $_GET['act'];?>&op=<?php echo$_GET['op'];?>" method="post">
<table style="margin-left:41%;margin-top:15%;">
	<input type="hidden" name="key" value="<?php echo $output['key'];?>">
	<tr><td>
	<span><?php echo $output['login']['login_user'];?>:</span></td><td><input type="text" id="username" name="username">
	<tr><td>
	</td></tr>
	<tr><td>
	<span><?php echo $output['login']['login_pwd'];?>:</span></td><td><input type="password" id="password" name="password">
	<tr><td>
	</td></tr>
	<?php if($output['is_captcha']){ ?>
	<tr><td>
	</td><td>
	<img id="captcha_img" src="index.php?act=<?php echo $_GET['act'];?>&op=captcha" onclick="this.src='index.php?act=<?php echo $_GET['act'];?>&op=captcha&'+Math.random();"></img>
	</td></tr>
	<tr><td><span><?php echo $output['login']['login_captcha'];?>:</span></td><td><input type="text" id="captcha" name="captcha"></td></tr>
	<tr>
	<td></td><td>
	<?php } ?>
	<input style="width:60px;height:30px;background: paleturquoise;border-radius: 4px;" type="submit" value="<?php echo $output['login']['login_login'];?>">
	</td></tr>
</table>
</form>
</body>
</html>
