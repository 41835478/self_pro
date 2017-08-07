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
                        <a href="javascript:;"><?php echo $_SESSION['admin']['username'];?></a>
                        <dl class="layui-nav-child"> <!-- 二级菜单 -->
                          <dd><a onclick="clear_cache('清除缓存','?act=cache&op=clearcache')">清除缓存</a></dd>
                          <dd><a onclick="question_edit('修改密码','?act=admin&op=reset_password','','400','300')">修改密码</a></dd>
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
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>问题管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="?act=index&op=index_list">
                                            <cite>问题列表</cite>
                                        </a>
                                    </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo TPL;?>/question-del.html">
                                            <cite>删除问题</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>产品管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="?act=goods&op=goods_list">
                                            <cite>产品列表</cite>
                                        </a>
                                    </dd>
                                </dd>
								<dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="?act=cat&op=cat_list">
                                            <cite>产品分类</cite>
                                        </a>
                                    </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo TPL;?>/welcome.html">
                                            <cite>品牌管理（待开发）</cite>
                                        </a>
                                    </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo TPL;?>/welcome.html">
                                            <cite>类型管理（待开发）</cite>
                                        </a>
                                    </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo TPL;?>/welcome.html">
                                            <cite>类型属性（待开发）</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>轮播管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo TPL;?>/banner-list.html">
                                            <cite>轮播列表</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>订单管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="<?php echo TPL;?>/welcome.html">
                                            <cite>订单列表（待开发）</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>导航</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="?act=nav&op=nav_list">
                                        <cite>导航列表</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>评论管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/comment-list.html">
                                        <cite>评论列表</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/feedback-list.html">
                                        <cite>意见反馈</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>会员管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="member-list.html">
                                        <cite>会员列表</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/member-del.html">
                                        <cite>删除会员</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/member-level.html">
                                        <cite>等级管理</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/member-kiss.html">
                                        <cite>积分管理</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/member-view.html">
                                        <cite>浏览记录</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/member-view.html">
                                        <cite>分享记录</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>管理员管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="?act=admin&op=admin_list">
                                        <cite>管理员列表</cite>
                                    </a>
                                </dd>
								<dd class="">
                                    <a href="javascript:;" _href="?act=admin&op=admin_log_list">
                                        <cite>管理员操作日志</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/admin-role.html">
                                        <cite>角色管理</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/admin-cate.html">
                                        <cite>权限分类</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/admin-rule.html">
                                        <cite>权限管理</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>系统统计</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts1.html">
                                        <cite>拆线图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts2.html">
                                        <cite>柱状图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts3.html">
                                        <cite>地图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts4.html">
                                        <cite>饼图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts5.html">
                                        <cite>雷达图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts6.html">
                                        <cite>k线图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts7.html">
                                        <cite>热力图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/echarts8.html">
                                        <cite>仪表图</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="http://echarts.baidu.com/examples.html" target="_blank" _href="<?php echo TPL;?>/welcome.html">
                                        <cite>更多案例</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>系统设置</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="?act=system&op=system_setting">
                                        <cite>系统设置</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="?act=value&op=value_list">
                                        <cite>系统变量</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="?act=payment&op=payment_index">
                                        <cite>支付配置</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/sys-log.html">
                                        <cite>系统日志</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/sys-link.html">
                                        <cite>友情链接</cite>
                                    </a>
                                </dd>
                                <dd class="">
                                    <a href="javascript:;" _href="<?php echo TPL;?>/sys-qq.html">
                                        <cite>第三方登录</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
						<li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>微信相关</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="?act=wechat&op=wechat_menu">
                                        <cite>微信菜单</cite>
                                    </a>
                                </dd>
								<dd class="">
                                    <a href="javascript:;" _href="?act=wechat&op=test">
                                        <cite>测试</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
						<li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>友情链接</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="?act=link&op=link_list">
                                        <cite>友情链接</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
						 <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe617;</i><cite>测试页面</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test1">
                                        <cite>测试1</cite>
                                    </a>
                                </dd>
								<dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test2">
                                        <cite>测试2</cite>
                                    </a>
                                </dd>
								<!--
								<dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test3">
                                        <cite>测试3</cite>
                                    </a>
                                </dd>
								<dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test4">
                                        <cite>测试4</cite>
                                    </a>
                                </dd>
								<dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test5">
                                        <cite>测试5</cite>
                                    </a>
                                </dd>
								<dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test6">
                                        <cite>测试6</cite>
                                    </a>
                                </dd>
								-->
								<dd class="">
                                    <a href="javascript:;" _href="?act=test&op=test7">
                                        <cite>测试7</cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
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