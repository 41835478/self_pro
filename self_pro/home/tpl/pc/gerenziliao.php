<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">


    <link rel="stylesheet" href="<?php echo CSS;?>/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/index.css"/>
    <link rel="stylesheet" href="<?php echo CSS;?>/LCalendar.css"/>

    <link rel="stylesheet" href="<?php echo CSS;?>/gerzl.css">

    <title>个人资料</title>
    <style>
        html {
            padding-bottom: 200px;
            padding-top: 15px;
            background-color:#FAFAFA;
        }
    </style>
</head>
<body>
    <div  id="shezhitouxiang"  class="gerzl_1">
        <span  class="gerzl_1_lt">头像</span>
        <span class="gerzl_1_rt" style="display:block;height:100%;" style="background:url('<?php echo $output['user']['user_logo'];?>');" ></span>
    </div>
    <div class="gerzl_1 gerzl_2">
        <span class="gerzl_1_lt">昵称</span>
        <span class="gerzl_2_rt">
            <input class="gerzl_2_rt_inptxt nickname" type="text" placeholder="请填写" value="<?php echo $output['user']['nickname'];?>"/>
        </span>
    </div>
    <div class="gerzl_1 gerzl_2">
        <span class="gerzl_1_lt">生日</span>


        <div class="asddsa main_page">

            <div class="select_start_date">
                <div class="start_date_right">
                    <input class="asd111" type="text" name="start_date" id="start_date" placeholder="选择开始日期" readonly="readonly" value="<?php echo $output['user']['birthday'];?>" />
                </div>
            </div>
        </div>


    </div>
    <div class="gerzl_1 gerzl_2">
        <span class="gerzl_1_lt">性别</span>
        <span class="gerzl_2_rt">
            <input id="xb_nan" class="gerzl_2_rt_inpckbx" <?php if($output['user']['user_sex'] == 1){ ?>checked="checked"<?php }?> type="radio" name="xingb" value="1"/>
            <label for="xb_nan">男</label>
            <input id="xb_nv" class="gerzl_2_rt_inpckbx" <?php if($output['user']['user_sex'] == 2){ ?>checked="checked"<?php }?>  type="radio" name="xingb" value="2"/>
            <label for="xb_nv">女</label>
        </span>
    </div>
    <div class="gerzl_1 gerzl_2">
        <span class="gerzl_1_lt">联系电话</span>
        <span class="gerzl_2_rt">
            <input class="gerzl_2_rt_inpnb phone" type="number" placeholder="请填写" value="<?php echo $output['user']['phone'];?>"/>
        </span>
    </div>
    <div class="gerzl_1 gerzl_2">
        <span class="gerzl_1_lt">所在城市</span>
        <span class="gerzl_2_rt">
            <input class="gerzl_2_rt_inptxt area" type="text" id='city-picker'  placeholder="北京-东城区" value="<?php echo $output['user']['area'];?>" />
        </span>
    </div>
<div id="uploader" class="wu-example" style="display:none">
	<!--用来存放文件信息-->
	<div id="thelist" class="uploader-list"></div>
	<div class="btns">
		<button id="ctlBtn" class="btn btn-default">开始上传</button>
	</div>
</div>
<div style="height:2rem;width:100%;background:#00C800;color:#fff;text-align:center;font-weight: bold;line-height:2rem;position:fixed;bottom:0px;" onclick="submit_gerenziliao()">保存
</div>
    <script type='text/javascript' src='<?php echo JS;?>/gerzl_1.js' charset='utf-8'></script>
    <script type='text/javascript' src='<?php echo JS;?>/gerzl_2.js' charset='utf-8'></script>
    <script type="text/javascript" src="<?php echo JS;?>/gerzl_3.js" charset="utf-8"></script>


<script src="<?php echo JS;?>/LCalendar.js" type="text/javascript"></script>
<script src="<?php echo JS;?>/index.js"></script>
<script>
<?php if(!empty( $output['user']['user_logo'])){ ?>
$('.gerzl_1_rt').css('background','url("<?php echo $output['user']['user_logo'];?>") no-repeat center');
$('.gerzl_1_rt').css('max-height','1.6rem');
$('.gerzl_1_rt').css('marginTop','0.6rem');
$('.gerzl_1_rt').css('backgroundSize','40px 40px');	
<?php } ?>

