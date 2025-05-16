<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM ce_usuario WHERE CodUsuario=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Usuário excluido com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao
if(isset($_GET["id"])) {
$id_pesquisa = $_GET["id"];
}
?>
<style>
    .td_padding {
        padding: 10px;
    }
    
    textarea {
        font-family: Arial, Verdana;
        font-size: 12px;
        color: #727272;
    }
    
</style>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<script type="text/javascript" src="js/ordem.js"></script>
<script type="text/javascript">
function ultimoid() {
    $.ajax({
    	url: 'pc_ordem.php',
    	type: 'POST',
    	data: ({
    		ultimo_id: 1
    	}),	
        success: function(data){
    		total_id = data;					
    	}			  
    });  
}

tab_id = '';

$(document).ready(function() {
    $("#bt_salvar").hide();
    $("#bt_cancelar").hide();

    ultimoid();
    // Initialise the table
     $('#tabela').tableDnD({
        onDragClass: "myDragClass",
        onDrop: function(table, row) {
            $("#loading").fadeIn('fast');
            ordem_obtida = $.tableDnD.serialize();
            ordem = ordem_obtida.split("&");
            ordem_final = "";
            for(i = 0; i < ordem.length; i++) {
                ordem_filtro = ordem[i].replace("tabela[]=","");
                ordem_final += ordem_filtro+'|';
            }
            $.ajax({
				url: 'pc_ordem.php',
				type: 'POST',
				data: ({
					ordem: ordem_final
				}),	
                success: function(data){
                    $("#loading").fadeOut('fast');
            	}
             });  
        },
        dragHandle: ".dragHandle"
    });    
    
    ocupado = false;
});

function adicionar_questao() {  
    
    ocupado = true;
    var total_questoes = $("#questoes tr").length;
    tab_id = (Number(total_id)+Number(1));
    var nova_questao = '<tr id="tab-'+tab_id+'" class="cel_fonte"><td colspan="4"><div class="td_padding">';
    nova_questao += '<strong>Questão: </strong><br /><textarea id="input_novaquestao" class="input_texto" style="width: 50%; height: 70px;"></textarea><br />';
    nova_questao += '<strong>Tipo: </strong><input type="radio" value="Aberto" id="tipo_ab" name="tipo_questao_'+(total_questoes+1)+'" onclick="aberto();" /> Aberto <input type="radio" id="tipo_fc" value="Fechado" name="tipo_questao_'+(total_questoes+1)+'" onclick="fechado()" /> Fechado';
    nova_questao += '<span id="fechado"><span id="alternativas"></span><div><button class="input_botao" onclick="adicionar_alternativa('+(total_questoes+1)+')" style="margin-top: 5px;">Adicionar Alternativa</button></div></span>';
    nova_questao += '</div></td></tr>';
    
    $("#questoes").append(nova_questao);
    $("#fechado").hide();
    $("#bt_novaquestao").hide();
    $("#bt_salvar").show();
    $("#bt_cancelar").show();
    
    $("#tabela tbody tr").mouseover(function() {
        $(this).removeClass("tabs").addClass("tabs");
    }).mouseout(function(){
        $(this).removeClass("tabs");
    });        
}

function cancelar_questao() {
    ocupado = false;
    var total_questoes = $("#questoes tr").length;
    $("#tab-"+tab_id).remove();
    $("#bt_novaquestao").show();
    $("#bt_salvar").hide();
    $("#bt_cancelar").hide();
}

function adicionar_alternativa(id,valor,campo,ids) {
    if(typeof(valor)==='undefined') { valor = ''; };
    if(typeof(campo)==='undefined') { campo = ''; };
    var estaMarcado = "";
    if(campo == '1') { estaMarcado = "checked"; } 
    var total_alternativas = $("#alternativas .input_texto").length;
    $("#alternativas").append('<div id="alter_'+(total_alternativas+1)+'" style="margin-top: 3px;"><a onclick="remover_alternativa('+(total_alternativas+1)+','+id+')" style="margin-right: 5px;cursor: pointer;"><img src="imagens/x.png" width="10" /></a>Alternativa <span class="altnum">'+(total_alternativas+1)+'</span>: <input type="text" value="'+valor+'" class="input_texto" altid="'+ids+'" id="alt_'+(total_alternativas+1)+'" style="width: 450px" /> <input type="checkbox" value="1" id="campo_'+(total_alternativas+1)+'" '+estaMarcado+' /> Com campo digitável</div>');
}

