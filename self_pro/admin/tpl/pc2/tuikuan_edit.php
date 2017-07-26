<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--引入css样式start-->
<link href="<?php echo CSS;?>/order.css" rel="stylesheet"> 
<!--引入css样式end-->

<!--内容start-->
<section id="content" class="container">
<!-- Table Striped -->
<div class="block-area" id="tableStriped">
	<h3 class="block-title">订单编辑</h3>
	<form class="from_box" action="" method="post" enctype="multipart/form-data" >
		<input type="hidden" id="order" name="order_id" value="<?php echo isset($_GET['order_id'])?intval($_GET['order_id']):'';?>" >
		<p>预定人姓名</p>
		<input type="text" name="safe_name" value="<?php echo isset($output['data']['safe_name'])?$output['data']['safe_name']:'';?>" class="form-control m-b-10">
		<p>订单简单描述</p>
		<input type="text" name="order_desc" value="<?php echo isset($output['data']['order_desc'])?$output['data']['order_desc']:'';?>" class="form-control m-b-10" >
		<p>应付金额</p>
		<input type="text" name="price" value="<?php echo isset($output['data']['price'])?$output['data']['price']:'';?>" class="form-control m-b-10"   >
		<p>实付款</p>
		<input type="text" name="over_price" value="<?php echo isset($output['data']['over_price'])?$output['data']['over_price']:'';?>" class="form-control m-b-10"   >
		<p>发票金额</p>
		<input type="text" name="fapiao_price" value="<?php echo isset($output['data']['fapiao_price'])?$output['data']['fapiao_price']:'';?>" class="form-control m-b-10"   >
		<p>发票状态</p>
		<div style="margin-top:10px;">
		<?php $order_state = array('未开发票','已开发票'); ?>
		<?php foreach($order_state as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="order_state" <?php if(isset($output['data']['order_state']) && $output['data']['order_state'] == $key){ ?> checked="checked" <?php } ?> value="<?php echo $key;?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
		</div>
		<p>发票地址</p>
		<input type="text" name="order_address" value="<?php echo isset($output['data']['order_address'])?$output['data']['order_address']:'';?>" class="form-control m-b-10"   >
		<p>入驻状态</p>
		<input type="text" name="ruzhu_state" value="<?php echo isset($output['data']['ruzhu_state'])?$output['data']['ruzhu_state']:'';?>" class="form-control m-b-10"   >
		<p>渠道</p>
		<input type="text" name="channel" value="<?php echo isset($output['data']['channel'])?$output['data']['channel']:'';?>" class="form-control m-b-10"   >
		<p>押金</p>
		<input type="text" name="deposit" value="<?php echo isset($output['data']['deposit'])?$output['data']['deposit']:'';?>" class="form-control m-b-10"   >
		<p>应扣除押金</p>
		<input type="text" name="zj_deposit" value="<?php echo isset($output['data']['zj_deposit'])?$output['data']['zj_deposit']:'';?>" class="form-control m-b-10"   >
		<p>应退回押金(参考)</p>
		<input type="text" name="deposit2" value="<?php echo isset($output['data']['deposit2'])?$output['data']['deposit2']:'';?>" class="form-control m-b-10"   >
		
		<p>退回押金</p>
		<input type="text" id="yajin" value="<?php echo isset($output['data']['deposit2'])?$output['data']['deposit2']:'';?>" class="form-control m-b-10"   >
		<p>是否有押金退回</p>
        <div class="make-switch switch-mini">
			<input name="is_tui" checked="checked" type="checkbox">
		</div>
		<p>备注</p>
		<input type="text" name="order_remarks" value="<?php echo isset($output['data']['order_remarks'])?$output['data']['order_remarks']:'0';?>" class="form-control m-b-10"  >
		<!--
		<p>积分</p>
		<input type="text" name="total_price" value="<?php echo isset($output['data']['total_price'])?$output['data']['total_price']:'0';?>" class="form-control m-b-10"  >
		-->
		<div style="margin-top:10px;">
		<?php $pay = array('实付款未支付','实付款已支付'); ?>
		<?php foreach($pay as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="pay" <?php if(isset($output['data']['pay']) && $output['data']['pay'] == $key){ ?> checked="checked" <?php } ?> value="<?php echo $key;?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
		</div>
		
		<div style="margin-top:10px;">
		<?php $deposit_pay = array('押金未支付','押金已支付','已退押金'); ?>
		<?php foreach($deposit_pay as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="deposit_pay" <?php if(isset($output['data']['deposit_pay']) && $output['data']['deposit_pay'] == $key){ ?> checked="checked" <?php } ?> value="<?php echo $key;?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
		</div>
		<!--
		<p>减免</p>
		<input type="text" name="reminder" value="<?php echo isset($output['data']['reminder'])?$output['data']['reminder']:'0';?>" class="form-control m-b-10"  >
		-->
		<div id="calendar" >
			<div id="tools">
				<div class="l">
					<select id="selectYear" ></select> 年
					<select id="selectMonth"></select> 月
				</div>
				<div class="r">
					<span id="prevMonth">前一个月</span>
					<span id="nextMonth">后一个月</span>
				</div>
			</div>
			<table id="showTable">
				<thead>
					<tr>
						<th>日</th>
						<th>一</th>
						<th>二</th>
						<th>三</th>
						<th>四</th>
						<th>五</th>
						<th>六</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<p>人数</p>
		<input type="text" name="people_num" value="<?php echo isset($output['data']['people_num'])?$output['data']['people_num']:'1';?>" class="form-control m-b-10"  >
		<p>手机号</p>
		<input type="text" name="mobile" value="<?php echo isset($output['data']['mobile'])?$output['data']['mobile']:'';?>" class="form-control m-b-10"  >
		<?php if(isset($output['goods_list']) && !empty($output['goods_list'])){ ?>
		<p>请选择商品</p>
		<div class="min-height:100px;">
		<?php foreach($output['goods_list'] as $key => $val){ ?>
			<div>
				<div style="float:left;line-height:33px;min-width:350px;"><?php echo $val['goods_name']?>(￥<?php echo $val['goods_price'];?>) 数量：</div>
				<input type="hidden" name="goods[]" value="<?php echo $val['goods_id'];?>">
				<input class="form-control m-l-10 m-r-10 select_goods" data_price="<?php echo $val['goods_price'];?>" data_id="<?php echo $val['goods_id'];?>" style="float:left;width:50px" name="goods_<?php echo $val['goods_id']?>" type="text" value="<?php echo isset($val['num']) ? $val['num'] : 0;?>">
			</div>
		<?php } ?>
		</div>
		<?php } ?>
		<div class="dada_time" style="display:none" ></div>
		<!--
		<p>订单出售时间（不填写代表没有限制）(开始)</p>
		<!-- Date Time Picker -->
		<!--
		<div class="row">
			<div class="col-md-4 m-b-15">
				<p>日期</p>
				<div class="input-icon datetime-pick date-only">
					<input data-format="yyyy-MM-dd" name="start_day" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['start_day'])?$output['data']['start_day']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
			<div class="col-md-4 m-b-15">
				<p>小时</p>
				<div class="input-icon datetime-pick time-only">
					<input data-format="hh:mm:ss" name="start_hour" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['start_hour'])?$output['data']['start_hour']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
		</div>
		<p>订单出售时间（不填写代表没有限制）(结束)</p>
		<!-- Date Time Picker -->
		<!--
		<div class="row">
			<div class="col-md-4 m-b-15">
				<p>日期</p>
				<div class="input-icon datetime-pick date-only">
					<input data-format="yyyy-MM-dd" name="end_day" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['end_day'])?$output['data']['end_day']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
			<div class="col-md-4 m-b-15">
				<p>小时</p>
				<div class="input-icon datetime-pick time-only">
					<input data-format="hh:mm:ss" name="end_hour" type="text" class="form-control input-sm" value="<?php echo isset($output['data']['end_hour'])?$output['data']['end_hour']:'';?>" />
					<span class="add-on">
						<i class="sa-plus"></i>
					</span>
				</div>
			</div>
		</div>
		-->
		<input type="hidden" class="duihuanma" value="<?php echo isset($output['data']['duihuanma'])?$output['data']['duihuanma']:'';?>">
		<!--空盒子-->
		<div class="empty_box" style="width:100%;margin-top:30px;float:left" ></div>
		<div class="empty_box" style="width:100%;margin-top:0px;float:left" >
		<!--
		<a onclick="enter()" class="btn btn-lg ">确认</a>
		-->
		<a onclick="tuiyajin()" class="btn btn-lg ">退押金</a>
		</div>
		
		<?php if(isset($_GET['order_id']) && intval($_GET['order_id']) > 0){ ?>
			<!--<a onclick="order_settlement()" class="btn btn-lg m-r-5">订单结算</a>-->
		<?php } ?>
		<!--
		<a onclick="enter()" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 45%;">确认</a>
		
		<a onclick="tuiyajin()" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 55%;">退押金</a>
		-->
	</form>
