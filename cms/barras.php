<? include('conn.php'); ?> 
<?
if ($_REQUEST["insc_id"]) {
	$id_atv = $_REQUEST["insc_id"];

	
	$sql = "SELECT *,date_format(data_insc, '%d/%m/%Y %H:%i') AS data_evento_1 FROM inscritos_curso WHERE id=$id_atv";
	
	//echo $sql;
	
	$result = mysql_query($sql);
	$linha = mysql_fetch_assoc($result);
	$nome = $linha["nome_completo"];
	$matricula = $linha["rg"];
	$local = $linha["endereco"];
	$data_evento_1 = $linha["data_evento_1"];
	
	
}


?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' rel='stylesheet' type='text/css'>	
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<title>APP Web | Comprovante</title>
		<style>
		.centro_cmprova {
			margin-top: 15px;
			width: 450px;
			margin: 0 auto;
			padding: 10px;
			border: 1px solid #000000;
		}
		
		.tb_comprova {
			width: 90%;
			margin: 0 auto;
			font-family: Arial;
			font-size: 12px;
			text-transform: uppercase;
		}
		
		.bt_comprovante2 {
			background-color: #f79733;
			padding: 5px;
			color: #ffffff;
			text-transform: uppercase;
			width: 80px; 
			font-weight: bold;
		}
		
		h1, h2 {
			margin-top: 0px;
			text-align: center;
		}

		</style>
	</head>
	<!--onload="window.print();"-->
	<body >
		<p style="text-align: center;">
		<input type="button" name="imprimir" value="Imprimir Comprovante" style="margin: 0 auto;" onclick="window.print();">
		</p>
		<div class="centro_cmprova">
			
			<div style="text-align: center; margin-bottom: 10px; margin-top: 10px;" align="center">
				<img src="../img/logo.png" style="height: 34px; margin-right: 15px;" />
			</div>
			
			<table class="tb_comprova" align="center" cellspacing="10">
				<tr>
					<td colspan="2">
						<h1>NEUROLIDERANÇA A MENTE DO NOVO LÍDER</h1><br/>
						<h2>29 de outubro de 2014 <br/> 8:00hs ás 12:00hs</h2>
					</td>
				</tr>
				<tr>
					<td valign="top">Nome:</td>
					<td><?=$nome;?></td>
				</tr>
				<tr>
					<td valign="top">Data da Inscrição</td>
					<td>
						<?=$data_evento_1;?>
					</td>
				</tr>
				<tr>
					<td valign="top">Local Do Evento:</td>
					<td>
					FIEMG - Federação das Indústrias do Estado de Minas Gerais <br/>
					Auditório Albano Franco <br/>
					Av. do Contorno, 4520 (térreo) - B. Funcionários - BH/MG <br/>
					</td>
				</tr>
			</table>
			
			
		</div>
	
	</body>
</html>







