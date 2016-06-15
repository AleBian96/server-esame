baseFolder = "WEBSITES/EveryPC/remoteFolder/"+personalFolder+"/";
folder = "";
response = "";

function PC(value,output){
	var toSend = "";
	var V = value.split(" ");

	switch(V[0]){
		case "nfile":
			toSend="echo '' >> "+baseFolder+folder+V[1];
				break;
		case "read":
			toSend="cat "+baseFolder+folder+V[1];
				break;
		case "ls":
			toSend="ls -L --group-directories-first "+baseFolder+folder;
				break;
		case "cd":
			if(V.length==1 || V[1]==""){
				folder="";
			}else if(V[1] == ".."){
				if(folder.split("/")[1]=="" || folder=="")folder="";
				var s = folder.split("/");
				folder = "";
				for(i=0;i<s.length-2;i++)folder+=s[i]+"/";
			}else {folder += V[1];if(!folder.endsWith("/"))folder+="/";}
				PC("ls",output);break;
		case "mkdir":
			if(V.length==1 || V[1]==""){break;}
			toSend="mkdir "+baseFolder+folder+V[1];
				break;
		case "rm":
			if(V.length==1 || V[1]==""){break;}
			toSend="rm -r "+baseFolder+folder+V[1];
				break;
		default: break;
	}

	if(toSend=="")return;
	toSend = encodeURIComponent(toSend);
	var R = new XMLHttpRequest();
	R.open("POST","Exec.php",true);
	R.send("cmd="+toSend);
	R.onreadystatechange = function(){
		if(R.readyState==4){
			response=R.responseText;
			output();
			response="";
		}
	}
}