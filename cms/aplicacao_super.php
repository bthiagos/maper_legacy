<?php include("conn.php"); ?>

<?php include("logon.php"); ?>

<?php include("library.php"); ?>

<?

//echo phpinfo();

if($_SESSION["organizacaon"]){

	$organizacaon = $_SESSION["organizacaon"];

	$user_id = $_SESSION["id_usuario_adm"];

	//echo $_SESSION["id_usuario_adm"];

}



// Sessão Usuário

$user_id = $_SESSION["id_usuario_adm"];





// --- INICIO Efetuando a exlcusao

if ($_REQUEST['apagar']) {

	

	$sql = "DELETE FROM aplicacoes_commit WHERE id=".$_REQUEST['cod'];

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

						<td align="center">Organização</td>

						<td align="center">Grupo</td>

						<td align="center">Cargo</td>

						<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444") or ($permissao == "5555") or  ($permissao == "2222")){?>

						<td align="center">A&ccedil;&otilde;es</td>

						<?}?>

					</tr>

				

					

			<?

				/*//$sql = "SELECT *, date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`  FROM aplicacoes ORDER BY nome";

				$sql = "

				SELECT

				aplicacoes.id,

				aplicacoes.nome,

				aplicacoes.email,

				aplicacoes.telefone,

				aplicacoes.cpf,

				aplicacoes.nasc,

				aplicacoes.cargo,

				aplicacoes.tempo,

				aplicacoes.respostas,

				aplicacoes.data_aplic,

				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

				organizacoes.nome as orga,

                organizacoes.id as id_orga,

				grupos.nome as grupo,

				aplicacoes.status_envio

				FROM

				aplicacoes

				left Join grupos ON aplicacoes.grupo = grupos.id

				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id

				ORDER BY aplicacoes.data_aplic desc

				"

				;

				$result = mysql_query($sql);*/

				$where = " ";

				$aplicacaoINNER = " ";

				$campoINNER = " ";

					

				

				if($_POST["nome"] != ""){

					$nome_pesq = $_POST["nome"];

						$where = " AND aplicacoes.nome like '%$nome_pesq%'";

				}

				

				// Buscando as Organizações

				$where_orga = '';

				$sql_orga = "SELECT * FROM organizacoes_superusuario WHERE id_usuario='$user_id'";

				$result_org = mysql_query($sql_orga);

				while ($linha_orga = mysql_fetch_assoc($result_org)) {

					if($where_orga!=""){

						$where_orga .= " or organizacao='".$linha_orga["id_organizacao"]."' ";

					}else{

						$where_orga .= " WHERE organizacao='".$linha_orga["id_organizacao"]."' ";

					}

				}



				

				

				

				$sql = "SELECT

				*,

				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

				aplicacoes.id as id,

				organizacoes.nome as nome_org,

				grupos.nome  as nome_grupo,

				aplicacoes.nome as nome_teste

				FROM

				aplicacoes

				INNER JOIN organizacoes ON aplicacoes.organizacao = organizacoes.id

				INNER JOIN grupos ON aplicacoes.grupo = grupos.id

				$where_orga $where

				ORDER BY aplicacoes.data_aplic desc

				LIMIT $inicial, $numreg";

				$result = mysql_query($sql);

				$i = $inicial;

				

				$sql2 = "SELECT

				*,

				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

				organizacoes.nome as nome_org,

				grupos.nome  as nome_grupo,

				aplicacoes.nome as nome_teste

				FROM

				aplicacoes

				$where_orga $where

				ORDER BY aplicacoes.data_aplic desc

				";

				

				//echo $sql;

				

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

                    

                    <div class="simple_overlay" id="mies<?=$k?>" style="margin-top: 30px;">
                    	<div style="padding: 10px;">
                        <form name="form" action="aplica_email_envia.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>&grupo=<?=$linha["grupoid"]?>" method="POST" onsubmit="return confere();">
                        <div style="clear: both; margin-bottom: 10px;margin-top:0px"><img src="imagens/enviar_rel.jpg" /></div>
                    	   <div style="clear: both; border-top: 1px dotted #666; margin-top: 0px; margin-bottom: 10px;"></div>
                           
                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">
                               <b>Relatório: </b>
                           </div>
                           <div style="float: left; margin-left: 5px; margin-bottom: 15px;">
                               <select id="relatorio" name="relatorio">
                                   <option value="">Selecione</option>
                                   <option value="7">Novo Relatório - Português</option>
                                   <option value="8">Novo Relatório - Inglês</option>
                                   <option value="9">Novo Relatório - Espanhol</option>

                                   <!--
                                   <option value="1">Relatório Base 10 com Gráficos</option>
                                   <option value="2">Relatório Base 10 sem Gráficos</option>
                                   <option value="4">Relatório Coaching com Gráfico</option>
                                   <option value="5">Relatório Coaching sem Gráfico</option>
                                   <option value="6">Relatório de Estilos</option>
                                   -->
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

						<td align="left" ><?=$linha["nome_teste"]?></td>

						<td align="center" ><?=$linha["tempo"]?> </td>

						<td align="center" ><?=$linha["ticket"]?> </td>

						<td align="center" ><?=$linha["nome_org"]?> </td>

						<td align="center" ><?=$linha["nome_grupo"]?> </td>

						<td align="center" ><?=$linha["cargo"]?> </td>

	<? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "4444") or ($permissao == "5555") or ($permissao == "2222")) { ?>

						<td align="center" width="1%" nowrap>

						

								<!-- Icone pdf vendido com grafico -->

							<!--<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_grafB10.jpg" title="Relatório Base 10 c/ Gráficos" alt="Relatório Base 10 c/ Gráficos" border="0"></a> 
							-->
							<!-- Icone pdf vendido com grafico -->

							

							

							<!-- Icone pdf vendido sem grafico -->

							<!--<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdfB10.jpg" title="Relatório Base 10 s/ Gráficos" alt="Relatório Base 10 s/ Gráficos" border="0"></a> 
							-->

							<a href="novo_relatorio_monta.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_novorel.gif" title="NOVO Relatório Coaching c/ Gráficos" alt=" NOVO Relatório Coaching c/ Gráficos" border="0"></a>

							 
							<!--
							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Relatório Coaching c/ Gráficos" alt="Relatório Coaching c/ Gráficos" border="0"></a> 



							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdf.jpg" title="Relatório Coaching s/ Gráficos" alt="Relatório Coaching s/ Gráficos" border="0"></a>
							-->

							<span id="triggers">
                                <img src="imagens/manda_imail.gif" title="Enviar E-mail Por Pessoa" alt="Enviar E-mail" border="0" rel="#mies<?=$k?>" style="cursor: pointer;" />
                            </span>

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





<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->

</body>

<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>

</html>