function remover_alternativa(id,alt) {
    if(confirm("Tem certeza que deseja apagar esta alternativa?")) {
        $("#alter_"+id).remove();
        j = 1;
        $("#alternativas .altnum").each(function (i) {
            $(this).html(j);
            $(this).next().attr("id","alt_"+j);
            $(this).next().next().attr("id","campo_"+j);
            $(this).prev().attr("onclick","remover_alternativa("+j+","+id+")")
            $(this).parent().attr("id","alter_"+j);
            j++;
        })
    }
}

function salvar_questao() {
    var total_questoes = $("#questoes tr").length;    
    if($("#input_novaquestao").val() != "" && $('input[name=tipo_questao_'+(total_questoes)+']:checked').val() != undefined) {
    $("#loading").fadeIn('fast');
    var total_alternativas = $("#alternativas .input_texto").length;
    var alts = "";
    var camps = "";
    var campval = 0;
    for(k = 1; k <= total_alternativas; k++) {
        alts += $("#alternativas #alt_"+k).val()+"|||";
        if($("#alternativas #campo_"+k+":checked").val() !== undefined){ campval = 1; } else { campval = 0; }
        camps += campval+"|||";
    }
    
    var quest = $("#input_novaquestao").val();
    var tipo_quest = $('input[name=tipo_questao_'+(total_questoes)+']:checked').val();
       
    
    $.ajax({
    	url: 'pc_pergunta_insert.php',
    	type: 'POST',
    	data: ({
            id_pesq: <?=$id_pesquisa?>,
    		questao: quest,
            tipo: tipo_quest,
            alts: alts,
            camps: camps      
    	}),	
        success: function(data){
		    ultimoid();	
            cancelar_questao();
            $("#questoes").append('<tr class="cel_fonte" id="tab-'+((Number(total_id)+Number(1)))+'"><td width="26" align="center" class="dragHandle"><img src="imagens/updown.png"></td><td align="left" style="padding-left: 10px; padding-right: 10px;">'+quest+'</td><td width="60" align="center">'+tipo_quest+'</td><td width="1%" nowrap="" align="center"><a class="editbt" onclick="editar_pergunta('+((Number(total_id)+Number(1)))+')" style="cursor: pointer;"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a><a class="delbt" onclick="apagar_pergunta('+((Number(total_id)+Number(1)))+')" style="cursor: pointer;"><img src="imagens/icon_apagar.gif" alt="Apagar" border="0"></a></td></td></tr>');
            
            $('#tabela').tableDnD({
                onDragClass: "myDragClass",
                onDrop: function(table, row) {
                    $("#loading").fadeIn('fast');
                    ordem_obtida = $.tableDnD.serialize();
                    ordem = ordem_obtida.split("&");
                    ordem_final = "";
                    for(i = 0; i < ordem.length; i++) {
                        ordem_filtro = ordem[i].replace("tabela[]=","");
                        ordem_final += ordem_filtro+"|";
                    }
                    $.ajax({
        				url: 'pc_ordem.php',
        				type: 'POST',
        				data: ({
        					ordem: ordem_final
        				}),
                        success: function(data){
                            $("#loading").fadeOut('fast');
                    	}
        		   });  
                },
                
                dragHandle: ".dragHandle"
            });
            
            $("#loading").fadeOut('fast');
    	}			  
    });  

    } else {
        alert("É necessário digitar uma pergunta e escolher um tipo.");
    }
}

function apagar_pergunta(id) {
    
    if(confirm("Tem certeza que deseja pagar esta pergunta e todas suas alternativas?")) {
    $("#loading").fadeIn('fast');
    $("#tab-"+id).remove();
    $.ajax({
		url: 'pc_pergunta_delete.php',
		type: 'POST',
		data: ({
			id: id
		}),				  
   });  
   $("#loading").fadeOut('fast');
   }
}

