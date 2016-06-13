// TOOL BOX BUTTON FUNCTIONs

Mode = "";
function toolBoxButton(){
	var tb = document.getElementById("toolBox");
	var style = "height='40%' width='40%' style='margin-left:30%;margin-top:30%;'";

	//HOME BUTTON
	var home = document.createElement("div");
	home.onclick = function(){show("cd");}
	home.innerHTML = "<img src='../remoteStyle/img/home.png' "+style+"/>";
	tb.appendChild(home);

	//REFRESH BUTTON
	var refresh = document.createElement("div");
	refresh.onclick = function(){show("ls");}
	refresh.innerHTML = "<img src='../remoteStyle/img/refresh.png' "+style+"/>";
	tb.appendChild(refresh);

	//BACK BUTTON
	var back = document.createElement("div");
	back.innerHTML = "<img src='../remoteStyle/img/back.png' "+style+"/>";
	back.onclick = function(){show("cd ..");}
	tb.appendChild(back);

	//NEW FILE BUTTON
	var newF = document.createElement("div");
	newF.innerHTML = "<img src='../remoteStyle/img/newfile.png' "+style+"/>";
	newF.onclick = function(){
		var epoch = (new Date).getTime();
		var name = "FILE_"+epoch+".txt";
		PC("nfile "+name,function(){show("ls")});
	};
	tb.appendChild(newF);

	//NEW FOLDERBUTTON
	var newFold = document.createElement("div");
	newFold.innerHTML = "<img src='../remoteStyle/img/newfolder.png' "+style+"/>";
	newFold.onclick = function(){
		var epoch = (new Date).getTime();
		var name = "FOLDER_"+epoch;
		PC("mkdir "+name,function(){show("ls")});
	};
	tb.appendChild(newFold);

	//DELETE BUTTON
	var del= document.createElement("div");
	del.innerHTML = "<img src='../remoteStyle/img/delete.png' "+style+"/>";
	del.onclick = function(){
		if(Mode == ""){
			Mode = "delete";
			del.classList.toggle("alert",true);
		}else if(Mode == "delete"){
			Mode = "";
			del.classList.toggle("alert",false);
		}
	}
	tb.appendChild(del);

	//RENAME BUTTON
	var ren= document.createElement("div");
	ren.innerHTML = "<img src='../remoteStyle/img/rename.png' "+style+"/>";
	ren.onclick = function(){
		if(Mode == ""){
			Mode = "rename";
			ren.classList.toggle("alert",true);
		}else if(Mode == "rename"){
			Mode = "";
			ren.classList.toggle("alert",false);
		}
	}
	tb.appendChild(ren);
}