<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

//echo __FILE__;
$actual_year = date("Y");
//echo phpinfo();
if($_SESSION["organizacaon"]){
	$organizacaon = $_SESSION["organizacaon"];
}

$userid = $_SESSION["id_usuario_adm"];
$getorg1 = mysql_query("SELECT organizacao FROM ce_usuario WHERE CodUsuario = '$userid'");
$getorg1 = mysql_fetch_array($getorg1);
$getorg1 = $getorg1["organizacao"];


// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM aplicacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

if($_GET["feito"] != "")
{
    alert("E-mail enviado com sucesso!");
    redireciona("?");
}

if($_GET["erro"] != "")
{
    alert("Erro! Confira se o e-mail é válido.");
    redireciona("?");
}


// --- FIM    Efetuando a exlcusao
//echo date("d/m/Y H:i:s");

if($_GET["corrigir"] == "sim") {
$sql = mysql_query("SELECT * FROM aplicacoes WHERE length(respostas) < 100");
while($linha = mysql_fetch_array($sql)) {
    $id = $linha["id"];
    $resp = $linha["respostas"];
    
    $resp2 = $resp;
    while(strlen($resp2) < 100) {
    $rand = rand(0,1);
    if($rand == 1) { $add = "a"; } else { $add = "b"; }
    $resp2 .= $add;
    }
    mysql_query("UPDATE aplicacoes SET respostas = '$resp2' WHERE id = '$id'");
}
}

?>



<?php				$where = "";
					//######### INICIO Paginação
				
					    $numreg = 110; // Quantos registros por página vai ser mostrado
					  if (!isset($pg)) {
					       $pg = 0;
					    }
					   $pg = $_REQUEST["pg"];
					    $inicial = $pg * $numreg;
					   
					//######### FIM dados Paginação
	function get_mes($mes) {  
	   switch ($mes) {
            case "01":    $mes = Janeiro;     break;
            case "02":    $mes = Fevereiro;   break;
            case "03":    $mes = Março;       break;
            case "04":    $mes = Abril;       break;
            case "05":    $mes = Maio;        break;
            case "06":    $mes = Junho;       break;
            case "07":    $mes = Julho;       break;
            case "08":    $mes = Agosto;      break;
            case "09":    $mes = Setembro;    break;
            case "10":    $mes = Outubro;     break;
            case "11":    $mes = Novembro;    break;
            case "12":    $mes = Dezembro;    break; 
        }
        return $mes;
	}	
    
    function data_formata($data) {
        $date = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
        return $date;
    }
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<script src="js/editinplace.js"></script>
<style type="text/css">

