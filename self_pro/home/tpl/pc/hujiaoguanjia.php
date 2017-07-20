<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>呼叫管家</title>
    <style>
        html {
            background-color:#FAFAFA;
            height:100%;
        }
        body{
            height:100%;
        }
		.xiao_3333333{
			text-align:center;
			color:#fff;
			background-color:#ffc603;
			margin:auto;
			padding:.2rem 0;
			font-size:.4rem;
			font-weight: bold;
			position:absolute;
			bottom:0;
			left:0;
			width:100%;
		}
    </style>
</head>
<body>
    <div class="hujgj_1">我的信息</div>
    <div class="hujgj_2" style="border-bottom:.01rem solid #ccc;">
        我的称呼 <input class="otl name" type="text" placeholder="方便您与管家联系   "/>
    </div>
    <div class="hujgj_2" style="border-bottom:.01rem solid #ccc;">
        手机号码 <input class="otl phone" type="number" placeholder="方便您与管家联系   "/>
    </div>
    <div class="hujgj_2">
        我的位置 <input class="otl position" type="text" placeholder="例如：我在别墅三楼大厅"/>
    </div>
    <div class="hujgj_3">备注信息</div>
    <div class="hujgj_4">
        <textarea class="beizhu" placeholder="请输入您的需求,便于我们对您更好的服务"/></textarea>
    </div>
	<div class="xiao_3333333">确定</div>
<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>"></script>
</body>
</html>
<script>
	$('.xiao_3333333').click(function(){
		var data = {};
		data.name = $('.name').val();
		data.phone = $('.phone').val();
		data.position = $('.position').val();
		data.beizhu = $('.beizhu').val();
		data.order_id = '<?php echo $output['order_id'];?>';
		var url = '/api/api.php?commend=hujiaoguanjia';
		$.post(url,{data:data},function(data){
			if(data.msg.code == '1'){
				alert('呼叫成功，管家正火速赶往目的地');
				window.location.href = '?act=user&op=person_info';
			}else{
				alert(data.msg.msg);
			}
		},'json');
	})
</script>