<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>未开发票</title>
    <style>
        html {
            padding-bottom: 1rem;;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="weifa_1">请选择发票类型</div>
    <div class="weifa_2">
        <ul class="weifa_2_ul">
            <li data="1" class="weifa_2_ul_1 weifa_2_ul_bdcl">纸质发票</li>
            <li data="2" class="weifa_2_ul_2">电子发票</li>
        </ul>
    </div>
    <div class="weifa_1">发票抬头</div>
    <div class="weifa_3">
        <div class="weifa_3_1">
            <i class="weifa_3_1_iii weifa_3_1_gou" data="个人" ></i>
            <input type="hidden" value="1"/>
            <span>个人</span>
        </div>
        <div class="weifa_3_2 inputtttt">
            <i class="weifa_3_2_iii weifa_3_1_bdbtm" data="单位"></i>
            <input type="hidden" value="2"/>
            <span>单位</span>
            <input class="inputt in_1 weifa_4_2_inp" type="text" placeholder="请填写单位名称"/>
            <!--<b class="weifa_4_2_inp_fon">请填写单位名称</b>-->
        </div>
    </div>
    <div class="weifa_1">发票金额及内容</div>
    <div class="weifa_4">
        <div class="weifa_4_1">
            <span class="weifa_4_1_1">发票金额</span>
            <span class="weifa_4_1_2 f_price"><?php echo isset($output['order']['over_price'])?$output['order']['over_price']:0?></span>
        </div>
        <div class="weifa_4_2">
            <span class="weifa_4_1_1">发票内容</span>
            <span class="weifa_4_1_2 fapiaoneirong">活动费</span>
        </div>
    </div>
    <div class="weifa_1">收件信息</div>
    <div class="weifa_5 fade">
        <div>
            <span class="weifa_4_1_12 weifa_4_1_1">邮箱</span>
            <input class="inputt inputt2 in_11 weifa_4_2_inp" type="text" placeholder="用来接收电子发票邮箱,可选填"/>
        </div>
        <div class="weifa_4_1 weifa_4_2">
            <span class="weifa_4_1_12 weifa_4_1_1">联系电话</span>
            <input class="inputt inputt2 in_12 weifa_4_2_inp" type="text" placeholder="可用过手机号在发票服务平台查询"/>
        </div>
    </div>
    <div class="weifa_6">
        <div>
            <span class="weifa_4_1_12 weifa_4_1_1">收件人</span>
            <input class="inputt inputt2 in_2 weifa_4_2_inp" type="text" placeholder="填写受票人姓名"/>
        </div>
        <div class="weifa_4_1 weifa_4_2">
            <span class="weifa_4_1_12 weifa_4_1_1">联系电话</span>
            <input class="inputt inputt2 in_3 weifa_4_2_inp" type="text" placeholder="请填写正确的收票人号码"/>
        </div>
        <div class="weifa_4_1 weifa_4_2">
            <span class="weifa_4_1_12 weifa_4_1_1">所在地区</span>
            <input class="inputt inputt2 in_4 weifa_4_2_inp" type="text" placeholder="请填写所在的省、市、区"/>
        </div>
        <div class="weifa_4_1 weifa_4_2">
            <span class="weifa_4_1_12 weifa_4_1_1">详细地址</span>
            <input class="inputt inputt2 in_5 weifa_4_2_inp" type="text" placeholder="请填写具体的乡镇街道地址"/>
        </div>
    </div>
    <div class="weifa_4_btm ">
        <span>确定</span>
    </div>

<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>
<script>
	var data = {};
	$('.weifa_4_btm ').click(function(){
		data.f_xinghao 	= $('.weifa_2_ul_bdcl').html();
		data.f_title 	= $('.weifa_3_1_gou').attr('data');
		data.f_name 	= $('.in_2').val();
		
		data.email 		= $('.in_11').val();
		data.phone 		= $('.in_3').val();  //in_12
		
		data.address 	= $('.in_4').val();
		data.xx_address = $('.in_5').val();
		data.f_price = $('.f_price').html();
		
		if(data.phone == '' || typeof(data.phone ) == 'undefined'){
			data.phone = $('.in_12').val();
			
		}
		if($('.weifa_2_ul_bdcl').attr('data') == '1'){
			if(data.f_name == ''){
				alert('请填写收件人');
				return false;
			}
			if(data.address == ''){
				alert('请填写地址');
				return false;
			}
			if(!(/^1[34578]\d{9}$/.test(data.phone))){
				alert('手机号有误，请重填');
				return false;
			}
		}
		if($('.weifa_2_ul_bdcl').attr('data') == '2'){
			if(data.email == ''){
				alert('请填写邮箱');
				return false;
			}
		}
		
		data.f_fapiaoneirong = $('.fapiaoneirong').html();
		data.user_id = "<?php echo $output['user']['user_id'];?>";
		data.order_id = "<?php echo $output['order']['order_id'];?>";
		var url = '/api/api.php?commend=kaifapiao';
		$.post(url,{data:data},function(state){
			if(state.msg.code == 1){
				alert(state.msg.msg);
			}else{
				alert(state.msg.msg);
			}
		},'json');
	})
</script>