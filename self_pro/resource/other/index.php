<?php
	define('PROJECT_NAME',true);
	include '../../work/include/fun.php';
	file_put_contents('ip.log',get_ip()." ". date('Y-m-d H:i:s') ." \n",FILE_APPEND);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<title>数独</title>
</head>
<script src="jquery-1.9.1.min.js"></script>
<body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<div class="shudu">
	</div>
	<div class="menu" >
		<div>1</div>
		<div>2</div>
		<div>3</div>
		<div>4</div>
		<div>5</div>
		<div>6</div>
		<div>7</div>
		<div>8</div>
		<div>9</div>
	</div>
	<div class="message">
		<div class="message_title" ></div>
		<div class="message_info"></div>
	</div>
	<div class="tijiao" >确认</div>
</body>
</html>

<script>
	var input_str = ''; 
	var num = rand(1,81);
	for(var i = 1 ; i <= 81 ; i++){
		
		if(num == i){
			input_str += '<input class="zhiding" type=number type="text" value="' + rand(1,9) + '" readOnly="true" >';
		}else{
			input_str += '<input class="buzhiding" type=number  readOnly="true" type="text" >';
		}
		
	//	input_str += '<input class="buzhiding" type=number type="text" >';
		if(i%3 == 0 && i%9 != 0){
			
			input_str += "<div class='shuxian' ></div>"
		}
		if(i == 27 || i == 54){
			input_str += "<div class='hengxian' ></div>"
		}
	}
	
	$('.menu div').click(function(){
		var num = $(this).html();
		$('#tianxie').val(num);
	});
	$('.shudu').html(input_str);
	function rand(min,max){
		return Math.floor(min + Math.random() * (max-min+1));
	}
	$('.tijiao').click(function(){
		$(this).css('background','#dec64a');
		setTimeout(function(){
			$('.tijiao').css('background','#54c1a4');
		},150);
		is_win();
	})
	/*
	$('.shudu :input').on('keyup',function(code){
		$('.shudu :input').attr('id','');
		$(this).attr('id','tianxie');
		return;
		if(code.key == 0){
			$(this).val('');
			return ;
		}
		$(this).val(code.key);
	});
	*/
	$('.shudu :input').click(function(){
		$('.shudu :input').attr('id','');
		$('.shudu :input').css('background','');
		$(this).attr('id','tianxie');
		$(this).css('background','#eaddf3');
		return;
	})
	var d1 = [];
	var d2 = [];
	var is_win_flag = false;
	
	function is_win(){
		var input = $('.shudu :input');
		len = input.length;
		var d = {};
		for( var i = 1 ; i <= 81 ; i ++){
			d[i] = parseInt(input.eq(i-1).val());
		}
		//console.log(d);
		for(var i = 1 ; i <=9 ; i++){
			if(is_num9(d[(i-1)*9+1],d[(i-1)*9+2],d[(i-1)*9+3],d[(i-1)*9+4],d[(i-1)*9+5],d[(i-1)*9+6],d[(i-1)*9+7],d[(i-1)*9+8],d[(i-1)*9+9]) &&  	//横向
			   is_num9(d[i*1],d[i+9],d[(i+2*9)],d[(i+3*9)],d[(i+4*9)],d[(i+5*9)],d[(i+6*9)],d[(i+7*9)],d[(i+8*9)]) //纵向
			){
				is_win_flag = true;
			}else{
				//console.log(1);
				is_win_flag = false;
				break ;
			}
			if(i >= 1 && i <= 3){
				if(is_num9(d[(i-1)*3+1],d[(i-1)*3+2],d[(i-1)*3+3],
						   d[(i-1)*3+1+9],d[(i-1)*3+2+9],d[(i-1)*3+3+9],
						   d[(i-1)*3+1+18],d[(i-1)*3+2+18],d[(i-1)*3+3+18]) //第一层
				){
					is_win_flag = true;
				}else{
					//console.log(2);
					is_win_flag = false;
					break ;
				}
			}
			if(i >= 4 && i <= 6){
				if(is_num9(d[(i-4)*3+1+27],d[(i-4)*3+2+27],d[(i-4)*3+3+27],
						   d[(i-4)*3+1+27+9],d[(i-4)*3+2+27+9],d[(i-4)*3+3+27+9],
						   d[(i-4)*3+1+27+18],d[(i-4)*3+2+27+18],d[(i-4)*3+3+27+18]) //第二层
				){
					is_win_flag = true;
				}else{
				//console.log(3);
					is_win_flag = false;
					break ;
				}
			}
			if(i >= 7 && i <= 9){
				if(is_num9(d[(i-7)*3+1+54],d[(i-7)*3+2+54],d[(i-7)*3+3+54],
						   d[(i-7)*3+1+54+9],d[(i-7)*3+2+54+9],d[(i-7)*3+3+54+9],
						   d[(i-7)*3+1+54+18],d[(i-7)*3+2+54+18],d[(i-7)*3+3+54+18]) // 三层
				){
					is_win_flag = true;
				}else{
				//console.log(4);
					is_win_flag = false;
					break ;
				}
			}
		}
		
		if(is_win_flag){
			$('.message_info').html('恭喜过关');
			$('.message').show();
		}else{
			$('.message_info').html('您没有填写正确哦，请继续加油');
			$('.message').show();
		}
		setTimeout(function(){
			$('.message').hide();
		},1300);
	}
	//是不是9个数都不一样
	function is_num9(num1,num2,num3,num4,num5,num6,num7,num8,num9){
		var data = [num1,num2,num3,num4,num5,num6,num7,num8,num9];
		//console.log(data);
		var str = '123456789';
		var str2 = '';
		data.sort();
		for(x in data){
			if(typeof(data[x]) == 'NaN'){
				return false;
			}
			str2 += data[x] + '';
		}
		//console.log(str+ '--' +str2);
		if(str == str2){
			return true;
		}else{
			return false;
		}
	}
