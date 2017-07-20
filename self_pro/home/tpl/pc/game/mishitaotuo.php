<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=480,user-scalable=no,uc-user-scalable=no,target-densitydpi=high-dpi"/>
<script>
function play68_init() {
	//updateShare(0);
}
function goHome() {
	window.location.href = "?act=game&op=rank";
}
function play68_submitScore(score) {
//	updateShareScore(score);
	setTimeout( function() { show_share(); }, 500 );
}

function updateShare(bestScore) {
	imgUrl = './1.jpg';
	lineLink = 'http://game2.id87.com/mishi/';
	descContent = "你觉得你反应很快吗？试试就知道！";
	updateShareScore(bestScore);
	appid = '';
}

function updateShareScore(bestScore) {
	if(bestScore > 0) {
		shareTitle = "考反应游戏《密室逃脱》我过了" + bestScore + "关，实在是太变态了！";
	}
	else{
		shareTitle = "变态考反应游戏《密室逃脱》能通关你就能闪子弹了！";
	}
}
</script>
<script type="text/javascript" src="/home/tpl/pc/game/jsgamemin.js"></script>
<!--
<script type="text/javascript" src="/home/tpl/pc/game/spaceman.min.js"></script>
-->
<title>黑眼圈潮趴馆</title>
<link rel="shortcut icon" href="http://www.52h5game.com/images/icon.png">
<style>
body{margin:0px; background-color:black; color:#6A6A6A;}
	.bandiv{float:left; width:100%; background-color:#DBD1BB;}
	.bandiv div{padding:10px; text-align:left;}
	body{
	oncontextmenu: return false;
	onselectstart: return false;
}

#play68box{
	width: 190px;
	font-size: 12px;
	line-height: 15px;
	right: -172px;
	top: 35%; 
	position: fixed;
	z-index: 100;
}

#tab{
	float: left;
	list-style: none outside none;
	padding: 0;
	position: relative;
	z-index: 99;
	margin-top: 10px;
	margin-right: 0;
	margin-bottom: 0;
	margin-left: 0;
}

#tab li span{
    display: block;
    padding: 0 5px;
    position: relative;
}

#links{
	width: 100px;
	padding: 1px;
	float: left;
	background-color: #f6bb42;
	border-radius: 8px;
}

.show, .hide{
            transition: margin-right .4s ease-in;
    -webkit-transition: margin-right .4s ease-in;
}

.hide{
    margin-right:0px;
}

.show{
    margin-right:95px;
}

#arrow, .bt{
    cursor: pointer;
}

.bt{
	width: 95px;
	height: 41px;
	margin: 2px;
	text-align:center;
    font: bold 15px Arial, Helvetica, "Microsoft Yahei", "微软雅黑", STXihei, "华文细黑", sans-serif;
	background-color: #da4453;
	border-radius: 6px;
}

.bt a{
    line-height: 40px;
    color: #fff;
    display: block;
	text-decoration:none;
}

.bt:hover{
    transition: background .3s linear         -o-transition: background .3s linear;
       -moz-transition: background .3s linear;
    -webkit-transition: background .3s linear;
	background-color: #37bc9b;
}

#deco{
	width: 90px;
	float: left;    
}

#share-wx{
	background:rgba(0,0,0,0.8);
	position:absolute;top:0px;
	left:0px;
	width:100%;
	height:100%;
	z-index:10000;
	display:none;
}

#wx-qr{
	background:rgba(0,0,0,0.8);
	position:absolute;top:0px;
	left:0px;
	width:100%;
	height:100%;
	z-index:10000;
	display:none;
}
</style>
<script>
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	WeixinJSBridge.call('showOptionMenu');
});
//new Image().src = 'http://game2.id87.com/';
</script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=34915524" charset="UTF-8"></script>
</head>
<body onLoad="main()" id="0">
<div style="text-align:center;">
<canvas id="jsGameScreen"></canvas> 
</div>
<audio controls="controls" id="music" loop="loop" style="display:none">
	<source src="/home/tpl/pc/game/2.mp3"/>
</audio>
<audio controls="controls" muted='muted' id="music2" style="display:none">
	<source src="/home/tpl/pc/game/1.mp3"/>
