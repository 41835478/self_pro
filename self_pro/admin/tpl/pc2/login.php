<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="Violate Responsive Admin Template">
        <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

        <title>后台管理系统</title>
            
        <!-- CSS -->
        <link href="<?php echo CSS;?>/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/form.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/style.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/animate.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/generics.css" rel="stylesheet"> 
    </head>
    <body id="skin-blur-violate">
	<!-- 星空背景 -->
	<canvas  id="canvas" width="100%" min-height="1024px"></canvas>
		<section id="login">
            <!--
			<header>
                <h1>Super Admin</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>
			</header>
			-->
            <div class="clearfix"></div>
            <!-- Login -->
            <form action="index.php?act=<?php echo $_GET['act'];?>&op=<?php echo$_GET['op'];?>" method="post" class="box tile animated active" id="box-login">
                <input type="hidden" name="key" value="<?php echo $output['key'];?>">
				<h2 class="m-t-0 m-b-15">登录</h2>
                <input type="text" id="username" name="username" class="login-control m-b-10" placeholder="账号">
                <input type="password" id="password" name="password" class="login-control" placeholder="密码">
                
				<div class="checkbox m-b-20">
				<img id="captcha_img" src="index.php?act=<?php echo $_GET['act'];?>&op=captcha" onclick="this.src='index.php?act=<?php echo $_GET['act'];?>&op=captcha&'+Math.random();">				
					<!--
                    <label>
                        <input type="checkbox">
                        记住登陆
                    </label>
					-->
                </div>
				<input type="text" id="captcha" name="captcha" class="login-control m-b-10" placeholder="验证码">
				
				<input type="submit" value="登陆" class="btn btn-sm m-r-5">
                <!--  
                <small>
                    <a class="box-switcher" data-switch="box-register" href="">Don't have an Account?</a> or
                    <a class="box-switcher" data-switch="box-reset" href="">Forgot Password?</a>
                </small>
				-->
            </form>
            <!-- Register -->
			<!--
            <form class="box animated tile" id="box-register">
                <h2 class="m-t-0 m-b-15">Register</h2>
                <input type="text" class="login-control m-b-10" placeholder="Full Name">
                <input type="text" class="login-control m-b-10" placeholder="Username">
                <input type="email" class="login-control m-b-10" placeholder="Email Address">    
                <input type="password" class="login-control m-b-10" placeholder="Password">
                <input type="password" class="login-control m-b-20" placeholder="Confirm Password">

                <button class="btn btn-sm m-r-5">Register</button>

                <small><a class="box-switcher" data-switch="box-login" href="">Already have an Account?</a></small>
            </form>
            -->
            <!-- Forgot Password -->
			<!--
            <form class="box animated tile" id="box-reset">
                <h2 class="m-t-0 m-b-15">Reset Password</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>
                <input type="email" class="login-control m-b-20" placeholder="Email Address">    

                <button class="btn btn-sm m-r-5">Reset Password</button>

                <small><a class="box-switcher" data-switch="box-login" href="">Already have an Account?</a></small>
            </form>
			-->
        </section>                      
        
        <!-- Javascript Libraries -->
        <!-- jQuery -->
        <script src="<?php echo RES;?>/js/jquery1.9.1/jquery-1.9.1.min.js"></script> <!-- jQuery Library -->
        <script src="<?php echo RES;?>/js/yzm/gt.js"></script> <!-- jQuery Library -->
        
        <!-- Bootstrap -->
        <script src="<?php echo JS;?>/bootstrap.min.js"></script>
        
        <!--  Form Related -->
        <script src="<?php echo JS;?>/icheck.js"></script> <!-- Custom Checkbox + Radio -->
        
        <!-- All JS functions -->
        <script src="<?php echo JS;?>/functions.js"></script>
    </body>
</html>
<!--登录窗口放在中间-->
<script>
	var form_box = document.getElementById('box-login');
	form_box.style.margin = '0 auto';
	form_box.style.marginTop = '10%';
</script>
