<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

if ($_REQUEST['id']) {
	$depoimentos2 = $_REQUEST["id"];
}
// --- INICIO Efetuando a exlcusao

// --- FIM    Efetuando a exlcusao

		
if($_POST["objetivo"] != ""){		
		$objetivo = addslashes($_POST["objetivo"]);
	} else {
		$ok=0;
	}
	
if($_POST["qtde"] != ""){		
		$qtde = addslashes($_POST["qtde"]);
	} else {
		$ok=0;
	}
	
	
if($_POST["titulo"] != ""){		
		$titulo = addslashes($_POST["titulo"]);
	} else {
		$ok=0;
	}
	
if($_POST["autor"] != ""){		
		$autor = addslashes($_POST["autor"]);
	} else {
		$ok=0;
	}

	if($_POST["free"] != ""){		
		$free = addslashes($_POST["free"]);
	} else {
		$ok=0;
	}


	

if ($_REQUEST['cadastra']) {
	
			$sql = "INSERT INTO `avaliacao` (nome,objetivo,criador,qtde,free) VALUES ('$titulo','$objetivo','$autor','$qtde','$free')";
			//echo $sql;
			if (mysql_query($sql)) {
				$last = mysql_query("SELECT * FROM avaliacao ORDER BY id DESC");
				$last = mysql_fetch_array($last);
				$last = $last["id"];
				
				$ins = "INSERT INTO avaliacao_atividade (id_avaliacao) VALUES ('$last')";
				if(mysql_query($ins))
				{
				alert("Avaliação cadastrada com sucesso!");
				}
				redireciona("avaliacao_gerencia.php");
			} else {
				die("Erro: " . mysql_error());
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
			<form action="?cadastra=1&cod=<?=$depoimentos2?>" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
				
				
				
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Título: </span>
					</div>
					<input type="text" name="titulo" class="form_style" value="<?=$titulo?>" style="width: 500px;">
				</div>
				
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Objetivo: </span>
					</div>
					<textarea name="objetivo" class="form_style" style="width: 500px; height: 100px"><?=$objetivo?></textarea>
				</div>
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Qtde. de Afirmações: </span>
					</div>
					<input type="text" name="qtde" value="<?=$qtde?>" class="form_style" style="width: 50px;"> 
				</div>
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Gratuito: </span>
					</div>
					<input type="checkbox" name="free" value="1" class="form_style"> 
				</div>
				
				<div id="linha_form_auto">
					<div id="label">
						<span class="label_fonte">Autor(a): </span>
					</div>
					<input type="text" name="autor" value="<?=$autor?>" class="form_style" style="width: 500px;">
				</div>


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