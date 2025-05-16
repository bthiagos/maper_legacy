$(document).ready(function() {
    $("#nascimento").mask("99/99/9999");
    $("#cpf").mask("999.999.999-99");
    if($("#organizacao").val() != "") {
        getGrupos($("#organizacao").val());
    }
})

function somente_numero(campo){  
 var digits="0123456789"  
 var campo_temp   
     for (var i=0;i<campo.value.length;i++){  
         campo_temp=campo.value.substring(i,i+1)   
         if (digits.indexOf(campo_temp)==-1){  
             campo.value = campo.value.substring(0,i);  
         }  
     }  
 }

function getGrupos(id) {
    $("#grupo").html("<option value=''>(carregando grupos...)</option>");
    $.ajax({ 
		url: 'aplicacao_ajax/getGrupos.php',
		type: 'POST',
		data: ({
			id: id
		}),
        
		 success: function(data){
	     if(data != "fail") {
		    $("#grupo").removeAttr("disabled");
            $("#grupo").html('<option value="" selected="selected">(escolha)</option>');
		    $("#grupo").append(data);
         } else {
            $("#grupo").html('<option value="" selected="selected">(escolha uma organização)</option>');
            $("#grupo").attr("disabled",true);
         }
		}					  
   });   
}

function retiraAcento(strToReplace) {
    str_acento= "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
    str_sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
    var nova="";
    for (var i = 0; i < strToReplace.length; i++) {
    if (str_acento.indexOf(strToReplace.charAt(i)) != -1) {
    nova+=str_sem_acento.substr(str_acento.search(strToReplace.substr(i,1)),1);
    } else {
    nova+=strToReplace.substr(i,1);
    }
    }
    return nova;
}

function validacpf(cpf){
      var numeros, digitos, soma, i, resultado, digitos_iguais;
      digitos_iguais = 1;
      if (cpf.length < 11)
            return false;
      for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
                  {
                  digitos_iguais = 0;
                  break;
                  }
      if (!digitos_iguais)
            {
            numeros = cpf.substring(0,9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                  soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0))
                  return false;
            numeros = cpf.substring(0,10);
            soma = 0;
            for (i = 11; i > 1; i--)
                  soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1))
                  return false;
            return true;
            }
      else
            return false;
}

