$(function() {
	$("#searchBtn").click(function() {
		$("#searchTab").show();
		$(this).addClass("searchOpen");
	});
	$("#searchTab li").hover(function() {
		$(this).addClass("selected");
	}, function() {
		$(this).removeClass("selected");
	});
	$("#searchTab li").click(function() {
		var searchType = $(this).html();
		$("#searchBtn").html(searchType);
		$("#searchTab").hide();
		$("#searchBtn").removeClass("searchOpen");
		if(searchType == "×ÊÑ¶"){
			$("#searchTxt #type").val(10);
		}else if(searchType == "¹¥ÂÔ"){
			$("#searchTxt #type").val(11);
		}else{
			$("#searchTxt #type").val(9);
		}
	});
});