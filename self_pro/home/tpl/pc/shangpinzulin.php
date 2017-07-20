<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS?>/index.css"/>
    <title>商品租赁</title>
    <style>
        html {
            background-color:#FAFAFA;
            padding:0.4rem .5rem;
        }
        .zulin_1{
            height:1.2rem;
            width:100%;
            padding:.2rem .2rem .2rem 0;
            background:#fff;
            border-bottom:.01rem solid #ccc;
        }
        .zulin_1>div{
            float:left;
        }
        .zulin_1_a{
            height:.8rem;
            width:.8rem;
        }
        .zulin_1_a>img{
            height:100%;
            width:100%;
            border-radius: .06rem;;
        }
        .zulin_1_b{
            margin-left:.3rem;
        }
        .zulin_1_b>div{
            color:#323232;
            font-size: .3rem;
        }
        .zulin_1_b>p{
            color:#646464;
            font-size: .25rem;
        }
        div.zulin_1_c{
            float:right;
            margin-top:.35rem;
            line-height:.3rem;
            font-size: .3rem;
        }
        .zulin_1_c>img{
            width:.25rem;
            height:.25rem;
        }
        .zulin_2{
            height:3.15rem;
            width:100%;
            margin-top:.4rem;
            position: relative;
        }
        .zulin_2 textarea{
            width:100%;
            height:100%;
            padding:.2rem;
            font-size: .3rem;
        }
        .zulin_2_a{
            position: absolute;
            bottom:2%;
            right:3%;
        }
        .zulin_3{
            height:.75rem;
            line-height:.75rem;
            width:50%;
            background-color:#FFC603;
            color:#fff;
            font-weight: bold;
            font-size: .4rem;
            margin: auto;
            text-align: center;
            border-radius: .1rem;
            margin-top:.5rem;
        }
    </style>
</head>
<body>
	<?php if(isset($output['data']) && !empty($output['data'])){ ?>
	<?php foreach($output['data'] as $key => $val){ ?>
	<div class="zulin_1">
        <div class="zulin_1_a">
            <img src="<?php echo $val['z_img'];?>"/>
        </div>
        <div class="zulin_1_b">
            <div><?php echo $val['z_name'];?></div>
            <p>￥<?php echo $val['z_price'];?></p>
        </div>
        <div class="zulin_1_c">
            <img class="zulin_1_c_jian fade" src="<?php echo IMG;?>/zulin_02.png"/>
            <span data_id="<?php echo $val['z_id'];?>" data_name="<?php echo $val['z_name'];?>" data_price="<?php echo $val['z_price'];?>" class="shangpinzulin zulin_1_c_nmb">0</span>
            <img class="zulin_1_c_jia" src="<?php echo IMG;?>/zulin_03.png"/>
        </div>
    </div>
	<?php } ?>
	<?php } ?>
	<!--
    <div class="zulin_1">
        <div class="zulin_1_a">
            <img src="<?php echo IMG;?>/zulin_01.png"/>
        </div>
        <div class="zulin_1_b">
            <div>黑眼圈定制充电宝</div>
            <p>10000毫安</p>
        </div>
        <div class="zulin_1_c">
            <img class="zulin_1_c_jian fade" src="<?php echo IMG;?>/zulin_02.png"/>
            <span class="zulin_1_c_nmb">0</span>
            <img class="zulin_1_c_jia" src="<?php echo IMG;?>/zulin_03.png"/>
        </div>
    </div>
    <div class="zulin_1">
        <div class="zulin_1_a">
            <img src="<?php echo IMG;?>/zulin_01.png"/>
        </div>
        <div class="zulin_1_b">
            <div>黑眼圈定制充电宝</div>
            <p>10000毫安</p>
        </div>
        <div class="zulin_1_c">
            <img class="zulin_1_c_jian fade" src="<?php echo IMG;?>/zulin_02.png"/>
            <span class="zulin_1_c_nmb">0</span>
            <img class="zulin_1_c_jia" src="<?php echo IMG;?>/zulin_03.png"/>
        </div>
    </div>
    <div class="zulin_1">
        <div class="zulin_1_a">
            <img src="<?php echo IMG;?>/zulin_01.png"/>
        </div>
        <div class="zulin_1_b">
            <div>黑眼圈定制充电宝</div>
            <p>10000毫安</p>
        </div>
        <div class="zulin_1_c">
            <img class="zulin_1_c_jian fade" src="<?php echo IMG;?>/zulin_02.png"/>
            <span class="zulin_1_c_nmb">0</span>
            <img class="zulin_1_c_jia" src="<?php echo IMG;?>/zulin_03.png"/>
        </div>
    </div>
	-->
    <div class="zulin_2">
        <textarea class="beizhu" maxlength="100" placeholder="请您输入您的需求,方便我们更好的服务"></textarea>
        <div class="zulin_2_a">
            <span>0</span>/100
        </div>
    </div>

    <div class="zulin_3">
        确 定
    </div>

<script src="<?php echo JS?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS?>/index.js"></script>
<script>
    $(function(){
        var zulin=0;
        $('.zulin_1_c_jia').on('click',function(){
            var zulin111=parseInt($(this).prev().html());
            $(this).prev().removeClass('fade').html(zulin111+1);
            $(this).prev().prev().removeClass('fade');
			gouwuche();
        })
        $('.zulin_1_c_jian').on('click',function(){
            var zulin222=parseInt($(this).next().html());
            $(this).next().removeClass('fade').html(zulin222-1);
            $(this).next().next().removeClass('fade');
            if(zulin222==1){
                $(this).addClass('fade');
            }
			gouwuche();
        })
    })
	var data = {};
	function gouwuche(){
		var str = '';
		var price = 0;
		$('.shangpinzulin').each(function(i){
			var shuliang = parseInt($(this).html());
			if(shuliang > 0){
				var ppp = (parseInt($(this).attr('data_price')) * shuliang);
				str += '<div class="fangx_btm_top_mid"><span class="fangx_btm_top_mid_1">'+ $(this).attr('data_name') +'</span><span class="fangx_btm_top_mid_2"><span>&yen;价格：<e>' + ppp +'</e></span>数量：<e class="fangx_btm_top_mid_nbr" data_name="'+ $(this).attr('data_name') +'" data_price="'+ $(this).attr('data_price') +'">'+ shuliang +'</e></span></div>';
				var id =  $(this).attr('data_id');
				var ddd = {};
				ddd.price = $(this).attr('data_price');
				ddd.num = shuliang;
				ddd.z_price = ppp;
				
				data[id] = ddd;  //价格
				$('.gouwuche_box').html(str);
				price += ppp;
				$('.fangjian_price').html(price+'');
			}
		})
	}
    var nbr123=0;
    $(".zulin_2 textarea").keyup(function() {
        nbr123=$('.zulin_2 textarea').val().length;
        $('.zulin_2_a span').html(nbr123);
    });
	
	$('.zulin_3').click(function(){
		var url='/api/api.php?commend=shangpinzulin';
		var info = $('.beizhu').val();
		var store_id = '<?php echo $output['store_id'];?>';
		var order_id = '<?php echo $output['order_id'];?>';
		$.post(url,{store_id:store_id,order_id:order_id,data:data,info:info},function(state){
			if(state.msg.code == '1'){
				alert(state.msg.msg);
				window.location.href = '?act=user&op=fangjian';
			}else{
				alert(state.msg.msg);
			}
		},'json');
	});
</script>
</body>
</html>