function valida(formulario,campos) {
	ok = 1;
	msg = "";
	
    
	campo = campos.split("|");
	
	for(i = 0; i < campo.length; i++) {
	    $("#debug").append(campo[i]+'\n');
        campo_id = retiraAcento(campo[i]);
        
	    campo_valor = $("#"+formulario+" "+"#"+campo_id).val();
        campo_objeto = "#"+formulario+" "+"#"+campo_id;
        $("#erro_"+i).remove();
        $(campo_objeto).css("border","1px solid #CCC");
        
        if(campo_id == "telefone") {
            if(campo_valor == "" || $("#ddd").val() == "") {
                ok = 0;
				msg = "Campo obrigatório!";
                
                if(campo_valor == "") {
                    $(campo_objeto).css("border","1px solid #CD0000");
                }
                $(campo_objeto).after("<span id='erro_"+i+"' style='color: #CD0000;'> * "+msg+"</span>");
            } 
        }
        
        
        if(campo_valor == "" && campo_id != "telefone") {
			ok = 0;
			msg = "Campo obrigatório!";
            $(campo_objeto).css("border","1px solid #CD0000");
            if(campo_id != "ddd") {
                $(campo_objeto).after("<span id='erro_"+i+"' style='color: #CD0000;'> * "+msg+"</span>");
            } 
		} else {
            
		     
		    if(campo[i] == "email") {
                er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
                if(!er.exec(campo_valor)) {
                    ok = 0;
                    msg = "O e-mail é inválido.\n";
                    $(campo_objeto).css("border","1px solid #CD0000");
                    $(campo_objeto).after("<span id='erro_"+i+"' style='color: #CD0000;'> * "+msg+"</span>");
                }
            }
            
            if(campo[i] == "nascimento") {
                var today = new Date();
                var yy = today.getFullYear();
                var mm = today.getMonth()+1; //January is 0!
                var nasc = campo_valor;
                var nasc_div = nasc.split("/");
                var dia = nasc_div[0];
                var mes = nasc_div[1];
                var ano = nasc_div[2];
                if(dia > 31 || mes > 12 || ano > (yy-10)) {
                    ok = 0;
                    msg = "Data de nascimento inválida.\n";
                    $(campo_objeto).css("border","1px solid #CD0000");
                    $(campo_objeto).after("<span id='"+i+"' style='color: #CD0000;'> * "+msg+"</span>");
                }
            }
            
            if(campo[i] == "cpf") {
                campo_valor = campo_valor.replace(".","");
                campo_valor = campo_valor.replace(".","");
                campo_valor = campo_valor.replace("-","");
                if(!validacpf(campo_valor)) {
                    ok = 0;
                    msg = "O CPF é inválido.\n";
                    $("#erro_cpf").remove();
                    $(campo_objeto).css("border","1px solid #CD0000");
                    $(campo_objeto).after("<span id='erro_cpf' style='color: #CD0000;'> * "+msg+"</span>");
                } else {
                    
                    $.ajax({
                		url: 'aplicacao_ajax/cpf.php',
                		type: 'POST',
                		data: ({
                            cpf:campo_valor       
                		}),
                       success: function(data) {
                            $("#erro_cpf").remove();
                            if(data == "cpf_proibido") {
                                ok = 0;
                                msg = "O CPF inserido já efetuou esta aplicação nos últimos seis meses.";
                                $(campo_objeto).css("border","1px solid #CD0000");
                                $(campo_objeto).after("<span id='erro_cpf' style='color: #CD0000;'> * "+msg+"</span>");
                            }
                       }				  
                   });
                   
                }
            }
                        
             
            if(campo[i] == "ticket") {
                $("#erro_ticket").remove();
                $("#erro_ticket").css("border","1px solid #CCC");               
                if($("#organizacao").val() == "" || $("#grupo").val() == "") {
                    ok = 0;
                    msg = "Escolha uma Organização e Grupo.";
                    $(campo_objeto).css("border","1px solid #CD0000");
                    $(campo_objeto).after("<span id='erro_ticket' style='color: #CD0000;'> * "+msg+"</span>");
                } else {
                    $.ajax({
                		url: 'aplicacao_ajax/ticket.php',
                		type: 'POST',
                		data: ({
                            ticket:campo_valor,
                            organizacao: $("#organizacao").val(),
                            grupo: $("#grupo").val()
                		}),
                       success: function(data) {
                            if(data != "liberado") {
                                ok = 0;
                                $(campo_objeto).css("border","1px solid #CD0000");
                                $(campo_objeto).after("<span id='erro_ticket' style='color: #CD0000;'> * "+data+"</span>");
                            } else {
                                if(ok) { $("#formulario").submit(); }
                            }
                       }				  
                   });
               }
            }
		}
	}
	
	
}

// SLIDER SLIDER SLIDER SLIDER

$(document).ready(function(){
    $("#fim").hide();
    $("#load").hide();
    $("#load2").hide();
    $("#protocolo_invalido").hide();   
    //$("#perfil").hide();
	qtd_slides = $("#slider li").length;
	slide_atual = 0;
	$("#ant").css("opacity", "0.5");
	largura = $("#slider").css("width");
	//var altura = $("#slider").css("height");        
    var conteudo_altura = $("#conteudo_slider").css("height");
    var altura = conteudo_altura + 20;

	$("#slider li").css("width",largura);
	$("#slider li").css("height",altura);
    $("#slider_wrapper").css("height",altura);
    
    //Recupera respostas
    var respostas = $("#respostas").val();
    if(respostas != "") {
        if(respostas.length >= 100) {
            $("#perfil").hide();
            $("#protocolo_invalido").show();    
        } else {
            ir_para_slide(respostas.length + 1);
            $("#atual").html(respostas.length + 1);
            for(p = 0; p < respostas.length; p++) {
                $(".q_"+p).each(
                    function() {
                        if($(this).val() == respostas[p]) {
                            $(this).attr("checked",true);
                        }
                    }
                )
            }
        }
    }
});

