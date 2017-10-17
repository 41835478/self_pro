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
        <link rel="shortcut icon" href="<?php echo URL;?>/favicon.ico" type="image/x-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="<?php echo TPL;?>/css/x-admin.css" media="all">
    </head>
    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header header header-demo">
                <div class="layui-main">
                    <a class="logo" href="?act=index&op=index">
                        <?php echo SYS('web_conf.admin_name');?>
                    </a>
                    <ul class="layui-nav" lay-filter="">
                      <!--
					  <li class="layui-nav-item"><img src="<?php echo TPL;?>/images/logo.png" class="layui-circle" style="border: 2px solid #A9B7B7;" width="35px" alt=""></li>
                      -->
					  <li class="layui-nav-item">
                        <a href="javascript:;"><?php echo $_SESSION['area']['name'];?></a>
                        <dl class="layui-nav-child"> <!-- 二级菜单 -->
                          <dd><a href="?act=login&op=logout">退出</a></dd>
                        </dl>
                      </li>
                      <!-- <li class="layui-nav-item">
                        <a href="" title="消息">
                            <i class="layui-icon" style="top: 1px;">&#xe63a;</i>
                        </a>
                        </li> -->
                      <li class="layui-nav-item x-index"><a target="_blank" href="/">前台首页</a></li>
                    </ul>
                </div>
            </div>
            <div class="layui-side layui-bg-black x-side">
                <div class="layui-side-scroll">
                    <ul class="layui-nav layui-nav-tree site-demo-nav" lay-filter="side">
                        <!-- 左边列表 -->
						<?php if(isset($output['menu']) && !empty($output['menu'])){?>
						<?php foreach($output['menu']['top'] as $key => $val){ ?>
						<li class="layui-nav-item" <?php if(isset($val[1])){ echo $val[1];}?> >
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite><?php echo $val[0];?></cite>
                            </a>
                            <dl class="layui-nav-child">
								<?php foreach($output['menu']['left'][$key] as $k => $v){?>
                                <dd class="" <?php if(isset($v[2])){ echo $v[2];}?> >
                                    <a href="javascript:;" _href="<?php echo $v[1];?>">
                                        <cite><?php echo $v[0];?></cite>
                                    </a>
                                </dd>
								<?php } ?>
                            </dl>
                        </li>
						<?php } ?>
						<?php } ?>
						
                    </ul>
                </div>
            </div>
            <div class="layui-tab layui-tab-card site-demo-title x-main" lay-filter="x-tab" lay-allowclose="true">
                <div class="x-slide_left"></div>
                <ul class="layui-tab-title">
                    <li class="layui-this">
                        我的桌面
                        <i class="layui-icon layui-unselect layui-tab-close">ဆ</i>
                    </li>
                </ul>
                <div class="layui-tab-content site-demo site-demo-body">
                    <div class="layui-tab-item layui-show">
                        <iframe frameborder="0" src="?act=index&op=welcome" class="x-iframe"></iframe>
                    </div>
                </div>
            </div>
            <div class="site-mobile-shade">
            </div>
        </div>
		<script src="<?php echo TPL;?>/lib/layui/layui.js" charset="utf-8"></script>
        <script src="<?php echo TPL;?>/js/x-layui.js" charset="utf-8"></script>
        <script src="<?php echo TPL;?>/js/x-admin.js"></script>
		<script>
		layui.use(['laydate','element','layer','form'], function(){
                $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
              lement = layui.element();//面包导航
        //      laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层
		});
		function clear_cache(title,url){
			$.post(url,{data:'all'},function(res){
				layer.msg(res.msg,{icon:1,time:2000});
				setTimeout(function(){
					location.href = location.href
				},2100);
			},'json');
		}
		function question_edit (title,url,id,w,h) {
			x_admin_show(title,url,w,h); 
		}
		</script>
    </body>
</html>
