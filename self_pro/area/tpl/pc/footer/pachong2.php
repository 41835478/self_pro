<script>
	var data = {};
	var d = {};
	var title = $('.title a');
	var t = [];
	var h = [];
	title.each(function(){
		t.push($(this).html());
		h.push($(this).attr('href'));
	})
	var desc = $('.list-info .baseinfo');  //说明
	var d = [];
	desc.each(function(i){
		if(i%2 == 0){
			var str = $(this).html();
			d.push($(this).html());
		}else{
			d[d.length-1] += '#' + $(this).html();
		}
		
	});
	var price = $('.sum');  //价格
	var p = [];
	price.each(function(){
		var pr = $(this).html();
		p.push(pr);
	})
	
	var unit = $('.unit');  //空间
	var u = [];
	unit.each(function(){
		var pr = $(this).html();
		u.push(pr);
	})
	data.title = t;
	data.href = h;
	data.desc = d;
	data.price = p;
	data.unit = u;
	
	$.post('/api/api.php?commend=zhengli',{data:data},function(){
		
	},'json');
</script>