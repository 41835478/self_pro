<?php if(!defined('PROJECT_NAME')) die('project empty'); ?>

<script src="<?php echo TPL;?>/js/jquery.min.js" charset="utf-8"></script>
<script>
jQuery(function() {
	var checkeds = document.getElementsByClassName('checked');
	$('.all_checked_abc').click(function(){
		if($(this).is(':checked')){
			for(var x = 0 ; x < checkeds.length ; x++ ){
				checkeds[x].setAttribute('checked','checked');
			}
		}else{
			for(var x = 0 ; x < checkeds.length ; x++ ){
				checkeds[x].removeAttribute('checked');
			}
		}
	});
});
</script>