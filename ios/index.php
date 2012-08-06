<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>FilmDB</title>
		<meta http-equiv="content-type" content="utf-8">
		<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no, initial-scale=1; maximum-scale=1; minimum-scale=1;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
		<style type="text/css">
		<!--
		html, body {
			overflow: hidden;
			font-family: helvetica, arial, sans-serif;
			background: rgb(177,189,157) url(apple-touch-startup-image.png) center center no-repeat;
			width: 100%;
			height: 100%; 
			margin: 0px;
			padding: 0px;
		}
		marquee.scroller {
			width: 90%;
			height: 100%;
			margin: 0px 5%;
			padding: 0px;
			color: white;
			font-size: 24px;
			line-height: 32px;
			text-align: center;
			text-shadow: black 0px 0px 4px;
		}	
		button {
			text-shadow: black 0px 0px 0px;
		}	
		button.small {
			display: inline-block;
			font-weight: bold;
			font-size: 24px;
			line-height: 32px;
		}
		button.big {
			font-weight: bolder;
			font-size: 48px;
			line-height: 64px;
		}
		-->
		</style>
		<script type="text/javascript">
		<!--
			var tmp='';
			window.scrollTo(0, 1);
			
			if(window.localStorage) {
				tmp='?view='+(localStorage.view||'poster');
				tmp+='&page='+(localStorage.page||0);
				tmp+='&filtertitle='+(localStorage.filtertitle||'');
				tmp+='&sorter='+(localStorage.sorter||'inserted_DESC');
				tmp+='&genres='+(localStorage.genres||'');
				tmp+='&sortby[0]='+(localStorage.sortby0||'inserted DESC');
				tmp+='&sortby[1]='+(localStorage.sortby1||'nr ASC');
				tmp+='&sortby[2]='+(localStorage.sortby2||'year ASC');
				tmp+='&tosearch='+(localStorage.tosearch||'');
				tmp+='&searchin='+(localStorage.searchin||'movies.name,aka');
				tmp+='&filter='+(localStorage.filter||'');
			}
			
			function setup() {
				if(typeof(window.orientation)==="undefined") {
					var w=window.innerWidth,h=window.innerHeight;
					if(w<=h) {
						window.location.href='portrait.php'+tmp;
					}else if(w>h) {
						window.location.href='landscape.php'+tmp;
					}
					return false;
				}else {
					switch(window.orientation) {
						case -90: // Landscape: turned 90 degrees counter-clockwise
						case 90:  // Landscape: turned 90 degrees clockwise
							window.location.href='landscape.php'+tmp;
						break;
						default:
						case 0:   // Portrait
						case 180: // Upside-down Portrait
							window.location.href='portrait.php'+tmp;
						break;
					}
				}
			}
			
			window.onload=function() {
				if(typeof(window.orientation)!="undefined"||navigator.userAgent.match(/(iPhone|iPod|iPad)/i)) {
					document.getElementById("notapple").style.visibility='hidden';
					document.getElementById("notapple").style.display='none';
					if(!window.navigator.standalone) {
						document.getElementById("install").style.visibility='visible';
					}else { 
						setup();
					}
				}
			};	
		-->
		</script>
	</head>
	<body>
		<noscript><marquee class="scroller" style="visibility: visible;" behavior="scroll" scrollamount="1" scrolldelay="60" direction="up">
			With deactivated JavaScript you won't see any results!
		</marquee></noscript>
		<marquee id="notapple" class="scroller" style="visibility: visible;" behavior="scroll" scrollamount="1" scrolldelay="60" direction="up">
			This device <b>is neither</b><br />an iPhone / iPod Touch,<br /><b>nor</b> an iPad <i>(Sorry)</i>!<br /><br />
			If you want to go on<br />as a <b>mobile</b> device,<br />then tap / click / press<br />this <button class="small" onclick="window.location.href='../mobile/';">FilmDB</button> button!<br /><br />
			If you want to go on<br />as a <b>desktop</b> device,<br />then tap / click / press<br />this <button class="small" onclick="window.location.href='../';">FilmDB</button> button!<br /><br />
			If you want to go on<br />as a <b>forced</b> iPhone,<br />then tap / click / press<br />this <button class="small" onclick="setup();">FilmDB</button> button!
		</marquee>
		<marquee id="install" class="scroller" style="visibility: hidden;" behavior="scroll" scrollamount="1" scrolldelay="60" direction="up">
			<button class="small" onclick="setup();">skip marquee</button><br /><br />To <b>install</b> this web app,<br />tap the white [<b>+</b>] button<br />of the browser gui and<br />then select the item...<br />"<b>Add to Home Screen</b>"<br />...or to went on without<br />any installation, tap the<br />first or following button!<br /><br /><button class="big" onclick="setup();">FilmDB</button>
		</marquee>
	</body>
</html>
