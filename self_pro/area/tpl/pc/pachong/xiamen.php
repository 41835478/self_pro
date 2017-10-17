<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width" />
<title>请输入验证码</title>
<link rel="stylesheet" type="text/css" href="/new_index.css">
<script type="text/javascript"
	src="/jquery-1.5.2.min.js"></script>
</head>
<body>
	<div class="pop">
		<p class="title">访问过于频繁，本次访问需要输入验证码</p>
		<div class="main">
			<div class="code_img">
				<img
					src="../code/3031251756/d2f0c16866644d2db327720f60534b43.do" id="verify_img" onClick="changeVerifyImage()" onMouseOver="this.style.cursor='hand';">
				<em onclick="changeVerifyImage()">看不清?</em>
			</div>
			<div class="code_num">
				<div class="code_num_inp">
					<input id="verify_code" type="text" name="" placeholder="请输入验证码">
				</div>
				<em class="btn_tj" id="btnSubmit">提交</em>
			</div>
			<div class="toast_mess" id="errmsg"></div>
		</div>
	</div>
	<div class="footer">
		© 
					<a href="http://www.58.com">58.COM</a>
			</div>
</body>
<input type="hidden" id="uuid" value="d2f0c16866644d2db327720f60534b43" />
<input type="hidden" id="url" value="xm.58.com/ershoufang/?key=别墅" />
<input type="hidden" id="namespace" value="ershoufanglistphp" />
<input type="hidden" id="ip" value="3031251756" />
</body>
<script type="text/javascript">
	function changeVerifyImage(){
		var uuid = $("#uuid").val();
		var ip = $("#ip").val();
		$("#verify_img").attr("src","../code/"+ip+"/"+uuid+".do?"+new Date().getTime());//更换图片
	}
	
	$(document).ready(function() {
		$("#btnSubmit").click(function() {
			var namespace = $("#namespace").val();
			var uuid = $("#uuid").val();
			var url = $("#url").val();
			var verify_code = $("#verify_code").val();
			var ip = $("#ip").val();
			if (verify_code == '') {
				alert("请输入验证码");
				return;
			}
			if (verify_code.length!=4) {
				$("#errmsg").html("验证码错误");
				return;
			}
			respMessage = $.ajax({
				url : window.location.href,
				data : {
					namespace : namespace,
					uuid : uuid,
					url : url,
					verify_code : verify_code
				},
				type : "POST",
				async : true,
				success : function(results) {
					var parsedJson = jQuery.parseJSON(results);
					if (parsedJson.code === 0) {
						var redLocation = parsedJson.msg;
						if(redLocation.indexOf("http://")==-1 && redLocation.indexOf("https://")==-1){
							redLocation = "http://"+redLocation;
						}
						window.location.href = redLocation;
					} else {
						$("#errmsg").html(parsedJson.msg);
						$("#verify_code").attr("value","");//清空输入
						$("#verify_img").attr("src","../code/"+ip+"/"+uuid+".do?"+new Date().getTime());//更换图片
					}
				}
			});
		});
	});
</script>
</html>