</section>
<!--
<div class="weui_dialog_alert sharee_spe" id="sharee_spe_tg"  style="position:fixed;z-index:999999;width:100%;top:50%;display:none">
	<div class="weui_dialog" style="height:100%;width:100%;top:0;background:white;opacity:0;z-index:9998;"></div>
	<div class="weui_mask">
		<div class="select_day">
			<div>
				<div class="select_day_head">请选择场次<span class="sharee_spe_close" style="float: right; padding-right: 0.1rem;">X</span></div>
				<div class="select_day_body">
					<div class="select_day_body_l  lk1">
						<div>早场</div>
						<div><?php echo $output['changci'][0]['start_time'];?>-<?php echo $output['changci'][0]['end_time'];?></div>
					</div>
					<div class="select_day_body_r  lk2">
						<div>晚场</div>
						<div><?php echo $output['changci'][1]['start_time'];?>-<?php echo $output['changci'][1]['end_time'];?></div>
					</div>
				</div>
			</div>
			<div class="select_day_button" style="    margin-top: 155px;">确定</div>
		</div>
	</div>
</div>
-->
<!--content内容结束-->
<script>
	function enter(){
		create_data_input();
		$('.from_box').submit();
	}
	function tuiyajin(){
		var order_id = $('#order').val();
		
	//	var order_id = $('#order_id').val();
		var duihuanma = $('.duihuanma').val();
		if(duihuanma != ''){
			var url = '/api/api.php?commend=use_jiushui';
			$.ajax({
				url:url,
				type:'POST',
				async:false,
				dataType:'json',
				data:'&order_id='+order_id+'&d_code='+ duihuanma, //{order_no:order_no,d_code:duihuanma},
				success:function(state){
					
				}
			});
		}
		
		var yajin = $('#yajin').val();
		$('.from_box').attr('action',"?act=order&op=tuiyajin&order_id=" + order_id + '&yajin='+yajin);
		$('.from_box').submit();
	}
	var string = '';
	function create_data_input(){
		if(typeof(over_post) != 'undefined'){
			for(x in over_post){
				string += '<input type="hidden" name="date_time[]" value="'+x+'|'+over_post[x]+'">';
			}
			$('.dada_time').html(string);
		}
	}
