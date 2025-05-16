<?php include("conn.php"); ?>

<?php include("logon.php"); ?>

<?php include("library.php"); ?>

<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

<?



            /*

                $array = "6566,7789,10860,6527,5293,9261,8222,9390,6740,7478,5537,8234,6792,8599,7131,7828,9515,7833,5227,7484,6532,5161,8374,8984,5342,7624,5198,6528,7521,7508,6534,8610,7271,7317,10851,5230,8316,7443,8352,7435,8981,8227,7253,7825,6535,5137,8619,7714,8693,5228,6830,8887,9626,10850,5123,5116,7434,6931,5489,7830,9186,5256,7313,7643,5347,7813,8657,6939,5184,7129,6565,6853,6525,5177,7130,5235,5340,7438,7530,8622,5158,6838,6557,8232,5182,9264,6816,7522,5295,5236,7441,7635,10814,6524,7703,5131";

                $array_ex = explode(",",$array);

                $array = str_replace(",","' OR aplicacoes.id = '",$array);

                $array .= "')";

              */  



                

				

//echo __FILE__;



//echo phpinfo();

if($_SESSION["organizacaon"]){

	$organizacaon = $_SESSION["organizacaon"];

}

// --- INICIO Efetuando a exlcusao

if ($_REQUEST['apagar']) {

	

	$sql = "DELETE FROM aplicacoes WHERE id=".$_REQUEST['cod'];

	if (mysql_query($sql)) {

		alert("Aplicação excluida com sucesso!");

	}

	

}



// --- FIM    Efetuando a exlcusao

//echo date("d/m/Y H:i:s");

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



			



			<form action="grupoMont2.php" target="_blank" name="myform" method="POST" >

			

			

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->

			<div id="caixa_table">

			

				

				<table width="100%" align="center" class="sortable" cellspacing="3">

					

				

					<tr height="30">

						<td align="center">#</td>

						<td align="center">Data</td>

						<td align="center">Nome</td>

						<td align="center">Nascimento</td>

						<td align="center">Tempo</td>

						<td align="center">Organização</td>

						<td align="center">Grupo</td>

						<td align="center">Cargo</td>

						<td align="center">A&ccedil;&otilde;es</td>

					</tr>

					<tr height="30">						

						<td align="center" colspan="8">

					  		 TODOS

						</td>					

						<td align="center" width="1%" nowrap>

						<input type="checkbox" value="0" id="selectAll" name="opcao[]"/>

						</td>

					</tr>

                    <script>

                        var tam = 0;

                    </script>

										

			<?			

              

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

				organizacao=194

				ORDER BY aplicacoes.data_aplic DESC 

				";

				//echo $sql;

                $result = mysql_query($sql);

				

				

				//echo $sql;

				$i=0;

				//break;

                $o = 0;

				while ($linha = mysql_fetch_assoc($result)) {

				$i++;

				//$resultado_url = executa_url($url);

				//$_SESSION["$nome_session"] = $resultado_url;

				//echo $_SESSION[$nome_session];

				

			?>				

					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">

						<td align="center" ><?=$i;?></td>

						<td align="center" ><?=$linha["databr"]?></td>

						<td align="left" ><?=$linha["nome"]?></td>

						<td align="left" ><?=$linha["data_nasc"]?></td>

						<td align="center" ><?=$linha["tempo"]?> </td>

						<td align="center" ><?=$linha["orga"]?> </td>

						<td align="center" >

						<?

								echo $linha["grupo"];

							

						?>

						</td>

						<td align="center" ><?=$linha["cargo"]?> </td>



						<td align="center" width="1%" nowrap>

							<input type="checkbox" id="edit-checkbox-<?=$o?>" value="<?=$linha["id"]?>" name="gerar[]">

						</td>

					</tr>

                    <? $o++; ?>

				    <script>

                        tam++;

                    </script>

				<?

				}

                	

				?>

				

					

					</table>

					

                    <input type="hidden" value="<?=$where?>" name="awhere">

                    <div style="visibility: hidden;" id="tipo_gerador"></div>

                    

 					<p align="center">

 					<button type="button" onclick="valida(1)" class="form_style">Gerar Grafico Pessoas Selecionadas</button>&nbsp;

 					

                         <!--<button type="button" class="form_style" onclick="valida(2)">Gerar Grafico de Todos Listados</button>--> 

 					</p>

			</div>

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			

			</form>

            <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

			<script>

                function valida(n) {

                    if(n != 2) {

                    i = 0;

                    tudo_ok = false;

                    while(i < tam) {

                    if($('#edit-checkbox-'+i).is(':checked')) {

                        tudo_ok = true;

                    }

                    i++;

                    }

                     

                    if(tudo_ok) {

                        //$("#persons").val(1);

                        $("#tipo_gerador").html('<input type="hidden" value="1" id="persons" name="pessoas">');

                        document.forms["myform"].submit();

                    } else {

                        alert("Escolha pelo menos uma aplicação.");

                        

                    }

                    } else {

                        $("#tipo_gerador").html('<input type="hidden" value="1" id="groups" name="grupos">');

                        document.forms["myform"].submit();

                        

                    }

                }

            </script>

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