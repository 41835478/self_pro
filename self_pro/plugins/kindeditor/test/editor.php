<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo DS.PLUGINS;?>/kindeditor/kindeditor-all-min.js" charset="utf-8"></script>
 <script type="text/javascript">
// 编辑器样式
	jQuery(function() {
		KindEditor.ready(function(K) {
			var editors = document.getElementsByTagName('textarea');
			/*
			if(editors != null){
				for( x in editors){
				//	console.log(editors[x]);
				}
			}
			*/
			var editor1 = K.create('.select_editor_label', {
				allowFileManager : true,
				filePostName : 'imgFile',
				cssPath : [
					'<?php echo DS.PLUGINS;?>/kindeditor/plugins/code/prettify.css'
				],
				width : '100%',
				height : '350px',
				resizeType: 1,
				pasteType : 2,
				urlType : 'absolute',
				fileManagerJson : '<?php echo DS.PLUGINS;?>/kindeditor/php/upload_json.php',
				uploadJson : '<?php echo DS.PLUGINS;?>/kindeditor/php/upload_json.php',
				
				afterBlur: function(){this.sync();}
			});
		});
	});
</script>