</audio>
<script type="text/javascript">
//var mebtnopenurl = 'http://game2.id87.com/';
function shareFriend() {
	WeixinJSBridge.invoke("sendAppMessage", {
		appid: appid,
		img_url: imgUrl,
		img_width: "200",
		img_height: "200",
		link: lineLink,
		desc: descContent,
		title: shareTitle
	},
	function(e) {
		document.location.href = mebtnopenurl;
		
	})
}
function shareTimeline() {
	WeixinJSBridge.invoke("shareTimeline", {
		img_url: imgUrl,
		img_width: "200",
		img_height: "200",
		link: lineLink,
		desc: descContent,
		title: shareTitle
	},
	function(e) {
		document.location.href = mebtnopenurl;
	})
}
function shareWeibo() {
	WeixinJSBridge.invoke("shareWeibo", {
		img_url: imgUrl,
		content: shareTitle + " " + descContent,
		url: lineLink
	},
	function(e) {
		document.location.href = mebtnopenurl;
	})
}
function isWeixin() {
	var e = navigator.userAgent.toLowerCase();
	if (e.match(/MicroMessenger/i) == "micromessenger") {
		return true
	} else {
		return false
	}
}
function toggle(e) {
	var t = document.getElementById(e);
	var n = document.getElementById("arrow");
	var r = t.getAttribute("class");
	if (r == "hide") {
		t.setAttribute("class", "show");
		delay(n, RESOURCE_IMG_PATH + "arrowright.png", 400)
	} else {
		t.setAttribute("class", "hide");
		delay(n, RESOURCE_IMG_PATH + "arrowleft.png", 400)
	}
}
function delay(e, t, n) {
	window.setTimeout(function() {
		e.setAttribute("src", t)
	},
	n)
}
function show_share() {

		document.getElementById("share-wx").style.display = "block"
	
}
function closeshare() {
	document.getElementById("share-wx").style.display = "none"
}
function closewx() {
	document.getElementById("wx-qr").style.display = "none"
}
function addShareWX() {
	var e = document.createElement("div");
	e.id = "share-wx";
	e.onclick = closeshare;
	document.body.appendChild(e);
	var t = document.createElement("p");
	t.style.cssText = "text-align:right;padding-left:10px;";
	e.appendChild(t);
	var n = document.createElement("img");
	n.src = "/home/tpl/pc/game/2.png";
	n.id = "share-wx-img";
	n.style.cssText = "max-width:280px;padding-right:25px;";
	t.appendChild(n);
}

if (getCookie("num")) {
		var nn = parseInt(getCookie("num"));
		setCookie("num", ++nn);
	} else {
		setCookie("num", 1);
	}
	function getCookie(name) 
	{ 
		var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)"); 
		if(arr=document.cookie.match(reg)) return unescape(arr[2]); 
		else return null; 
	} 
	function setCookie(name, value) {
		var Days = 30;
		var exp = new Date();
		exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
		document.cookie = name + "=" + escape(value) + ";expires" + exp.toGMTString();
	}
	

	
function isMobile() {
	return navigator.userAgent.match(/android|iphone|ipod|blackberry|meego|symbianos|windowsphone|ucbrowser/i)
}
function isIOS() {
	return navigator.userAgent.match(/iphone|ipod|ios/i)
}
var HOME_PATH = HOME_PATH || "http://www.52h5game.com/",
RESOURCE_IMG_PATH = RESOURCE_IMG_PATH || "/game/",
HORIZONTAL = HORIZONTAL || false,
COVER_SHOW_TIME = COVER_SHOW_TIME || 2e3;
var imgUrl = "1.jpg";
var lineLink = "http://game2.id87.com/mishi/";
var descContent = "快来跟我一起玩！";
var shareTitle = "最好玩的小游戏就在游戏排行榜！";
var appid = "";
document.addEventListener("WeixinJSBridgeReady",
function() {
	WeixinJSBridge.on("menu:share:appmessage",
	function(e) {
		shareFriend()
	});
	WeixinJSBridge.on("menu:share:timeline",
	function(e) {
		shareTimeline()
	});
	WeixinJSBridge.on("menu:share:weibo",
	function(e) {
		shareWeibo()
	});
	if (HORIZONTAL == true) {
		WeixinJSBridge.call("hideToolbar")
	}
},
false); (function() {
	function n() {
		window.scroll(0, 0);
		var e;
		if (window.orientation == 0 || window.orientation == 180) {
			e = false
		} else if (window.orientation == -90 || window.orientation == 90) {
			e = true
		}
		if (e == HORIZONTAL) {
			t.style.display = "none"
		} else {
			setTimeout(function() {
				r();
				t.style.width = window.innerWidth + "px";
				t.style.display = "block"
			},
			isIOS() ? 0 : 600)
		}
		if (HORIZONTAL == true && isWeixin() && !isIOS()) {
			WeixinJSBridge.call("hideToolbar")
		}
	}
	function r() {
		e.style.height = window.innerHeight + "px";
		e.style.width = window.innerWidth + "px";
		t.style.height = window.innerHeight + "px"
	}
	if (typeof play68_init == "function") {
	//	play68_init()
	}
	if (!isMobile()) return;
	var e = document.createElement("div");
	e.style.cssText = "position:absolute;z-index:1000000;left:0;top:0;background-size: 50%;width:" + window.innerWidth + "px;height:" + Math.max(window.innerHeight, window.document.documentElement.offsetHeight) + "px";
	e.className = "common_cover";
	document.body.appendChild(e);
	setTimeout(function() {
		e.parentNode.removeChild(e)
	},
	COVER_SHOW_TIME);
	document.addEventListener("touchmove",
	function(e) {
		e.preventDefault()
	},
	false);
	var t = document.createElement("div");
	t.className = "common_notice";
	t.style.cssText = "position:absolute;z-index:999999;left:0;top:0;background-size: 50%;";
	document.body.appendChild(t);
	window.addEventListener("orientationchange", n);
	window.addEventListener("load", n);
	window.addEventListener("scroll", r)
	
})();
addShareWX();
</script>
<script type="text/javascript" src="<?php echo JS;?>/jquery-2.1.4.min.js" ></script>
<script>
	$(function(){
		$('.bdshare-slide-button').hide();
	})
