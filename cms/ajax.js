//inicia o ajax
ie=((document.all)?true:false);	
	var xmlhttp=0; 
	var texto='';
	var erro=false;
try { 
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
	}catch (e){ 
	ie=false;
	try {
		xmlhttp=new XMLHttpRequest();
	}catch (e) {
		xmlhttp = false;
		alert("Devido a versão do seu browser ser antiga, você não conseguirá realizar esta operação");
		}
	}
/*Fila de conexões - nessa fila existirá 4 parametros que irão fazer parte do vetor
1 - fila[ifila][0] - id - id do campo que vem da pagina que solicita no caso onde tem a função imput_xml(...)...
2 - fila[ifila][1] - link - aqui é a pagina que vem da imput_xml onde será executado o arquivo php
3 - fila[ifila][2] - funcao - essa função é a função que irá montar o combox ou listbox ou textarea...
4 - fila[ifila][3] - variavel - é a variável que vem pelo metodo POST unica no caso, é bom para mandar um texto longo tipo 
gerenciar conteudo
*/
fila=[];
ifila=0;
function imput_xml(id,link,funcao,variavel){
	//Adiciona à filaa

    fila[fila.length]=[id,link,funcao,variavel];
	 //Se não há conexões pendentes, executa
    if((ifila+1)==fila.length)ajaxRun();	
	
	
}
	
function ajaxRun(){
	 //Exibe o texto carregando no div conteúdo
	
    if(fila[ifila][0]=="area"){
		var conteudo=document.getElementById(fila[ifila][0])
    	conteudo.innerHTML='<div class="carregando">carregando...</div>'
	}
	xmlhttp.open("POST", fila[ifila][1],true);//chama pelo POST
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");//post
	xmlhttp.onreadystatechange=function() { 
        if (xmlhttp.readyState==4){//se tudo ok
		//	document.f.eval(fila[ifila][0]).value = xmlhttp.responseText;	
			//aqui ele precisa saber primeiro- qual função - depois o texto - depois o id - coloque alert no lugar do eval e veja
			 //Lê o texto
            var texto=xmlhttp.responseText
		
            //Desfaz o urlencode quem vem do php - echo(urlencode($men->nome)); ->buscamenu.php
            texto=texto.replace(/\+/g," ")
            texto=unescape(texto)
			//alert(fila[ifila][2]+"('"+texto+"','"+fila[ifila][0]+"')");
			eval(fila[ifila][2]+"('"+texto+"','"+fila[ifila][0]+"')");//eval(funcao(texto,id))
			ifila++
            if(ifila<fila.length)setTimeout("ajaxRun()",20)//aqui ele espera uns milisegundo e chama denovo, para não travar
		}
	}
xmlhttp.send("n=" + fila[ifila][3]);//executa passando o metodo post, se fosse get seria .send(null)
}