cancelar_quest = "";
function editar_pergunta(id) {
    
    if(ocupado == false) {
        $("#loading").fadeIn('fast');
    ocupado = true;    
    var total_questoes = $("#questoes tr").length;    
    var total_alternativas = $("#alternativas .input_texto").length;
    $.ajax({
		url: 'pc_pergunta_update.php',
		type: 'POST',
		data: ({
			id: id
		}),
       success: function(data) {       
           var respostas = data.split("|||");
           var perg = respostas[0];
           var tipo = respostas[1];
           var resp = respostas[2];
           var camp = respostas[3];
           var ids = respostas[4];
           
           var isFechado = "";
           var isAberto = "";
           
           if(tipo == "Fechado") { isFechado = "checked"; } else { isAberto = "checked"; }
           cancelar_quest = perg;
           var edit_questao = '<td colspan="4"><div class="td_padding">';
           edit_questao += '<strong>Questão: </strong><br /><textarea id="input_novaquestao" class="input_texto" style="width: 50%; height: 70px">'+perg+'</textarea><br />';
           edit_questao += '<strong>Tipo: </strong><input type="radio" value="Aberto" name="tipo_questao_'+id+'" onclick="aberto();" '+isAberto+' /> Aberto <input type="radio" value="Fechado" name="tipo_questao_'+id+'" onclick="fechado()" '+isFechado+' /> Fechado';
           edit_questao += '<span id="fechado"><span id="alternativas"></span><div><button class="input_botao" onclick="adicionar_alternativa('+id+')" style="margin-top: 5px; margin-left: 0px;">Adicionar Alternativa</button></div></span>';
           edit_questao += '<div style="margin-top: 5px; "><button id="bt_salvar" class="input_botao" onclick="salvar_edicao(\''+id+'\');" style="margin-left: 0px; margin-right: 5px;">Salvar</button><button id="bt_cancelar" class="input_botao" onclick="cancelar_edicao(\''+id+'\',\''+tipo+'\');">Cancelar</button></div>';
           edit_questao += '</div></td>';

           $("#tab-"+id).html(edit_questao);
                       
           if(tipo != "Fechado") { $("#fechado").hide(); }
           
           $("#bt_novaquestao").hide();
           $("#bt_salvar_edita").show();
           $("#bt_cancelar_edita").show();
        
           var resp_alt = resp.split("&&&");
           var camp_alt = camp.split("&&&");
           var ids = ids.split("&&&");
           
           for(j = resp_alt.length-2; j >= 0; j--) {
             adicionar_alternativa(id,resp_alt[j],camp_alt[j],ids[j]);
           }
           
           var total_questoes = $("#questoes tr").length;
           $("#loading").fadeOut('fast');
       }				  
   });
   } else {
    alert("Termine a ação atual.");
   }
}

function salvar_edicao(id) {
    cancelar_quest = $("#input_novaquestao").val();
    $("#loading").fadeIn('fast');
    var total_questoes = $("#questoes tr").length;
    var total_alternativas = $("#alternativas .input_texto").length;
    var alts = "";
    var ids_alts = "";
    var camps = "";
    var campval = 0;
    for(k = 1; k <= total_alternativas; k++) {
        alts += $("#alternativas #alt_"+k).val()+"|||";
        ids_alts += $("#alternativas #alt_"+k).attr("altid")+"|||";
        if($("#alternativas #campo_"+k+":checked").val() !== undefined){ campval = 1; } else { campval = 0; }
        camps += campval+"|||";
    }
    
    var quest = $("#input_novaquestao").val();
    var tipo_quest = $('input[name=tipo_questao_'+id+']:checked').val();
    
    $.ajax({
		url: 'pc_pergunta_update_salva.php',
		type: 'POST',
		data: ({
            id: id,
			questao: quest,
            tipo: tipo_quest,
            alts: alts,
            camps: camps,
            ids_alts: ids_alts
            
		}),
       success: function(data) {       
           cancelar_edicao(id,tipo_quest);

           $('#tabela').tableDnD({
                onDragClass: "myDragClass",
                onDrop: function(table, row) {
                    ordem_obtida = $.tableDnD.serialize();
                    ordem = ordem_obtida.split("&");
                    ordem_final = "";
                    for(i = 0; i < ordem.length; i++) {
                        ordem_filtro = ordem[i].replace("tabela[]=","");
                        ordem_final += ordem_filtro+"|";
                    }
                    $.ajax({
        				url: 'pc_ordem.php',
        				type: 'POST',
        				data: ({
        					ordem: ordem_final
        				}),				  
        		   });  
                },
                
                dragHandle: ".dragHandle"
            });
            
            $("#loading").fadeOut('fast');
       }				  
   });

}

