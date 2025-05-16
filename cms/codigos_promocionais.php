<?php include("conn.php"); ?>

<?php include("logon.php"); ?>

<?php include("library.php"); ?>





<?



// --- INICIO Efetuando a exlcusao

if ($_REQUEST['apagar']) {		



				$sql = "DELETE FROM codigos_promocionais WHERE id=".$_REQUEST['cod'];

				if (mysql_query($sql)) {

					alert("Excluido com sucesso!");

				}

	

}

// --- FIM    Efetuando a exlcusao







// --- INICIO Efetuando o cadastro

if ($_REQUEST['cadastra']) {

	

	// Varificacao de campos

	$ok = 1;


	

	if (!($_POST["validade"] == "")) {

		$validade = addslashes($_POST["validade"]);


	} else {

		$ok = 0;

	}

	

	if (!($_POST["usos"] == "")) {

		$usos = addslashes($_POST["usos"]);

	} else {

	}

	



	

		

	if ($ok) {



		$data = date("Y-m-d");

					

             

            $existe = true;

            while($existe) {

                $codigo = generateRandomString();

                $check = mysql_query("SELECT codigo FROM codigos_promocionais WHERE codigo = '$codigo'");

                if(mysql_num_rows($check) == 0) {

                    $existe = false;

                }

            }

            

		    $sql = "INSERT INTO codigos_promocionais (codigo,validade,uso) values ('$codigo','$validade','$usos')";

		    if (mysql_query($sql)) {

		    	alert("Código gerado com sucesso!");

		    	redireciona("codigos_promocionais.php");

		    } else {

		    	// QUERY

		    	

		    	alert("Erro ao cadastra!");

		    	redireciona("codigos_promocionais.php");

		    }

		    





	} // OK

	

} // REQUEST



// --- FIM    Efetuando o cadastro

function generateRandomString($length = 6) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';

    $charactersLength = strlen($characters);

    $randomString = '';

    for ($i = 0; $i < $length; $i++) {

        $randomString .= $characters[rand(0, $charactersLength - 1)];

    }

    return $randomString;

}

?>





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<?php include("header.php"); ?>



<body>



<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->

<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>

<br><br><br></div>



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

			<div id="info" style="height: 25px;"> 

				<div style="font-family: Arial; font-size: 16px; color: #727272;">Gerar Código Promocional</div>

			</div>

			<!-- INICIO - DIV info - Barra de informacao -->

			

			<form action="codigos_promocionais.php?cadastra=1" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">

			

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->

			<div id="caixa_form">

			

				
			<!--
				<div id="linha_form">

					<div id="label"> <span class="label_fonte">Porcentagem de Desconto: </span> </div><input size="10" maxlength="3" type="number" name="desconto" class="form_style" value="<?=$desconto?>" />						

				</div>	
			-->
				<div id="linha_form">

					<div id="label"> <span class="label_fonte">Válido até: </span> </div><input size="10" type="datetime-local" name="validade" class="form_style" value="<?=$validade?>" />						

				</div>	
				

				<div id="linha_form">

					<div id="label"> <span class="label_fonte">Total de usos permitidos: </span> </div><input size="10" type="number" name="usos" class="form_style" value="<?=$usos?>" />						

				</div> 

			

					<p align="center"><input type="submit" value="Gerar Código Promocional" class="form_style"></p>

			</div>

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			

			

			</form>

				

			<!-- INICIO - DIV info fim - Barra de informacao -->

			<div id="info_fim">

				&nbsp;

			</div>

			<!-- INICIO - DIV info fim - Barra de informacao -->	

            

            

			<div id="info" style="height: 25px;"> 

				<div style="font-family: Arial; font-size: 16px; color: #727272;">Gerenciar Códigos Promocionais</div>

			</div>

			<!-- INICIO - DIV info - Barra de informacao -->

			

			

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->

			<div id="caixa_table">



				<table width="100%" align="center" class="sortable" cellspacing="3">

					<tr height="30">

						<td align="center">Código</td>


						<td align="center">Usos Restantes</td>

						<td align="center">Criado em</td>
						<td align="center">Válido até</td>

						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>

					</tr>

				

					

			<?

				$sql = "SELECT *, DATE_FORMAT(criado,'%d/%m/%Y %H:%i') as dt, DATE_FORMAT(validade,'%d/%m/%Y %H:%i') as dt2 FROM codigos_promocionais ORDER BY criado DESC";

				$result = mysql_query($sql);

				

				while ($linha = mysql_fetch_assoc($result)) {

					$data = $linha["data"];

					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);

			?>					

					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">

						<td align="center" ><?=$linha["codigo"]?></td>


                        <td align="center" ><?=$linha["uso"]?></td>

                        <td align="center" ><?=$linha["dt"]?></td>
						<td align="center" ><?=$linha["dt2"]?></td>

						<td align="center" >

						

						<a href="codigos_promocionais.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir ?')" alt="Apagar" border="0"></a></td>

					</tr>

				<?

				}

				?>

				</table>



	<div id="info_fim">

				&nbsp;

			</div>

			</div>

		

			

					

				

		</div>



			

	

	</div>

	<!-- FIM - DIV global - Emgloba todo o site -->	





<!-- QuickMenu Structure [Menu 0] -->





<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->

</body>

<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>

</html>