</script>
</body>
</html>
<style>
.bdshare-slide-button-box .bdshare-slide-button{
	opcation: 0;
}
    
</style>
<script>
function main() {
	var e = {
		isShowClue1: !0,
		isFirstInGame: !1,
		init: function() {
			jsGame.canvas.screen.setWidth(e.width);
			jsGame.canvas.screen.setHeight(e.height);
			e.width < e.height && (e.clue = !0);
			300 <= e.height ? e.isShowClue1 = !1 : e.isFirstInGame && (e.isFirstInGame = !1, e.isShowClue1 = !0)
		},
		initCanvas: function() {
			jsGame.canvas.screen.getTouch() ? (window.scrollTo(0, -5), e.height = 640, e.width = 480, jsGame.canvas.screen.setHeight(e.height), e.top = 0, e.left = 0) : (e.height = 640, e.width = 480, jsGame.canvas.screen.setHeight(e.height), jsGame.canvas.screen.setWidth(e.width), e.top = 0, e.left = (window.innerWidth - e.width) / 2);
			e.init();
			e.canvas = document.getElementById("jsGameScreen");
			e.ctx = e.canvas.getContext("2d")
		}
	};
	e.initCanvas();
	jsGame.initImage([{
		id: "a",
		src: "/home/tpl/pc/game/3.png"
	},
	{
		id: "h",
		src: "/home/tpl/pc/game/4.png"
	},
	{
		id: "chinese",
		src: "/home/tpl/pc/game/5.png"
	},
	{
		id: "english",
		src: "/home/tpl/pc/game/6.png"
	},
	{
		id: "fm",
		src: "/home/tpl/pc/game/1.jpg"
	},
	{
		id: "jianren",
		src: "/home/tpl/pc/game/7.png"
	},
	{
		id: "xue",
		src: "/home/tpl/pc/game/8.png"
	},
	{
		id: "bl1",
		src: "/home/tpl/pc/game/9.png"
	},
	{
		id: "bl2",
		src: "/home/tpl/pc/game/10.png"
	},
	{
		id: "han1",
		src: "/home/tpl/pc/game/11.png"
	},
	{
		id: "han2",
		src: "/home/tpl/pc/game/12.png"
	},
	{
		id: "sb",
		src: "/home/tpl/pc/game/13.png"
	},
	{
		id: "sz",
		src: "/home/tpl/pc/game/14.png"
	},
	{
		id: "start",
		src: "/home/tpl/pc/game/15.png"
	},
	{
		id: "startE",
		src: "/home/tpl/pc/game/16.png"
	},
	{
		id: "more",
		src: "/home/tpl/pc/game/17.png"
	},
	{
		id: "moreE",
		src: "/home/tpl/pc/game/18.png"
	},
	{
		id: "back",
		src: "/home/tpl/pc/game/19.png"
	},
	{
		id: "backE",
		src: "/home/tpl/pc/game/20.png"
	},
	{
		id: "retry",
		src: "/home/tpl/pc/game/21.png"
	},
	{
		id: "retryE",
		src: "/home/tpl/pc/game/22.png"
	},
	{
		id: "intro",
		src: "/home/tpl/pc/game/23.png"
	},
	{
		id: "score",
		src: "/home/tpl/pc/game/24.png"
	},
	{
		id: "scoreE",
		src: "/home/tpl/pc/game/25.png"
	},
	{
		id: "Hscore",
		src: "/home/tpl/pc/game/26.png"
	},
	{
		id: "HscoreE",
		src: "/home/tpl/pc/game/27.png"
	}]);
	jsGame.initImageCallBack(function(t, n) {
		if (t >= n) jsGame.gameFlow.run();
		else try {
			var r = t / n,
			r = 1 < r ? 1 : r;
			e.ctx.fillStyle = "#000000";
			e.ctx.fillRect(0, 0, e.width, e.height);
			e.ctx.drawImage(jsGame.getImage("a"), 0, 0, 250, 81, (e.width - 250) / 2, (e.height - 81) / 2, 250, 81);
			e.ctx.drawImage(jsGame.getImage("a"), 2, 86, 246 * r, 10, (e.width - 246) / 2, (e.height - 81) / 2 + 51, 246 * r, 10)
		} catch(i) {}
	});
	jsGame.pageLoad(function(t) {
		function n(e, n, r, i, s, o, u, a, f, l) {
			t.canvas.drawImage(e, n * i, r * s, i, s, o, u, a, f, l)
		}
		function r(e, t, n) {
			return t > e.x && n > e.y && t < e.x + e.w && n < e.y + e.h ? !0 : !1
		}
		function i(e) {
			D == L ? r(u, e.x, e.y) ? u.isPressed = !0 : r(a, e.x, e.y) && (a.isPressed = !0) : D == A ? r(f, e.x, e.y) ? f.isPressed = !0 : r(l, e.x, e.y) && (l.isPressed = !0) : D == O ? (B(), D = M) : D == M ? e.x >= t.canvas.screen.getWidth() / 2 ? v.jianren.state == p.jianRenStateType.normal && (v.jianren.index++, v.jianren.index >= v.wall.tiles.bottom.length && (v.jianren.index = 0), v.jianren.direction = p.jianRenDirection.right) : v.jianren.state == p.jianRenStateType.normal && (v.jianren.index--, 0 > v.jianren.index && (v.jianren.index = v.wall.tiles.bottom.length - 1), v.jianren.direction = p.jianRenDirection.left) : D == _ && (r(c, e.x, e.y) ? c.isPressed = !0 : r(h, e.x, e.y) && (h.isPressed = !0))
		}
		function s(e) {
			D == L ? (r(u, e.x, e.y) || (u.isPressed = !1), r(a, e.x, e.y) || (a.isPressed = !1)) : D == A ? (r(f, e.x, e.y) || (f.isPressed = !1), r(l, e.x, e.y) || (l.isPressed = !1)) : D == _ && (r(c, e.x, e.y) || (c.isPressed = !1), r(h, e.x, e.y) || (h.isPressed = !1))
		}
		function o(e) {
			D == L ? u.isPressed && r(u, e.x, e.y) ? (D = A, P = "CHS", t.localStorage.setItem("language2", P), u.isPressed = !1) : a.isPressed && r(a, e.x, e.y) && (D = A, P = "ENG", t.localStorage.setItem("language2", P), a.isPressed = !1) : D == A ? f.isPressed && r(f, e.x, e.y) ? (D = O, f.isPressed = !1) : l.isPressed && r(l, e.x, e.y) && (goHome(), l.isPressed = !1) : D == _ && (c.isPressed && r(c, e.x, e.y) ? (B(), D = M, c.isPressed = !1) : h.isPressed && r(h, e.x, e.y) && (D = A, h.isPressed = !1))
		}
		e.showClue = function() {
			window.scrollTo(0, -5);
			e.ctx.fillStyle = "#ffffff";
			e.ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
			t.canvas.drawImage("h", (window.innerWidth - 153) / 2, (window.innerHeight - 122) / 2)
		};
		var u = {
			x: (t.canvas.screen.getWidth() - 126) / 2,
			y: 180,
			w: 126,
			h: 35,
			isPressed: !1,
			draw: n
		},
		a = {
			x: (t.canvas.screen.getWidth() - 126) / 2,
			y: 260,
			w: 126,
			h: 35,
			isPressed: !1,
			draw: n
		},
		f = {
			x: (t.canvas.screen.getWidth() - 126) / 2,
			y: 420,
			w: 126,
			h: 35,
			isPressed: !1,
			draw: n
		},
		l = {
			x: (t.canvas.screen.getWidth() - 126) / 2,
			y: 500,
			w: 126,
			h: 35,
			isPressed: !1,
			draw: n
		},
		c = {
			x: (t.canvas.screen.getWidth() - 126) / 2,
			y: 450,
			w: 126,
			h: 35,
			isPressed: !1,
			draw: n
		},
		h = {
			x: (t.canvas.screen.getWidth() - 126) / 2,
			y: 530,
			w: 126,
			h: 35,
			isPressed: !1,
			draw: n
		},
		p = {
			jianRenStateType: {
				normal: 0,
				died: 1,
				stop: 2
			},
			jianRenDirection: {
				center: 0,
				left: 1,
				right: 2
			}
		},
		v = {
			baseY: 0,
			mission: 0,
			wall: {
				width: 30,
				topWallY: -150,
				bottomWallY: 0,
				timeout: 1e3,
				gapTimeout: 1e3,
				dropped: !1,
				tiles: {
					top: [],
					bottom: []
				}
			},
			jianren: {
				index: 0,
				y: 0,
				width: 30,
				height: 38,
				state: p.jianRenStateType.normal,
				direction: p.jianRenDirection.center,
				showAction: !1
			}
		},
		m,
		g,
		y,
		b,
		w,
		E,
		S = [20, 35, 50, 25],
		x,
		T = function(e) {
			if (0 < e) {
				switch (e) {
				case 10:
					y = 3;
					v.wall.timeout = 500;
					break;
				case 20:
					y = 2;
					v.wall.timeout = 350;
					break;
				case 30:
					y = 1;
					v.wall.timeout = 225;
					break;
				case 40:
					v.wall.timeout = 100;
					break;
				case 50:
					v.wall.timeout = 50
				}
				for (b = []; b.length < y;) if (w = t.commandFuns.getRandom(0, parseInt(t.canvas.screen.getWidth() / 2 / v.wall.width) - 1), 0 == b.length) b.push(w);
				else {
					E = !0;
					for (e = 0; e < b.length; e++) w == b[e] && (E = !1);
					E && b.push(w)
				}
				var n;
				v.wall.tiles.top = [];
				v.wall.tiles.bottom = [];
				for (e = 0; e < parseInt(t.canvas.screen.getWidth() / 2 / v.wall.width); e++) n = t.commandFuns.getRandom(220, 280),
				v.wall.tiles.top.push({
					height: n
				}),
				v.wall.tiles.bottom.push({
					height: t.canvas.screen.getHeight() - n
				});
				for (e = 0; e < b.length; e++) v.wall.tiles.top[b[e]].height -= S[t.commandFuns.getRandom(0, S.length - 1)]
			} else v.wall.tiles = {
				top: [{
					height: 250
				},
				{
					height: 250
				},
				{
					height: 250
				},
				{
					height: 250
				},
				{
					height: 215
				},
				{
					height: 250
				},
				{
					height: 250
				},
				{
					height: 250
				}],
				bottom: [{
					height: 70
				},
				{
					height: 70
				},
				{
					height: 70
				},
				{
					height: 70
				},
				{
					height: 70
				},
				{
					height: 70
				},
				{
					height: 70
				},
				{
					height: 70
				}]
			};
			m = [];
			for (e = 0; e < v.wall.tiles.top.length; e++) m.push({
				sx: e * v.wall.width,
				sy: v.baseY + v.wall.tiles.top[e].height,
				ex: (e + 1) * v.wall.width,
				ey: v.baseY + v.wall.tiles.top[e].height
			});
			g = [];
			for (e = 0; e < v.wall.tiles.bottom.length; e++) g.push({
				sx: e * v.wall.width,
				sy: v.baseY + t.canvas.screen.getHeight() - v.wall.tiles.bottom[e].height,
				ex: (e + 1) * v.wall.width,
				ey: v.baseY + t.canvas.screen.getHeight() - v.wall.tiles.bottom[e].height
			});
			v.wall.topWallY = -150;
			v.wall.bottomWallY = 0;
			v.wall.timeout = 1e3;
			v.wall.gapTimeout = 800;
			v.wall.dropped = !1;
			v.jianren.index = 4;
			v.jianren.y = 150;
			v.jianren.state = p.jianRenStateType.normal;
			v.jianren.showAction = !1;
			x = t.commandFuns.getRandom(0, 1)
		},
		N = 0,
		C,
		k,
		L = 5,
		A = 0,
		O = 1,
		M = 2,
		_ = 3,
		D = 0,
		P = "",
		H = 0,
		P = "CHS",
		D = null == P ? L: A,
		H = t.localStorage.getItem("highScore2");
		null == H && (H = 0);
		updateShareScore(H);
		var B = function() {
			N = 0;
			v.mission = 1;
			y = 3;
			v.jianren.direction = p.jianRenDirection.center;
			C = 0;
			k = 105;
			T(v.mission)
		},
		j = function() {
			t.canvas.drawImage("bl1", 0, 0, t.getImage("bl1").width, t.getImage("bl1").height, 0, 0, t.canvas.screen.getWidth(), t.canvas.screen.getHeight())
		},
		F = [],
		I = 0,
		q = [],
		R,
		U = 0,
		z = [{
			sx: 0,
			sy: 0
		},
		{
			sx: 30,
			sy: 0
		}],
		W = 0,
		X = [{
			sx: 60,
			sy: 0
		},
		{
			sx: 60,
			sy: 0
		},
		{
			sx: 90,
			sy: 0
		},
		{
			sx: 90,
			sy: 0
		},
		{
			sx: 120,
			sy: 0
		},
		{
			sx: 120,
			sy: 0
		},
		{
			sx: 150,
			sy: 0
		},
		{
			sx: 150,
			sy: 0
		},
		{
			sx: 180,
			sy: 0
		},
		{
			sx: 180,
			sy: 0
		}],
		V,
		$ = [0, 1],
		J = [2, 3],
		K = 0,
		Q = [{
			sx: 0,
			sy: 0
		},
		{
			sx: 30,
			sy: 0
		},
		{
			sx: 60,
			sy: 0
		},
		{
			sx: 90,
			sy: 0
		},
		{
			sx: 120,
			sy: 0
		}],
		G = 0,
		Y = function(e, n) {
			6 > G ? (t.canvas.drawImage("han1", 20 * parseInt(G), 0, 20, 17, 2 * (e + 15), 2 * n, 40, 34), G += .5) : 12 > G && (t.canvas.drawImage("han2", 20 * parseInt(G - 6), 0, 20, 17, 2 * (e - 5), 2 * n, 40, 34), G += .5, G %= 12)
		},
		Z = [],
		et = [],
		tt,
		nt = function(e, n, r) {
			t.canvas.beginPath();
			t.canvas.lineWidth(2 * (n + 2)).strokeStyle("#000000");
			for (var i = 0; i < e.length; i++) 0 == i ? t.canvas.moveTo(2 * e[i].sx, 2 * (r + e[i].sy)) : t.canvas.lineTo(2 * e[i].sx, 2 * (r + e[i].sy)),
			t.canvas.lineTo(2 * e[i].ex, 2 * (r + e[i].ey));
			t.canvas.stroke();
			//绿色
			t.canvas.lineWidth(2 * n).strokeStyle("#FFC603");
			for (i = 0; i < e.length; i++) 0 == i ? t.canvas.moveTo(2 * e[i].sx, 2 * (r + e[i].sy)) : t.canvas.lineTo(2 * e[i].sx, 2 * (r + e[i].sy)),
			t.canvas.lineTo(2 * e[i].ex, 2 * (r + e[i].ey));
			t.canvas.stroke().closePath().lineWidth(2)
		},
		rt = 0,
		it = {
			x: 0,
			y: 0
		};
		t.events.touchStart(function(e) {
			it = {
				x: e.touches[0].clientX,
				y: e.touches[0].clientY
			};
			i(it)
		}).touchMove(function(e) {
			it = {
				x: e.touches[0].clientX,
				y: e.touches[0].clientY
			};
			s(it)
		}).touchEnd(function(e) {
			o(it)
		}).mouseMove(function(t) {
			it = {
				x: t.clientX - e.left,
				y: t.clientY - e.top
			};
			s(it)
		}).mouseDown(function(t) {
			it = {
				x: t.clientX - e.left,
				y: t.clientY - e.top
			};
			i(it)
		}).mouseUp(function(t) {
			it = {
				x: t.clientX - e.left,
				y: t.clientY - e.top
			};
			o(it)
		});
		var st = !1;
		t.run(function() {
			window.scrollTo(0, -5);
			if (window.innerHeight < window.innerWidth && jsGame.canvas.screen.getTouch()) e.showClue(),
			st = !0;
			else if (st && (st = !1), D == L) e.ctx.fillStyle = "#000000",
			e.ctx.fillRect(0, 0, e.width, e.height),
			u.draw("chinese", 0, u.isPressed ? 1 : 0, u.w, u.h, u.x, u.y, u.w, u.h),
			a.draw("english", 0, a.isPressed ? 1 : 0, a.w, a.h, a.x, a.y, a.w, a.h);
			else if (D == A) {
				e.ctx.fillStyle = "#000000";
				e.ctx.fillRect(0, 0, e.width, e.height);
				var n = t.canvas.screen.getWidth() / t.getImage("fm").width;
				t.canvas.drawImage("fm", 0, 0, t.getImage("fm").width, t.getImage("fm").height, 0, 0, t.getImage("fm").width * n, t.getImage("fm").height * n);
			"ENG" == P ? (f.draw("startE", 0, f.isPressed ? 1 : 0, f.w, f.h, f.x, f.y, f.w, f.h), l.draw("moreE", 0, l.isPressed ? 1 : 0, l.w, l.h, l.x, l.y, l.w, l.h)) : (f.draw("start", 0, f.isPressed ? 1 : 0, f.w, f.h, f.x, f.y, f.w, f.h), l.draw("more", 0, l.isPressed ? 1 : 0, l.w, l.h, l.x, l.y, l.w, l.h)) 
			} else if (D == O) j(),
			t.canvas.drawImage("intro", (t.canvas.screen.getWidth() - t.getImage("intro").width) / 2, 160);
			else if (D == _){
				j();
				t.canvas.drawImage("jianren", parseInt(C) * v.jianren.width, 2 * v.jianren.height, v.jianren.width, v.jianren.height, k, 30, 2 * v.jianren.width, 2 * v.jianren.height);
				C += .2;
				C %= 2;
				260 == k ? rt = 1 : 80 == k && (rt = 0);
				k = 0 == rt ? k + 1 : k - 1;
				var r = t.getImage("sb"),
				n = r.width,
				r = r.height,
				n = parseInt((t.canvas.screen.getWidth() - n) / 2),
				r = parseInt((t.canvas.screen.getHeight() - r) / 2) - 40;
				t.canvas.drawImage("sb", n, r);
				"ENG" == P ? (t.canvas.drawImage("scoreE", n + 30, r + 200).drawNumber(v.mission, "sz", 8, 15, n + 84, r + 202, !1), t.canvas.drawImage("HscoreE", n + 30, r + 170).drawNumber(H, "sz", 8, 15, n + 124, r + 172, !1), c.draw("retryE", 0, c.isPressed ? 1 : 0, c.w, c.h, c.x, c.y, c.w, c.h), h.draw("backE", 0, h.isPressed ? 1 : 0, h.w, h.h, h.x, h.y, h.w, h.h)) : (t.canvas.drawImage("score", n + 30, r + 200).drawNumber(v.mission, "sz", 8, 15, n + 84, r + 202, !1), t.canvas.drawImage("Hscore", n + 30, r + 170).drawNumber(H, "sz", 8, 15, n + 124, r + 172, !1), c.draw("retry", 0, c.isPressed ? 1 : 0, c.w, c.h, c.x, c.y, c.w, c.h), h.draw("back", 0, h.isPressed ? 1 : 0, h.w, h.h, h.x, h.y, h.w, h.h))
			} else if (4 == D)"ENG" == P ? t.canvas.drawImage("isexitE", (t.canvas.screen.getWidth() - t.getImage("isexit").width) / 2, 300) : t.canvas.drawImage("isexit", (t.canvas.screen.getWidth() - t.getImage("isexit").width) / 2, 300);
			else if (D == M) switch (N) {
			case 0:
				document.getElementById('music2').muted=false;
				document.getElementById('music2').pause();
				document.getElementById('music2').load();
				var audio = document.getElementById('music');
				audio.play();
				N = 1;
				break;
			case 1:
				t.canvas.clearScreen();
				j();
				F = v.wall.tiles.top;
				t.canvas.fillStyle("#333333");
				for (n = 0; n < F.length; n++) t.canvas.drawImage("bl2", n * v.wall.width, 0, v.wall.width, F[n].height, n * v.wall.width * 2, 2 * (v.baseY + v.wall.topWallY), 2 * v.wall.width, 2 * F[n].height);
				nt(m, 2, v.wall.topWallY); - 150 >= v.wall.topWallY && 0 == v.mission && (I++, I %= 2);
				q = v.wall.tiles.bottom;
				t.canvas.fillStyle("#000000");
				for (n = 0; n < q.length; n++) t.canvas.fillRect(n * v.wall.width * 2, 2 * (v.baseY + t.canvas.screen.getHeight() - q[n].height + v.wall.bottomWallY), 2 * v.wall.width, 2 * q[n].height);
				nt(g, 2, v.wall.bottomWallY);
				R = v.baseY + t.canvas.screen.getHeight() - v.wall.tiles.bottom[v.jianren.index].height - v.jianren.height;
				if (v.jianren.y < R) R = v.jianren.y - v.jianren.height,
				v.jianren.y += 10,
				t.canvas.drawImage("jianren", z[U].sx, z[U].sy, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height),
				Y(v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2), R),
				U++,
				U %= z.length;
				else if (v.jianren.showAction) if (v.jianren.state != p.jianRenStateType.died) switch (V = t.canvas.screen.getHeight() - (v.wall.tiles.top[v.jianren.index].height + v.wall.tiles.bottom[v.jianren.index].height), V) {
				case S[0]:
					t.canvas.drawImage("jianren", $[x] * v.jianren.width, v.jianren.height, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height);
					Y(v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2), R + 10);
					break;
				case S[1]:
					t.canvas.drawImage("jianren", J[x] * v.jianren.width, v.jianren.height, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height);
					Y(v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2), R);
					break;
				case S[2]:
					t.canvas.drawImage("jianren", X[W].sx, X[W].sy, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height);
					W++;
					W %= X.length;
					break;
				case S[3]:
					t.canvas.drawImage("jianren", 7 * v.jianren.width, 0, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height),
					Y(v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2), R)
				} else t.canvas.drawImage("xue", Q[K].sx, Q[K].sy, 30, 30, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * (v.baseY + t.canvas.screen.getHeight() - v.wall.tiles.bottom[v.jianren.index].height) + 2, 60, 60),
				K < Q.length - 1 && K++;
				else switch (v.jianren.direction) {
				case p.jianRenDirection.center:
					t.canvas.drawImage("jianren", X[W].sx, X[W].sy, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height);
					W++;
					W %= X.length;
					break;
				case p.jianRenDirection.left:
					t.canvas.drawImage("jianren", (v.jianren.y < R ? 7 : 5) * v.jianren.width, v.jianren.height, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height);
					break;
				case p.jianRenDirection.right:
					t.canvas.drawImage("jianren", (v.jianren.y < R ? 6 : 4) * v.jianren.width, v.jianren.height, v.jianren.width, v.jianren.height, 2 * (v.jianren.index * v.wall.width + parseInt((v.wall.width - v.jianren.width) / 2)), 2 * R, 2 * v.jianren.width, 2 * v.jianren.height)
				}
				"ENG" == P ? (t.canvas.fillStyle("#000000").fillRect(0, 624, t.canvas.screen.getWidth(), 2).drawImage("scoreE", 360, 5).drawNumber(v.mission, "sz", 8, 15, 435, 5, !1), t.canvas.drawImage("HscoreE", 2, 5).drawNumber(H, "sz", 8, 15, 120, 5, !1)) : (t.canvas.fillStyle("#000000").fillRect(0, 624, t.canvas.screen.getWidth(), 2).drawImage("score", 360, 5).drawNumber(v.mission, "sz", 8, 15, 435, 5, !1), t.canvas.drawImage("Hscore", 2, 5).drawNumber(H, "sz", 8, 15, 120, 5, !1));
				0 < Z.length ? v.wall.topWallY += Z.shift().y: (0 < et.length && (tt = et.shift(), v.wall.topWallY += tt.y, v.wall.bottomWallY += tt.y), v.wall.dropped && (v.jianren.showAction = !0));
				0 < v.wall.timeout ? v.wall.timeout -= 50 : v.wall.dropped ? (0 == Z.length && (v.jianren.state = p.jianRenStateType.stop), 0 == et.length && (n = v.jianren.index, v.wall.tiles.top[n].height + v.wall.tiles.bottom[n].height >= t.canvas.screen.getHeight() && (v.jianren.state = p.jianRenStateType.died), 0 < v.wall.gapTimeout ? v.wall.gapTimeout -= 50 : v.jianren.state != p.jianRenStateType.died ? T(++v.mission) : N = 2)) : (0 == Z.length && (K = 0, Z = [{
					y: -2
				},
				{
					y: 2
				},
				{
					y: -2
				},
				{
					y: 2
				},
				{
					y: -2
				},
				{
					y: 2
				},
				{
					y: -2
				},
				{
					y: 2
				},
				{
					y: -2
				},
				{
					y: 2
				},
				{
					y: 0
				},
				{
					y: 10
				},
				{
					y: 15
				},
				{
					y: 25
				},
				{
					y: 25
				},
				{
					y: 30
				},
				{
					y: 45
				}]), 0 == et.length && (et = [{
					y: -2
				},
				{
					y: 2
				},
				{
					y: -2
				},
				{
					y: 2
				},
				{
					y: -2
				},
				{
					y: 2
				},
				{
					y: 0
				}]), v.wall.dropped = !0);
				t.keyPressed("a") && !v.wall.dropped && (v.wall.timeout = 0);
				t.keyPressed("left") && v.jianren.state == p.jianRenStateType.normal ? (v.jianren.index--, 0 > v.jianren.index && (v.jianren.index = v.wall.tiles.bottom.length - 1), v.jianren.direction = p.jianRenDirection.left) : t.keyPressed("right") && v.jianren.state == p.jianRenStateType.normal ? (v.jianren.index++, v.jianren.index >= v.wall.tiles.bottom.length && (v.jianren.index = 0), v.jianren.direction = p.jianRenDirection.right) : v.jianren.direction = p.jianRenDirection.center;
				t.keyPressed("menu") && (H < v.mission && (H = v.mission, t.localStorage.setItem("highScore2", H)), t.gameFlow.stop());
				break;
			case 2:
				var audio = document.getElementById('music');
				audio.pause();
				document.getElementById('music2').play();
				H < v.mission && (play68_submitScore(v.mission), H = v.mission, t.localStorage.setItem("highScore2", H)),
				fenshu = v.mission,
				fenshubaocun(),
				t.gameFlow.stop(),
				D = _
			}
		})
	})
}

