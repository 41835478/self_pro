<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" href="<?php echo TPL;?>css/swiper.css">
    <link rel="stylesheet" href="<?php echo TPL;?>css/common.css">
    <link rel="stylesheet" href="<?php echo TPL;?>css/index.css">
</head>
<body>
<!--导航条-->
<div class="head">
    <div class="head_box col-xs-12">
        <div class="left_img col-xs-2 fl"><a href="javascript:;"><img src="<?php echo TPL;?>images/logo.png"/></a></div>
        <a href="<?php echo TPL;?>location2.html"><div class="head_txt col-xs-8 fl"><span id="community">点击定位</span><span class="downBtn"></span></div></a>
        <div class="right_img col-xs-1 fr"><a href="javascript:;"><img src="<?php echo TPL;?>images/search.png"/></a></div>
    </div>
</div>

<!--轮播图-->
<div class="banner swiper-container">
    <div class="swiper-wrapper w100" id="swiper-wrapper">

    </div>
    <div class="swiper-pagination"></div>
</div>

<!--分类-->
<div class="cate-list-wrapper">
    <ul class="cate-list sum-4 clearfix" id="cate-list">
        <!-- <li class="fl">
            <a href="javascript:;">
                <img src="<?php echo TPL;?>images/lingy.png" class="">
                <div class="name">娱快领用</div>
            </a>
        </li>
        <li class="fl classify" gc_id="1">
            <a href="http://www.5898.me/">
                <img src="<?php echo TPL;?>images/men.png">
                <div class="name">手机通行</div>
            </a>
        </li>
        <li class="fl classify" gc_id="2">
            <a href="javascript:;">
                <img src="<?php echo TPL;?>images/zhongchuangzhijia.png">
                <div class="name">众创之家</div>
            </a>
        </li>
        <li class="fl classify" gc_id="3">
            <a href="javascript:;">
                <img src="<?php echo TPL;?>images/huodong.png">
                <div class="name">约吧约</div>
            </a>
        </li> -->
    </ul>
</div>
<div class="grayMargin"></div>

<!--社长资源-->
<div class="home-title-wrapper clearfix">
    <div class="fl home-title">社长资源</div>
    <span><img src="<?php echo TPL;?>images/arrow.png" class="fr"/></span>
</div>
<div class="shezhang" id="shezhang" data-template-name="single_item">
    <ul class="shezhang_ul" id="shezhang_ul">
        <!-- <li class="shezhang_li fl">
            <div><img src="<?php echo TPL;?>images/logo.png"></div>
            <div class="name">社长名称</div>
            <div class="tag"><span>德州扑克</span></div>
            <div class="tag"><span>麻将</span></div>
        </li>
        <li class="shezhang_li fl">
            <div><img src="<?php echo TPL;?>images/logo.png"></div>
            <div class="name">社长名称</div>
            <div class="tag"><span>德州扑克</span></div>
            <div class="tag"><span>麻将</span></div>
        </li>
        <li class="shezhang_li fl">
            <div><img src="<?php echo TPL;?>images/logo.png"></div>
            <div class="name">社长名称</div>
            <div class="tag"><span>德州扑克</span></div>
            <div class="tag"><span>麻将</span></div>
        </li>
        <li class="shezhang_li fl">
            <div><img src="<?php echo TPL;?>images/logo.png"></div>
            <div class="name">社长名称</div>
            <div class="tag"><span>德州扑克</span></div>
            <div class="tag"><span>麻将</span></div>
        </li>
        <li class="shezhang_li fl">
            <div><img src="<?php echo TPL;?>images/logo.png"></div>
            <div class="name">社长名称</div>
            <div class="tag"><span>德州扑克</span></div>
            <div class="tag"><span>麻将</span></div>
        </li> -->
    </ul>
</div>

<div class="grayMargin"></div>

<!--精选资源-->
<a href="<?php echo TPL;?>allResource.html">
    <div class="home-title-wrapper clearfix">
        <div class="fl home-title">精选资源</div>
        <span><img src="<?php echo TPL;?>images/arrow.png" class="fr"/></span>
    </div>
</a>
<div class="resource" id="resource">
    <ul class="clearfix">
        <li class="fl">
            <img class="fl" src="<?php echo TPL;?>images/logo.png">
            <div class="fl resource-name">电子指纹锁</div>
        </li>
        <li class="fl">
            <img class="fl" src="<?php echo TPL;?>images/logo.png">
            <div class="fl resource-name">饮水机</div>
        </li>
    </ul>
    <ul class="clearfix">
        <li class="fl">
            <img class="fl" src="<?php echo TPL;?>images/logo.png">
            <div class="fl resource-name">电子指纹锁</div>
        </li>
        <li class="fl">
            <img class="fl" src="<?php echo TPL;?>images/logo.png">
            <div class="fl resource-name">饮水机</div>
        </li>
    </ul>
</div>
<div class="grayMargin"></div>

<!--求助信息-->
<div class="home-title-wrapper clearfix">
    <div class="fl home-title">求助信息</div>
    <span><img src="<?php echo TPL;?>images/arrow.png" class="fr"/></span>
</div>
<ul class="help" id="help">
    <li class="help-info clearfix" >
        <div class="fl user-icon">
            <img src="<?php echo TPL;?>images/logo.png">
        </div>
        <div class="fl col-xs-8 title">求助信息</div>
        <div class="fl col-xs-8 time">10分钟前</div>
        <div class="fl content">求助信息求助信息求助信息求助信息求助信息求助信息求助信息求助信息求助信息</div>
        <div class="fr num-info">
            <div class="fl num">
                <img class="fl icon" src="<?php echo TPL;?>images/pinglun.png">
                <div class="fl comment">10</div>
            </div>
            <div class="fl num">
                <img class="fl icon" src="<?php echo TPL;?>images/shoucanliuy.png">
                <div class="fl fav">10</div>
            </div>
            <div class="fl num">
                <img class="fl icon" src="<?php echo TPL;?>images/dianzan.png">
                <div class="fl zan">10</div>
            </div>
        </div>
    </li>
    <li class="help-info clearfix" >
        <div class="fl user-icon">
            <img src="<?php echo TPL;?>images/logo.png">
        </div>
        <div class="fl col-xs-8 title">求助信息</div>
        <div class="fl col-xs-8 time">10分钟前</div>
        <div class="fl content">
            <div>求助信息求助信息求助信息求助信息求助信息求助信息求助信息求助信息求助信息</div>
            <img src="<?php echo TPL;?>images/123.jpg">
            <img src="<?php echo TPL;?>images/123.jpg">
            <img src="<?php echo TPL;?>images/123.jpg">
        </div>
        <div class="fr num-info">
            <div class="fl num">
                <img class="fl icon" src="<?php echo TPL;?>images/pinglun.png">
                <div class="fl comment">10</div>
            </div>
            <div class="fl num">
                <img class="fl icon" src="<?php echo TPL;?>images/shoucanliuy.png">
                <div class="fl fav">10</div>
            </div>
            <div class="fl num">
                <img class="fl icon" src="<?php echo TPL;?>images/dianzan.png">
                <div class="fl zan">10</div>
            </div>
        </div>
    </li>
</ul>
<div class="grayMargin"></div>

<!--活动精选-->
<div class="home-title-wrapper clearfix">
    <div class="fl home-title">活动精选</div>
    <span><img src="<?php echo TPL;?>images/arrow.png" class="fr"/></span>
</div>

</body>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/iscroll.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/index.js"></script>
</html>