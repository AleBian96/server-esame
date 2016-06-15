response="";
function AJAX(php,send,output){
	send = send.split("+").join("%2B");
	var R = new XMLHttpRequest();
	R.open("POST",php,true);
	R.send(send);
	R.onreadystatechange = function(){
		if(R.readyState==4){
			response=R.responseText;
			output();
			response="";
		}
	}
}