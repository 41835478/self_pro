
(function(){
	/* 
		轮播插件
	*/
	var adv_url = '/api/api.php?commend=adv_list';
	var adv = document.getElementsByClassName('adv');
	var adv_show  = document.getElementsByClassName('adv_show');
	var adv_icon  = document.getElementsByClassName('adv_icon');
	var adv_left  = document.getElementsByClassName('adv_left');
	var adv_right = document.getElementsByClassName('adv_right');
	var is_show_bottom_move = 'center';  //left,right,default
	var is_show_bottom_moves = [];  	 //left,right,default
	var adv_mode = 'right';  	//left,right,default
	var adv_modes = [];  		//left,right,default
	var auto_flag = [];
	var click_flag = [];
	
	var adv_icon_width 			= '30px';  	//小图标宽度
	var adv_default_width 		= '500px';	//轮播图默认宽度
	var adv_default_height 		= '400px';	//轮播图默认高度
	var left_and_right_is_show 	= true;		//是否显示左边和右边的按钮
	var adv_is_show_num 		= true;		//是否显示下边底部的数字
	var adv_is_show_bottom 		= true;		//是否显示底部图标
	var post_data = null;		//获取数据
	var adv_config = [];    	//轮播配置
	var stop_time = 3300;		//间隔时间
	
	var turns_sleep = 14;  //9  移动速度
	var turns_time  = 10;  //15 移动定时器 
	var adv_images  = [];	
	var ml = [];
	var adv_state   = [];
	
	var conf = [];
	
	var adv_conf = function(id,config){
		if(typeof(config) == 'undefined'){
			adv_config.icon_width 			= adv_icon_width;
			adv_config.adv_width 			= adv_default_width;
			adv_config.adv_height 			= adv_default_height;
			adv_config.left_and_right_id_show = left_and_right_is_show;
			adv_config.is_show_bottom 		= adv_is_show_bottom;
			adv_config.is_show_number 		= adv_is_show_num;
			adv_config.adv_url 				= adv_url;
			adv_config.adv_mode 			= adv_mode;
			adv_config.is_show_bottom_move 	= is_show_bottom_move;
			
			return adv_config;
		}
		
		if(typeof(config.adv_width) != 'undefined'){
			adv_config.adv_width = config.adv_width;
		}
		//图标宽度
		if(typeof(config.icon_width) != 'undefined'){
			adv_config.icon_width = config.icon_width;
		}
		//轮播高度
		if(typeof(config.adv_height) != 'undefined'){
			adv_config.adv_height = config.adv_height;
		}
		//左右两边按钮是否显示
		if(typeof(config.left_and_right) != 'undefined'){
			adv_config.left_and_right_id_show = config.left_and_right  == true ? true : false ;
		}
		//是否显示底部图标
		if(typeof(config.is_show_bottom) != 'undefined'){
			adv_config.is_show_bottom = config.is_show_bottom == true ? true : false ;
		}
		//底部是否显示数字
		if(typeof(config.is_show_num) != 'undefined'){
			adv_config.is_show_number = config.is_show_num  == true ? true : false ;
		}
		//底部是否显示数字
		if(typeof(config.adv_url) != 'undefined'){
			adv_config.adv_url = config.adv_url ;
		}
		if(typeof(config.adv_mode) != 'undefined'){
			adv_config.adv_mode = config.adv_mode ;
		}
		if(typeof(config.adv_mode) != 'undefined'){
			adv_config.is_show_bottom_move = config.is_show_bottom_move ;
		}
	}
	
	adv_init = function(){
		adv_conf();
	}
	//配置初始化
	adv_init();
	
	//广告设置
	var adv_selected = function(i,conf){
		if(post_data != null && typeof(post_data.type) != 'undefined'){
			//轮播图
			var html = '';
			if(post_data.type == 'take_turns'){
				var is_L_AND_R_show = '';
				if(post_data.is_L_AND_R == false){
					is_L_AND_R_show = 'display:none;';
				}
				html += '<div style="'+ is_L_AND_R_show +'" class="adv_left">左边</div>';
				html += '<div style="'+ is_L_AND_R_show +'" class="adv_right">右边</div>';
				var width = parseInt(post_data.width);
				var height = parseInt(post_data.height);
				
				if(width > 0){
					adv_config.adv_width = width;
					adv[i].style.width = width + 'px';
				}
				if(height > 0){
					adv_config.adv_height = height;
					adv[i].style.height = height + 'px';
				}
				var is_show_bottom_show = '';
				if(post_data.is_show_bottom == false){
					is_show_bottom_show = 'display:none;';
				}
				
				is_show_bottom_moves[i] = '';
				if(typeof(post_data.is_show_bottom_move) != 'undefined'){
					adv_config.is_show_bottom_move = post_data.is_show_bottom_move;
					is_show_bottom_moves[i] = post_data.is_show_bottom_move;
				}
				html += '<div style="'+ is_show_bottom_show +'" class="adv_icon adv_icon_' + is_show_bottom_moves[i] + ' ' + i +'" >';
				
				for(var j = 0 ; j < post_data.images.length ; j++){
					var str = '';
					if(post_data.is_show_num == true){
						str = j+1;
					}
					var class_str = '';
					if(j == 0){
						class_str = 'adv_icons adv_icons_selected';
					}else{
						class_str = 'adv_icons';
					}
					html += '<div class="' + class_str + '" >'+ str +'</div>';
				}
				html += '</div>';
				
				html += '<div class="adv_images">';
				for(var j = 0 ; j < post_data.images.length ; j++){
					
					html += '<a data="'+ j +'" href="'+ post_data.urls[j] +'"><img style="width:' + adv_config.adv_width + 'px;height:'+ adv_config.adv_height + 'px" src="'+ post_data.images[j] +'"></a>';
					
				}
				html += '</div>';
				
				adv[i].innerHTML = html;
			}
			menu_inits++;
			if(typeof(post_data.adv_mode) != 'undefined' && post_data.adv_mode != ''){
				adv_config.adv_mode = post_data.adv_mode;
			}
			adv_modes[i] = adv_config.adv_mode;
			
			turns(i,adv_modes[i]);
			
			//图片取出完毕
			if(menu_inits == adv_len){
				adv_icon_position();
				adv_left  = document.getElementsByClassName('adv_left');
				adv_right = document.getElementsByClassName('adv_right');
				menus_init();
			}
		}
	}
	
	//底部按钮配置
	function adv_icon_position(){
		var adv_icon_center = document.getElementsByClassName('adv_icon_center');
		if(typeof(adv_icon_center) != 'undefined'){
			var center_len = adv_icon_center.length;
			for(var i = 0 ; i < center_len; i++){
				var width = parseInt(adv_icon_center[i].childNodes[0].style.width);
				if(isNaN(width)){
					width = parseInt(adv_icon_width);
				}
				var len = adv_icon_center[i].childNodes.length;
				var adv_width = parseInt(adv_icon_center[i].parentNode.style.width);
				var max_width = width * len;
				var pos = (adv_width - max_width)/2;
				adv_icon_center[i].style.marginLeft = pos + 'px';
			}
		}
		
		var adv_icon_right = document.getElementsByClassName('adv_icon_right');
		if(typeof(adv_icon_right) != 'undefined'){
			var center_len = adv_icon_right.length;
			for(var i = 0 ; i < center_len; i++){
				var width = parseInt(adv_icon_right[i].childNodes[0].style.width);
				if(isNaN(width)){
					width = parseInt(adv_icon_width);
				}
				var len = adv_icon_right[i].childNodes.length;
				var adv_width = parseInt(adv_icon_right[i].parentNode.style.width);
				var max_width = width * len;
				var pos = (adv_width - max_width);
				adv_icon_right[i].style.marginLeft = pos + 'px';
			}
		}
	}
	
	//轮播
	function turns(i,mode){
		auto_flag[i] = false;
		setTimeout(function(){
			auto_flag[i] = true;
			click_flag[i] = true;
		},2000);
		setInterval(function(){
			auto_flag[i] = true;
		},9000);
		adv_modes[i] = mode;
		var adv_len = adv[i].childNodes.length;
		for(var j = 0 ; j < adv_len ; j ++){
			if(adv[i].childNodes[j].className == 'adv_images'){
				adv[i].childNodes[j].style.width = parseInt(adv[i].style.width) * adv_len + 'px';
				adv[i].childNodes[j].style.height = parseInt(adv[i].style.height) + 'px';
				adv_images[i] = adv[i].childNodes[j];
			}
		}	 //parseInt(adv[i].style.width)
		ml[i] = parseInt(adv_images[i].firstChild.style.marginLeft);
		if(isNaN(ml[i])){
			ml[i] = '';
		}
		adv_state[i] = true;
		setInterval(function(){
			if(auto_flag[i]){
				if(click_flag[i]){
					switch(adv_modes[i]){
						case 'right' :
							if(ml[i] == ''){
								ml[i] = (0 - parseInt(adv[i].style.width));
								adv_images[i].insertBefore(adv_images[i].lastChild,adv_images[i].firstChild);
								adv_images[i].firstChild.style.marginLeft = (0 - parseInt(adv[i].style.width)) + 'px';
								ml[i] += turns_sleep;
							}else{
								if(adv_state[i]){
									ml[i] += turns_sleep;
									if(ml[i] == 0){
										ml[i] = 1;
									}
								}
							}
							break;
						case 'left':
							if(ml[i] == ''){
								ml[i] = 0;
								ml[i] -= turns_sleep;
							}else{
								if(adv_state[i]){
									ml[i] -= turns_sleep;
									if(ml[i] == 0){
										ml[i] = 1;
									}
								}
							}
							break;
						default :
							if(ml[i] == ''){
								ml[i] = true ;
								setTimeout(function(){
									adv_images[i].appendChild(adv_images[i].firstChild);
									var x = adv_images[i].firstChild.nextSibling.getAttribute('data');
									for(var z = 0 ; z <  adv_icon[i].childNodes.length ; z++){
										adv_icon[i].childNodes[z].setAttribute('class','adv_icons');
									}
									adv_icon[i].childNodes[x].setAttribute('class','adv_icons adv_icons_selected');
									ml[i] = '' ;
								},stop_time);
							}
							return ;
							break;
					}
					ml[i] = parseInt(ml[i]);
					if(( ml[i] < 0 && adv_modes[i] == 'right' )
						|| (ml[i] < 0 && ml[i] > -parseInt(adv[i].style.width)-10 && adv_modes[i] == 'left')
					){
						adv_images[i].firstChild.style.marginLeft = ml[i] ==1 ? (ml[i]-1) : ml[i] + 'px';
					}
					
					if(( ml[i] >= 0 && adv_modes[i] == 'right' && adv_state[i] == true )
						|| (ml[i] < 0 && ml[i] <= -parseInt(adv[i].style.width)-10 && adv_state[i] == true )
					){
						if( adv_modes[i] == 'right' ){
							adv_images[i].firstChild.style.marginLeft = '0px';
						}
						adv_state[i] = false;
						x = adv_images[i].firstChild.nextSibling.getAttribute('data');
						for(var z = 0 ; z <  adv_icon[i].childNodes.length ; z++){
							adv_icon[i].childNodes[z].setAttribute('class','adv_icons');
						}
						adv_icon[i].childNodes[x].setAttribute('class','adv_icons adv_icons_selected');
						if(adv_modes[i] == 'left'){
							adv_images[i].appendChild(adv_images[i].firstChild);
							adv_images[i].lastChild.style.marginLeft = '0px';
						}
						setTimeout(function(){
							if( adv_modes[i] == 'left' ){
								
								adv_images[i].lastChild.style.marginLeft = '0px';
								ml[i] = 0;
							}
							if( adv_modes[i] == 'right' ){
								adv_images[i].insertBefore(adv_images[i].lastChild,adv_images[i].firstChild);
								adv_images[i].firstChild.style.marginLeft = (0 - parseInt(adv[i].style.width)) + 'px';
								adv_images[i].firstChild.nextSibling.style.marginLeft = '0px';
								x = adv_images[i].firstChild.nextSibling.getAttribute('data');
								ml[i] = (0 - parseInt(adv[i].style.width));
							}
							adv_state[i] = true;
						},stop_time);
					}
				}
			}
		},turns_time);
	}
	var timer_num = -1;
	var jilu_time = [];
	function  menus_init(){
		var l_len = adv_left.length;
		for(var i = 0 ; i < l_len ; i ++){
			
			//密闭水槽
			(function(i){
				adv_left[i].onclick = function(){
					if(adv_modes[i] == 'left' || adv_modes[i] == 'right'){
						auto_flag[i] = false;
						click_flag[i] = false;
						var tt = new Date();
						jilu_time[i] = tt.getTime()/1000;
						adv_images[i].firstChild.style.marginLeft = '0px';
						var m = 0;
						var left_t = setInterval(function(){
							m -= turns_sleep;
							adv_images[i].firstChild.style.marginLeft = m + 'px';
							adv_images[i].lastChild.style.marginLeft = '0px';
							if(m < (0-(parseInt(adv_images[i].parentNode.style.width)))){
								adv_images[i].appendChild(adv_images[i].firstChild);
								adv_images[i].lastChild.style.marginLeft = '0px';
								clearInterval(left_t);
								var x = adv_images[i].firstChild.nextSibling.getAttribute('data');
								if(adv_modes[i] == 'right'){
									adv_images[i].firstChild.style.marginLeft = '-'+ parseInt(adv_images[i].parentNode.style.width) +'px';
									x = adv_images[i].firstChild.nextSibling.getAttribute('data');
								}
								for(var z = 0 ; z <  adv_icon[i].childNodes.length ; z++){
									adv_icon[i].childNodes[z].setAttribute('class','adv_icons');
								}
							}
						},turns_time);
						setTimeout(function(){
							var t2 = new Date();
							if((t2.getTime()/1000 - jilu_time[i]) > 5){
								click_flag[i] = true;
							}
						},6000);
					}else{
						adv_images[i].insertBefore(adv_images[i].lastChild,adv_images[i].firstChild);
						adv_images[i].firstChild.nextSibling.style.marginLeft = '0px';
						
						
					}
					adv_icon[i].childNodes[x].setAttribute('class','adv_icons adv_icons_selected');
				}
			})(i);
		}
		
		var r_len = adv_right.length;
		for(var i = 0 ; i < r_len ; i ++){
			(function(i){
				adv_right[i].onclick = function(){
					if(adv_modes[i] == 'left' || adv_modes[i] == 'right'){
						auto_flag[i] = false;
						var tt = new Date();
						jilu_time[i] = tt.getTime()/1000;
						adv_images[i].lastChild.style.marginLeft = -parseInt(adv_images[i].parentNode.style.width) + 'px';
						adv_images[i].insertBefore(adv_images[i].lastChild,adv_images[i].firstChild);
						var m = 0 - parseInt(adv_images[i].parentNode.style.width);
						
						var right_t = setInterval(function(){
							m += turns_sleep;
							adv_images[i].firstChild.style.marginLeft = m + 'px';
							adv_images[i].lastChild.style.marginLeft = '0px';
							if(m > 0){
								adv_images[i].firstChild.style.marginLeft = '0px';
								adv_images[i].lastChild.style.marginLeft = '0px';
								adv_images[i].firstChild.nextSibling.style.marginLeft = '0px';
								clearInterval(right_t);
								var x = adv_images[i].firstChild.getAttribute('data');
								for(var z = 0 ; z <  adv_icon[i].childNodes.length ; z++){
									adv_icon[i].childNodes[z].setAttribute('class','adv_icons');
								}
								adv_icon[i].childNodes[x].setAttribute('class','adv_icons adv_icons_selected');
							}
						},turns_time);
						setTimeout(function(){
							var t2 = new Date();
							if((t2.getTime()/1000 - jilu_time[i]) > 5){
								click_flag[i] = true;
							}
						},6000);
					}else{
						auto_flag[i] = false;
						adv_images[i].appendChild(adv_images[i].firstChild);
						adv_images[i].firstChild.style.marginLeft = '0px';
						
					}
				}
			})(i);
		}
		
		var icon_len = adv_icon.length;
		for(var i = 0 ; i < r_len ; i ++){
			if(typeof(adv_icon[i]) != 'undefined'){
				var child_len = adv_icon[i].childNodes.length;
				for(var j = 0 ; j < child_len; j++){
					(function(j,i){
						adv_icon[i].childNodes[j].onclick = function(){ //移动
							
							for(var z = 0 ; z <  adv_icon[i].childNodes.length ; z++){
								adv_icon[i].childNodes[z].setAttribute('class','adv_icons');
							}
							adv_icon[i].childNodes[j].setAttribute('class','adv_icons adv_icons_selected');
							
							var data = adv_icon[i].nextSibling.childNodes;
							var len = data.length;
							var num = adv_icon[i].nextSibling.firstChild.getAttribute('data');
							for(var k = 0 ; k < len ; k++){
								data[k].style.marginLeft = '0px';
							}
							while(num != j){
								adv_icon[i].nextSibling.appendChild(adv_icon[i].nextSibling.firstChild);
								num = adv_icon[i].nextSibling.firstChild.getAttribute('data');
							}
							if(adv_modes[i] == 'right'){
							//	adv_icon[i].nextSibling.insertBefore(adv_icon[i].nextSibling.lastChild,adv_icon[i].nextSibling.firstChild);
								data[0].style.marginLeft = '-' + adv_icon[i].parentNode.style.width;
							}
							adv_icon[i].nextSibling.firstChild.style.marginLeft = '0px';
						}
					})(j,i);
				}
			}
		}
	}
	
	/*
		id是轮播图id
		i是数组下标
		c是配置 config
	*/
	function ajax_post(id,i,c){
		var xmlhttp;
		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("POST",adv_config.adv_url,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("adv_id="+ id +"&id=" + id);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				post_data = JSON.parse(xmlhttp.responseText);
				adv_selected(i,c);
			}
		}
	}
	var adv_len = adv.length;
	var menu_inits = 0;
	var adv_id = 0;
	for(var i = 0 ; i < adv_len; i++){
		adv_id = adv[i].id;
		var c = adv_conf(adv_id,conf);
		ajax_post(adv_id,i,c);
		
	}
})();