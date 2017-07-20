<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>订单备注</title>
    <style>
        html {
            padding:.3rem;
            padding-bottom: 5rem;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="bz_1">
        <textarea maxlength="50" class="bz_1_ipt" placeholder="请输入备注,也可不填"></textarea>
        <div class="bz_1_bj">
            <span class="bz_1_bj_nbr">0</span>/50
        </div>
    </div>
    <div class="bz_2">
        <div class="bz_2_1">常用备注</div>
        <ul class="bz_2_2 bz_2_22">
            <li>准备拖鞋</li>
            <li>准备毛巾</li>
            <li>生日聚会</li>
            <li>生日聚会</li>
            <li>准备拖鞋</li>
            <li>准备毛巾</li>
            <li>生日聚会</li>
            <li>生日聚会</li>
            <li>生日聚会</li>
            <li>准备拖鞋</li>
        </ul>
    </div>
    <div class="bz_ri">确 定</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/bootstrap.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
	window.onload=function(){
		if(window.localStorage){
			var site33 = localStorage.getItem("aaass33");
			$('.bz_1_ipt').val(site33);
		}
	}

	$('.bz_ri').click(function(){
		var beizhu = $('.bz_1_ipt').val();
		var url = '/api/api.php?commend=order_remarks';
		var order_id = <?php echo $_GET['order_id'];?>;
		if(beizhu != ''){
			$.post(url,{order_id:order_id,order_remarks:beizhu},function(state){
				if(state.code == 200){
					alert(state.msg.msg);
					history.go(-1);
				}else{
				
				}
			},'json');
		}else{
			alert("请填写备注信息");
		}
	});
	
	$('.bz_ri').on('click',function(){
		var asdgfkg33=$(".bz_1_ipt").val();
		localStorage.setItem("aaass33", asdgfkg33);
	})
</script>