// TOOL BOX BUTTON FUNCTIONs

Mode = "";
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

	var del= document.createElement("div");
	del.onclick = function(){
		if(Mode == ""){
			Mode = "delete";
			del.classList.toggle("alert",true);
		}else{
			Mode = "";
			del.classList.toggle("alert",false);
		}
	}
	del.innerHTML = "<p>delete</p>";
	tb.appendChild(del);
}