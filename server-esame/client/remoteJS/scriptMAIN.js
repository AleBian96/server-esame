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

			foldEl.innerHTML+="<input value="+T[i]+" disabled/>";
			foldEl.setAttribute("open",T[i]);
			foldEl.style.opacity=0;
			foldEl.setAttribute("tabindex",i+1);
			if(T[i].indexOf(".") != -1){
				foldEl.classList.add("file");
				foldEl.onclick = function(){
					var fName = this.getAttribute("open");
					if(Mode == "delete"){
						AJAX("delete.php","file="+baseFolder+folder+fName,function(){show("ls");});
						return;
					}
					if(Mode == "rename"){
						var bgform = document.createElement("div");
						var input = document.createElement("input");
						var block = document.createElement("div");
						input.placeholder="new name";
						input.value=fName;
						input.setSelectionRange(0,input.value.indexOf('.'));
						block.classList.add("display");
						block.style.width="25%";
						block.style.opacity=.25;
						bgform.classList.add("inputField");
						input.onkeydown = function(){
							var K = event.keyCode || event.which;
							if(K == 13){
								AJAX("rename.php","oldname="+fName+"&newname="+this.value+"&dir="+baseFolder+folder,function(){show("ls");});
								document.body.removeChild(block);
								document.body.removeChild(bgform);
							}
						};
						bgform.appendChild(input);
						document.body.appendChild(bgform);
						document.body.appendChild(block);
						input.focus();
						return;
					}
					var textReader = document.createElement("textArea");
					var popUpMenu = document.createElement("div");
					var btnContainer = document.createElement("div");
					var save = document.createElement("button");
					var close = document.createElement("button");
					var fileName = document.createElement("input");

					textReader.acceptCharset = "utf-8";
					textReader.spellcheck = false;
					textReader.autocapitalize = "off";
					textReader.autocorrect = "off";
					textReader.wrap = "off";
					textReader.setSelectionRange(0,0);

					fileName.value = fName;
					fileName.onchange = function(){
						fName = this.value;
					}

					if(fName.indexOf(".png") != -1){
						save.style.display = "none";
						textReader.disabled=true;
						PC("readIMG "+fName,function(){
							response = response.split(endline).join().split(",").join("");
							textReader.style.backgroundImage="url(data:image/png;base64,"+response+")";
						});
					}


					textReader.classList.add("reader");
					if(fName.indexOf(".png") == -1)PC("read "+fName,function(){
						response = response.split(endline).join("\n");
						text = response.substring(0,response.length-2);
						textReader.innerHTML = text;
						textReader.onkeydown = function(){
							var K = event.keyCode || event.which;
							if(K == 9){
								event.preventDefault();
								pos = textReader.selectionStart;
								textReader.value = textReader.value.substring(0,pos) + "\t" + textReader.value.substring(pos,textReader.value.length);
								textReader.setSelectionRange(pos+1,pos+1);
							}
						};
						textReader.oninput = function(){
							close.classList.toggle("alert",true);
						};
					});
					block = document.createElement("div");
					block.classList.add("display");
					block.style.width="25%";
					fileMenu = document.createElement("div");
					fileMenu.classList.add("bar");
					fileMenu.setAttribute("id","bar3");
					save.innerHTML = "Save";
					save.onclick = function(){
						close.classList.toggle("alert",false);
						AJAX("save.php","dir="+baseFolder+folder+fName+"&text="+encodeURIComponent(textReader.value),function(){
							if(response != false)close.style = "";
						});
					};
					close.innerHTML = "Close";
					close.onclick = function closeReader(){
						textReader.style = "";
						setTimeout(function(){
							textReader.style.opacity=0;
							fileMenu.style.opacity=0;
							block.style.opacity=0;
						},100);
						setTimeout(function(){
							document.body.removeChild(block);
							document.body.removeChild(fileMenu);
							document.body.removeChild(textReader);
							show("ls");
						},250);
					};

					fileMenu.style.opacity=0;
					block.style.opacity=0;
					btnContainer.style.opacity=0;
					btnContainer.style.overflow="visible";
					textReader.style.opacity=0;

					document.body.appendChild(fileMenu);
					document.body.appendChild(block);
					btnContainer.appendChild(close);
					btnContainer.appendChild(save);
					fileMenu.appendChild(btnContainer);
					fileMenu.appendChild(fileName);
					document.body.appendChild(textReader);

					setTimeout(function(){
						textReader.style.left="10%";
						textReader.style.width="83.75%";
						textReader.style.boxShadow="black -2vmin 0 4vmin -2vmin";
						textReader.style.opacity=1;
						fileMenu.style.opacity=1;
						block.style.opacity=.25;
						btnContainer.style.opacity=1;
						textReader.focus();
						textReader.scrollTop=0;
					},0);
				};
			}else{
				foldEl.classList.add("folder");
				foldEl.onclick = function(){
					var fName = this.getAttribute("open");
					if(Mode == "delete"){
						AJAX("deleteFolder.php","folder="+baseFolder+folder+fName,function(){show("ls");});
						return;
					}
					if(Mode == "rename"){
						var bgform = document.createElement("div");
						var input = document.createElement("input");
						var block = document.createElement("div");
						input.placeholder="new name";
						input.value=fName;
						input.setSelectionRange(0,input.value.length);
						block.classList.add("display");
						block.style.width="25%";
						block.style.opacity=.25;
						bgform.classList.add("inputField");
						input.onkeydown = function(){
							var K = event.keyCode || event.which;
							if(K == 13){
								AJAX("rename.php","oldname="+fName+"&newname="+this.value+"&dir="+baseFolder+folder,function(){show("ls");});
								document.body.removeChild(block);
								document.body.removeChild(bgform);
							}
						};
						bgform.appendChild(input);
						document.body.appendChild(bgform);
						document.body.appendChild(block);
						input.focus();
						return;
					}
					show("cd "+fName);
				};
			}
			foldEl.appendChild(img);
			whr.appendChild(foldEl);
		}
		showFoldEl();
	});
}