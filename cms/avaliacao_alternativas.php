<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

if ($_REQUEST['id']) {
	$id = $_REQUEST["id"];
}

//EDIT	
$sql = mysql_query("SELECT * FROM avaliacao WHERE id = '$id'");
$sql = mysql_fetch_array($sql);
$qtde = $sql["qtde"];

$sql2 = mysql_query("SELECT * FROM avaliacao_atividade WHERE id_avaliacao = '$id'");
$sql2 = mysql_fetch_array($sql2);
$alta_full = $sql2["altA"];
$altb_full = $sql2["altB"];


	

if ($_REQUEST['cadastra']) {
	$ok =1;
	$alta_full = "";
	$altb_full = "";
	for($i= 1; $i < $qtde+1; $i++)
	{
		
		
		if($_REQUEST["alta".$i] != "")
		{
			$alta_full .= $_REQUEST["alta".$i] . "%";
		} else {
			$ok = 0;
		}
		
		if($_REQUEST["altb".$i] != "")
		{
			$altb_full .= $_REQUEST["altb".$i] . "%";
		} else {
			$ok = 0;
		}
		
	}
	
		if($ok == 1)
		{
			$sql = "UPDATE avaliacao_atividade SET altA='$alta_full',altB='$altb_full',id_avaliacao='$id' WHERE id_avaliacao = '$id'";
			//echo $sql;
			if (mysql_query($sql)) {
				alert("Alternativas cadastradas com sucesso!");
				redireciona("avaliacao_gerencia.php");
			} else {
				die("Erro: " . mysql_error());
			}
		}else{
			alert("Todas as alternativas precisam ser preenchidas.");
		}
				
		} 

		


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
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		

			<!-- INICIO - DIV info - Barra de informacao -->
			
			<div id="info">
				Cadastro de Avaliações
			</div>
			<form action="?cadastra=1&id=<?=$id?>" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<?php
				$ex1 = explode("%",$alta_full);
				$ex2 = explode("%",$altb_full);
			
				for($i = 1; $i < $qtde+1; $i++)
				{
			?>
				
			
				<div style="background-color: #E8E8E8
;margin-bottom: 10px; margin-top:20px; width: 800px; border: 1px solid #222222;margin-left: 30px; ">
					
						<span class="label_fonte" style="width: 800px; margin-left: 10px;"><b>Afirmativa <?=$i?></b></span>
						
				
					
				</div>
					
				<div id="linha_form_auto" >
					<div id="label">
						<span class="label_fonte">Alternativa A: </span>
					</div>
					<input name="alta<?=$i?>" class="form_style" value="<?=$ex1[$i-1]?>" style="width: 500px;">
				</div>
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Alternativa B: </span>
					</div>
					<input name="altb<?=$i?>" class="form_style" value="<?=$ex2[$i-1]?>" style="width: 500px;">
				</div>
				
			<? } ?>
				
				

				<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
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