<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            X-admin v1.0
        </title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="<?php echo TPL;?>/css/x-admin.css" media="all">
    </head>
    <body>
		 <!--
        <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>会员管理</cite></a>
              <a><cite>编辑</cite></a>
            </span>
			<a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
		</div>
		-->
        <div class="x-body">
			<form class="layui-form layui-form-pane" <?php echo isset($output['form_url']) ? $output['form_url'] :'';?> <?php echo isset($output['method']) ? $output['method'] :'';?> >
				<table class="layui-table">
					<?php echo $output['form'];?>
				</table>
				<div class="layui-form-item">
					<button class="layui-btn" lay-filter="add" lay-submit>
						提交
					</button>
				</div>
			</form>
        </div>
        <script src="<?php echo TPL;?>/lib/layui/layui.js" charset="utf-8"></script>
        <script src="<?php echo TPL;?>/js/x-layui.js" charset="utf-8"></script>
        <script>
			
            layui.use(['laydate','element','laypage','layer','form'], function(){
                $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
			  var form = layui.form();
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层

              <?php if(isset($output['time_abcdefghijkl']) && !empty($output['time_abcdefghijkl'])){ ?>
			  <?php foreach($output['time_abcdefghijkl'] as $key => $val){ ?>
				  var <?php echo $val;?> = {
				//	min: '1991-01-01'//laydate.now()
				//	,max: '2099-06-16 23:59:59'
					istoday: true
					,issure:true
					,format:"YYYY-MM-DD hh:mm:ss"
				//	,isclear:true
					,istime:true
					,choose: function(datas){
				//	  <?php echo $val;?>.min = datas;
				//	  <?php echo $val;?>.max = datas; //结束日选好后，重置开始日的最大日期
					}
				  };
				  
				  document.getElementById('<?php echo $val;?>').onclick = function(){
					<?php echo $val;?>.elem = this;
					laydate(<?php echo $val;?>);
				  }
			  <?php } ?>
			  <?php } ?>
			  //监听提交
				form.on('submit(add)', function(data){
					var url = data.form.action;
					var type = data.form.method;
					$.ajax({
						url:url,
						type:type,
						data:data.field,
						async:false, //同步
						success:function(res){
							if(res.code == '1'){
								layer.alert(res.msg, {icon: 6 },function () {
									// 获得frame索引
									var index = parent.layer.getFrameIndex(window.name);
									//关闭当前frame
									parent.layer.close(index);
									
								});
							}else{
								layer.msg(res.msg,{icon:1,time:1500});
							}
						},
						dataType:'json'
					});
					return false;
				}); 
			});
            </script>
    </body>
</html>
<style>
.input-label{
	border:0px;
}
</style>