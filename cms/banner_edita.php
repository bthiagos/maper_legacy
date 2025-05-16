<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

if ($_REQUEST['id']) {
	$banner = $_REQUEST["id"];
}
// --- INICIO Efetuando a exlcusao

// --- FIM    Efetuando a exlcusao


	
		
	if ($_REQUEST['cadastra']) {
		
		if($_FILES[img][name]) {
			$dir = "uploaded";			
			$file = $_FILES[img];			
			$sExt = substr(strrchr($file["name"], "."),1);
			$sExt = strtolower($sExt);
			$foto = time().".".$sExt;		
			move_uploaded_file($_FILES[img][tmp_name], $dir . "/" . $foto);	
			$sql = "UPDATE banner SET foto = '$foto' WHERE id = '$banner'";
			//echo $sql;
			if (mysql_query($sql)) {
				alert("Banner cadastrado com sucesso!");
				redireciona("banner_gerencia.php?cod=");
			} else {
				die("Erro: " . mysql_error());
			}
			
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
		<?php include("menu.php"); 
		$servicos_query = "SELECT * FROM banner WHERE id = '$banner' LIMIT 1";
		$result = mysql_query($servicos_query) or die("Erro: " . mysql_erro());
		$servicos_array = mysql_fetch_array($result);
		print($servicos_array);
		
		?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		

			<!-- INICIO - DIV info - Barra de informacao -->
			
			<div id="info">
				Atualiza&ccedil;&atilde;o de Banner
			</div>
			<form action="?cadastra=1&id=<?=$banner?>" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
					
                <div id="caixa_form">
					
                  <div id="linha_form">
                    <span class="label_fonte">Foto: </span>
					<input type="file" name="img" class="form_style" style="width:450px" />
					</div>
                
                                    
                </div>
				
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
				<p align="center"><input type="submit" value="Cadastrar" class="form_style"/></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">

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