</script>
<script>
	function delete_images(order_id,image,hide_id){
		url = "?act=order&op=order_images_del";
		$.post(url,{order_id:order_id,image:image},function(state){
			if(state.code == 1){
				$('#imgs_'+hide_id).hide();
			}else{
				slert('删除失败');
			}
		},'json');
		
	}
	/*
	var ppp = 0;
	var d = {};
	var goods = {};
	$('.select_goods').on('blur',function(){
		var goods_price = 0;
		$('.select_goods').each(function(i){
			d.goods_num = $(this).val();
			if(parseInt(d.goods_num) > 0){
				var goods_id = $(this).attr('data_id');
				d.z_price = parseInt($(this).val()) * parseInt($(this).attr('data_price'));
				d.price = $(this).attr('data_price');
				$(this).attr('num',$(this).val());
				d.num = $(this).attr('num');
				goods[goods_id] = d;
			}
			goods_price += parseInt($(this).val()) * parseInt($(this).attr('data_price'));
		});
	})
	*/
</script>
<script>
	var over_post = {};
	window.onload = function() {
		var store_id = <?php echo $_SESSION['store_id']?>;
		var text1 = document.getElementById('text1');
			calendar();


		var dat1 = {};
		var dat2 = {};
		var dat3 = {};
		function get_month_order_reserve(YY,mm,dd){
			
		//	var to_year = $('#selectYear option:selected').val();
		//	var to_month = parseInt($('#selectMonth option:selected').val())+1;
		
			function init_order(){
				if(dat3 != null){
					$('#showTable td').each(function(i){
						var Y = $('#selectYear option:selected').val();
						var m = parseInt($('#selectMonth option:selected').val())+1;
						var d = $(this).html();
						var sss = Y + '-' + m + '-' + d;
						for(k in dat3){
							if(k == sss){
								$(this).attr('time',k);
								$(this).attr('data2',dat3[k]);
								var abc = $(this);
								var code = dat3[k];
								switch(code){
								case 1:
									abc.css('background','');
								break;
								case 2:
									abc.css('background','url(<?php echo IMG;?>/leftcircle.png) no-repeat center');
								break;
								case 3:
									abc.css('background','url(<?php echo IMG;?>/rightcircle.png) no-repeat center');
								break;
								case 4:
									abc.css('background','url(<?php echo IMG;?>/t5.png) no-repeat center');
								break;
								case 5:
									abc.css('background','url(<?php echo IMG;?>/t6.png) no-repeat center');
								break;
								case 6:
									abc.css('background','url(<?php echo IMG;?>/t9.png) no-repeat center');
								break;
								case 7:
									abc.css('background','url(<?php echo IMG;?>/t8.png) no-repeat center');
								break;
								case 8:
									abc.css('background','url(<?php echo IMG;?>/t7.png) no-repeat center');
								break;
							}
							}
						}
					});
				}
			}
			var uri = '/api/api.php?commend=get_month_order_reserve';
			var t_one = YY + '-' + mm + '-' + dd;
			$.post(uri,{store_id:store_id,today:t_one},function(data){
				if(typeof(data.msg) == 'object'){
					var da = data.msg;
					$('#showTable td').each(function(i){
						if(parseInt($(this).html()) > 0){
						//	console.log(da);
							for(x in da){
								if(x == to_year + '-' + to_month + '-' + $(this).html()){
									if(da[x] == 1){
										$(this).css('background','url(<?php echo IMG;?>/leftcircle.png) no-repeat center');
									}
									if(da[x] == 2){
										$(this).css('background','url(<?php echo IMG;?>/rightcircle.png) no-repeat center');
									}
									if(da[x] == 3){
										$(this).css('background','url(<?php echo IMG;?>/dinged.png) no-repeat center');
									}
								//	console.log(da[x]);
									$(this).attr('state',da[x]);
									$(this).attr('data',x);
									$(this).attr('is_yuding',1);
								}
							}
						}
					});
				}
				init_order();
			},'json');
		}
		var to_year = $('#selectYear option:selected').val();
		var to_month = parseInt($('#selectMonth option:selected').val())+1;
		var to_today = $('.today').html();
		get_month_order_reserve(to_year,to_month,to_today);
		function calendar() {

			var calendarElement = document.getElementById('calendar');

			var selectYearElement = document.getElementById('selectYear');
			var selectMonthElement = document.getElementById('selectMonth');
			var showTableElement = document.getElementById('showTable');
			var prevMonthElement = document.getElementById('prevMonth');
			var nextMonthElement = document.getElementById('nextMonth');

			calendarElement.style.display = 'block';

			/*
			 * 获取今天的时间
			 * */
			var today = new Date();

			//设置日历显示的年月
			var showYear = today.getFullYear();
			var showMonth = today.getMonth();

				//持续更新当前时间
			updateTime();
			//动态生成选择年的select
			for (var i=1970; i<2020; i++) {
				var option = document.createElement('option');
				option.value = i;
				
				option.innerHTML = i;
				if ( i == showYear ) {
					option.selected = true;
				}
				selectYearElement.appendChild(option);
			}
			//动态生成选择月的select
			for (var i=1; i<13; i++) {
				var option = document.createElement('option');
				option.value = i - 1;
				option.innerHTML = i;
				if ( i == showMonth + 1 ) {
					option.selected = true;
				}
				selectMonthElement.appendChild(option);
			}

			//初始化显示table
			showTable();

			//选择年
			selectYearElement.onchange = function() {
				showYear = this.value;
				showTable();
				showOption();
			}

			//选择月
			selectMonthElement.onchange = function() {
				showMonth = Number(this.value);
				showTable();
				showOption();
				
			}

			//上一个月
			prevMonthElement.onclick = function() {
				showMonth--;
				showTable();
				showOption();
				var Y = $('#selectYear option:selected').val();
				var m = parseInt($('#selectMonth option:selected').val())+1;
				get_month_order_reserve(Y,m,1);
				
			}

			//下一个月
			nextMonthElement.onclick = function() {
				showMonth++;
				showTable();
				showOption();
				var Y = $('#selectYear option:selected').val();
				var m = parseInt($('#selectMonth option:selected').val())+1;
				get_month_order_reserve(Y,m,1);
				
			}
			
			var ll = rr = true;  //是否允许被点击
			var that = null;  	//控制当前被点击的
			$('#showTable').on('click','td',function(){
				 var nian = $('#selectYear option:selected').val();
				 var yue = parseInt($('#selectMonth option:selected').val())+1;
				 var ri = $(this).html();
				 if(ri == ''){
					 return false;
				 }
				 that = $(this);
				 that.time = nian + '-' + yue + '-' + ri;
				 that.l = that.r = true;
				 
				 if(typeof($(this).attr('data2')) == 'undefined' ){
					  that.l = that.r = false;
				 }
				
				 if(typeof($(this).attr('data2')) != 'undefined' ){
					var data2 = $(this).attr('data2');
					switch(data2){
						case '1':
							that.l = that.r = false;
						break;
						case '2':
							that.l = that.r = false;
						break;
						case '3':
							that.l = false;
						break;
						case '4':
							ll = false
						break;
						case '5':
							rr = false;
						break;
						case '6':
							that.r = false;
						break;
						case '7':
							that.l = false;
						break;
					} 
				 }
				 
				 if($(this).attr('state') == '1' ){
					$('.lk1').css('background','url(<?php echo IMG;?>/dinged_la.png) no-repeat center');//dinged_la.png
					$('.lk1').css('backgroundSize','1.4rem 1.4rem');
					$('.lk1 div').hide();
					ll = false;
					that.l = false;
				 }
				 if($(this).attr('state') == '2' || $(this).attr('data2') == '3'){
					$('.lk2 div').hide();
					$('.lk2').css('background','url(<?php echo IMG;?>/dinged_la.png) no-repeat center');//dinged_la.png
					$('.lk2').css('backgroundSize','1.4rem 1.4rem');
					rr = false;
					that.r = false;
				 }
				 if($(this).attr('state') == '3'){
					 return false;
				 }
				
				 if(that.l){
					 $('.lk1').css('backgroundColor','rgb(255, 198, 3)');
				 }
				 if(that.r){
					 $('.lk2').css('backgroundColor','rgb(255, 198, 3)');
				 }
				 
				
				 $('#sharee_spe_tg').show();
			});
			
			$('.sharee_spe_close').click(function(){
				$('#sharee_spe_tg').hide();
				box_init();
			})
			var data2 = 0;
			var selected_num = 0;
			var post_data = {};
			
			var left_num = 0;
			var right_num = 0;
			var chongjian = 0;
			$('.select_day_button').click(function(){
				var str1 = that.attr('time');
				var str2 = that.attr('data2');
				var str3 = that.css('background-image');
					console.info('str3.p.'+str3)
			//	alert(str3);
				if(that.l == false && that.r == false){
					data2 = 1;
					selected_num = 0;
				}
				if(ll == false && that.r == false){
					data2 = 2;
					selected_num = 0;
				}
				if(rr == false && that.l == false){
					data2 = 3;
					selected_num = 0;
				}
				if(ll == false && that.r == true){  //左边一杯选中
					data2 = 4;
					selected_num = 2;
				}
				if(rr == false && that.l == true){
					data2 = 5;
					selected_num = 1;
				}
				if(rr == true && that.l == true && that.r == false){
					data2 = 6;
					selected_num = 1;
				}
				if(ll == true && that.l == false && that.r == true){
					data2 = 7;
					selected_num = 2;
				}
				if(that.l == true && that.r == true){
					data2 = 8;
					selected_num = 3;
				}
				
				dat3[that.time] = data2;
				if(selected_num > 0){
					dat1[that.time] = selected_num;
				}else{
					dat1[that.time] = 0;
					dat3[that.time] = 1;
				}
				for(c in dat1){
					if(dat1[c] == 2){
						dat2[c] = dat1[c];
						right_num ++;
					}
				}
				for(b in dat1){
					if(dat1[b] == 3){
						dat2[b] = dat1[b];
						chongjian ++;
					}
				}
				for(a in dat1){
					if(dat1[a] == 1){
						dat2[a] = dat1[a];
						left_num ++;
					}
				}
				over_post = dat2;
				var url = '/api/api.php?commend=reserve';
				var ttt = that;
				$.post(url,{store_id:store_id,dat2:dat2},function(ddd){
					if(ddd.msg.code == '1'){
						$('#yuding_price').html(ddd.msg.over_price);
					}
					if(ddd.msg.code == '-1'){  //报错
						alert(ddd.msg.msg);
						ttt.attr('time',str1);
						if(typeof(str2) == 'undefined'){
							ttt.attr('data2','1');
						}else{
							ttt.attr('data2',str2);
						}
						dat3[ttt.time] = '';
						
						ttt.css('backgroundImage',str3);
					}
				},'json');
				
				switch(data2){
					case 1:
						that.css('background','');
					break;
					case 2:
						that.css('background','url(<?php echo IMG;?>/leftcircle.png) no-repeat center');
					break;
					case 3:
						that.css('background','url(<?php echo IMG;?>/rightcircle.png) no-repeat center');
					break;
					case 4:
						that.css('background','url(<?php echo IMG;?>/t5.png) no-repeat center');
					break;
					case 5:
						that.css('background','url(<?php echo IMG;?>/t6.png) no-repeat center');
					break;
					case 6:
						that.css('background','url(<?php echo IMG;?>/t9.png) no-repeat center');
					break;
					case 7:
						that.css('background','url(<?php echo IMG;?>/t8.png) no-repeat center');
					break;
					case 8:
						that.css('background','url(<?php echo IMG;?>/t7.png) no-repeat center');
					break;
				}
				that.attr('time',that.time);
				that.attr('data2',data2);
				that.attr('class','curr');
				
				$('#sharee_spe_tg').hide();
				$('.tg_answer_3').show();
				box_init();
			});
			
			//确定和关闭初始化
			function box_init(){
				ll = rr = true;
				$('.lk2 div').show();
				$('.lk1 div').show();
				$('.lk1').css('background','');
				$('.lk2').css('background','');
				that = null;
				state = 0;
				selected_num = 0;
				left_num = right_num = 0;
				dat2 = {};
			}
			$('.lk1').click(function(){
				if(!ll){
					return false;
				}
				if($(this).css('backgroundColor')=='rgb(251, 251, 251)'){
					$(this).css('backgroundColor','rgb(255, 198, 3)');
					that.l = true;
				}else{
					$(this).css('backgroundColor','rgb(251, 251, 251)');
					that.l = false;
				};
			})
			$('.lk2').click(function(){
				if(!rr){
					return false;
				}
				if($(this).css('backgroundColor')=='rgb(251, 251, 251)'){
					$(this).css('backgroundColor','rgb(255, 198, 3)');
					that.r = true;
				}else{
					$(this).css('backgroundColor','rgb(251, 251, 251)');
					that.r = false;
				};
			})
			/*
			* 实时更新当前时间
			* */
			function updateTime() {
				var timer = null;
				//每个500毫秒获取当前的时间，并把当前的时间格式化显示到指定位置
				var today = new Date();
				timer = setInterval(function() {
					var today = new Date();
				}, 500);
			}

			function showTable() {
				showTableElement.tBodies[0].innerHTML = '';
				//根据当前需要显示的年和月来创建日历
				//创建一个要显示的年月的下一个的日期对象
				var date1 = new Date(showYear, showMonth+1, 1, 0, 0, 0);
				//对下一个月的1号0时0分0秒的时间 - 1得到要显示的年月的最后一天的时间
				var date2 = new Date(date1.getTime() - 1);
				//得到要显示的年月的总天数
				var showMonthDays = date2.getDate();
				//获取要显示的年月的1日的星期,从0开始的星期
				date2.setDate(1);
				//showMonthWeek表示这个月的1日的星期，也可以作为表格中前面空白的单元格的个数
				var showMonthWeek = date2.getDay();

				var cells = 7;
				var rows = Math.ceil( (showMonthDays + showMonthWeek) / cells );

				//通过上面计算出来的行和列生成表格
				//没生成一行就生成7列
				//行的循环
				for ( var i=0; i<rows; i++ ) {

					var tr = document.createElement('tr');

					//列的循环
					for ( var j=0; j<cells; j++ ) {

						var td = document.createElement('td');

						var v = i*cells + j - ( showMonthWeek - 1 );

						//根据这个月的日期控制显示的数字
						//td.innerHTML = v;
						if ( v > 0 && v <= showMonthDays  ) {

							//高亮显示今天的日期
							if ( today.getFullYear() == showYear && today.getMonth() == showMonth && today.getDate() == v ) {
								td.className = 'today';
							}

							td.innerHTML = v;
						} else {
							td.innerHTML = '';
						}

						td.ondblclick = function() {
							calendarElement.style.display = 'none';

							text1.value = showYear + '年' + (showMonth+1) + '月' + this.innerHTML + '日';
						}

						tr.appendChild(td);

					}

					showTableElement.tBodies[0].appendChild(tr);

				}
			}

			function showOption() {

				var date = new Date(showYear, showMonth);
				var sy = date.getFullYear();
				var sm = date.getMonth();
		//        console.log(showYear, showMonth)

				var options = selectYearElement.getElementsByTagName('option');
				for (var i=0; i<options.length; i++) {
					if ( options[i].value == sy ) {
						options[i].selected = true;
					}
				}

				var options = selectMonthElement.getElementsByTagName('option');
				for (var i=0; i<options.length; i++) {
					if ( options[i].value == sm ) {
						options[i].selected = true;
					}
				}
			}
		}

		/*
		 * 获取指定时间的时分秒
		 * */
		function getTime(d) {
			return [
				addZero(d.getHours()),
				addZero(d.getMinutes()),
				addZero(d.getSeconds())
			].join(':');
		}

		/*
		* 获取指定时间的年月日和星期
		* */
		function getDate(d) {
			return d.getFullYear() + '年'+ addZero(d.getMonth() + 1) +'月'+ addZero(d.getDate()) +'日 星期' + getWeek(d.getDay());
		}

		/*
		* 给数字加前导0
		* */
		function addZero(v) {
			if ( v < 10 ) {
				return '0' + v;
			} else {
				return '' + v;
			}
		}

		/*
		* 把数字星期转换成汉字星期
		* */
		function getWeek(n) {
			return '日一二三四五六'.split('')[n];
		}
		
		
	}
