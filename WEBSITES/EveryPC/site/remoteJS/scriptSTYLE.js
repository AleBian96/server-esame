//BOOT AND STYLE CODE

window.oncontextmenu = function(){return false;}
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

	reader.innerHTML = "<input value='Dashboard' disabled/>";
	bar1.innerHTML = "<input value='EveryPC' disabled/>";

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
	},2250);
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
	for(i=0;i<F.length;i++)showEl(F,i,10);
}