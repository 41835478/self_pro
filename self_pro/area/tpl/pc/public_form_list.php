<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            <?php echo SYS('web_conf.admin_name');?>
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
        <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>会员管理</cite></a>
              <a><cite>问题/资讯列表</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <form class="layui-form x-center formsearch" action="?act=<?php echo $_GET['act']?>&op=<?php echo $_GET['op']?>" method="post" style="width:100%">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
					<?php if($output['form_top_hujdfisahjhj']['selected']){ echo $output['form_top_hujdfisahjhj']['selected'];};?>
                   
					<?php if($output['form_top_hujdfisahjhj']['start_time']){ ?>
					<div class="layui-input-inline">
                      <input name="start_time" value="<?php echo $output['form_top_hujdfisahjhj']['start_time'] == KEY ? '' :  $output['form_top_hujdfisahjhj']['start_time'];?>" class="layui-input" placeholder="开始时间" id="LAY_demorange_s">
                    </div>
					<?php } ?>
                    <?php if($output['form_top_hujdfisahjhj']['end_time']){ ?>
					<div class="layui-input-inline">
                      <input name="end_time" value="<?php echo $output['form_top_hujdfisahjhj']['end_time'] == KEY ? '' :  $output['form_top_hujdfisahjhj']['end_time'];?>"  class="layui-input" placeholder="结束时间" id="LAY_demorange_e">
                    </div>
					<?php } ?>
                    <?php if($output['form_top_hujdfisahjhj']['keyword']){ ?>
					<div class="layui-input-inline">
                      <input type="text" name="keyword"  placeholder="关键字" value="<?php echo $output['form_top_hujdfisahjhj']['keyword'] == KEY ? '' : $output['form_top_hujdfisahjhj']['keyword'] ;?>" autocomplete="off" class="layui-input">
                    </div>
					<?php } ?>
					<?php if($output['form_top_hujdfisahjhj']['search']){ ?>
					<div class="layui-input-inline" style="width:80px">
                        <a class="layui-btn" onclick="search_keyword()"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i>搜索</a>
                    </div>
					<?php } ?>
                  </div>
                </div> 
				
				<input id="form_page" type="hidden" name="page" value="1" >
				
            </form>
            <xblock>
			
			<?php if($output['form_top_hujdfisahjhj']['self']){ echo $output['form_top_hujdfisahjhj']['self'];};?>
			
			<?php if($output['form_top_hujdfisahjhj']['export']){ ?>
			<button class="layui-btn layui-btn-danger layui-export" href="<?php echo $output['form_top_hujdfisahjhj']['export']?>">导出execl</button>	
			<?php } ?>
			<?php if($output['form_top_hujdfisahjhj']['all_del']){ ?>
			<button class="layui-btn layui-btn-danger" onclick="delAll('<?php echo $output['form_top_hujdfisahjhj']['all_del']?>')"><i class="layui-icon">&#xe640;</i>批量删除</button>	
			<?php } ?>
			<?php if($output['form_top_hujdfisahjhj']['add']){ ?>
			<button class="layui-btn" onclick="question_add('添加','<?php echo $output['form_top_hujdfisahjhj']['add']?>','1024','768')"><i class="layui-icon">&#xe608;</i>添加</button>
			<?php } ?>
			<span class="x-right" style="line-height:40px">共有数据：<?php echo isset($output['count']) ? intval($output['count']) : '0' ;?> 条</span>
			</xblock>
			<table class="layui-table">
				<?php echo $output['form_list'];?>
			</table>
			<?php echo isset($output['page']) && !empty($output['page']) ? $output['page'] : '';?>
           
        </div>
        <script src="<?php echo TPL;?>/lib/layui/layui.js" charset="utf-8"></script>
        <script src="<?php echo TPL;?>/js/x-layui.js" charset="utf-8"></script>
        <script>
			
            layui.use(['laydate','element','layer','form'], function(){
                $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
        //      laypage = layui.laypage;//分页
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
              
            });

            //批量删除提交
             function delAll (url) {
                layer.confirm('确认要删除吗？',function(index){
                    //捉到所有被选中的，发异步进行删除
					var ids = '';
					$('.checked').each(function(){
						if($(this).context.checked){
							ids += $(this).val() + ',';
						}
					});
					$.post(url,{ids:ids},function(res){
						layer.msg(res.msg, {icon: 1,time:1500});
						setTimeout(function(){
							window.location.href = window.location.href;
						},1500);
					},'json');
                });
             }

             function question_show (argument) {
                layer.msg('可以跳到前台具体问题页面',{icon:1,time:1000});
             }
             /*添加*/
            var win = window;
			win.width 	= window.innerWidth;
			win.height 	= window.innerHeight ;
            function question_add(title,url,w,h){
            //    x_admin_show(title,url,w,h);
                x_admin_show(title,url,win.width,win.height);
            }
            //编辑 
			function question_edit (title,url,id,w,h) {
            //    x_admin_show(title,url,w,h); 
				x_admin_show(title,url,win.width,win.height);
            }

            /*删除*/
            function question_del(obj,url){
                layer.confirm('确认要删除吗？',function(index){
                    //发异步删除数据
					$.ajax({
						url:url,
						type:'get',
						async:false, //同步
						success:function(res){
							if(res.code == '1'){
								$(obj).parents("tr").remove();
								
							}
							layer.msg(res.msg,{icon:1,time:1000});
						},
						dataType:'json'
					});
                });
            }
			function search_keyword(page){
			//	var page = $('.page .cur').attr('data');
				if(typeof(page) != 'undefined'){
					$("#form_page").val(page);
				}
				$('.formsearch').submit();
			}
            </script>
    </body>
</html>
<style>
.input-label{
	border:0px;
}

#page .cur{
    left: -1px;
    top: -1px;
    padding: 1px;
	display: inline-block;
	padding: 0 15px;
	border: 1px solid #e2e2e2;
	height: 37px;
	color: #fff;
    background-color: #009688;
}
#page a{
	display: inline-block;
    vertical-align: middle;
    padding: 0 15px;
    border: 1px solid #e2e2e2;
    height: 35px;
    line-height: 35px;
    margin: 0 -1px 5px 0;
    background-color: #fff;
    color: #333;
    font-size: 12px;
}
#page span{
	display: inline-block;
    vertical-align: middle;
    padding: 0 15px;
    border: 1px solid #e2e2e2;
    height: 35px;
    line-height: 35px;
    margin: 0 -1px 5px 0;
    background-color: #fff;
    color: #333;
    font-size: 12px;
}
</style>
<script>
	
</script>
