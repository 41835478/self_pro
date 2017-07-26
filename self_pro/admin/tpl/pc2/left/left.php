<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<section id="main" class="p-relative" role="main">
<!-- Sidebar -->
<aside id="sidebar">
	<!-- Sidbar Widgets -->
	<div class="side-widgets overflow">
		<!-- Profile Menu -->
		<div class="text-center s-widget m-b-25 dropdown" id="profile-menu">
			<a href="" data-toggle="dropdown">
				<img class="profile-pic animated" src="<?php echo $_SESSION['admin_logo'];?>" alt="">
			</a>
			<ul class="dropdown-menu profile-menu">
				<li><a href="">My Profile</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
				<li><a href="">Messages</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
				<li><a href="?act=user&op=self_admin_edit&admin=edit">个人信息设置</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
				<li><a href="?act=login&op=logout">退出</a> <i class="icon left">&#61903;</i><i class="icon right">&#61815;</i></li>
			</ul>
			<h4 class="m-0"><?php echo $_SESSION['admin'];?></h4>
			<!--@malinda-h-->
		</div>
		
		<!-- Calendar -->
		<div class="s-widget m-b-25">
			<div id="sidebar-calendar"></div>
		</div>
		<div >
			<a href="?act=setting&op=index" class="btn btn-alt m-l-5 m-r-5">网站设定</a><a href="?act=index&op=nav" class="btn btn-alt m-l-5 m-r-5">后台导航</a>
		</div>
		<!-- Feeds -->
		<!--
		<div class="s-widget m-b-25">
			<!--
			<h2 class="tile-title">
			   News Feeds
			</h2>
			
			<div class="s-widget-body">
				<div id="news-feed"></div>
			</div>
			
		</div>
		-->
		<!-- Projects -->
		<!--
		<div class="s-widget m-b-25">
		
			<h2 class="tile-title">
				Projects on going
			</h2>
			
			<div class="s-widget-body">
				<div class="side-border">
					<small>Joomla Website</small>
					<div class="progress progress-small">
						 <a href="#" data-toggle="tooltip" title="" class="progress-bar tooltips progress-bar-danger" style="width: 60%;" data-original-title="60%">
							  <span class="sr-only">60% Complete</span>
						 </a>
					</div>
				</div>
				<div class="side-border">
					<small>Opencart E-Commerce Website</small>
					<div class="progress progress-small">
						 <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-info" style="width: 43%;" data-original-title="43%">
							  <span class="sr-only">43% Complete</span>
						 </a>
					</div>
				</div>
				<div class="side-border">
					<small>Social Media API</small>
					<div class="progress progress-small">
						 <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-warning" style="width: 81%;" data-original-title="81%">
							  <span class="sr-only">81% Complete</span>
						 </a>
					</div>
				</div>
				<div class="side-border">
					<small>VB.Net Software Package</small>
					<div class="progress progress-small">
						 <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: 10%;" data-original-title="10%">
							  <span class="sr-only">10% Complete</span>
						 </a>
					</div>
				</div>
				<div class="side-border">
					<small>Chrome Extension</small>
					<div class="progress progress-small">
						 <a href="#" data-toggle="tooltip" title="" class="tooltips progress-bar progress-bar-success" style="width: 95%;" data-original-title="95%">
							  <span class="sr-only">95% Complete</span>
						 </a>
					</div>
				</div>
			</div>
		</div>
		-->
	</div>
	
	<!-- Side Menu -->
	<ul class="list-unstyled side-menu">
		<!--
		<li >
			<a  >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">商品管理</div>
				<span class="menu-item">商品管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=goods&op=goods_list">商品列表</a></li>
				<li><a href="?act=category&op=category_list">商品分类</a></li>
				<li><a href="?act=navigation&op=navigation_list">商品导航</a></li>
				<!--
				<li><a href="?act=category&op=category_list">商品规格</a></li>
				<li><a href="?act=category&op=category_list">商品属性</a></li>
				
				<li><a href="?act=role&op=list">用户评论</a></li>
				
				<li><a href="?act=role&op=list">商品品牌</a></li>
				
			</ul>
		</li>
		-->
		<li class="dropdown">
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">商铺管理</div>
				<span class="menu-item">商铺管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=store&op=store_list">商铺列表</a></li>
				<!--
				<li><a href="?act=store&op=store_list&type=2">开启的店铺</a></li>
				<li><a href="?act=store&op=store_list&type=3">关闭的店铺</a></li>
				<li><a href="?act=store&op=store_list&type=4">审核通过的店铺</a></li>
				<li><a href="?act=store&op=store_list&type=5">申请中的店铺</a></li>
				<li><a href="?act=store&op=store_list&type=6">申请失败的店铺</a></li>
				<li><a href="?act=store&op=store_list&type=7">已过期的店铺</a></li>
				-->
			</ul>
		</li>
		<!--
		<li class="dropdown">
			<a class="sa-side-typography" href="typography.html">
				<span class="menu-item">促销管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=one&op=one_buy_list">一元购物</a></li>
				
				<li><a href="?act=one&op=one_indiana">一元夺宝</a></li>
				<li><a href="?act=user&op=user_list">夺宝奇兵</a></li>
				<li><a href="?act=role&op=list">红包类型</a></li>
				<li><a href="?act=role&op=list">商品包装</a></li>
				<li><a href="?act=role&op=list">祝福贺卡</a></li>
				<li><a href="?act=role&op=list">团购活动</a></li>
				<li><a href="?act=role&op=list">专题管理</a></li>
				<li><a href="?act=role&op=list">拍卖活动</a></li>
				<li><a href="?act=role&op=list">优惠活动</a></li>
				<li><a href="?act=role&op=list">批发管理</a></li>
				<li><a href="?act=role&op=list">超值礼包</a></li>
				<li><a href="?act=role&op=list">积分商城商品</a></li>
				
			</ul>
		</li>
		-->
		<li class="dropdown" >
			<a  >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">订单管理</div>
				<span class="menu-item">订单管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=order&op=order_list">订单列表</a></li>
				<li><a href="?act=order&op=no_tuiyajin_list">退押金列表</a></li>
				<li><a href="?act=order&op=tuiyajin_list">退押金列表(已退的)</a></li>
				<li><a href="?act=order&op=order_bujia_list">订单补价</a></li>
				<!--
				<li><a href="?act=role&op=list">合并订单</a></li>
				<li><a href="?act=role&op=list">订单打印</a></li>
				<li><a href="?act=role&op=list">缺货登记</a></li>
				<li><a href="?act=role&op=list">添加订单</a></li>
				<li><a href="?act=role&op=list">发货单列表</a></li>
				<li><a href="?act=role&op=list">退货单列表</a></li>
				-->
			</ul>
		</li>
		<!--
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">广告管理</div>
				<span class="menu-item">广告管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=adv&op=adv_list">广告列表</a></li>
			</ul>
		</li>
		-->
		<li class="dropdown">
			<a href="">
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">权限管理</div>
				<span class="list-unstyled menu-item">权限管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=user&op=user_list">管理员列表</a></li>
				<!--
				<li><a href="?act=role&op=role_list">角色管理</a></li>
				<li><a href="?act=group&op=group_list">组管理</a></li>
				-->
			</ul>
		</li>
		<li class="dropdown" >
			<a  >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">会员管理</div>
				<span class="menu-item">会员管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=user&op=member_list">会员列表</a></li>
			<!--<li><a href="?act=user&op=member_edit">添加会员</a></li>-->
				<!--
				<li><a href="?act=user&op=member_level">会员等级</a></li>
				<li><a href="?act=user&op=member_recharge">充值和提现申请</a></li>
				<li><a href="?act=user&op=member_capital">资金管理</a></li>
				-->
			</ul>
		</li>
		<li class="dropdown" >
			<a  >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">兑换码</div>
				<span class="menu-item">兑换码</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=duihuan&op=duihuan_list">兑换码列表</a></li>
			<!--<li><a href="?act=user&op=member_edit">添加会员</a></li>-->
				<!--
				<li><a href="?act=user&op=member_level">会员等级</a></li>
				<li><a href="?act=user&op=member_recharge">充值和提现申请</a></li>
				<li><a href="?act=user&op=member_capital">资金管理</a></li>
				-->
			</ul>
		</li>
		<!--
		<li class="dropdown">
			<a class="sa-side-ui" href="">
				<span class="menu-item">报表统计</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="buttons.html">流量分析</a></li>
				<li><a href="labels.html">客户统计</a></li>
				<li><a href="images-icons.html">订单统计</a></li>
				<li><a href="alerts.html">销售概况</a></li>
				<li><a href="media.html">会员排行</a></li>
				<li><a href="components.html">销售明细</a></li>
				<li><a href="other-components.html">搜索引擎</a></li>
				<li><a href="other-components.html">销售排行</a></li>
				<li><a href="other-components.html">访问购买率</a></li>
				<li><a href="other-components.html">站外投放js</a></li>
			</ul>
		</li>
		-->
		<!--
		<li class="dropdown">
			<a class="sa-side-ui" href="">
				<span class="menu-item">导航与分类控制</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="buttons.html">导航控制</a></li>
				<li><a href="labels.html">分类控制</a></li>
			</ul>
		</li>
		-->
		<!--
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">区域管理</div>
				<span class="menu-item">区域管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=region&op=update">地区更新</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a href="charts.html">
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">文章管理</div>
				<span class="menu-item">文章管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=article&op=article_list">文章列表</a></li>
				<li><a href="?act=article&op=article_class_list">文章分类</a></li>
			</ul>
		</li>
		-->
		<!--
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">系统设置</div>
				<span class="menu-item">系统设置</span>
			</a>
			<ul class="list-unstyled menu-item">
				<!--
				<li><a href="buttons.html">网站设置</a></li>
				<li><a href="buttons.html">会员注册项设置</a></li>
				-->
				<!--
				<li><a href="?act=payment&op=payment_list">支付方式</a></li>
				<!--
				<li><a href="images-icons.html">配送方式</a></li>
				<li><a href="alerts.html">邮件服务器设置</a></li>
				<li><a href="media.html">地区列表</a></li>
				<li><a href="components.html">计划任务</a></li>
				-->
				<!--
				<li><a href="?act=link&op=link_list">友情链接</a></li>
				<!--
				<li><a href="other-components.html">验证码管理</a></li>
				<li><a href="other-components.html">文件权限检测</a></li>
				<li><a href="other-components.html">文件效验</a></li>
				<li><a href="other-components.html">首页主广告管理</a></li>
				<li><a href="other-components.html">自定义导航栏</a></li>
				<li><a href="other-components.html">站点地图</a></li>
				-->
				<!--
			</ul>
		</li>
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">财务统计</div>
				<span class="menu-item">财务统计</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=financial&op=financial_statistics">财务统计</a></li>
			</ul>
		</li>
		-->
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">管家列表</div>
				<span class="menu-item">管家列表</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=guanjia&op=guanjia_list">管家列表</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">报销申请</div>
				<span class="menu-item">报销申请</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=baoxiao&op=baoxiao_list">报销列表</a></li>
				<li><a href="?act=baoxiao&op=yitijiao">已提交</a></li>
				<li><a href="?act=baoxiao&op=yibaoxiao">已通过</a></li>
				<li><a href="?act=baoxiao&op=weibaoxiao">未通过</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a >
				<div style="width:25px;margin-left:10px;margin-top:5px;position:absolute;">数据导出</div>
				<span class="menu-item">数据导出</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="?act=data&op=data">数据导出</a></li>
			</ul>
		</li>
		<!--
		<li class="dropdown" >
			<a class="sa-side-chart" href="charts.html">
				<span class="menu-item">模板管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="buttons.html">模板选择</a></li>
				<li><a href="labels.html">设置模板</a></li>
				<li><a href="images-icons.html">库项目管理</a></li>
				<li><a href="alerts.html">语言项编辑</a></li>
				<li><a href="media.html">模板设置备份</a></li>
				<li><a href="components.html">邮件模板</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a class="sa-side-chart" href="charts.html">
				<span class="menu-item">数据库管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="buttons.html">数据备份</a></li>
				<li><a href="labels.html">数据表优化</a></li>
				<li><a href="images-icons.html">sql查询</a></li>
				<li><a href="alerts.html">转换数据</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a class="sa-side-chart" href="charts.html">
				<span class="menu-item">短信管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="buttons.html">发送短信</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a class="sa-side-chart" href="charts.html">
				<span class="menu-item">推荐管理</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="buttons.html">推荐设置</a></li>
				<li><a href="buttons.html">分成管理</a></li>
			</ul>
		</li>
		<li class="dropdown" >
			<a class="sa-side-calendar" href="calendar.html">
				<span class="menu-item">Calendar</span>
			</a>
		</li>
		<li class="dropdown">
			<a class="sa-side-page" href="">
				<span class="menu-item">Pages</span>
			</a>
			<ul class="list-unstyled menu-item">
				<li><a href="list-view.html">List View</a></li>
				<li><a href="profile-page.html">Profile Page</a></li>
				<li><a href="messages.html">Messages</a></li>
				<li><a href="login.html">Login</a></li>
				<li><a href="404.html">404 Error</a></li>
			</ul>
		</li>
		-->
	</ul>

</aside>