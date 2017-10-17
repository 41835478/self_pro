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
    </head>
    
    <body>
        <div class="x-body">
            <form action="" method="post" class="layui-form layui-form-pane">
                <input type="hidden" name="id" value="<?php echo $output['admin']['id'];?>">
				<div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>帐号
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" readonly id="name" name="name" required="" lay-verify="required" value="<?php echo $output['admin']['username'];?>" 
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
							<?php if(isset($output['menu']) && !empty($output['menu'])){ ?>
							<?php foreach($output['menu']['top'] as $key => $val){ ?>
							 <tr>
                                <td>
                                    <?php echo $val[0];?>
                                </td>
                                <td>
                                    <div class="layui-input-block">
										<?php foreach($output['menu']['left'][$key] as $k => $v){ ?>
											<input style="display:none" <?php if(isset($output['admin']['weight'][$key.'_'.$k])){ ?>checked=""<?php } ?> name="<?php echo $key;?>_<?php echo $k;?>" type="checkbox" value="<?php echo $k;?>"> <?php echo $v[0];?>
										<?php } ?>
                                    </div>
                                </td>
                            </tr>
							<?php } ?>
							<?php } ?>
                        </tbody>
                    </table>
                </div>
				
				<!--
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea">具有至高无上的权利</textarea>
                    </div>
                </div>
				-->
                <div class="layui-form-item">
                <a class="layui-btn" lay-submit="" lay-filter="save">保存</a>
              </div>
            </form>
        </div>
        <script src="<?php echo TPL;?>/lib/layui/layui.js" charset="utf-8">
        </script>
        <script src="<?php echo TPL;?>/js/x-layui.js" charset="utf-8">
        </script>
        <script>
            layui.use(['form','layer'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;

              //监听提交
              form.on('submit(save)', function(data){
                console.log(data);
				
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
								// 获得frame索引
								window.parent.location.reload();
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
				
                //发异步，把数据提交给php
				/*
                layer.alert("增加成功", {icon: 6},function () {
					window.parent.location.reload();
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                });
                return false;
				*/
              });
            });
        </script>
    </body>
</html>