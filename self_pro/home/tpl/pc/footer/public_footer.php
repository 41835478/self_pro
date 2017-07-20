<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" ></script>
<script>
wx.config({
    //debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $output["wx_jdk"]['appId'];?>', // 必填，公众号的唯一标识
    timestamp: <?php echo $output["wx_jdk"]['timeStamp'];?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $output["wx_jdk"]['nonceStr'];?>', // 必填，生成签名的随机串
    signature: '<?php echo $output["wx_jdk"]['signature'];?>',// 必填，签名，见附录1
    jsApiList: [
				'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
				'hideMenuItems',
                'chooseImage', 'uploadImage', 'previewImage'
				] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	wx.ready(function() {
            //分享到朋友圈
            wx.onMenuShareTimeline({
                title: '<?php echo $output["wechatShare"]["title"];?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
			
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: '<?php echo $output["wechatShare"]["title"]?>',
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                type: '<?php echo $output["wechatShare"]["type"]?>',
                dataUrl: "",
                success: function () {},
                cancel: function () {}
            });
			
//            alert('<?php echo $output["wechatShare"]["title"]?>');
            //分享到QQ
            wx.onMenuShareQQ({
                title: '<?php echo $output["wechatShare"]["title"]?>',
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
            //分享到腾讯微博
            wx.onMenuShareWeibo({
                title: '<?php echo $output["wechatShare"]["title"]?>',
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
        });
</script>