<?php include("conn.php"); ?>
<?php include("library.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body style="font-family:tahoma; font-size:12px;">

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>
<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
<?
				$sql = "SELECT *,date_format(data_enviado, '%d-%m-%Y') as data_formatada FROM pesquisa_enviados WHERE id=".$_REQUEST["cod"];
				//echo $sql;
				$result = mysql_query($sql);
				$tiporesp = $_REQUEST["tiporesp"];
				$i=0;
				$linha = mysql_fetch_assoc($result);
				$data = $linha["data_formatada"];
				$id = $linha["id"];
				$pesquisa = explode("|",$linha["codpesquisa"]);
				$perguntas = explode("#",$linha["perguntas"]);
				$formato_alternativa = explode("#",$linha["formato_alternativa"]);
				$alternativas = explode("#",$linha["alternativas"]);
				$respostas = explode("#",$linha["respostas"]);
				$outra = explode("#",$linha["outra"]);
				$nome_pasta= "$id"."_".$data;
				
				$dir = "/home/appweb/public_html/cms/graficos_pesquisa/barra/$nome_pasta/";
				
				if (!(is_dir("$dir"))){
				//mkdir ("$dir", 0777 );
				}
				
				

?>
	<div class="txt_chamada" style="width: 100%; margin-top: 20px; margin-left:10px;">
			<?=$pesquisa[1]?>
		</div>
	
		<div class="textos" style="width: 100%; margin-top: 20px; float: left;  margin-left:10px;">
			<?=$pesquisa[2]?>
		</div>
<table width="100%" border="0" align="left" cellspacing="5" cellpadding="5">
		
			<?	//echo count($perguntas);
				for($i=0;$i<count($perguntas)-1;$i++){
					
				$separar_pergunta_txto = explode("|",$perguntas[$i]);
				
				$pergunta = $separar_pergunta_txto[0];
				$texto = $separar_pergunta_txto[1];
				
				//SE EXISTIR UM TEXTO DE INTRODUCAO
					if($texto != ""){					
				?>
				<tr>
						<td> <?=nl2br($texto)?></td>
				</tr>
						<?}?>
					
				<tr>
					<td><b><?=$i+1?>. <?=$pergunta?></b></td>
				</tr>
		
			<? if($formato_alternativa[$i] == 1){ 
				
				
				?>				
				<tr>
					<td><?=str_ireplace("^","<br><br>",$respostas[$i]);?></td>
				</tr>
							
			<?}?>
			
			<? if($formato_alternativa[$i] == 2){
					$p=$i+1;
					$nome_imagem = $p."_".$p;
					$alt_trim = trim(str_ireplace(" ","-",$alternativas[$i]));
					$url = "http://www.appweb.com.br/cms/gerar_grafico_barra.php?item=$p&pergunta=$p&alternativa=$alt_trim&resposta=$respostas[$i]&pasta=$nome_pasta&tiporesp=$tiporesp";			
					$resultado_url = executa_url("$url");					
					//echo $url;
					
					$todas_alternativas = explode("|",$alternativas[$i]);
					$todas_outra = explode("|",$outra[$i]);
					$pergunta2  = str_ireplace(" ","",$pergunta);	
					
					if(($_REQUEST["cod"] == "85") AND ($i==0)){
			?>
						<tr>
								<td><img src="graficos_pesquisa/barra/<?=$nome_pasta?>/iel.png" ></td>
						</tr>
					
				<?	}else{?>
						<tr>
								<td><img src="graficos_pesquisa/barra/<?=$nome_pasta?>/<?=$nome_imagem?>.png" ></td>
						</tr>
					
			<?	}
							$y = (count($todas_alternativas)-1);
				
							if($todas_alternativas[$y] == "Informações Adicionais"){
								
								
						$retirando = explode("^",$todas_outra[$y]);								
				?>
							
							<tr>
								<td><b>Informações Adicionais</b>:</td>
							</tr>
							
							<tr>
								<td>
									<?
										for($n=1;$n<=count($retirando);$n++){
											echo "<p>".$retirando[$n]."</p>";
										}
										
										
									?>
								
								</td>
							</tr>								
						<?	}							
					}?>		

				<tr>
				<td><hr></td>
				</tr>				
											
		<?}?>
		
						
		
			
		</table>
</div>