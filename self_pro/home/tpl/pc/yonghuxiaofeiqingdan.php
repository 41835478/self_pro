<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<title>交易结果</title>
<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<?php
	$output['data']['xiaofei_text'] = str_replace(array('#','hr'),
												  array('&nbsp;&nbsp;&nbsp;','<hr></hr>'),
												  $output['data']['xiaofei_text']);
?>
<?php echo $output['data']['xiaofei_text'];?>
<?php if(isset($output['data']['image']) && !empty($output['data']['image'])){ ?>
<img src="<?php echo str_replace(' ','+',$output['data']['image']);?>">
<?php }else{ ?>
<div class="qianming" >
	<div>电子签名，交易有保障</div>
	<fieldset style="margin-top:5px;border:none;background:#f0f0f0; height: 200px;">
        <!--
		<legend>签名区域</legend>
        -->
		<div id="signature" style="height: 100%;">
        </div>
    </fieldset>
	<div style="width:70%;margin:0 auto; padding:0 10%;overflow:hidden;margin-top:15px;margin-bottom:20px">
		<div onclick="jSignatureTest()" style="float:left;background:#ffc603;width:40%;height:40px;color:#FFF;text-align:center;line-height:40px;border-radius:5px">
			确认</div>
		<div onclick="reset()" style="background:#ffc603;width:40%;height:40px;color:#FFF;float:right;text-align:center;line-height:40px;border-radius:5px">
			重新签名</div>
	</div>
    <div style="display:none" id="image" style="margin: 20px">
    </div>
    <div style="display:none" id="img_src">
    </div>	
</div>
<?php } ?>

</body>
</html>
<style>
	table{
		width:95%;
		
	}
	.qianming{
		margin:0 auto;
		width:95%;
	}
</style>

<script src="/plugins/Scripts/jquery-1.4.1.js" type="text/javascript"></script>
<script src="/plugins/Scripts/jSignature/flashcanvas.js" type="text/javascript"></script>
<script src="/plugins/Scripts/jSignature/jSignature.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
		$("#signature").jSignature();
	   // $(".jSignature").css({ "width": "100%", "height": "100%" });
	});
	function reset() {
		var $sigdiv = $("#signature");
		$sigdiv.jSignature("reset");
	}
	function outputImage(src) {
	//	var $sigdiv = $("#signature");
	//	var datapair = $sigdiv.jSignature("getData", "image"); //设置输出的格式，具体可以参考官方文档

	//	var imagebase64 = datapair[1].replace(/\+/g, '%2B');

		$.ajax({
			type: "POST",
			url: "/api/api.php?commend=yonghuqingdantupian",
			data: "image=" +src+ "&x_id=<?php echo $output['data']['x_id'];?>",
			success: function (msg) {
				if(msg.msg.code == '1'){
					alert('签名成功');
					setTimeout(function (){
						window.location.href = window.location.href;
					},500);
				}
			}
		});

	}
	function jSignatureTest() {
		var $sigdiv = $("#signature");
		var datapair = $sigdiv.jSignature("getData", "image"); //设置输出的格式，具体可以参考官方文档

		var i = new Image();
		i.src = "data:" + datapair[0] + "," + datapair[1];
		
		outputImage(i.src);
		$(i).appendTo($("#image")) // append the image (SVG) to DOM.
	}
           
</script>
