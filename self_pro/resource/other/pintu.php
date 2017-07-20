<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<title>pintu</title>
</head>
<script src="jquery-1.9.1.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<body>
	<div class="main">
		<select class="harder" onchange="hard()" >
			<option value="1">3x3</option>
			<option value="2">4x4</option>
			<option value="3">5x5</option>
		<select>
		<div class="box"></div>
		<div class="show_image" >
			<img class="show_image_peth" >
		</div>
	</div>
</body>  
</html>
<style>
	.box{
		width:20rem;
		height:20rem;
		margin:2rem 0;
		border:1px solid #666;
		/*background:red;*/
	}
	.box3{
		width:33.33%;
		height:33.33%;
		float:left;
	}
	.box4{
		width:25%;
		height:25%;
		float:left;
	}
	.box5{
		width:20%;
		height:20%;
		float:left;
	}
	.main{
		width:20rem;
		margin: 0 auto;
	}
	.show_image{
		width:8rem;
		height:8rem;
	}
	.show_image_peth{
		width:100%;
		height:100%;
	}
</style>
<script>
	function hard(){
		game_init($('.harder').val());
	}
	
	var fenge = 0;
	var img_path = 'pic.jpg';
	function game_init(hard){
		switch(hard){
			case '1':
				fenge = 3;
			break;
			case '2':
				fenge = 4;
			break;
			case '3':
				fenge = 5;
			break;
		}
		var str = '';
		var x = 0;y = 0;
		var width_b = parseInt($('.box').css('width'));
		var height_b = width_b / fenge;
		var len = fenge * fenge;
		var rand_num = 0;
		var str = '';
		var str2 = '';
		for(var i = 1 ; i <= len; i ++){
			if(x == fenge){
				x = 0;
				y++;
			}
			if(y == fenge){
				y = 0;
			}
			if(i == fenge * fenge){
				str += '<div class="menu tihuan image box'+ fenge +'" style="overflow: hidden;position: relative;"><div style="position: absolute;left:-'+ x * height_b +';top:-'+ y * height_b +';width:'+width_b+';height:'+width_b+';background:#fff" ></div></div>';
			}else{
				str += '<div class="menu image box'+ fenge +'" style="overflow: hidden;position: relative;"><div class="pos '+ i +'" style="position: absolute;left:-'+ x * height_b +';top:-'+ y * height_b +';width:'+width_b+';height:'+width_b+';" ><img style="width:100%;height:100%" src="'+ img_path+'"></div></div>';
			}
			x ++;
		}
		
		$('.box').html(str);
		for(var i = 0 ; i < len-3; i ++){
			rand_num = rand(0,len-3);
			if(rand_num%fenge == fenge-1){
				console.log(rand_num + '|' + (fenge-1));
				continue;
			}
			console.log(rand_num);
			str = $('.menu').eq(rand_num).html();
			str2 = $('.menu').eq(rand_num+1).html();
			
			$('.menu').eq(rand_num).html(str2);
			$('.menu').eq(rand_num+1).html(str);
		}
		var string1 = '';
		var string2 = '';
		var pos1 = {};
		var pos2 = {};
		var ju_width = 0;
		var ju_height = 0;
		var num = 0;
		var piancha = 5;
		$(function(){
			$('.menu').click(function(){
				pos1 = $(this).position();
				pos2 = $('.tihuan').position();
				ju_width = parseInt($(this).css('width'));
				ju_height = parseInt($(this).css('height'));
				if(pos1.top == pos2.top){
					if(Math.abs(pos1.left-pos2.left) > ju_width + piancha){
						return;
					}
				}else if(pos1.left == pos2.left){
					if(Math.abs(pos1.top-pos2.top) > ju_width + piancha){
						return;
					}
				}else{
					return ;
				}
				string1 = $(this).html();
				string2 = $('.tihuan').html();
				
				$(this).html(string2);
				$('.tihuan').html(string1);
				
				$('.tihuan').addClass('menu');
				$('.tihuan').removeClass('tihuan');
				
				$(this).addClass('tihuan');
				$(this).removeClass('menu');
			})
		})
	}
	
	function rand(min,max){
		return Math.floor(min + Math.random() * (max-min+1));
	}
	
	game_init($('.harder').val());
	
	$('.show_image_peth').attr('src',img_path);
</script>


