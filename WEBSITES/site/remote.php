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
<div tabindex=100000 onfocus="document.getElementsByClassName('file')[0].focus();document.getElementsByClassName('folder')[0].focus()"></div>
<script src="remoteScript.js"></script>
<script src="uscape.js"></script>

<script>
document.body.oncontextmenu = function(){return false;}
window.onload = function(){sexyBoot(function(){show("ls")});}
function sexyBoot(exitFn){
	var explorer = document.createElement("div");
	var toolBox = document.createElement("div");
	var reader = document.createElement("div");

	var bar1 = document.createElement("div");
	var bar2 = document.createElement("div");
	var bar3 = document.createElement("div");

	reader.style =
		"background:rgb(0,230,190);"+
		"width:0;height:.5%;"+
		"position:absolute;top:49.75%;left:35%;";
	toolBox.style =
		"background:rgb(0,230,190);"+
		"width:0;height:.5%;"+
		"position:absolute;top:49.75%;left:20%;";
	explorer.style =
		"background:rgb(0,230,190);"+
		"position:absolute;"+
		"top:49.75%;left:5%;"+
		"width:0;height:.5%;";
	bar1.style.cssText = explorer.style.cssText;
	bar2.style.cssText = toolBox.style.cssText;
	bar3.style.cssText = reader.style.cssText;

	bar1.style.width = "15%";
	bar2.style.width = "15%";
	bar3.style.width = "60%";

	bar1.style.background = "rgb(75,75,75)";
	bar2.style.background = "rgb(75,75,75)";
	bar3.style.background = "rgb(75,75,75)";

	document.body.appendChild(bar1);
	document.body.appendChild(bar2);
	document.body.appendChild(bar3);

	document.body.appendChild(explorer);
	document.body.appendChild(toolBox);
	document.body.appendChild(reader);

	setTimeout(function(){bar1.style.width="15%";explorer.style.width="15%"},500);
	setTimeout(function(){bar2.style.width="15%";toolBox.style.width="15%"},1000);
	setTimeout(function(){bar3.style.width="60%";reader.style.width="60%";},1500);
	setTimeout(function(){
		bar1.style = "";
		bar2.style = "";
		bar3.style = "";
		toolBox.style = "";
		reader.style = "";
		explorer.style = "";
		bar1.classList.add("bar");
		bar2.classList.add("bar");
		bar3.classList.add("bar");
		bar1.setAttribute("id","bar1");
		bar2.setAttribute("id","bar2");
		bar3.setAttribute("id","bar3");
		toolBox.setAttribute("id","toolBox");
		reader.setAttribute("id","reader");
		explorer.classList.add("display");
		toolBoxButton();
		exitFn();
	},2000);
}

function toolBoxButton(){
	var tb = document.getElementById("toolBox");

	var refresh = document.createElement("div");
	refresh.innerHTML = "<p>refresh</p>";
	refresh.onclick = function(){show("ls");}
	tb.appendChild(refresh);

	var back = document.createElement("div");
	back.onclick = function(){show("cd ..");}
	back.innerHTML = "<p>back</p>";
	tb.appendChild(back);

	var newF = document.createElement("div");
	newF.onclick = function(){
		openFile("test.txt");
	};
	newF.innerHTML = "<p>new</p>";
	tb.appendChild(newF);
}

function showFoldEl(){
	function showEl(el,i,time){
		setTimeout(function(){el[i].style.opacity=1;},time*i);
	}
	function concat(obj1,obj2){
		var A = new Array();
		for(i=0;i<obj1.length;i++)A.push(obj1[i]);
		for(i=0;i<obj2.length;i++)A.push(obj2[i]);
		return A;
	}
	var F = concat(document.getElementsByClassName("folder"),document.getElementsByClassName("file"));
	for(i=0;i<F.length;i++)showEl(F,i,50);
}

window.onresize = function(){document.body.style.minWidth = window.innerHeight*(16/9);}

function show(cmd,displayN=0){
	PC(cmd,function(){
		whr = document.getElementsByClassName("display")[displayN];
		whr.innerHTML= "";
		whr.scrollTop = 0;
		T = response.split(endline);
		if(cmd!="ls")show("ls",displayN);
		if(cmd!="ls")return;
		for(i=0;i<T.length-1;i++){
			var foldEl = document.createElement("div");
				var img = document.createElement("span");
			foldEl.innerHTML+="<l>"+T[i]+"</l>";
			foldEl.setAttribute("open",T[i]);
			foldEl.style.opacity=0;
			foldEl.setAttribute("tabindex",i+1);
			if(T[i].indexOf(".") != -1){
				foldEl.classList.add("file");
				foldEl.onclick = function(){
					var fName = this.getAttribute("open");
					var textReader = document.createElement("textArea");
						var popUpMenu = document.createElement("div");
							var btnContainer = document.createElement("div");
								var save = document.createElement("button");
								var close = document.createElement("button");
						var fileName = document.createElement("input");

					fileName.value = fName;
					fileName.onchange = function(){
						fName = this.value;
					}
					textReader.classList.add("reader");
					PC("read "+fName,function(){
						response = response.split(endline).join("\n");
						text = response.substring(0,response.length-2);
						textReader.innerHTML = text;
						textReader.spellcheck = false;
						textReader.autocapitalize = "off";
						textReader.autocorrect = "off";
						textReader.wrap = "off";
						document.body.appendChild(textReader);
						textReader.focus();
						textReader.setSelectionRange(0,0);
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
					block = document.createElement("div");
					block.classList.add("display");
					block.style.opacity=.25;
					block.style.width="25%";
					fileMenu = document.createElement("div");
					fileMenu.classList.add("bar");
					fileMenu.setAttribute("id","bar3");
					save.innerHTML = "Save";
					save.onclick = function(){
						AJAX("save.php","dir="+baseFolder+folder+fName+"&text="+escape(textReader.value),function(){});
					};
					close.innerHTML = "Close";
					close.onclick = function closeReader(){
						textReader.style.opacity=0;
						fileMenu.style.opacity=0;
						setTimeout(function(){
							document.body.removeChild(block);
							document.body.removeChild(fileMenu);
							document.body.removeChild(textReader);
							show("ls");
						},200);
					};
					btnContainer.style.overflow="visible";
					btnContainer.appendChild(close);
					btnContainer.appendChild(save);
					fileMenu.appendChild(btnContainer);
					fileMenu.appendChild(fileName);
					document.body.appendChild(fileMenu);
					document.body.appendChild(block);
				}
			}else{
				foldEl.classList.add("folder");
				foldEl.onclick = function(){
					show("cd "+this.getAttribute("open"));
				};
			}
			foldEl.appendChild(img);
			whr.appendChild(foldEl);
		}
		showFoldEl();
	});
}
</script>
</HTML>