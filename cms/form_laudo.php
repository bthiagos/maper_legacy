<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

$cod = $_REQUEST["cod"];

if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}

if($_SESSION["organizacaon"]){
	//$verifica = verificarOrganizacao($cod,$commit);
	$verifica = true;
    if(!$verifica){
		echo "Organização diferente do seu login.Proibido a visualização.";
		exit;
	}
}

$t = "aplicacoes".$tabela_commit;

?>


<?	

//$datax=array("Planejamento","Organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.à mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização");
$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Percepção/ priorização","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");
?>

<?
	if($_REQUEST["gerar"]){
		if($_REQUEST["commit"]){
			$commit=$_REQUEST["commit"];
			$tabela_commit = "_commit";
		}

$t = "aplicacoes".$tabela_commit;
				
		$i=0;
		while($i<20){
								$peso = "peso_".$i;
								$pesos .=	$_POST[$peso]."|";
								$i++;
		}							
		$pesos = trim($pesos);
		$descricao = nl2br($_POST["descricao"]);
		//echo $pesos;
		$sql_updt = "UPDATE $t SET pesos = '$pesos' , descricao= '$descricao' WHERE id=".$_REQUEST["cod"]; 
		mysql_query($sql_updt);
		
		$cod = $_REQUEST["cod"];
		
		$url = "http://www.appweb.com.br/cms/gerar_laudo.php?id=$cod&orga=$orga&commit=$commit";
		
		$resultado_url = executa_url($url);
	
		require_once("dompdf/dompdf_config.inc.php");
		
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($resultado_url);
		$dompdf->set_paper('a4', 'portrait');
		$dompdf->render();
		$dompdf->stream("App_Web.pdf");
		
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
			<div id="info">
				<img src="imagens/barra_cadastro_form.gif" alt="Formulário de avaliação de perfil do cargo" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="form2_laudo.php?gerar=1&cod=<?=$cod?>&commit=<?=$commit?>" method="post" onSubmit="return validaForm()" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			<div id="linha_form_auto">
					 <span class="label_fonte">
				<?
				
					$sql2 = "SELECT
				$t.id,
				$t.pesos,
				$t.descricao,
				$t.nome FROM
				$t WHERE id=".$_REQUEST["cod"];
					$result2 = mysql_query($sql2);
					$linha2 = mysql_fetch_assoc($result2);
					$nome = $linha2["nome"];
					$pesos = $linha2["pesos"];
					$descricao = $linha2["descricao"];
					$pesos2 = array();
					?>
				</span>
				</div>
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Descrição de cargo: </span> </div><textarea name="descricao" rows="10" cols="80"><?=$descricao?></textarea>
				</div>
			
				<div id="linha_form_auto">
				<span class="label_fonte">NOME: <b><?=$nome?></b>
			
				<?
					$i=0;
					while($i<20){
								$pesos2 = explode("|",$pesos);		
								//echo $teste[$i]."<br>";
								$i++;
					}
				
				?>
				
				</span>
				<div style="widht:100%">
						<table border="0" style="float:left; width:48%; height:auto;" align="left">
						<tr>
							<td width="40%" class="label_fonte">CARACTERÍSTICAS PROFISSIONAIS</td>
							<td class="label_fonte">Peso</td>
							
						</tr>
						
						<? $i=0;
						   $pos = 1;
						while($i<10){?>
						<tr>
							<td class="label_fonte"><? 
							
							echo $pos.".&nbsp;&nbsp;".$datax[$i]; ?></td>
							<td><!--<input type="text" size="10" name="peso_<?=$i?>" onKeyUp="javascript:somente_numero(this);" value="<?=$pesos2[$i]?>">-->
							<select name="peso_<?=$i?>">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							
							</select>	
								
							</td>
						
						</tr>
						
					
						
						<? $i++;$pos++; }?>
						
						</table>
						
						<table border="0" style="float:left; width:48%; height:auto;" align="left">
						<tr>
							<td width="40%" class="label_fonte">CARACTERÍSTICAS PESSOAIS</td>
							<td class="label_fonte">Peso</td>
							
						</tr>
						
						<? $i=10;
						   $pos = 1;
						while($i<20){?>
						<tr>
							<td class="label_fonte"><? 
							
							echo $pos.".&nbsp;&nbsp;".$datax[$i]; ?></td>
							<td><!--<input type="text" size="10" name="peso_<?=$i?>" onKeyUp="javascript:somente_numero(this);" value="<?=$pesos2[$i]?>">-->
								<select name="peso_<?=$i?>">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>	
							
							</td>
						
						</tr>
						
					
						
						<? $i++;$pos++; }?>
						
						</table>
			
				</div>
				</div>
				
				

					<p align="center"><input type="submit" value="Visualizar Formulário" class="form_style"></p>
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
</html>