function ir_para_slide(slide_num) {
	var slide_atual_plus = slide_atual + 1;
	var diferenca = slide_num - slide_atual_plus;
	var largura_sempx = largura.replace('px', '');
	var largura_avanca = Math.abs(diferenca) * largura_sempx;
	
	if($('#slider:animated').length == 0) {
		if(diferenca != 0) {			
			if(diferenca < 0) {
				$("#slider").animate({"margin-left": "+="+largura_avanca}, 500);
			} else {
				$("#slider").animate({"margin-left": "-="+largura_avanca}, 500);
			}
			slide_atual = (slide_num - 1);
		}
	}
}

function respondeu(qual,nome,email,telefone,cpf,nascimento,organizacao,grupo,cargo,tempo,resposta,ordem,protocolo,ticket) {
	$("#slider_nav_"+qual).addClass("respondido");	
    $("#load").fadeIn('fast');
    
    $.ajax({
		url: 'aplicacao_ajax/resposta.php',
		type: 'POST',
		data: ({
            nome: nome,
            email: email,
            telefone: telefone,
            cpf: cpf,
            nascimento: nascimento,
            organizacao: organizacao,
            grupo: grupo,
            cargo: cargo,
            tempo: tempo,
            resposta: resposta,
            ordem: ordem,
            protocolo: protocolo,
            ticket: ticket
		}),
       success: function(data) {
            
            $("#load").fadeOut('fast');
            if(slide_atual != qtd_slides-1) {
        		ir_para_slide(qual+2);
        	     $("#atual").html(Number($("#atual").html()) + 1);
            } else {
                $("#load2").fadeIn('fast');
                $.ajax({ 
            		url: 'aplicacao_ajax/inserir_aplicacao.php',
            		type: 'POST',
            		data: ({
            			nome: nome,
                        email: email,
                        telefone: telefone,
                        cpf: cpf,
                        nascimento: nascimento,
                        organizacao: organizacao,
                        grupo: grupo,
                        cargo: cargo,
                        tempo: tempo,
                        resposta: resposta,
                        ordem: ordem,
                        protocolo: protocolo,
                        ticket: ticket
            		}),
                    
           		    success: function(data){
           		        $("#load2").fadeOut('fast');
            	        $("#perfil").hide();
                        $("#fim").show();
            		}					  
               });   
                
            }
            
       }				  
    });
    
	
}


perg_array = "";

//TIMER

$(document).ready(function() {
    var tempo_normal = $("#tempo").val();
    
    if(tempo_normal != "") { 
        tempo_normal = tempo_normal.split(":");
        var minuto = tempo_normal[0] * 6000;
        var segundo = tempo_normal[1] * 100;
        var tempo = Number(minuto) + Number(segundo);
        
        var startstopTimer, startstopCurrent = tempo;
    	startstopTimer = $.timer(function() {
    		var min = parseInt(startstopCurrent/6000);
    		var sec = parseInt(startstopCurrent/100)-(min*60);
    		var micro = pad(startstopCurrent-(sec*100)-(min*6000),2);
    		var output = "00"; if(min > 0) {output = pad(min,2);}
    		$('#timer').html(output+":"+pad(sec,2));
    		startstopCurrent+=7;
    	}, 70, true);
        
    }
});

function startstopReset() {
	startstopCurrent = 0;
	startstopTimer.stop().once();
}

// Padding function
function pad(number, length) {
	var str = '' + number;
	while (str.length < length) {str = '0' + str;}
	return str;
}

function valida_protocolo() {
    $("#protocolo").css("border","1px solid #CCC");
    $("#erro_protocolo").html("");
    
    if($("#protocolo").val() == "") {
        msg = "* Digite um protocolo.";
        $("#protocolo").css("border","1px solid #CD0000");
        $("#erro_protocolo").html(msg);
    } else {
        $.ajax({ 
    		url: 'aplicacao_ajax/protocolo.php',
    		type: 'POST',
    		data: ({
    			protocolo: $("#protocolo").val()
    		}),
            
    		success: function(data){
    	        if(data == "falha") {
    	           msg = "* O protocolo não existe.";
                    $("#protocolo").css("border","1px solid #CD0000");
                    $("#erro_protocolo").html(msg);
    	        } else {
                    $("#formulario_protocolo").submit();
    	        }
    		}					  
       });   
    }
}