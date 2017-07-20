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
        <div class="x-body">
            <blockquote class="layui-elem-quote">
                欢迎!<!--使用x-admin 后台模版！<span class="f-14">v1.0</span>-->
            </blockquote>
            <p>登录次数：18 </p>
            <p>上次登录IP：222.35.131.79.1  上次登录时间： 2017-01-01 11:19:55</p>
            <fieldset class="layui-elem-field layui-field-title site-title">
              <legend><a name="default">信息统计</a></legend>
            </fieldset>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>统计</th>
                        <th>管理员</th>
                        <th>店铺(开启)</th>
                        <th>商品(正在出售)</th>
                        <th>用户</th>
                        <!--
						<th>用户</th>
                        <th>管理员</th>
						-->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>总数</td>
                        <td>92</td>
                        <td>9</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
					<tr>
                        <td>一周</td>
                        <td>92</td>
                        <td>9</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">服务器信息</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th width="30%">系统</th>
                        <td><span id="lbServerName"><?php echo $output['data']['server_name'];?></span></td>
                    </tr>
                    <tr>
                        <td>服务器IP地址</td>
                        <td><?php echo $output['data']['ip'];?></td>
                    </tr>
                    <tr>
                        <td>服务器域名</td>
                        <td><?php echo $output['data']['url'];?></td>
                    </tr>
                    <tr>
                        <td>服务器端口</td>
                        <td><?php echo $output['data']['web_port'];?></td>
                    </tr>
                    <tr>
                        <td>服务器软件信息</td>
                        <td><?php echo $output['data']['server_software'];?></td>
                    </tr>
                    <tr>
                        <td>服务器操作系统 </td>
                        <td><?php echo $output['data']['system'];?></td>
                    </tr>
                    <tr>
                        <td>系统所在文件夹 </td>
                        <td><?php echo $output['data']['root_dir'];?></td>
                    </tr>
                    <tr>
                        <td>服务器的语言</td>
                        <td><?php echo $output['data']['language'];?></td>
                    </tr>
                    <tr>
                        <td>服务器当前时间 </td>
                        <td><?php echo $output['data']['current_time'];?></td>
                    </tr>
                    <tr>
                        <td>当前系统用户名 </td>
                        <td>NETWORK SERVICE</td>
                    </tr>
                </tbody>
            </table>
        </div>
		<!--
        <div class="layui-footer footer footer-demo">
            <div class="layui-main">
                <p>感谢layui,百度Echarts,jquery</p>
                <p>
                    <a href="/">
                        Copyright ©2017 x-admin v2.3 All Rights Reserved.
                    </a>
                </p>
                <p>
                    <a href="./" target="_blank">
                        本后台系统由X前端框架提供前端技术支持
                    </a>
                </p>
            </div>
        </div>
		-->
        <script src="<?php echo TPL;?>/lib/layui/layui.js" charset="utf-8"></script>
        <script src="<?php echo TPL;?>/js/x-admin.js"></script>
        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
    </body>
</html>