</script>
<style>
.message_title{
	width:100%;
	height:5rem;
	border-bottom:1px solid #d8d3d3;
}
.message{
	display:none;
	position:fixed;
	top:35%;
	left:17.5%;
	width:65%;
	height:20rem;
	background:#fff;
	border:1px solid #d8d3d3;
}
.message_info{
	width:100%;
	height:5rem;
	margin:5rem auto 0;
	font-size:2.6rem;
	text-align:center;
	/*border:1px solid #d8d3d3;*/
}
.menu div{
	text-align:center;
	width:32%;
	float:left;
	font-size:5rem;
	color:#5a7d40;
	background:#6ac5ca;
	margin:2px;
}
.menu{
	width:90%;
	position:fixed;
	bottom:11rem;
	margin-left:5%;
}
input{
	width:10.1%;
	margin:0 0.24rem;
	height:5.5rem;
	font-size:3rem;
	text-align:center;
	float:left;
}
.shuxian{
	width:5px;
	height:5.5rem;
	background:red;
	float:left;
}
.hengxian{
	width:99.6%;
	height:5px;
	margin:0.24rem 0rem;
	background:red;
	margin-left:0.2%;
	float:left;
}
.zhiding{
	color:#a4f75b;
}
.shudu{
	margin-top:2rem;
	width:90%;
	height:51.2rem;
	margin:0 auto;
	border: 5px solid red;
}
.tijiao{
	position:fixed;
	bottom:3rem;
	padding: 1rem 3rem;
	width:10rem;
	height:5rem;
	line-height:5rem;
	font-size:5rem;
	left:23rem;
	background:#54c1a4;
	color:#fff;
	border-radius:15px;
}
.music_menu{	
	margin:0.5rem auto;
	width:13rem;
	height:13rem;
}
.music img{
	width:100%;
	height:100%;
}
</style>