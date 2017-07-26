<script>
	var htmls = [];
	var url = $('#qySelectFirst a').each(function(){
		htmls.push($(this).attr('href'));
	});
	var uri = '/api/api.php?commend=pachong';
	var arr = [];
	for(x in htmls){
		var url = htmls[x];
		for(var i = 1 ; i < 100 ; i++ ){
			var a = url;
			var a = '<?php echo $output['uuu'];?>' + a.replace('ershoufang','ershoufang/pn' + i);
			arr.push(a);
		}
		console.log(arr);
	}
	
	var i = 1;
	setInterval(function(){
		$.post(uri,{url:arr[i]},function(state){

		},'json');
		i++;
	},10000);
</script>