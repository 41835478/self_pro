<?php
if(!defined('PROJECT_NAME')) die('project empty');
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="Violate Responsive Admin Template">
        <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

        <title>Super Admin Responsive Template</title>
            
        <!-- CSS -->
        <link href="<?php echo CSS;?>/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/animate.min.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/form.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/calendar.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/style.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/icons.css" rel="stylesheet">
        <link href="<?php echo CSS;?>/generics.css" rel="stylesheet">
		<link href="<?php echo CSS;?>/currency.css" rel="stylesheet">
		
    </head>
    <body >
        <header id="header" class="media">
		<!-- 星空背景 -->
		<canvas  id="canvas" width="100%" min-height="1024px"></canvas> 
            <a href="" id="menu-toggle"></a> 
            <a class="logo pull-left" href="index.html">SUPER ADMIN 1.0</a>
            
            <div class="media-body">
                <div class="media" id="top-menu">
                    <!--
					<div class="pull-left tm-icon">
                        <a data-drawer="messages" class="drawer-toggle" href="">
                            <i class="sa-top-message"></i>
                            <i class="n-count animated">5</i>
                            <span>Messages</span>
                        </a>
                    </div>
                    <div class="pull-left tm-icon">
                        <a data-drawer="notifications" class="drawer-toggle" href="">
                            <i class="sa-top-updates"></i>
                            <i class="n-count animated">9</i>
                            <span>Updates</span>
                        </a>
                    </div>
					-->
                   

                    <div id="time" class="pull-right">
                        <span id="hours"></span>
                        :
                        <span id="min"></span>
                        :
                        <span id="sec"></span>
                    </div>
                    
                    <div class="media-body">
                        <input id="search_keysord" type="text" class="main-search" value="<?php echo isset($output['keywords'])?$output['keywords']:'';?>">
                    </div>
                </div>
            </div>
        </header>
		
        <div class="clearfix"></div>
<!-- Javascript Libraries -->
<!-- jQuery -->
<script src="<?php echo JS;?>/jquery.min.js"></script> <!-- jQuery Library -->
<script src="<?php echo JS;?>/jquery-ui.min.js"></script> <!-- jQuery UI -->
<script src="<?php echo JS;?>/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->
<!--  Form Related -->
<script src="<?php echo JS;?>/validation/validate.min.js"></script> <!-- jQuery Form Validation Library -->
<script src="<?php echo JS;?>/validation/validationEngine.min.js"></script> <!-- jQuery Form Validation Library - requirred with above js -->
<script src="<?php echo JS;?>/select.min.js"></script> <!-- Custom Select -->
<script src="<?php echo JS;?>/chosen.min.js"></script> <!-- Custom Multi Select -->
<script src="<?php echo JS;?>/datetimepicker.min.js"></script> <!-- Date & Time Picker -->
<script src="<?php echo JS;?>/colorpicker.min.js"></script> <!-- Color Picker -->
<script src="<?php echo JS;?>/icheck.js"></script> <!-- Custom Checkbox + Radio -->
<script src="<?php echo JS;?>/autosize.min.js"></script> <!-- Textare autosize -->
<script src="<?php echo JS;?>/toggler.min.js"></script> <!-- Toggler -->
<script src="<?php echo JS;?>/input-mask.min.js"></script> <!-- Input Mask -->
<script src="<?php echo JS;?>/spinner.min.js"></script> <!-- Spinner -->
<script src="<?php echo JS;?>/slider.min.js"></script> <!-- Input Slider -->
<script src="<?php echo JS;?>/fileupload.min.js"></script> <!-- File Upload -->
<!-- Bootstrap -->
<script src="<?php echo JS;?>/bootstrap.min.js"></script>

<!-- Charts -->
<script src="<?php echo JS;?>/charts/jquery.flot.js"></script> <!-- Flot Main -->
<script src="<?php echo JS;?>/charts/jquery.flot.time.js"></script> <!-- Flot sub -->
<script src="<?php echo JS;?>/charts/jquery.flot.animator.min.js"></script> <!-- Flot sub -->
<script src="<?php echo JS;?>/charts/jquery.flot.resize.min.js"></script> <!-- Flot sub - for repaint when resizing the screen -->

<script src="<?php echo JS;?>/sparkline.min.js"></script> <!-- Sparkline - Tiny charts -->
<script src="<?php echo JS;?>/easypiechart.js"></script> <!-- EasyPieChart - Animated Pie Charts -->
<script src="<?php echo JS;?>/charts.js"></script> <!-- All the above chart related functions -->

<!-- Map -->
<script src="<?php echo JS;?>/maps/jvectormap.min.js"></script> <!-- jVectorMap main library -->
<script src="<?php echo JS;?>/maps/usa.js"></script> <!-- USA Map for jVectorMap -->

<!--  Form Related -->
<script src="<?php echo JS;?>/icheck.js"></script> <!-- Custom Checkbox + Radio -->

<!-- UX -->
<script src="<?php echo JS;?>/scroll.min.js"></script> <!-- Custom Scrollbar -->

<!-- Other -->
<script src="<?php echo JS;?>/calendar.min.js"></script> <!-- Calendar -->
<script src="<?php echo JS;?>/feeds.min.js"></script> <!-- News Feeds -->

<!-- All JS functions -->
<script src="<?php echo JS;?>/functions.js"></script>
<script>
	if(typeof(where) == 'undefined'){
		var where = {};
	}
	$("#search_keysord").keyup(function(){ 
		if(event.keyCode == 13){
			var keywords = $("#search_keysord").val();
			window.location.href = <?php echo isset($output['keywords_url'])?'"'.$output['keywords_url'].'"':'window.location.href';?> + '&page=1&keywords='+keywords;
	} });
	
	function spuer_search(){
		var start_day = $('#start_day').val();
		var end_day = $('#end_day').val();
		var keywords = $("#search_keysord").val();
		var other = '';
		if(start_day != ''){
			start_day = '&start_day=' + start_day;
		}else{
			start_day = '';
		}
		if(end_day != ''){
			end_day = '&end_day=' + end_day;
		}else{
			end_day = '';
		}
		if(keywords != ''){
			keywords = '&keywords=' + keywords;
		}else{
			keywords = '';
		}
		
		if(typeof(where.pay) != 'undefined'){
			other += '&pay=' + where.pay;
		};
		
		window.location.href = <?php echo isset($output['keywords_url'])?'"'.$output['keywords_url'].'"':'window.location.href';?> + '&page=1' + start_day + end_day + keywords + other;
	};
</script>