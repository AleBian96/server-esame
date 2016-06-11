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
					if(Mode == "delete"){
						AJAX("delete.php","file="+baseFolder+folder+fName,function(){show("ls");});
						return;
					}
					var imgReader = document.createElement("img");
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
						textReader.setSelectionRange(0,0);
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
						block = document.createElement("div");
						block.classList.add("display");
						block.style.width="25%";
						fileMenu = document.createElement("div");
						fileMenu.classList.add("bar");
						fileMenu.setAttribute("id","bar3");
						save.innerHTML = "Save";
						save.onclick = function(){
							close.classList.toggle("alert",false);
							AJAX("save.php","dir="+baseFolder+folder+fName+"&text="+escape(textReader.value),function(){
								if(response != false)close.style = "";
							});
						};
						close.innerHTML = "Close";
						close.onclick = function closeReader(){
							textReader.style.opacity=0;
							fileMenu.style.opacity=0;
							block.style.opacity=0;
							setTimeout(function(){
								document.body.removeChild(block);
								document.body.removeChild(fileMenu);
								document.body.removeChild(textReader);
								show("ls");
							},200);
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
							textReader.style.opacity=1;
							fileMenu.style.opacity=1;
							block.style.opacity=.25;
							btnContainer.style.opacity=1;
							textReader.focus();
							text.scrollTop=0;
						},0);
					});
				};
			}else{
				foldEl.classList.add("folder");
				foldEl.onclick = function(){
					if(Mode == "delete"){
						AJAX("deleteFolder.php","folder="+baseFolder+folder+this.getAttribute("open"),function(){show("ls");});
						return;
					}
					show("cd "+this.getAttribute("open"));
				};
			}
			foldEl.appendChild(img);
			whr.appendChild(foldEl);
		}
		showFoldEl();
	});
}