<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
//echo phpinfo();
if($_SESSION["organizacaon"]){
	$organizacaon = $_SESSION["organizacaon"];
}

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM aplicacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Aplicação excluída com sucesso!");
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
?>

<?php				$where = "";
					//######### INICIO Paginação
				
					    $numreg = 50; // Quantos registros por página vai ser mostrado
					  if (!isset($pg)) {
					       $pg = 0;
					    }
					   $pg = $_REQUEST["pg"];
					    $inicial = $pg * $numreg;
					   
					//######### FIM dados Paginação
					
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
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
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_avaliacao_realizadas.gif" alt="Avaliações Realizadas" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="aplicacao_commit.php" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">

				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Nome:</span> </div>

						<input class="form_style" type="text" size="50" name="nome">
				      
				</div>	
				

				<p align="center"><input type="submit" value="Localizar" class="form_style" name="localizar"></p>
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>	
			
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Data</td>
						<td align="center">Nome</td>
						<td align="center">Tempo</td>
						<td align="center">Ticket</td>
						<td align="center">Empresa</td>
						<td align="center">Cargo</td>
						<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444") or ($permissao == "5555")){?>
						<td align="center">A&ccedil;&otilde;es</td>
						<?}?>
					</tr>
				
					
			<?
				/*//$sql = "SELECT *, date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`  FROM aplicacoes ORDER BY nome";
				$sql = "
				SELECT
				aplicacoes_commit.id,
				aplicacoes_commit.nome,
				aplicacoes_commit.email,
				aplicacoes_commit.telefone,
				aplicacoes_commit.cpf,
				aplicacoes_commit.nasc,
				aplicacoes_commit.cargo,
				aplicacoes_commit.tempo,
				aplicacoes_commit.respostas,
				aplicacoes_commit.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
                organizacoes.id as id_orga,
				grupos.nome as grupo,
				aplicacoes_commit.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes_commit.grupo = grupos.id
				left Join organizacoes ON aplicacoes_commit.organizacao = organizacoes.id
				ORDER BY aplicacoes_commit.data_aplic desc
				"
				;
				$result = mysql_query($sql);*/
				$where = " ";
				$aplicacaoINNER = " ";
				$campoINNER = " ";
					
				
				if($_POST["nome"] != ""){
					$nome_pesq = $_POST["nome"];
						$where .= " and aplicacoes.nome like '%$nome_pesq%'";
				}
				
				if($organizacaon){
					$where .= " and aplicacoes.organizacao='$organizacaon'";
				}

				$where .= " and organizacoes.commit = 1";
			
				
				$sql = "SELECT
				$campoINNER
				organizacoes.nome as nome_organizacao,
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.cargo,
				aplicacoes.ticket,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				aplicacoes.status_envio
				FROM
				aplicacoes
				LEFT JOIN organizacoes ON organizacoes.id = aplicacoes.organizacao
				$aplicacaoINNER WHERE  aplicacoes.id != ''
				 $where ORDER BY aplicacoes.data_aplic desc
				LIMIT $inicial, $numreg";
				$result = mysql_query($sql) or die(mysql_error());
				$i = $inicial;

				
				$sql2 = "SELECT
				$campoINNER
				organizacoes.nome as nome_organizacao,
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.ticket,
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,				
				aplicacoes.status_envio
				FROM
				aplicacoes
				LEFT JOIN organizacoes ON organizacoes.id = aplicacoes.organizacao
				$aplicacaoINNER WHERE aplicacoes.id != ''
				 $where ORDER BY aplicacoes.data_aplic desc
				";
				$result2 = mysql_query($sql2);

				
				$quantreg = mysql_num_rows($result2);
			  	$quant_pg = ceil($quantreg/$numreg);
				$quant_pg++;
				
				if($quantreg == 0){
					echo "<span class=\"label_fonte\">Nenhum registro</span>";
				}
				
				//echo $sql2;
                $k = 0;
				while ($linha = mysql_fetch_assoc($result)) {
				$i++;
				$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta.php?id=".$linha["id"];
				$nome_session = "url_".$linha["id"];
				//$resultado_url = executa_url($url);
				//$_SESSION["$nome_session"] = $resultado_url;
				//echo $linha["respostas"];
				
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
                        <div style="clear: both; margin-bottom: 10px;"><img src="imagens/enviar_rel.jpg" /></div>
                    	   <div style="clear: both; border-top: 1px dotted #666; margin-top: 0px; margin-bottom: 10px;"></div>
                           
                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">
                               <b>Relatório: </b>
                           </div>
                           <div style="float: left; margin-left: 5px; margin-bottom: 15px;">
                               <select id="relatorio" name="relatorio">
                                   <option value="">Selecione</option>
                                   <option value="1">Relatório Base 10 com Gráficos</option>
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
						<td align="center" ><?=$linha["tempo"]?> </td>
						<td align="center" ><? if($linha["ticket"] == "") { echo "MANUAL"; } else { echo $linha["ticket"]; } ?> </td>
						<td align="center" ><?=$linha["nome_organizacao"]?> </td>
						<td align="center" ><?=$linha["cargo"]?> </td>
						<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444") or ($permissao == "5555")) { ?>
						<td align="center" width="1%" nowrap>
						
								
							<!-- Gráfico coletivo por montagem de grupo 
							<a href="grupoMont_commit.php?commit=1" target="_blank"><img src="imagens/grupoMont.png" width="25px" height="25px" title="Gráfico coletivo por montagem de grupo" alt="Gráfico coletivo por montagem de grupo" border="0"></a> 
							 Gráfico coletivo por montagem de grupo 
							
							
							Gráfico total de um determinado grupo 
							<a href="grupoDet_commit.php?grupo=<?php echo $linha_empresa["nome_cliente"];?>&orga=999999&commit=1" target="_blank"><img src="imagens/grupoDet.png" width="25px" height="25px" title="Gráfico total de um determinado grupo" alt="Gráfico total de um determinado grupo" border="0"></a> 
							 Icone pdf vendido sem grafico -->
							
							
							<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=1&orga=1&commit=1" target="_blank"><img src="imagens/icon_grafB10.jpg" title="Relatório Base 10 c/ Gráficos" alt="Relatório Base 10 c/ Gráficos" border="0"></a> 
						
							<!-- Icone de edicao -->
							<a href="form_laudo.php?alterar=1&cod=<?=$linha["id"]?>&commit=1" target="_blank">
								<img src="imagens/icon_gerar_laudo.gif" title="Gerar Laudo" alt="Gerar Laudo" border="0">
							</a>
							<a onclick="abrir_novo_relatorio('<?php echo $linha["id"];?>')" target="_blank" style="cursor: pointer;"><img src="imagens/icon_novorel.gif" title="NOVO Relatório Coaching c/ Gráficos" alt=" NOVO Relatório Coaching c/ Gráficos" border="0"></a>
							<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "5555")){ ?>
								<!--<a href="testepdf.php?id=<?php echo $linha["id"];?>"&orga=<?=$linha["id_orga"]?>><img src="imagens/icon_email.gif" title="Enviar E-mail" alt="Enviar E-mail" border="0"></a>-->
								<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=1&commit=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Gerar PDF Completo" alt="Gerar PDF Completo" border="0"></a> 
	           							  
								<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=999999&commit=1" target="_blank"><img src="imagens/icon_pdf.jpg" title="Gerar PDF 2 Paginas" alt="Gerar PDF 2 Paginas" border="0"></a> 
								
								<!--<a href="aplica_alt.php?alterar=1&cod=<?=$linha["id"]?>&commit=1">
									<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
								</a>-->
                                <? if(($permissao == "99991") or ($permissao == "99992") or ($permissao != "5555")){ ?>
								<a href="aplicacao_commit.php?apagar=1&cod=<?=$linha["id"]?>&commit=1"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a avaliação de <?=$linha["nome"]?> ?')" title="Apagar" alt="Apagar" border="0"></a>	
							     <? } ?>
                                 
                                 <span id="triggers">
                                <img src="imagens/manda_imail.gif" title="Enviar E-mail Por Pessoa" alt="Enviar E-mail" border="0" rel="#mies<?=$k?>" style="cursor: pointer;" />
                            </span>
                            
                            <?}?>
						
						</td>
	<?}?>
					</tr>
				
				<?
                $k++;
				}
				?>
				
					<tr>
					<td align="center" colspan="8">
				 <?   // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
				    if ( $pg > 0) {
				        echo "<a href=".$PHP_SELF."?pg=".($pg-1)."&orga=$id_orga  class=pg><b>&laquo; anterior</b></a>";
				    } else {
				        echo "<span class=pg><b>&laquo; anterior</b></span>";
				    }
				     for($i_pg=1;$i_pg<$quant_pg;$i_pg++) {
				        // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente
				        if ($pg == ($i_pg-1)) {
				            echo "&nbsp;<span class=pg>[$i_pg]</span>&nbsp;";
				        } else {
				            $i_pg2 = $i_pg-1;
				            echo "&nbsp;<a href=".$PHP_SELF."?pg=$i_pg2&orga=$id_orga class=pg><b>$i_pg</b></a>&nbsp;";
				        }
				    }
				    
				    // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima
				    if (($pg+2) < $quant_pg) {
				        echo "<a href=".$PHP_SELF."?pg=".($pg+1)."&orga=$id_orga class=\"pg\"><b>próximo &raquo;</b></a>";
				    } else {
				        echo "<span class=pg>próximo &raquo;</span>";
				    }
				?>
				</td>
					</tr>
					</table>

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

<div class="fundo-linguagem" style="display: none;">
    <div class="linguagem">
        <div class="fechar" onclick="$(this).parent().parent().fadeOut()">X</div>
        <div class="escolha">Escolha sua linguagem / Choose your language / Elige tu idioma</div>
        <div class="bandeiras">
            <a id="novo_relatorio_br" target="_blank" href="?lang=br"><img src="../img/flag_br.jpg" /></a>
            <a id="novo_relatorio_en" target="_blank" href="?linguagem=en"><img src="../img/flag_en.jpg" /></a>
            <a id="novo_relatorio_es" target="_blank" href="?linguagem=es"><img src="../img/flag_es.jpg" /></a>
        </div>
    </div>
</div>
<script>
function abrir_novo_relatorio(id) {
    $("#novo_relatorio_br").attr("href","novo_relatorio_monta2.php?id="+id+"&orga=1&lang=br");
    $("#novo_relatorio_en").attr("href","novo_relatorio_monta2.php?id="+id+"&orga=1&lang=en");
    $("#novo_relatorio_es").attr("href","novo_relatorio_monta2.php?id="+id+"&orga=1&lang=es");
    $(".fundo-linguagem").fadeIn();
} 
</script>
<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>