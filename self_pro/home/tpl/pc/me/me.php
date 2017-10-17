<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="<?php echo TPL?>css/common.css">
    <link rel="stylesheet" href="<?php echo TPL?>me/css/me.css">
</head>
<body>
<div class="head">
    <div class="head_box col-xs-12">
        <div class="left_img col-xs-2 fl"><a href="javascript:;"><img src="<?php echo TPL;?>/me/img/back.png"/></a></div>
        <div class="head_txt col-xs-8 fl">个人中心</div>
        <div class="right_img col-xs-2 fl"></div>
    </div>
</div>

<div class="main">
    <!--<div class="whiteMargin"></div>-->
    <a href="/home/tpl/pc/me/personalInfo.html">
        <section class="header-info clearfix" >
            <div class="fl user-icon">
                <img src="<?php echo $output['data']['image'];?>">
            </div>
            <div class="fl col-xs-8 name"><?php echo $output['data']['name'];?></div>
            <div class="fl col-xs-8 intro"><?php echo $output['data']['u_desc'];?></div>
			<!--
            <span class="arrow fl"><img src="<?php echo $output['data']['image'];?>" alt=""/></span>
			-->
        </section>
    </a>
    <section class="data-info clearfix">
        <div class="fl col-xs-4 section">
            <div><?php echo $output['data']['u_jifen'];?></div>
            <div>积分</div>
        </div>
        <div class="fl col-xs-4 section">
            <div><?php echo $output['data']['guanzhu'];?></div>
            <div>关注</div>
        </div>
        <div class="fl col-xs-4 section">
            <div><?php echo $output['data']['fensi'];?></div>
            <div>粉丝</div>
        </div>
    </section>
    <!--margin-->
    <div class="grayMargin"></div>

    <section class="clearfix">
        <div class="clearfix">
            <div class="row fl" id="xiaoxi">
            <a href="/home/tpl/pc/me/message.html">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/xiaoxi.png"/>
                <div class="fl title">我的消息</div>
                <div class="fl sub-title"><?php echo $output['data']['message_count'];?>条未读</div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </a>
            </div>
            <div class="row fl" id="liuyan">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/liuyan.png"/>
                <div class="fl title">留言记录</div>
                <div class="fl sub-title">12</div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
        </div>
        <div class="grayMargin"></div>
        <div class="clearfix">
            <div class="row fl" id="zhiwei">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/zhiwei.png"/>
                <div class="fl title">我的职位</div>
                <div class="fl sub-title"><?php echo $output['data']['role_name'];?></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
            <div class="row fl" id="jiedan">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/jied1.png"/>
                <div class="fl title">接单信息</div>
                <div class="fl sub-title">第三方手动阀</div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
            <div class="row fl" id="shequ">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/shequ.png"/>
                <div class="fl title">我的社区</div>
                <div class="fl sub-title"><?php echo $output['data']['role_name'];?></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
            <div class="row fl" id="fabu">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/fabu.png"/>
                <div class="fl title">我的发布</div>
                <div class="fl sub-title"></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
            <div class="row fl" id="jiaoyi">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/wogoumaide.png"/>
                <div class="fl title">交易记录</div>
                <div class="fl sub-title"></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
            <div class="row fl" id="shoucang">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/shoucan.png"/>
                <div class="fl title">我的收藏</div>
                <div class="fl sub-title"></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
            <div class="row fl" id="guanzhu">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/wodeguangzhu.png"/>
                <div class="fl title">我的关注</div>
                <div class="fl sub-title"></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
			<!-- <a href="?act=login&op=logout">
			<div class="row fl" id="tuichu">
                <img class="fl icon" src="<?php echo TPL;?>/me/img/wodeguangzhu.png"/>
                <div class="fl title">退出</div>
                <div class="fl sub-title"></div>
                <span class="arrow fr"><img src="<?php echo TPL;?>/me/img/arrow.png" alt=""/></span>
            </div>
			</a> -->
        </div>
        <div class="grayMargin"></div>
        <div class="logout fl">退出当前账号</div>
    </section>
</div>
</body>
<script type="text/javascript" src="<?php echo TPL;?>/js/zepto-1.2.0.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>me/js/me.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>/js/common.js"></script>
</html>
<script>
	var sign = '<?php echo $output['data']['sign'];?>';
	var phone = '<?php echo $output['data']['phone'];?>';
	var id = '<?php echo $output['data']['id'];?>';
    //获取用户信息
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "http://www.125898.com/api/api.php?commend=get_user_info",
        data: {u_id:id,sign:sign},
        success: function (data) {
            console.log(data);
            if (data.code == "-1")
                alert(data.msg);
            else {
                //保存用户信息
                var userModel = {userId:data.data.id,
                    userName:data.data.name,
                    sign:data.data.sign,
                    userIcon:data.data.image,
                    images:data.data.images,
                    phone:data.data.phone,
                    recomCode:data.data.recomm_code,
                    openId:data.data.openid,
                    userSex:data.data.u_sex,
                    userDesc:data.data.u_desc,
                    userRole:data.data.type};
                var userStr = JSON.stringify(userModel);
                sessionStorage.userModel = userStr;
            }
        }
    });
</script>