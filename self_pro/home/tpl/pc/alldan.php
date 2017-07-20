<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <title>邀请好友</title>
    <style>
        html {
            padding-bottom: 1rem;;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div class="all_1">
        <img src="<?php echo IMG;?>/al_top.png"/>
    </div>
    <div class="all_2">
        我的邀请码：<span><?php echo $output['yaoqingma'];?></span>
    </div>
    <div class="all_3">
        <div>邀请好友成功您可获得10元等值积分，并获得该好友一年内在黑眼圈消费的2%等值积分奖励。同时好友获得100元优惠券及10元等值积分奖励。</div>
    </div>
    <div class="all_4">
        <div class="all_4_1">
            <div class="all_4_1_aaa">
                <div class="all_4_1_aaa_1">累计收益</div>
                <div class="all_4_1_aaa_2">
                    <span><?php echo $output['jifen'] > 0 ? $output['jifen'] : 0;?></span>积分
                </div>
            </div>
            <div class="all_4_1_aaa">
                <div class="all_4_1_aaa_1">成功邀请</div>
                <div class="all_4_1_aaa_2">
                    <span><?php echo $output['yaoqing'] > 0 ? $output['yaoqing'] : 0;;?></span>人
                </div>
            </div>
        </div>
        <div class="all_4_2">
            <span>点击右上角分享</span>
        </div>
        <div class="all_4_3">
            扫描二维码直接邀请
        </div>
        <div class="all_4_4">
            <div><?php echo $output['img'];?></div>
        </div>
        <div class="all_4_5">
            <span>查看活动规则 ＞</span>
        </div>
    </div>
    <div class="all_5 fade" style="top: 45%;">
        <div class="all_5_1">活动规则</div>
        <div class="all_5_111"></div>
        <div class="all_5_02">
            <div class="all_5_2">
                <div>1.参与方式</div>
                <div>点击“快速分享邀请好友”，生成专属邀请链接，通过微博、微信、二维码等渠道推送分享给好友，或告诉好友您的邀请码，在注册时填写即可参与本次活动</div>
                <div>2.我怎样得到奖励？</div>
                <div>1）好友通过您分享的链接、二维码、邀请码注册成为途家新会员，则双方获得相应奖励</div>
                <div>3.双方可获得的奖励</div>
                <div>1）您每成功邀请一个新用户，可立即获得10元等值积分（1000分奖励以及被邀请人自注册日起365天内在途家实际预订房费2%的等值积分作为提成</div>
                <div>2）提成按照好友减去优惠后实际消费金额返现，返现时间为好友入住离店后</div>
                <div>3）提成仅限好友通过黑眼圈潮趴PC官网、手机官网及微信公众号下单可获得，通过其他第三方途径下单不予返现</div>
                <div>4）您邀请的好友可获得100元新用户优惠券及10元等值积分（1000分）</div>
                <div>4.奖励使用方法</div>
                <div>在黑眼圈潮啪预订房屋时，积分和礼品卡均可直接抵用房费，积分有效期1年，礼品卡有效期3个月，可在我的页面-我的途积分里查询积分及礼品卡</div>
                <div>5.说明</div>
                <div>为保证活动公平公正，黑眼圈潮趴将对作弊行为进行监测，一旦认定用户存在恶意邀请、刷单、作弊等行为，将取消相关返现</div>
                <div>在法律允许的范围内，黑眼圈潮趴将对本活动保留最终解释权</div>
            </div>
        </div>
        <div class="all_5_3">
            <div>我知道了</div>
        </div>
    </div>
    <div class="all_6 fade"></div>

<script src="<?php echo JS;?>/jquery-1.11.3.js"></script>
<script src="<?php echo JS;?>/index.js"></script>
</body>
</html>