<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

if($_REQUEST["c"])
{
	$c = $_REQUEST["c"];
}


// --- FIM    Efetuando a exlcusao
if ($_REQUEST['id'] != "") {
	$id = $_REQUEST['id'];
}
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	

	$perguntas = "";
	$tam = $_POST["tamanho"];
	
	if($c == 2)
	{
		if (!($_POST["igual"] == "")) {
				$igual = $_POST["igual"];
			} else {
		}
	}
	
	for($j = 1; $j < $tam + 1; $j++)
	{
		if (!($_POST["pergunta".$j] == "")) {
			$perguntas .= trim($_POST["pergunta".$j]). "/";
		} else {
			
		}
	}


	// Se seu campo estiver OK!
	if (!$ok) {

			alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
		

	} else {
				
			// Gravando dados no banco
			if($c == 1)
			{
				$sql = "UPDATE teste_gratuito_perguntas SET pergunta = '$perguntas' WHERE id_teste = '$id'";
			} else {
				$sql = "UPDATE teste_gratuito_respostas SET resposta = '$perguntas', igual = '$igual' WHERE id_teste = '$id'";
			}
			// Confirmacao de insert
			if (mysql_query($sql)) {
				if($c == 1)
				{
					alert("Perguntas criadas com sucesso!");
				} else {
					alert("Respostas criadas com sucesso!");
				}
				redireciona("gerenciar_gratuitos.php");
			}

	}
	
}

// --- FIM    Efetuando o cadastro

?>

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
		
		<?php
			$sel = mysql_query("SELECT * FROM teste_gratuito_cadastro WHERE id = '$id'");
			$sel = mysql_fetch_array($sel);
			
			$nome = $sel["nome"];
			$descricao = $sel["descricao"];
			$qtdeperguntas = $sel["qtdeperguntas"];
			$qtderespostas = $sel["qtderespostas"];
		?>
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/icoGratuito.png" /> 
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="preencher_gratuitos.php?cadastra=1&id=<?=$id?>&c=<?=$c?>" method="post" name="cadastro">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<?php
				
				
				if($c == 1)
				{
					$sel = mysql_query("SELECT * FROM teste_gratuito_perguntas WHERE id_teste = '$id'");
					$sel = mysql_fetch_array($sel);
					$perguntas2 = $sel["pergunta"];
				} else {
					$sel = mysql_query("SELECT * FROM teste_gratuito_respostas WHERE id_teste = '$id'");
					$sel = mysql_fetch_array($sel);
					$perguntas2 = $sel["resposta"];
				}
				
				if($c == 2)
				{
					$igual = $sel["igual"];
					$id_perg = $sel["id_pergunta"];
				}
				
				$perg = explode("/",$perguntas);
				$perg2 = explode("/",$perguntas2);
				?>
				
				<?
				if($c == 2)
				{
				?>
				<div id="linha_form" style="margin-bottom: 15px;">
					<div id="label">  </div><input type="checkbox" name="igual" value="1" class="form_style"><span class="label_fonte">Quero alternativas iguais para todas as perguntas.<br/>OBS: ao marcar esta opção, preencha somente os campos da primeira pergunta.</span>
				</div>
						
			
				<?
				}
				if($c == 1)
				{
					$tamtotal = $qtdeperguntas;
				} else {
					$tamtotal = $qtderespostas;
				}
				
				
				
				if($c == 2)
				{
					
						$selperg = mysql_query("SELECT * FROM teste_gratuito_perguntas WHERE id = '$id'");
						$selperg = mysql_fetch_array($selperg);
						$pergsid = $selperg["pergunta"];
						$pergsid = explode("/",$pergsid);
						
						$e = 0;
						$i = 1;
						while($e < sizeof($pergsid) - 1)
						{	
							$numeracao = 1;
							echo '<span class="label_fonte" style="margin-left: 30px;"><b>'.$pergsid[$e].'</b></span>';
							
	
							while($i < $tamtotal +1)
							{
							
							?>
						
							<div id="linha_form">
								<div id="label"> <span class="label_fonte"><?php if ($c ==1) { echo "Pergunta "; } else { echo "Alternativa "; }?><?=$numeracao?>: </span> </div><input maxlength="300" type="text" style="width: 330px;" name="pergunta<?=$i?>" value="<? if($perg[$i-1] == "") { echo $perg2[$i-1];} else { echo $perg[$i-1] ;} ?>" class="form_style">
							</div>
							
							
							<?php
							$numeracao++;
							$i++;
							}
							$num = $i;
							
							$tamtotal = $tamtotal + $qtderespostas;
	
							$e++;

						}
					
				} else {
					
					for($i = 1; $i < $tamtotal +1; $i++)
					{					
				?>
				
					<div id="linha_form" >
						<div id="label"> <span class="label_fonte"><?php if ($c ==1) { echo "Pergunta "; } else { echo "Alternativa "; }?><?=$i?>: </span> </div><input maxlength="200" type="text" style="width: 330px;" name="pergunta<?=$i?>" value="<? if($perg[$i-1] == "") { echo $perg2[$i-1];} else { echo $perg[$i-1] ;} ?>" class="form_style">
					</div>
					
					
				<?php
						$num = $i;
					}
				}
				
				
			?>	
				<input type="hidden" name="tamanho" value="<?=$num?>">

					<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
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
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>