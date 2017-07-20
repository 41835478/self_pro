<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,target-densitydpi=high-dpi,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<title>绍兴文理学院投票</title>
		<link rel="stylesheet" href="<?php echo CSS;?>/vote.css" />
		<script type="text/javascript" src ="<?php echo JS;?>/jquery-1.12.4.min.js"></script>
	</head>
	<script>
		(function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if(clientWidth>=750){
                    docEl.style.fontSize = '100px';
                }else{
                    docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);  	
    	
    	$(function(){
			$('.dropdown-toggle').each(function(){
				var state = $(this).attr('state');
				if(state == 'show'){
					 $(this).find('img').attr('src','<?php echo IMG;?>/vote_jian.png');
				}
				if(state == 'no_show'){
					$(this).find('img').attr('src','<?php echo IMG;?>/vote_plus.png');
				}
			})

    		$(".dropdown-toggle").click(function(){
				var state = $(this).attr('state');
				if(state == 'show'){
					 $(this).attr('state','no_show');
					
					 $(this).find('img').attr('src','<?php echo IMG;?>/vote_plus.png');
				}else{
					$(this).attr('state','show');
					 $(this).find('img').attr('src','<?php echo IMG;?>/vote_jian.png');
				}
				$(this).next(".dropdown-menu").toggle(500);
			 });
			 
			 var imp_width=window.screen.width;
			 imp_height=imp_width*545/750;
			 
			 var zhankai_id = 0;
			 var is_tou = true;
			 <?php if(isset($output['is_tou']) && $output['is_tou'] > 0 ){ ?>
				 is_tou = false;
				 zhankai_id = '<?php echo $output['is_tou'];?>';
			 <?php } ?>
			
			 $('.bg_head').css("height",imp_height);
				$('.vote').click(function(){
					alert('投票结束');
					return 0;
					if(!is_tou){
						alert('您已经投过票了');
						return 0;
					}
					is_tou = false;
					var url = '/api/api.php?commend=toupiao';
					var user_id = '<?php echo $output['user']['user_id'];?>';
					var s_id = $(this).attr('data');
				//	alert(s_id);return;
					$.post(url,{user_id:user_id,s_id:s_id},function(data){
						if(data.msg.code == '1'){
							$('#s_num'+s_id).html(data.msg.s_num);
							alert(data.msg.msg);
						}
					},'json');
					$(this).css({'border':'1px solid #808080'});
					$(this).css({'color':'#808080'});
					$(this).html('您已投票');
				})
    	})
		
		
		
	</script>
	<body style="background: url(<?php echo IMG;?>/vote_bg.png);">
		<div class="bg_head" style="background: url(<?php echo IMG;?>/vote_head.png) no-repeat center;background-size:100% 100%;"></div>
		<div style="font-size:0.35rem;width:100%; text-align:center;font-family:'微软雅黑';">绍兴文理学院</div>
		<?php if(isset($output['data']) && !empty($output['data'])){ ?>
		<?php foreach($output['data'] as $key => $val){ ?>
		<div class="btn-group">
		    <div class="dropdown-toggle"  data_id='<?php echo $val['s_id'];?>' state="<?php if(isset($output['is_show']) && $output['is_show'] == $val['s_id'] /* || !isset($output['is_show']) && $key == 0 */){ echo 'show';}else{ echo 'no_show';};?>">
		      	<?php echo $val['name'];?>(<?php echo $val['s_num'];?>)
				<img src="<?php echo IMG;?>/vote_plus.png" style="width:0.24rem;height:0.24rem"/>
				
		    </div>
			<?php if($key > 0){ ?>
				<ul class="dropdown-menu" style="display: none;">
			<?php }else{ ?>
				<ul class="dropdown-menu" style="display: none;" >
			<?php } ?>
				<?php if(isset($val['info']) && !empty($val['info'])){ ?>
				<?php foreach($val['info'] as $k => $v){ ?>
					 <li>
						<div><?php echo $v['s_name'];?></div>
						<?php if(isset($output['is_tou']) && $output['is_tou'] == $v['s_id']){ ?>
							<div class="yitoupiao" style="border : 1px solid #808080;color: #808080;" data="<?php echo $v['s_id'];?>">您已投票</div>
						<?php }else{ ?>
							<div class="vote" data="<?php echo $v['s_id'];?>">点击投票</div>
						<?php } ?>
						<div><span id="s_num<?php echo $v['s_id'];?>"><?php echo $v['s_num'];?></span>票</div>
					</li>
				<?php } ?>
				<?php } ?>
		       
		    </ul>
		</div>
		<?php } ?>
		<?php } ?>
		<!--
		<div class="btn-group">
		    <div class="dropdown-toggle">
		      	法学院
		    </div>
		    <ul class="dropdown-menu">
		        <li>
		        	<div>法学111</div>
		        	<div class="vote">点击投票</div>
		        	<div>123票</div>
		        </li>
		        <li>
		        	<div>法学112</div>
		        	<div class="vote">点击投票</div>
		        	<div>123票</div>
		        </li>
		    </ul>
		</div>
		<div class="btn-group">
		    <div class="dropdown-toggle">
		      	农学院
		    </div>
		    <ul class="dropdown-menu" style="display: none;">
		        <li>
		        	<div>农学111</div>
		        	<div class="vote">点击投票</div>
		        	<div>123票</div>
		        </li>
		        <li>
		        	<div>农学112</div>
		        	<div class="vote">点击投票</div>
		        	<div>123票</div>
		        </li>
		    </ul>
		</div>
		-->
	</body>
</html>