</script>
 <style>
	
	#calendar {
		width: 94%;
		padding: 5px 3%;
		background: rgb(0,0,0,0);
	}

	#tools {
		padding: 5px 0;
		height: 30px;
		color: #000;
	}
	#tools .l {
		float: left;
	}
	#tools .r {
		float: right;
	}
	table {
		width: 100%;
		color: #000;
		font-size:30px;
	}
	table th {
		color:gary;
	}
	table td {
		text-align: center;
		cursor: default;
	}
	table td.today {
		color: red;
	}
	#selectMonth,#selectYear{
		width:50px;
		height:30px;
		background:rgb(0,0,0,0);
	}
	
.select_day{
	width:710px;
	height: 320px;
	background: #fbfbfb;
	position: absolute;
	top:30%;
	left:25%;
	z-index:1000;
	box-shadow: 0px 10px 5px #888888;
}

.select_day_head{
	background: #ffc603;
	height:70px;
	color:#fff;
	font-size: 36px;
	font-family: "黑体";
	line-height:70px;
	text-align: center;
	}
.select_day_body{
	background: #fbfbfb;
	height:119px
	padding-top:16px;
	margin-bottom: 40px;
}
.select_day_body_l{
	height:119px;
	background: #fbfbfb;
	width:49%;
	border-right: 1px solid #ffd028;
		padding-bottom:24px;
		float:left;
}
.select_day_body_r{
		height:119px;
	background: #fbfbfb;
	width:50%;
	float:left;
		padding-bottom:24px;
}
.select_day_body_l div{
	text-align: center;
}
.select_day_body_r div{
	text-align: center;
}
.select_day_body_l div:nth-child(1){
	margin-top: 20px;
	margin-bottom:15px;
	color:#323232;
	font-size: 30px;
	font-family: "黑体";
	font-weight: bold;
}
.select_day_body_l div:nth-child(2){
	color:#646464;
	font-size: 24px;
	font-family: "微软雅黑";
}
.select_day_body_r div:nth-child(1){
	margin-top: 20px;
	margin-bottom: 15px;
	color:#323232;
	font-size: 30px;
	font-weight: bold;
	font-family: "黑体";
}
.select_day_body_r div:nth-child(2){
	color:#646464;
	font-size: 24px;
	font-family: "微软雅黑";
}
.select_day_button{
	width: 150px;
	height: 50px;
	text-align: center;
	color:white;
	background: #ffd028;
	line-height: 50px;;
	margin: 0 auto;
	border-radius: 3px;
	font-family: "微软雅黑";
}

</style>