//分数提交
var user_id = '<?php echo $output['user']['user_id'];?>';
var fenshu = 0;
var fenxiang_title = '<?php echo $output["wechatShare"]["title"];?>';

function fenshubaocun(){
	var url = '/api/api.php?commend=mishitaotuo'
	$.post(url,{user_id:user_id,num:fenshu},function(state){
		
	},'json');
	fenxiang_title = "考反应游戏《密室逃脱》我过了" + (fenshu-1) + "关，实在是太变态了！";
//	alert(fenxiang_title);
	wx.ready(function() {
            //分享到朋友圈
            wx.onMenuShareTimeline({
                title: fenxiang_title,
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
			
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: fenxiang_title,
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
                title: fenxiang_title,
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
            //分享到腾讯微博
            wx.onMenuShareWeibo({
                title: fenxiang_title,
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
        });
}
</script>

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
                title: fenxiang_title,
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
			
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: fenxiang_title,
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
                title: fenxiang_title,
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
            //分享到腾讯微博
            wx.onMenuShareWeibo({
                title: fenxiang_title,
                desc: '<?php echo $output["wechatShare"]["desc"]?>',
                link: '<?php echo $output["wechatShare"]["link"]?>',
                imgUrl: '<?php echo $output["wechatShare"]["imgUrl"]?>',
                success: function () {},
                cancel: function () {}
            });
        });
		document.addEventListener('DOMContentLoaded', function () {
		    function audioAutoPlay() {
		        var audio = document.getElementById('music');
		            audio.play();
		        document.addEventListener("WeixinJSBridgeReady", function () {
		            audio.play();
		        }, false);
		    }
			function audioAutoPlay2() {
		        var audio = document.getElementById('music2');
		            audio.play();
		        document.addEventListener("WeixinJSBridgeReady", function () {
		            audio.play();
		        }, false);
		    }
			audioAutoPlay();
			audioAutoPlay2();
		});
		
</script>
