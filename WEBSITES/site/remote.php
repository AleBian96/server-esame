<?php
	function index(){
		echo "<script>
			var F = document.createElement('form');
			var i = document.createElement('input');
			F.method = 'post';
			i.name = 'cmd';
			i.value = 'wrong';
			F.appendChild(i);
			F.action = '/';
			F.submit();
		</script>";
	}

	$name = $_POST["name"];
	$pass = $_POST["pass"];
	if(!(isset($name)) || !(isset($pass)))index();
	$DB = database("siteDB");
	$R = $DB->query("SELECT COUNT(*) as TOT, dir FROM users WHERE user='$name' AND pass='$pass'")->fetchArray();
	$folder = $R["dir"];
	$count = $R["TOT"];
	if($count != 0){
		echo "<script>personalFolder='".$folder."';</script>";
	}
	else{
		index();
	}
?>
<HTML>

<link rel="stylesheet" type="text/css" href="loadfonts.css"/>
<link rel="stylesheet" type="text/css" href="theme.css"/>

<script src="remoteScript.js"></script>
<script src="Uscape.js"></script>
<script>
window.onload = function(){sexyBoot(function(){show("ls")});}
function sexyBoot(exitFn){
	var screen = document.createElement("div");
	var loadBar = document.createElement("div");

	screen.style.background="rgb(140,140,140)";
	screen.style.position="absolute";
	screen.style.top="0";
	screen.style.left="0";
	screen.style.width="100%";
	screen.style.height="100%";

	loadBar.style.height=".5%";
	loadBar.style.width="0";
	loadBar.setAttribute("id","tmp123boot123");
	loadBar.style.position="absolute";
	loadBar.style.left="0";
	loadBar.style.top="49.75%";
	loadBar.style.background="black";

	document.body.appendChild(screen);
	document.body.appendChild(loadBar);

	var bar = document.getElementById("tmp123boot123");
	setTimeout(function(){bar.style.width="30%";},500);
	setTimeout(function(){bar.style.width="40%";},1000);
	setTimeout(function(){bar.style.width="100%";},1500);
	setTimeout(function(){
		bar.setAttribute("id","");
		bar.style = "";
		bar.className += " display";
		exitFn();
	},2000);
}

function show(cmd,whr=document.getElementsByClassName("display")[0]){
	PC(cmd,function(){
		whr.innerHTML="";
		whr.scrollTop = 0;
		T = response.split(endline);
		if(cmd!="ls")show("ls");
		for(i=0;i<T.length-1;i++){
			var div = document.createElement("div");
			var img = document.createElement("span");
			div.innerHTML+="<l>"+T[i]+"</l>";
			div.setAttribute("open",T[i]);
			div.setAttribute("tabindex",i+1);
			if(T[i].indexOf(".") != -1){
				div.classList.add("file");
				div.onclick = function(){
					var fName = this.getAttribute("open");
					var textReader = document.createElement("textArea");
					var popUpMenu = document.createElement("div");
					var save = document.createElement("button");
					var close = document.createElement("button");
					var btnContainer = document.createElement("div");
					var fileName = document.createElement("span");
					fileName.innerHTML = folder+fName;
					textReader.classList.add("reader");
					PC("read "+fName,function(){
						response = response.split(endline).join("\n");
						text = response.substring(0,response.length-2);
						textReader.innerHTML = text;
						fileName.innerHTML += " - "+text.split("\n").length+" line/s";
						document.body.appendChild(textReader);
						textReader.focus();
						textReader.onkeydown = function(){
							var K = event.keyCode || event.which;
							if(K == 9){
								event.preventDefault();
								pos = textReader.selectionStart;
								textReader.value = textReader.value.substring(0,pos) + "\t" + textReader.value.substring(pos,textReader.value.length);
								textReader.setSelectionRange(pos+1,pos+1);
							}
						}
						textReader.scrollTop=0;
					});
					popUpMenu.classList.add("menu");
					document.body.appendChild(popUpMenu);
					save.innerHTML = "Save";
					save.onclick = function(){
						AJAX("save.php","dir="+baseFolder+folder+fName+"&text="+escape(textReader.value),function(){});
					};
					close.innerHTML = "Close";
					close.onclick = function(){
						document.body.removeChild(popUpMenu);
						document.body.removeChild(textReader);
					};
					btnContainer.appendChild(close);
					btnContainer.appendChild(save);
					popUpMenu.appendChild(btnContainer);
					popUpMenu.appendChild(fileName);
				}
			}else{
				div.classList.add("folder");
				div.onclick = function(){
					//var d = document.createElement("div");
					//display.setAttribute("class","display");
					show("cd "+this.getAttribute("open"));
				};
			}
			div.appendChild(img);
			whr.appendChild(div);
		}
	});
}
</script>
</HTML>
