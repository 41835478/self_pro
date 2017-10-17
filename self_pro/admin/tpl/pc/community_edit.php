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
		<!-- 谷歌配置 -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
		<link rel="stylesheet" href="https://cache.amap.com/lbs/static/main.css"/>
		<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=<?php echo SYS('map_key')?>"></script>
		<script src="//webapi.amap.com/ui/1.0/main.js?v=1.0.10"></script>
		
    </head>
    <body>
		 <!--
        <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>会员管理</cite></a>
              <a><cite>编辑</cite></a>
            </span>
			<a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
		</div>
		-->
        <div class="x-body">
			<form class="layui-form layui-form-pane" <?php echo isset($output['form_url']) ? $output['form_url'] :'';?> <?php echo isset($output['method']) ? $output['method'] :'';?> >
				<table class="layui-table">
					<tr>
						<td>地图</td>
						<td>
							<div id="outer-box">
								<div id="panel" class="scrollbar1">
									<div id="searchBar">
										<input id="searchInput" placeholder="请输入您要添加的社区名称并点选确认" />
									</div>
									<div id="searchResults"></div>
								</div>
								<div id="container" class="map" tabindex="0"></div>
								
							</div>
						</td>
					</tr>
					<?php echo $output['form'];?>
				</table>
				<div class="layui-form-item">
					<a class="layui-btn" lay-filter="add" lay-submit>
						提交
					</a>
				</div>
			</form>
        </div>
        <script src="<?php echo TPL;?>/lib/layui/layui.js" charset="utf-8"></script>
        <script src="<?php echo TPL;?>/js/x-layui.js" charset="utf-8"></script>
        <script>
			
            layui.use(['laydate','element','laypage','layer','form'], function(){
                $ = layui.jquery;//jquery
              laydate = layui.laydate;//日期插件
			  var form = layui.form();
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
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
			  //监听提交
				form.on('submit(add)', function(data){
					var url = data.form.action;
					var type = data.form.method;
					$.ajax({
						url:url,
						type:type,
						data:data.field,
						async:false, //同步
						success:function(res){
							if(res.code == '1'){
								layer.alert(res.msg, {icon: 6 },function () {
									window.parent.location.reload();
									// 获得frame索引
									var index = parent.layer.getFrameIndex(window.name);
									//关闭当前frame
									parent.layer.close(index);
									
								});
							}else{
								layer.msg(res.msg,{icon:1,time:1500});
							}
						},
						dataType:'json'
					});
					return false;
				}); 
			});
            </script>
    </body>
</html>
<style>
.input-label{
	border:0px;
}
.layui-input-inline{
	min-width:300px;
}
#mapContainer{
	width:851px;
	height:600px;
	position:inherit;
}
#container{
	width:800px;
	height:600px;
	position:inherit;
	left:301px;
}
 #tip {
	background-color: #ddf;
	color: #333;
	border: 1px solid silver;
	box-shadow: 3px 4px 3px 0px silver;
	top: 217px;
	left: 131px;
	width: 285px;
	border-radius: 5px;
	overflow: hidden;
	line-height: 20px;
}
#tip input[type="text"] {
	height: 25px;
	border: 0;
	padding-left: 5px;
	width: 280px;
	border-radius: 3px;
	outline: none;
}

#outer-box {
	height: 100%;
/*	padding-right: 300px; */
	position: relative;
	width:1100px;
	padding:0px;
	margin:0px;
}


#panel {
	position: absolute;
	top: 0;
	bottom: 0;
/*     right: 0; */
	height: 100%;
	overflow: auto;
	width: 300px;
	z-index: 999;
	border-left: 1px solid #eaeaea;
	background: #fff;
}

#searchBar {
	height: 30px;
	background: #ccc;
}

#searchInput {
	width: 100%;
	height: 30px;
	line-height: 30%;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	border: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	padding: 0 5px;
}

#searchResults {
	overflow: auto;
	height: calc(100% - 30px);
}

.amap_lib_placeSearch,
.amap-ui-poi-picker-sugg-container {
	border: none!important;
}

.amap_lib_placeSearch .poibox.highlight {
	background-color: #CAE1FF;
}

.poi-more {
	display: none!important;
}
</style>


<script type="text/javascript">
    var map = new AMap.Map('container', {
        zoom: 10
    });

    AMapUI.loadUI(['misc/PoiPicker'], function(PoiPicker) {

        var poiPicker = new PoiPicker({
            input: 'searchInput',
            placeSearchOptions: {
                map: map,
                pageSize: 10
            },
            searchResultsContainer: 'searchResults'
        });

        poiPicker.on('poiPicked', function(poiResult) {

            poiPicker.hideSearchResults();

            var source = poiResult.source,
                poi = poiResult.item;

            if (source !== 'search') {

                //suggest来源的，同样调用搜索
                poiPicker.searchByKeyword(poi.name);

            } else {
				console.log(poi);
				$("input[name='name']").val(poi.name);
				$("input[name='pname']").val(poi.pname);
				$("input[name='type']").val(poi.type);
				$("input[name='posx']").val(poi.location.lng);
				$("input[name='posy']").val(poi.location.lat);
				$("input[name='gu_id']").val(poi.id);
				$("input[name='adcode']").val(poi.adcode);
				$("input[name='address']").val(poi.address);
				$("input[name='adname']").val(poi.adname);
				$("input[name='cityname']").val(poi.cityname);
				$("input[name='citycode']").val(poi.citycode);
				if(poi.photos != ''){
					$("input[name='image']").val(poi.photos[0].url);
				}
            }
        });

        poiPicker.onCityReady(function() {
            poiPicker.searchByKeyword('<?php echo isset($output['data']['name']) ? $output['data']['name'] : "" ;?>');
        });
    });
	
</script>
<script type="text/javascript" src="https://webapi.amap.com/demos/js/liteToolbar.js"></script>
