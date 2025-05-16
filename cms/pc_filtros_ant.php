<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

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
				<img src="imagens/barra_gera_ticket.gif" alt="Geração de Tickets" />
			</div>
            <? $id_pesq = $_GET["id"]; ?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<form action="pc_chart_pdf.php?id_pesquisa=<?=$id_pesq?>" method="post"  name="tickets" target="_blank">
				
                <input type="hidden" value="<?= $id_pesquisa ?>" name="id_pesquisa" />
                
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
                <script>
                    $(document).ready(function() {
                        tam = 1;
                        
                        adicionar_filtro_html = $("#filtro_html").html();
                        $("#filtro_html").remove();
                    })
                </script>
                <span id="filtro_html" style="display: none;">
                    <div id="linha_form">
    					<div id="label"> <span class="label_fonte">Pergunta: </span> </div>
    
                        <select style="font-size: 10px; width: 700px" name="perg_xxx" id="perg_xxx" onchange="get_alternativa(xxx,this.value)">
                              <option value="">Selecione</option>         
                            <?php
                               
                                $sql = mysql_query("SELECT perg.id, perg.pergunta FROM pc_pesquisa p LEFT JOIN pc_pergunta perg ON perg.id_pesquisa = p.id WHERE p.id = '$id_pesq' and perg.tipo = 'Fechado' ORDER BY perg.ordem ASC");
                                while($perg = mysql_fetch_array($sql)) {
                            ?> 
                              <option value="<?=$perg["id"]?>"><?=$perg["pergunta"]?></option>                       
                            <? } ?>
                        </select>
    				</div>
                    
                    <div id="linha_form">
    					<div id="label"> <span class="label_fonte">Alternativa: </span> </div>
    
                        <select name="alt_xxx" id="alt_xxx">
                            <option value="">Selecione</option> 
                        </select> 
    				</div>
                    <hr />
                </span>
                
                <div id="linha_form">
					<div id="label" style="width: 275px"> <span class="label_fonte">Incluir respostas abertas: </span> </div>
                    <input type="checkbox" name="fechadas" value="1" checked="1" />
				</div>
    
                <div id="linha_form">
					<div id="label" style="width: 275px;"> <span class="label_fonte">Incluir respostas fechadas: </span> </div>
                    <input type="checkbox" name="abertas" value="1" checked="1" />
				</div>
                
                <div id="linha_form">
					<div id="label" style="width: 275px"> <span class="label_fonte">Exibir alternativas abertas: </span> </div>
                    <input type="checkbox" name="exibir_abertas" value="1" checked="1" />
				</div>
                
                <div id="linha_form">
					<div id="label" style="width: 275px;"> <span class="label_fonte">Incluir participantes em andamento: </span> </div>
                    <input type="checkbox" name="em_andamento" value="1" checked="1" />
				</div>
            
            	<div id="filtro_pergunta">
                        <div id="linha_form">
        					<div id="label"> <span class="label_fonte">Pergunta: </span> </div>
        
                            <select style="font-size: 10px; width: 700px" name="perg_0" id="perg_0" onchange="get_alternativa(0,this.value)">
                                  <option value="">Selecione</option>         
                                <?php
                                
                                    $iduser = $_SESSION["id_usuario_adm"];
                                    $sql = mysql_query("SELECT perg.id, perg.pergunta FROM pc_pesquisa p LEFT JOIN pc_pergunta perg ON perg.id_pesquisa = p.id WHERE p.id = '$id_pesq' and perg.tipo = 'Fechado' ORDER BY perg.ordem ASC");
                                    while($perg = mysql_fetch_array($sql)) {
                                ?>
                                  <option value="<?=$perg["id"]?>"><?=$perg["pergunta"]?></option>                       
                                <? } ?>
                            </select>
        				</div>
                        
                        <div id="linha_form">
        					<div id="label"> <span class="label_fonte">Alternativa: </span> </div>
        
                            <select name="alt_0" id="alt_0">
                                <option value="">Selecione</option>
                            </select> 
        				</div>
                        <hr />
                </div>
                <button type="button" onclick="adicionar_filtro()">Adicionar Filtro</button>
                
                <script>
                    filtro_num = 0;
                    function adicionar_filtro(id) {
                        filtro_num++;
                        var filtro_atual = adicionar_filtro_html;
                        filtro_atual = filtro_atual.replace("perg_xxx","perg_"+filtro_num);
                        filtro_atual = filtro_atual.replace("alt_xxx","alt_"+filtro_num);
                        filtro_atual = filtro_atual.replace("perg_xxx","perg_"+filtro_num);
                        filtro_atual = filtro_atual.replace("alt_xxx","alt_"+filtro_num);
                        filtro_atual = filtro_atual.replace("get_alternativa(xxx","get_alternativa("+filtro_num);
                        
                        $("#filtro_pergunta").append(filtro_atual);
                        tam++;
                        $("#tam").val(tam);
                    }
                
                    function get_alternativa(id, id_perg) {
                        $.ajax({
                        	url: 'pc_pega_alternativas.php',
                        	type: 'POST',
                        	data: ({
                                id_perg: id_perg
                        	}),	
                            success: function(data){
                                $("#alt_"+id).html('<option value="">Selecione</option>');			
                        		$("#alt_"+id).append(data);				
                        	}			  
                        });  
                    }
                </script>
                          
                <input type="hidden" id="tam" name="tam" value="1" />
                                
                <p align="center"><input type="submit" value="Gerar" class="form_style"></p>
                
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
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


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
</html>