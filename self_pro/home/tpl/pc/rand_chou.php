<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <title></title>
    <style>
        .shaoxing{
            font-size:.3rem;
            margin-top:.1rem;
            height:.4rem;
            line-height:.4rem;
        }
        .dian{
            font-size:2rem;
            text-align: center;
			border:0.01rem solid black;
        }
        ul,li{
            list-style: none;
            font-size:1rem;
			margin-bottom:.1rem;
			margin:0;padding:0;
        }
        .nubul{
            width:100%;
        }
        .nubli{
            width:20%;
            text-align: center;
            float:left;
            margin-top:1rem;
        }
		@media screen and (max-width: 414px) {
			.nubli{
				width:50%;
			}
			.dian{
				font-size:1rem;
				text-align: center;
				border:0.01rem solid black;
			}
			ul,li{
				list-style: none;
				font-size:.8rem;
				margin-bottom:.1rem;
				margin:0;padding:0;
			}
		}
		.riqi{
			text-align:center;
			margin-top:20px;
		}
    </style>
</head>
<body>
    <div class="dian">点击取数</div>
	<div class='riqi'>日期:<span class='dddsssaaa'></span></div>
    <ul class="nubul">
        <?php if(isset($output['store']) && !empty($output['store'])){ ?>
		<?php foreach($output['store'] as $key => $val){ ?>
			<li class="nubli"><div><?php echo $val['store_name'];?></div><div class="store_rand" store_id="<?php echo $val['store_id'];?>"><?php echo isset($val['num'])?$val['num']:''?></div></li>
		<?php } ?>
		<?php } ?>
    </ul>

</body>
<script src="<?php echo JS;?>/jquery-1.9.1.min.js"></script>
<script>
	var d = new Date();
	var str = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate();
	$('.dddsssaaa').html(str);

	
	var obj = ['绍兴','杭州','其它','123'];
	var post_data = {};
	var data = 0;
	var store = {};
	var arr = [];
	<?php if(isset($output['store']) && !empty($output['store'])){ ?>
	<?php foreach($output['store'] as $key => $val){ ?>
		arr[<?php echo $val['store_id']?>] = [<?php echo $val['store_num'];?>];
	<?php } ?>
	<?php } ?>
	var url = '/api/api.php?commend=cunchu';
	var flag = true;
    $('.dian').click(function(){
		
		if(!flag){
			return;
		}
		var str = '';
		$('.store_rand').each(function(){
			
			store_id = $(this).attr('store_id');
			store.store_id = store_id;
			data = rand_num(arr[store_id]);
			store.store_num = data;
			post_data[store.store_id] = store;
			store = {};
			$(this).html(data);
		})
		$('.store_rand').hide();
		$.post(url,{datas:post_data},function(state){
			if(state.msg.code == '1'){
				flag = false;
				alert('插入成功');
			//	window.location.href = window.location.href; //刷新
				$('.store_rand').show();
			}else{
				alert(state.msg.msg);
				window.location.href = window.location.href; //刷新
			}
		},'json');
		
	})
	
	function rand_num(arr){
	//	var arr = [1,2,3,4,5,6,7,8,9];
		var nnn=parseInt(arr.length);
		console.log(nnn);
		var numb= Math.floor(Math.random()*nnn);
	//	console.log(numb);
		return arr[numb];
	}
</script>
</html>