function cancelar_edicao(id,tipo_quest) {
    ocupado = false;
    $("#tab-"+id).html('<td width="26" align="center" class="dragHandle"><img src="imagens/updown.png"></td><td align="left" style="padding-left: 10px; padding-right: 10px;">'+cancelar_quest+'</td><td width="60" align="center">'+tipo_quest+'</td><td width="1%" nowrap="" align="center"><a class="editbt" onclick="editar_pergunta('+id+')" style="cursor: pointer;"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a><a class="delbt" onclick="apagar_pergunta('+id+')" style="cursor: pointer;"><img src="imagens/icon_apagar.gif" alt="Apagar" border="0"></a></td></td>');
    $("#bt_novaquestao").show();
}

function fechado() {
    $("#fechado").show();
}

function aberto() {
    $("#fechado").hide();
}

</script>
<body>
<style>
.dragHandle:hover {
    cursor: row-resize;    
}

.input_botao {
    background-color: #EEE; border: 1px solid #B4B4B4; padding: 5px; color: #727272;
}

</style>
<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/titulo_perguntas.jpg" alt="Cadastro de Usu&aacute;rios" /><br />
                <div style="font-size: 12px; font-family: Arial; margin: 10px 0px 10px 0px"><strong>Importante:</strong> Caso a pesquisa tenha iniciado, não apague as alternativas (pode apenas alterar o texto ou adicionar novas alternativas). Caso uma alternativa seja apagada, os dados coletados para a alternativa apagada serão perdidos.</div>
                <br />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" id="tabela" cellspacing="3" style="margin-top: 22px;">
                <thead>
					<tr height="30">
						<td align="center"></td>
                        <td align="center">Pergunta</td>
						<td align="center">Tipo</td>
						<td align="center">A&ccedil;&otilde;es</td>
					</tr>
                </thead>
                <tbody id="questoes">
			<?
				$sql = "SELECT * FROM pc_pergunta WHERE id_pesquisa = '$id_pesquisa' ORDER BY ordem ASC";
				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" id="tab-<?=$linha["id"]?>" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" width="26" class="dragHandle"><img src="imagens/updown.png" /></td>
                        <td align="left" style="padding-left: 10px; padding-right: 10px;" ><?=$linha["pergunta"];?></td>
                        <td align="center" width="60"><?=$linha["tipo"]?></td>
						<td align="center" width="1%" nowrap>
							<a class="editbt" onclick="editar_pergunta('<?=$linha["id"]?>')" style="cursor: pointer;"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
							<a class="delbt" onclick="apagar_pergunta('<?=$linha["id"]?>')" style="cursor: pointer;"><img src="imagens/icon_apagar.gif" alt="Apagar" border="0"></a></td>
					</tr>
                    
				<?
                $i++;
				}
				?>
                </tbody>
				</table>
                <div>
                    <button id="bt_novaquestao" class="input_botao" onclick="adicionar_questao();">Adicionar Pergunta</button>
                    <button id="bt_salvar" class="input_botao" onclick="salvar_questao();" style="margin-left: 3px;">Salvar</button>
                    <button id="bt_cancelar" class="input_botao" onclick="cancelar_questao();">Cancelar</button>
                </div>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			

				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->

<div id="loading" style="width: 100%; height: 100%; font-size: 42px; font-weight: bold; text-align: center; position: fixed; top: 0px; left: 0px; z-index: 99999; background: url('http://appweb.com.br/pesquisa/img/fundo_transp.png'); display: none;">
<div style="margin-top: 250px; background: #FFF; width: 565px; padding-top: 20px; height: 75px; margin-left: auto; margin-right: auto; font-family: Arial, Verdana;"><img src="http://appweb.com.br/pesquisa/img/ajax-loader.gif" /> Carregando</div>
</div>
<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>