.pgoff {font-family: Aril, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a.pg {font-family: Arial, Arial, Helvetica; font-size:11px; color: #666666; text-decoration: none}
.pg{font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a:hover.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a:visited.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
</style>
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
        <? if($permissao == 99991) { ?>
		<script>
        
            function valida_fromto() {
              
                if($("#to").val() != "") {
                    if($("#from").val() == "") {
                        alert("Escolha uma data inicial.");
                        return false;
                    }
                }
            }
        
            $(document).ready(function() {
               
                    $("#grupo").attr("disabled",true);
                    get_grupos(<?=$_REQUEST["grupos"]?>);
            })
           
            function get_grupos(post) {
    
            value = $("#orgs").val();
            
            if(value) {
            if(post) {
                $("#grupo").removeAttr("disabled");
            }
            
            $.ajax({ 
    			url: 'pegar_grupos.php',
    			type: 'POST',
    			data: ({
    				id: value,
                    last: post
    			}),
                
    			 success: function(data){
    		     
    		     if(data != "fail") {
    			    $("#grupo").removeAttr("disabled");
                    $("#grupo").html('<option value="">Todos</option>');
    			    $("#grupo").append(data);
                 } else {
                    $("#grupo").html('<option value="">Todos</option>');
                    $("#grupo").attr("disabled",true);
                 }
    			}					  
    	   });            
                }
          }
        </script>
        <? } ?>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			
			<div style="width: 95%; margin-left: auto; margin-right: auto; text-align: right; margin-bottom: 7px; margin-top: -38px; font-family: Arial; font-size: 12px; ">
                Exibir relatórios em formato: <input type="radio" name="exportar" onclick="rel_pdf();" checked /> PDF<input type="radio" name="exportar" style="margin-left: 15px;" onclick="rel_word();" /> DOC
            </div>
            <script>
                $(document).ready(function() {
                    $(".word_export").hide();
                })
            
                function rel_pdf() {
                    $(".word_export").hide();
                    $(".pdf_export").show();
                }
                
                function rel_word() {
                    $(".pdf_export").hide();
                    $(".word_export").show();
                }
            </script>
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
            
			<div id="caixa_table">
            <?php
                if(!isset($_REQUEST["extrato"])) 
                {
            ?>			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center" width="50">Data</td>
						<td align="center">Nome</td>
						<td align="center">Nascimento</td>
						<td align="center">Tempo</td>
						<? if($permissao == "99991") {?><td align="center">Organização</td><? } ?>
						<td align="center" width="300">Grupo</td>
						<? if($permissao != "99991") {?><td align="center">Cargo</td><? } ?>
                        <td align="center">Perfil de Cargo</td>
						<td align="center">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
                if($_GET["ord"] != "")
                {
                    $ordenar = "aplicacoes.grupo, organizacoes.nome, aplicacoes.nome,";
                } else {
                    $ordenar = "";
                }
                
                
                if($permissao != 99991) {
                    if($where == "") { 
                       $where .= " WHERE aplicacoes.organizacao = '$getorg1'";
                    } else {
					   $where .= " and aplicacoes.organizacao >= '$getorg1'";
					}
                }

                $limite = "LIMIT ".$inicial.",".$numreg;
                
				$sql = "SELECT
				aplicacoes.id,
                aplicacoes.id_perfil,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
                aplicacoes.organizacao,
                str_to_date(nasc, '%d/%m/%Y') AS data_nasc, 
                year(str_to_date(nasc, '%d/%m/%Y')) as ano,
                aplicacoes.grupo,                
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
                grupos.id as grupoid,
				grupos.nome as grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio
				FROM 
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id 
				WHERE
				organizacao=194 and year(str_to_date(nasc, '%d/%m/%Y'))>1980
				ORDER BY $ordenar aplicacoes.data_aplic DESC
				";
				$result = mysql_query($sql);
				$i = $inicial;
				//echo $sql;

				
				//echo $sql2;
                $k= 0;
                $i= 0;
                
                ?>
				
                <script>
                    var tam = 0;
                </script>
                    
                
                <?
                while ($linha = mysql_fetch_assoc($result)) {
               
                $i++;
				$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta.php?id=".$linha["id"];
				$nome_session = "url_".$linha["id"];
				if($linha["nome"] != "" and $linha["grupo"] != "" and $linha["organizacao"] != "")
                {
                    
                $sql2 = mysql_query("SELECT * FROM perfil_cargos WHERE id_organizacao = '".$linha["id_orga"]."' ORDER BY cargo ASC") or die(mysql_error());
                $opts = "Nenhum,";
                while($perfil = mysql_fetch_array($sql2)) {
                    $opts .= $perfil["cargo"].",";
                }
                $opts = substr($opts,0,-1);
              
                
                    
                //$resultado_url = executa_url($url);
				//$_SESSION["$nome_session"] = $resultado_url;
				//echo $_SESSION[$nome_session];
				
			?>				
                    <script>
                        
                        $('.sendhow').click(function(){
            				if ($('input[type=radio][name=sendhow]:checked').val() == "Grupo"){
            					$('.candmail').hide();
            				}else{
            					
                                $('.candmail').show();
            				}
            			})
			
            			
                    </script>
            
                    <!-- OVERLAYS -->
                    <script>
                    $(document).ready(function() {
                        $("img[rel]").overlay({mask: '#000'});
                    });
                    </script>
                    
                    <div class="simple_overlay" id="mies<?=$k?>">
                    	<div style="padding: 10px;">
                        <form name="form" action="aplica_email_envia.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>&grupo=<?=$linha["grupoid"]?>" method="POST" onsubmit="return confere();">
                        <div style="clear: both; margin-bottom: 10px;margin-top: 50px"><img src="imagens/enviar_rel.jpg" /></div>
                    	   <div style="clear: both; border-top: 1px dotted #666; margin-top: 50px; margin-bottom: 10px;"></div>
                           
                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">
                               <b>Relatório: </b>
                           </div>
                           <div style="float: left; margin-left: 5px; margin-bottom: 15px;">
                               <select id="relatorio" name="relatorio">
                                   <option value="">Selecione</option>
                                   <option value="1">Relatório Base 10 com Gráficos</option>
                                   <option value="2">Relatório Base 10 sem Gráficos</option>
                                   <option value="4">Relatório Coaching com Gráfico</option>
                                   <option value="5">Relatório Coaching sem Gráfico</option>
                               </select>
                           </div>
                           <div style="clear: both; border-top: 1px dotted #666; margin-top: 0px; margin-bottom: 10px;"></div>
                           
                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">
                              <b>Enviar por:</b>
                           </div>
                           <div style="clear: both;"></div>
                           <div style="font-size: 12px; font-family: Arial, Verdana;">
                               <div><input type="radio" class="sendhow" name="sendhow" value="Grupo" /> Grupo - <?=$linha["orga"]?>, <?=$linha["grupo"]?></div>
                               <div style="margin-top: 5px;"><input type="radio" name="sendhow" value="Individual" class="sendhow" /> Individual - <?=$linha["nome"]?></div>
                           </div>   
                           
                           <div style="clear: both; border-top: 1px dotted #666; margin-top: 10px; margin-bottom: 10px;"></div>
                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">
                               <b>Enviar para:</b>
                           </div>
                           <div style="clear: both;"></div>
                           <div style="font-size: 12px; font-family: Arial, Verdana;">
                               <div><input type="radio" name="sendto" class="sendto" value="Candidato" /> Candidato<span class="candmail"> - Email: <input type="text" size="25" value="<?=$linha["email"]?>" name="mailcandidato" /></span></div>
                               
                               <div><input type="radio" name="sendto" class="sendto" value="Empresa" /> Empresa - Email:  <input type="text" name="mailempresa" size="26" /></div>
                           </div> 
                           <div style="text-align: center;"><input type="submit" value="    Enviar E-mail    " style="margin-top: 15px;" /></div>  
                    	</form>
                        </div>
                    </div>
                    <!-- OVERLAYS -->

					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i;?></td>
						<td align="center" ><?=$linha["databr"]?></td>
						<td align="left" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["data_nasc"]?></td>
						<td align="center" ><?=substr($linha["tempo"],3,5)?> </td>
						<? if($permissao == "99991") {?><td align="center" ><?=$linha["orga"]?> </td><? } ?>
						<td align="center" >
						
                        <?php
                            
                            $sql2 = mysql_query("SELECT * FROM grupos WHERE id_organizacao = '".$linha["id_orga"]."' ORDER BY nome ASC") or die(mysql_error());
                            //$opts2 = "Nenhum,";
                            $opts2 = "";
                            while($perfil = mysql_fetch_array($sql2)) {
                                $opts2 .= $perfil["nome"].",";
                            }
                            $opts2 = substr($opts2,0,-1);
                          
                        ?>
                        
                        <script>
                        $(document).ready(function(){
                            $("#edit_<?=$i?>").editInPlace({
                        		url: "grupos_salvar.php",
                                //callback: function(unused, enteredText) { return enteredText; },
                                params: "id=<?=$linha["id"]?>",
                        		field_type: "select",
                                show_buttons: true,
                                save_button: '<br /><a class="inplace_save">Salvar</a>',
                                cancel_button: '<a class="inplace_cancel">Cancelar</a>',
                        		select_options: "<?=$opts2?>"
                        	});
                         });
                        </script>
                        <p id="edit_<?=$i?>" >
                        
                        <?php
                            $perf = mysql_query("SELECT * FROM grupos WHERE id = '".$linha["grupoid"]."'");
                            if(mysql_num_rows($perf) == 0) {
                                echo "Nenhum";
                            } else {
                            $perf = mysql_fetch_array($perf);
                            echo $perf["nome"];
                            }
                        ?>
                        </p>
                        
                        <?
							
							
						?>
						</td>
                        
                        
                        
						<? if($permissao != "99991") {?><td align="center" ><?=$linha["cargo"]?> </td><? } ?>
                        <td align="center" >
                        <style>
                            .inplace_save {
                                cursor: pointer;
                            }
                            .inplace_cancel {
                                cursor: pointer;
                            }
                        </style>
                        
                        <script>
                        $(document).ready(function(){
                            $("#editme_<?=$i?>").editInPlace({
                        		url: "perfil_cargos_salvar.php",
                                //callback: function(unused, enteredText) { return enteredText; },
                                params: "id=<?=$linha["id"]?>",
                        		field_type: "select",
                                show_buttons: true,
                                save_button: '<br /><a class="inplace_save">Salvar</a>',
                                cancel_button: '<a class="inplace_cancel">Cancelar</a>',
                        		select_options: "<?=$opts?>"
                        	});
                         });
                        </script>
                        <p id="editme_<?=$i?>" >
                        
                        <?php
                            $perf = mysql_query("SELECT * FROM perfil_cargos WHERE id = '".$linha["id_perfil"]."'");
                            if(mysql_num_rows($perf) == 0) {
                                echo "Nenhum";
                            } else {
                            $perf = mysql_fetch_array($perf);
                            echo $perf["cargo"];
                            }
                        ?>
                        </p>
  
                        
                        </td>
						<td align="center" width="1%" nowrap>
							
							<!-- Gráfico coletivo por montagem de grupo 
							<a href="grupoMont.php" target="_blank"><img src="imagens/grupoMont.png" width="25px" height="25px" title="Gráfico coletivo por montagem de grupo" alt="Gráfico coletivo por montagem de grupo" border="0"></a> 
							
							
							
							Gráfico total de um determinado grupo
							<a href="grupoDet.php?grupo=<?php echo $linha["id_orga"];?>&orga=999999" target="_blank"><img src="imagens/grupoDet.png" width="25px" height="25px" title="Gráfico total de um determinado grupo" alt="Gráfico total de um determinado grupo" border="0"></a> 
							 Icone pdf vendido sem grafico -->
							<span class="word_export">	
								<!-- Icone pdf vendido com grafico -->
							<a href="pdf_vendido_word.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_grafB10.jpg" title="Relatório Base 10 c/ Gráficos" alt="Relatório Base 10 c/ Gráficos" border="0"></a> 
							<!-- Icone pdf vendido com grafico -->
							
							
							<!-- Icone pdf vendido sem grafico -->
							<a href="pdf_vendido_word.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdfB10.jpg" title="Relatório Base 10 s/ Gráficos" alt="Relatório Base 10 s/ Gráficos" border="0"></a> 
							<!-- Icone pdf vendido sem grafico -->
							
							
                            
							<!-- Icone de edicao -->
							<!--<a href="form_laudo.php?alterar=1&cod=<?=$linha["id"]?>" target="_blank">
								<img src="imagens/icon_gerar_laudo.gif" title="Formulário de Avaliação de Perfil de Cargo" alt="Formulário de Avaliação de Perfil de Cargo" border="0"></a>
                            -->
							
							<a href="testepdf_word.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Relatório Coaching c/ Gráficos" alt="Relatório Coaching c/ Gráficos" border="0"></a> 

							<a href="testepdf_word.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdf.jpg" title="Relatório Coaching s/ Gráficos" alt="Relatório Coaching s/ Gráficos" border="0"></a> 
							</span>
                            
                            <span class="pdf_export">	
								<!-- Icone pdf vendido com grafico -->
							<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_grafB10.jpg" title="Relatório Base 10 c/ Gráficos" alt="Relatório Base 10 c/ Gráficos" border="0"></a> 
							<!-- Icone pdf vendido com grafico -->
							
							
							<!-- Icone pdf vendido sem grafico -->
							<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdfB10.jpg" title="Relatório Base 10 s/ Gráficos" alt="Relatório Base 10 s/ Gráficos" border="0"></a> 
							<!-- Icone pdf vendido sem grafico -->
							
							
                            
							<!-- Icone de edicao -->
							<!--<a href="form_laudo.php?alterar=1&cod=<?=$linha["id"]?>" target="_blank">
								<img src="imagens/icon_gerar_laudo.gif" title="Formulário de Avaliação de Perfil de Cargo" alt="Formulário de Avaliação de Perfil de Cargo" border="0"></a>
                            -->
							
							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Relatório Coaching c/ Gráficos" alt="Relatório Coaching c/ Gráficos" border="0"></a> 

							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdf.jpg" title="Relatório Coaching s/ Gráficos" alt="Relatório Coaching s/ Gráficos" border="0"></a> 
							</span>
                            
                            <span id="triggers">
                                <img src="imagens/manda_imail.gif" title="Enviar E-mail Por Pessoa" alt="Enviar E-mail" border="0" rel="#mies<?=$k?>" style="cursor: pointer;" />
                            </span>
                            
                            <!--<a href="aplica_email_envia.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>" onclick="javascript: return confirm('Tem certeza que deseja enviar o relatório de avaliação de <?="&quot;"?><?=$linha["nome"]?><?="&quot;"?> para o e-mail <?="&quot;"?><?=$linha["email"]?><?="&quot;"?>?')"><img src="imagens/manda_imail.gif" title="Enviar E-mail Por Pessoa" alt="Enviar E-mail" border="0" /></a>
                            
                            <a href="aplica_email_envia_g.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>&grupo=<?=$linha["grupoid"]?>" onclick="javascript: return confirm('Tem certeza que deseja enviar o relatório de avaliação para TODOS DO GRUPO <?="&quot;"?><?=$linha["grupo"]?><?="&quot;"?>?')"><img src="imagens/manda_imail2.gif" title="Enviar E-mail Por Grupo" alt="Enviar E-mail" border="0" /></a>
							-->
                            <? if(($permissao == "3333")){ ?>          					
                            	<a href="aplica_org_alt.php?alterar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0"></a>
                            <? } ?>
                            <? if(($permissao == "99991") or ($permissao == "99992")){ ?>
           					
							<a href="aplica_alt.php?alterar=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0"></a>
							<a href="aplica_gerencia.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a avaliação de <?=$linha["nome"]?> ?')" title="Apagar" alt="Apagar" border="0"></a>
							<?}?>
							</td>
					</tr>
				
				<?
				}
                $k++;
                }
				?>
				

					</table>
                <? } ?>
                
 	
            
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				

		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	

<?php mysql_close(); ?>
<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>