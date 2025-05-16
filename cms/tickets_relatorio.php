<?php include("logon.php"); ?>

<?php include("conn.php"); ?>	

<?php include("library.php"); ?>

 
<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM coach_videos WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("VÍDEO EXCLUÍDO COM SUCESSO!");
	}
	
}
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra'])  {
	
	// Varificacao de campos
	$ok = 1;
	
	if (!($_POST["titulo"] == "")) {
		$titulo = addslashes($_POST["titulo"]);
	} else {
		$ok = 0;
		$msgErro .= "CAMPO TÍTULO OBRIGATÓRIO".'\n';
	}
	

	
	if (!($_POST["descricao"] == "")) {
		$descricao =  addslashes($_POST["descricao"]);
	} else {
		$ok = 0;
		$msgErro .= "CAMPO DESCRIÇÃO OBRIGATÓRIO".'\n';
	}
	
	if (!($_POST["video"] == "")) {
		$video = $_POST["video"];
	} else {
		$ok = 0; 
		$msgErro .= "CAMPO VÍDEO OBRIGATÓRIO".'\n';
	}
	


			// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert($msgErro);
	} else {

				// Gravando dados no banco
				$sql = "INSERT INTO coach_videos (titulo,descricao,video)
			VALUES ('$titulo','$descricao','$video')";
				 
				// Confirmacao de insert
				if (mysql_query($sql)) { 
					alert("VÍDEO CADASTRADO COM SUCESSO!");
					redireciona("coach_cvideos.php");
				} else {
					die(mysql_error());
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
            $org = $_GET["org"];
            $gru = $_GET["gru"];
            
            $orga = mysql_query("SELECT * FROM organizacoes WHERE id = '$org'");
            $orga = mysql_fetch_array($orga);
            $orga_nome = $orga["nome"];
            
            $grup = mysql_query("SELECT * FROM grupos WHERE id = '$gru'");
            $grup = mysql_fetch_array($grup);
            $grup_nome = $grup["nome"];
        ?>
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->

		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal" style="border: 0px;">
		

			<!-- INICIO - DIV info fim - Barra de informacao -->				



				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Empresa: <?=$orga_nome?></td>
						<td align="center">Data: </td>			
					</tr>
                    
                    <tr height="30">
						<td align="center">Lote</td>
						<td align="center">Número dos Tickets</td>			
					</tr>
				
					
			<?
				$sql = "SELECT * FROM coach_videos";
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">

						<td align="center" ><?=$linha["titulo"]?> </td>
                        <td align="center" ><?=$linha["titulo"]?> </td>
					</tr>
				<?
				}
				?>
				</table>


	</div>
	
			</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>