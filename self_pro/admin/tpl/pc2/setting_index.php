<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!--内容start-->
<section id="content" class="container">
	<div class="block-area" id="tableStriped">
	<h3 class="block-title">网站后台设置</h3>
		<div class="btn-group btn-group-justified">
			<a onclick="setting('web')" class="btn btn-sm btn-alt">网站设定</a>
			<a onclick="setting('pc')" class="btn btn-sm btn-alt">电脑端设定</a>
			<a onclick="setting('mobile')" class="btn btn-sm btn-alt">手机端设定</a>
			<a onclick="setting('wx')" class="btn btn-sm btn-alt">微信设定</a>
		</div>
	</div>
	
	<!-- 电脑设置 -->
	<div id="setting_pc" class="block-area setting" id="tableStriped">
	pc
	</div>
	
	<!-- 手机设置 -->
	<div id="setting_mobile" class="block-area setting" id="tableStriped">
	mobile
	</div>
	
	<!-- 微信设置 -->
	<div id="setting_wx" class="block-area setting" id="tableStriped">
	<form class="from_box" action="?act=setting&op=index" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="setting_type" value="wx" >
	
	<input type="submit" value="确认" class="btn btn-lg m-r-5">
	<input type="submit" value="确认" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">
	</form>
	</div>
	
	<!-- 网站设置 -->
	<div id="setting_web" class="block-area setting" id="tableStriped">
	<form class="from_box" action="?act=setting&op=index" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="setting_type" value="web" >
	<p>网站名称</p>
	<input type="text" name="web_name" value="<?php echo isset($output['web_config']['web_name'])?$output['web_config']['web_name']:'';?>" class="form-control m-b-10" placeholder="请填写网站名称">
	<p>网站地址</p>
	<input type="text" name="web_url" value="<?php echo isset($output['web_config']['web_url'])?$output['web_config']['web_url']:'';?>" class="form-control m-b-10" placeholder="请填写网站地址">
	<p>手机</p>
	<input type="text" name="web_mobile" value="<?php echo isset($output['web_config']['web_mobile'])?$output['web_config']['web_mobile']:'';?>" class="form-control m-b-10" placeholder="手机号">
	<p>QQ</p>
	<input type="text" name="web_QQ" value="<?php echo isset($output['web_config']['web_QQ'])?$output['web_config']['web_QQ']:'';?>" class="form-control m-b-10" placeholder="QQ号">
	<p>邮箱</p>
	<input type="text" name="web_mail" value="<?php echo isset($output['web_config']['web_mail'])?$output['web_config']['web_mail']:'';?>" class="form-control m-b-10" placeholder="邮箱">
	<p>网站描述</p>
	<input type="text" name="web_desc" value="<?php echo isset($output['web_config']['web_desc'])?$output['web_config']['web_desc']:'';?>" class="form-control m-b-10" placeholder="网站描述">
	<!--
	<p>网站加密秘钥，谨慎修改（6-32位）</p>
	<input type="text" name="web_key" value="<?php echo isset($output['web_config']['web_key'])?$output['web_config']['web_key']:'';?>" class="form-control m-b-10" placeholder="秘钥">
	-->
	<p>网站的图标（ico格式,上传成功之后可能需要等待一段时间才会更新）</p>
	<div class="fileupload fileupload-new" data-provides="fileupload">
		<div class="fileupload-preview thumbnail form-control">
			<?php if(!empty($output['web_config']['web_ico'])){ ?>
				<img id="img_<?php echo substr(basename($output['web_config']['web_ico']),0,19);?>" src="<?php echo $output['web_config']['web_ico'];?>">
			<?php } ?>
		</div>
		<div>
			<span class="btn btn-file btn-alt btn-sm">
				<span class="fileupload-new">上传图片</span>
				<span class="fileupload-exists">重新选择</span>
				<input type="file" name="web_ico" />
			</span>
		</div>
	</div>
	
	<p>网站logo</p>
	<div class="fileupload fileupload-new" data-provides="fileupload">
		<div class="fileupload-preview thumbnail form-control">
			<?php if(!empty($output['web_config']['web_logo'])){ ?>
				<img id="img_<?php echo substr(basename($output['web_config']['web_logo']),0,19);?>" src="<?php echo $output['web_config']['web_logo'];?>">
			<?php } ?>
		</div>
		<div>
			<span class="btn btn-file btn-alt btn-sm">
				<span class="fileupload-new">上传图片</span>
				<span class="fileupload-exists">重新选择</span>
				<input type="file" name="web_logo" />
			</span>
		</div>
	</div>
	
	<div style="margin-top:10px;">
		<label class="checkbox-inline">
			<input name="is_balance" <?php if(isset($output['web_config']['is_balance']) && $output['web_config']['is_balance'] == 1){ ?> checked="checked" <?php } ?> type="checkbox">
			是否允许使用余额（余额就是用户充值在站内的金币）
		</label>
		<label class="checkbox-inline">
			<input name="is_redbag" <?php if(isset($output['web_config']['is_redbag']) && $output['web_config']['is_redbag'] == 1){ ?> checked="checked" <?php } ?> type="checkbox">
			是否允许使用红包（红包是累积型）
		</label>
		<label onclick="show_box('is_integral')" class="checkbox-inline">
			<div id="icheckbox_is_integral" class="icheckbox_minimal <?php if(isset($output['web_config']['is_integral']) && $output['web_config']['is_integral'] == 1){ ?>checked<?php } ?>" ></div>
			<input id="is_integral" name="is_integral" value="<?php if(isset($output['web_config']['is_integral']) && $output['web_config']['is_integral'] == 1){ ?>1<?php }else{ echo 2; } ?>" type="hidden">
			是否允许使用积分（积分是累积型，是商品中的消费积分）
		</label>
		<label onclick="show_box('is_coupon')" class="checkbox-inline">
			<div id="icheckbox_is_coupon" class="icheckbox_minimal <?php if(isset($output['web_config']['is_coupon']) && $output['web_config']['is_coupon'] == 1){ ?>checked <?php } ?>" ></div>
			<input id="is_coupon" name="is_coupon" value="<?php if(isset($output['web_config']['is_coupon']) && $output['web_config']['is_coupon'] == 1){ ?>1<?php }else{ echo 2; } ?>" type="hidden">
			是否允许使用劵（劵是单独使用型）
		</label>
		<label class="checkbox-inline">
			<input name="is_discount" <?php if(isset($output['web_config']['is_discount']) && $output['web_config']['is_discount'] == 1){ ?> checked="checked" <?php } ?> type="checkbox">
			是否显示折扣（折扣是自动计算的）
		</label>
		<label class="checkbox-inline">
			<input name="is_distribution" <?php if(isset($output['web_config']['is_distribution']) && $output['web_config']['is_distribution'] == 1){ ?> checked="checked" <?php } ?> type="checkbox">
			是否分销（使用最多5级分销）
		</label>
	</div>
	<div class="is_integral_box">
	<p>积分使用比例</p>
	<input type="text" name="jifen_1" value="<?php if(isset($output['web_config']['jifen_1'])){ echo $output['web_config']['jifen_1']; }else{ echo '1'; } ?>" style="width:100px;display:inline-table" class="form-control m-b-5" value="1">比
	<input type="text" name="jifen_2" value="<?php if(isset($output['web_config']['jifen_2'])){ echo $output['web_config']['jifen_2']; }else{ echo '10'; } ?>" style="width:100px;display:inline-table" class="form-control m-b-5" value="10">
	</div>
	<div class="is_coupon_box">
	<p>劵使用比例</p>
	<input type="text" name="coupon_1" value="<?php if(isset($output['web_config']['coupon_1'])){ echo $output['web_config']['coupon_1']; }else{ echo '1'; } ?>" style="width:100px;display:inline-table" class="form-control m-b-5" value="1">比
	<input type="text" name="coupon_2" value="<?php if(isset($output['web_config']['coupon_2'])){ echo $output['web_config']['coupon_2']; }else{ echo '1'; } ?>" style="width:100px;display:inline-table" class="form-control m-b-5" value="10">
	</div>
	
	<p>注册送红包（0代表不赠送红包）</p>
	<input type="text" name="register_redbag" value="<?php echo isset($output['web_config']['register_redbag'])?$output['web_config']['register_redbag']:'';?>" class="form-control m-b-10" placeholder="红包">
	
	<p>商品价格计算</p>
	<div style="margin-top:10px;">
		<?php $num_float = array('不使用小数点','一位小数（百分位四舍五入）','一位小数（百分位的数字舍弃）','二位小数（千分位四舍五入）','二位小数（千分位的数字舍弃）'); ?>
		<?php foreach($num_float as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="num_float" <?php if(isset($output['web_config']['num_float']) && $output['web_config']['num_float'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
	</div>
	<p>交易是否收回扣</p>
	<div style="margin-top:20px;">
		<?php $is_rebate = array('不使用回扣','百分比回扣','固定回扣'); ?>
		<?php foreach($is_rebate as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="is_rebate" <?php if(isset($output['web_config']['is_rebate']) && $output['web_config']['is_rebate'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
	</div>
	<p>回扣价格</p>
	<input type="text" name="rebate_price" value="<?php echo isset($output['web_config']['rebate_price'])?$output['web_config']['rebate_price']:'';?>" class="form-control m-b-10" placeholder="收的回扣的价格">
	<p>标准运费(为保护商家权益，如果使用此运费，在商家没有填写运费时最初使用此运费，不填写则不使用此运费)</p>
	<input type="text" name="min_freight" value="<?php echo isset($output['web_config']['min_freight'])?$output['web_config']['min_freight']:'';?>" class="form-control m-b-10" placeholder="">
	
	<p>价格以下不收回扣（包含此价格）</p>
	<input type="text" name="rebate_unprice" value="<?php echo isset($output['web_config']['rebate_unprice'])?$output['web_config']['rebate_unprice']:'';?>" class="form-control m-b-10" placeholder="这个价格以下的不收回扣">
	
	<p>余额增长（次日生效）</p>
	<select class="select" name="integral_set">
		<?php $integral_set = array('不增长','每小时增长','每日增长','每周增长','每月增长'); ?>
		<?php foreach($integral_set as $key => $val){ ?>
			<option value="<?php echo $key+1;?>" <?php if( isset($output['web_config']['integral_set']) && $output['web_config']['integral_set'] == ($key+1)){ ?> selected="selected" <?php } ?> ><?php echo $val;?></option>
		<?php } ?>
	</select>
	<p>增长次数限制（0为不限）</p>
	<input type="text" name="integral_sum" value="<?php echo isset($output['web_config']['integral_sum'])?$output['web_config']['integral_sum']:'';?>" class="form-control m-b-10" placeholder="次数限制">
	<p>增长价格</p>
	<input type="text" name="integral_price" value="<?php echo isset($output['web_config']['integral_price'])?$output['web_config']['integral_price']:'';?>" class="form-control m-b-10" placeholder="增长价格">
	<p>版权信息</p>
	<input type="text" name="copyright_information" value="<?php echo isset($output['web_config']['copyright_information'])?$output['web_config']['copyright_information']:'';?>" class="form-control m-b-10" placeholder="版权信息">
	<p>备案号</p>
	<input type="text" name="keep_record" value="<?php echo isset($output['web_config']['keep_record'])?$output['web_config']['keep_record']:'';?>" class="form-control m-b-10" placeholder="备案号">
	
	<p>开启注册</p>
	<div style="margin-top:10px;">
		<?php $is_register = array('开启','关闭'); ?>
		<?php foreach($is_register as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="is_register" <?php if(isset($output['web_config']['is_register']) && $output['web_config']['is_register'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
	</div>
	<p>是否允许登陆</p>
	<div style="margin-top:10px;">
		<?php $is_login = array('允许登陆','不允许登陆'); ?>
		<?php foreach($is_login as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="is_login" <?php if(isset($output['web_config']['is_login']) && $output['web_config']['is_login'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
	</div>
	
	<p>是否使用验证码</p>
	<div style="margin-top:10px;">
		<?php $is_captcha = array('使用','不使用'); ?>
		<?php foreach($is_captcha as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="is_captcha" <?php if(isset($output['web_config']['is_captcha']) && $output['web_config']['is_captcha'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
	</div>
	
	<p>登陆超时时间（秒）</p>
	<input type="text" name="login_time" value="<?php echo isset($output['web_config']['login_time'])?$output['web_config']['login_time']:'';?>" class="form-control m-b-10" placeholder="">
	
	<p>商家入驻</p>
	<div style="margin-top:10px;">
		<?php $is_store = array('可以入住','禁止入驻'); ?>
		<?php foreach($is_store as $key => $val){ ?>
		<label class="checkbox-inline">
			<input name="is_store" <?php if(isset($output['web_config']['is_store']) && $output['web_config']['is_store'] == ($key+1)){ ?> checked="checked" <?php } ?> value="<?php echo ($key+1);?>" <?php ?> type="radio">
			<?php echo $val;?>
		</label>
		<?php } ?>
	</div>
	<p>商家到期关闭（天）审核通过开始计算</p>
	<input type="text" name="store_day" value="<?php echo isset($output['web_config']['store_day'])?($output['web_config']['store_day']/(3600*24)):'';?>" class="form-control m-b-10" placeholder="">
	
	<p>商家入驻申请时间间隔（小时）</p>
	<input type="text" name="store_time" value="<?php echo isset($output['web_config']['store_time'])?($output['web_config']['store_time']/3600):'';?>" class="form-control m-b-10" placeholder="">
	
	<p>网站是否关闭</p>
	<select class="select" name="is_close">
		<?php $is_close = array('开启所有','单独开启pc端','单独开启手机端（paid属于手机端）','关闭网站'); ?>
		<?php foreach($is_close as $key => $val){ ?>
		<label class="checkbox-inline">
			<option <?php if(isset($output['web_config']['is_close']) && $output['web_config']['is_close'] == ($key+1)){ ?> selected="selected" <?php } ?> value="<?php echo $key+1;?>"><?php echo $val;?></option>
			<?php echo $val;?>
		</label>
		<?php } ?>
	</select>
	
	<div class="form-group m-b-15">
		<label>关闭原因</label>
		<textarea name="close_info" class="input-sm validate[required] form-control" placeholder=""><?php echo isset($output['web_config']['close_info'])?$output['web_config']['close_info']:'维护中。。。';?></textarea>
	</div>
	<input type="submit" value="确认" class="btn btn-lg m-r-5">
	<input type="submit" value="确认" class="btn btn-lg m-r-5" style="position: fixed;top: 50px;left: 50%;">
	</form>
	</div>
</section>
<script>
</script>
<script>
	$('.setting').hide();
	$('#setting_web').show();
	function setting(type){
		$('.setting').hide();
		$('#setting_'+type).show();
	}
	
	var select = false;
	function show_box(type){
		select = !select;
		if(select){
			$('#'+type).attr('value','1');
			$('#icheckbox_'+type).attr('class','icheckbox_minimal checked');
			$('#'+type).attr('checked','checked');
			$('.' + type + '_box').show();
		}else{
			$('#'+type).attr('value','2');
			$('#icheckbox_'+type).attr('class','icheckbox_minimal');
			$('#'+type).attr('checked','none');
			$('.' + type + '_box').hide();
		}
	}
</script>