// TOOL BOX BUTTON FUNCTIONs

Mode = "";
function toolBoxButton(){
	var tb = document.getElementById("toolBox");
	var style = "height='40%' width='40%' style='margin-left:30%;margin-top:30%;'";

	//HOME BUTTON
	var home = document.createElement("div");
	home.onclick = function(){show("cd");}
	home.innerHTML = "<img src='../remoteStyle/img/iconpack3/Home.png' "+style+"/>";

	//REFRESH BUTTON
	var refresh = document.createElement("div");
	refresh.onclick = function(){show("ls");}
	refresh.innerHTML = "<img src='../remoteStyle/img/iconpack3/Refresh.png' "+style+"/>";

	//BACK BUTTON
	var back = document.createElement("div");
	back.innerHTML = "<img src='../remoteStyle/img/iconpack3/Previous.png' "+style+"/>";
	back.onclick = function(){show("cd ..");}

	//NEW FILE BUTTON
	var newF = document.createElement("div");
	newF.innerHTML = "<img src='../remoteStyle/img/iconpack3/Add_File.png' "+style+"/>";
	newF.onclick = function(){
		var epoch = (new Date).getTime();
		var name = "FILE_"+epoch+".txt";
		PC("nfile "+name,function(){show("ls")});
	};

	//NEW FOLDERBUTTON
	var newFold = document.createElement("div");
	newFold.innerHTML = "<img src='../remoteStyle/img/iconpack3/Add_Folder.png' "+style+"/>";
	newFold.onclick = function(){
		var epoch = (new Date).getTime();
		var name = "FOLDER_"+epoch;
		PC("mkdir "+name,function(){show("ls")});
	};

	//DELETE BUTTON
	var del= document.createElement("div");
	del.innerHTML = "<img src='../remoteStyle/img/iconpack3/Delete.png' "+style+"/>";
	del.onclick = function(){
		if(Mode == ""){
			Mode = "delete";
			del.classList.toggle("alert",true);
		}else if(Mode == "delete"){
			Mode = "";
			del.classList.toggle("alert",false);
		}
	}

	//RENAME BUTTON
	var ren = document.createElement("div");
	ren.innerHTML = "<img src='../remoteStyle/img/iconpack3/Rename.png' "+style+"/>";
	ren.onclick = function(){
		if(Mode == ""){
			Mode = "rename";
			ren.classList.toggle("alert",true);
		}else if(Mode == "rename"){
			Mode = "";
			ren.classList.toggle("alert",false);
		}
	}

	//LOGOUT BUTTON
	var logout = document.createElement("div");
	logout.innerHTML = "<img src='../remoteStyle/img/iconpack3/Logout.png' "+style+"/>";
	logout.onclick = function(){
		var F = document.createElement("form");
		var i = document.createElement("input");
		i.name = "logout";
		i.value = "true";
		F.action = "/";
		F.method = "POST";
		F.appendChild(i);
		F.submit();
	}



	tb.appendChild(refresh);
	tb.appendChild(home);
	tb.appendChild(back);
	tb.appendChild(newF);
	tb.appendChild(newFold);
	tb.appendChild(ren);
	tb.appendChild(del);
	tb.appendChild(logout);
}