function submit_gerenziliao(){
	var data = {};
	//data.user_logo = img[0];
	if(typeof($('.gerzl_1_rt').attr('images')) != 'undefined'){
		data.user_logo = $('.gerzl_1_rt').attr('images');
	}
	data.nickname = $('.nickname').val();
	data.birthday = $('.asd111').val();
	data.area = $('.area').val();
	data.phone = $('.phone').val();
	if(!(/^1[34578]\d{9}$/.test(data.phone))){
		alert('手机号有误，请重填');
		return false;
	}
	var user_id = "<?php echo $output['user']['user_id'];?>";
	data.user_sex = $("input[type='radio']:checked").val();
	var url = '/api/api.php?commend=gerenziliao';
	$.post(url,{user_id:user_id,data:data},function(state){
		if(state.msg.code = '1'){
			alert(state.msg.msg);
			window.location.href = "?act=user&op=person_info";
		}else{
			alert(state.msg.msg);
		}
	},'json');
}
	        $("#city-picker").cityPicker({
            toolbarTemplate: '<header class="bar bar-nav">\
			<button class="button button-link pull-right close-picker">确定</button>\
			<h1 class="title">选择收货地址</h1>\
			</header>'
        });
</script>
<script src="<?php echo JS;?>/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo JS;?>/webuploader.js" ></script>

<script>

var img = [];
jQuery(function() {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('#ctlBtn'),
        state = 'pending',
        uploader;
		var BASE_URL = './';
		var upload_url = '?act=upload&op=web_upload';
		//上传
		var uploader = WebUploader.create({

			// swf文件路径
			swf: BASE_URL + '/js/Uploader.swf',

			// 文件接收服务端。
			server: upload_url,

			// 选择文件的按钮。可选。
			// 内部根据当前运行是创建，可能是input元素，也可能是flash.
			pick: '#shezhitouxiang',
			
			auto:true,
			/*
			accept: {
				title: 'Images',
				extensions: 'gif,jpg,jpeg,bmp,png,JPG',
				mimeTypes: 'image/*'
			},
			*/
			chunkRetry : 3,
			
			method :'POST',
			
			multiple:'multiple',
			
		//	capture : 'cmaera',

			// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
			resize: false
		});
		// 当有文件被添加进队列的时候
		uploader.on( 'fileQueued', function( file ) {
			$list.append( '<div id="' + file.id + '" class="item">' +
				'<h4 class="info">' + file.name + '</h4>' +
				'<p class="state">等待上传...</p>' +
			'</div>' );
		});

		// 文件上传过程中创建进度条实时显示。
		uploader.on( 'uploadProgress', function( file, percentage ) {
			var $li = $( '#'+file.id ),
				$percent = $li.find('.progress .progress-bar');

			// 避免重复创建
			if ( !$percent.length ) {
				$percent = $('<div class="progress progress-striped active">' +
				  '<div class="progress-bar" role="progressbar" style="width: 0%">' +
				  '</div>' +
				'</div>').appendTo( $li ).find('.progress-bar');
			}

			$li.find('p.state').text('上传中');

			$percent.css( 'width', percentage * 100 + '%' );
		});
		
		uploader.on( 'uploadSuccess', function( file , res ) {
			img.unshift(res.path);
			$('.gerzl_1_rt').css('background','url("'+res.path+'") no-repeat center');
			$('.gerzl_1_rt').css('max-height','1.6rem');
			$('.gerzl_1_rt').css('marginTop','0.6rem');
			$('.gerzl_1_rt').css('backgroundSize','40px 40px');
			$('.gerzl_1_rt').attr('images',res.path);

		//	console.log(img);
			$( '#'+file.id ).find('p.state').text('已上传');
			$( '#'+file.id ).find('p.state').text(res.path);
		});

		uploader.on( 'uploadError', function( file ) {
			$( '#'+file.id ).find('p.state').text('上传出错');
		});

		uploader.on( 'uploadComplete', function( file ) {
			if(img[0]){
				$('.limg1').css('background','url("'+ img[0] +'") no-repeat ');
				$('.limg1').css('backgroundSize','cover');
			}
			if(img[1]){
				$('.limg2').css('background','url("'+ img[1] +'") no-repeat ');
				$('.limg2').css('backgroundSize','cover');
			}
			if(img[2]){
				$('.limg3').css('background','url("'+ img[2] +'") no-repeat ');
				$('.limg3').css('backgroundSize','cover');
			}
			$( '#'+file.id ).find('.progress').fadeOut();
		});
});
</script>

<script type="text/javascript">




        var calendar = new LCalendar();
        calendar.init({
            'trigger': '#start_date', //标签id
            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
            'minDate': (new Date().getFullYear()-100) + '-' + 1 + '-' + 1, //最小日期
            'maxDate': (new Date().getFullYear()+0) + '-' + 12 + '-' + 31,//最大日期//最大日期
			'data-lcalendar':'2007-01-01'
        });
      
</script>


</body>
</html>
<style>
.webuploader-pick{
	height:100%;
}
.gerzl_1_rt{
	border-radius:50%;
}
#shezhitouxiang input{
	display:none;
}
</style>