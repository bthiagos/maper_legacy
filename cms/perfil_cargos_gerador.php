<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>

<style type="text/css">
.style17 {font-family: Arial; font-size:5px; font-weight: bold; }
.style18 {font-family: Helvetica; font-size:7px; }
body,td,th {
	font-family: Arial, Helvetica, serif;
	font-size:7px;
	margin-left: 8px;
	margin-top: 0px;
	margin-right: 10px;
	margin-bottom: 0px;
}

</style>
</head>

<body>

<?
include("conn.php");
include("library.php");




/*
$i=0;
while($i<20){
			$teste = explode("|",$pesos);		
			//echo $teste[$i]."<br>";
			$i++;
}		
$i=0;
while($i<20){
	echo $teste[$i];
	$i++;
}
*/

//$datax=array("Planejamento","Organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.as mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização");
$datax=array("Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Percepção/ priorização","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização");
?>

<?

		$dia = date("j");
		$mes = date("n");
		$ano = date("Y");
/*	if($_REQUEST["gerar"]){
		$i=0;
		$pos=1;
		while($i<20){
			$peso = "peso_".$i;
			echo $pos.".&nbsp;&nbsp;".$datax[$i].".&nbsp;&nbsp;".$_POST[$peso]."<BR>";
			
		$i++;$pos++;	
		}
	}
		echo "<BR><BR>";*/
?>

<?
$codigo_id = $_REQUEST["aplicacoes"]; 


$orga = $_REQUEST["orga"]; 
//CONECTA AO MYSQL                     

	if($_REQUEST["commit"]){
			$commit=$_REQUEST["commit"];
			$tabela_commit = "_commit";
		}

$t = "aplicacoes".$tabela_commit;

$sql = " SELECT * FROM $t WHERE id=".$codigo_id; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

$pGabarito = $linha["respostas"];
//echo $pGabarito;
if (!$pGabarito) {

$pGabarito = $_REQUEST["gabarito"]; 

}
$pNome = $linha["nome"]; 
$pCpf = $linha["cpf"]; 
$cpf = formatarCPF_CNPJ($pCpf);
$pNasc = $linha["nasc"];  
$pPerfil = "Profissional"; 
$pCargo= $linha["cargo"];  
$id_perfil = $linha["id_perfil"];

$getp = mysql_query("SELECT pci.* FROM perfil_cargos_itens pci, competencias c  WHERE id_perfil = '$id_perfil' and pci.id_competencia=c.competencias_id order by c.ordem") or die(mysql_error());
$pesos = "";
if(mysql_num_rows($getp) == 0) {
  $pesos = "1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|";   
} else {
while($pes = mysql_fetch_array($getp)) {
    $pesos .= $pes["peso"] . "|";
}
}


$pDescricao= $linha["descricao"];  
$pPesos= $pesos;  
$pSenha= "Spider29";  
$pesos2 = array();
$i=0;
while($i<20){
			$pesos = explode("|",$pPesos);		
			//echo $teste[$i]."<br>";
			$i++;
}
//$pGabarito = "ababbbbbbbaabbababaaaaaababbbbaabaaaaaaabbbaaabbabbbbbaaaaaabbbbbaaaaabbbbabababbbabbaaaaaaabababbbb";

// teste Mariana"abababbaaaabaabaaaabbaababbbaaaabbbbbbbabbbbabaababbaabababaaaabbabbbaaaaababababaaaababaaabaaababaa";
//teste Leandro $pGabarito = "abaaaaaabaababbbaaababaababbaaaababaaababbaaababbabababaaaabbbaababaaabbbaaabbabaaaabbbaaabbabbbbbaa";

$i = $j = $total = 0; $login =0;
$Opcao = "";
$id_competencia = "";
$sql = "";
$row = "";
$competencias [20];
$nome_competencias[20];


	$i = 0;
	while ($i<20){
		$competencias[$i]=0;
		$i++;
	}
	
switch ($pSenha) {	
	case "Spider29": $login=1; break; 
	case "Logus05": $login=1; break;
	case "Moto08": $login=1; break;
	case "Zero05": $login=1; break;
	default: $login=0; break;
}

if ($login==1){
if (strlen($pGabarito)==100){

	   		$sql = " 
       		SELECT c.descricao 
       		FROM  competencias c
	   		ORDER BY c.ordem";   

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
			for ($i=0; $i<$row; $i++){
   				$nome_competencias[$i] = htmlentities (mysql_result($sql, $i, "descricao"));
			}


	$i = 0;
	while ($i<100){
		
		$Opcao = $pGabarito[$i];
		
		if (strcmp($Opcao, "a") || strcmp($Opcao, "b")){
			//QUERY  
	   		$sql = " 
       		SELECT c.ordem 
       		FROM  questoes q, competencias c
	   		WHERE q.competencia_id=c.competencias_id and q.ordem = ". ($i+1) . " and q.sequencia like \"" . $Opcao . "\"";   

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca das questÃµes");    
			
   			$id_competencia  = mysql_result($sql, 0, "ordem");
			$competencias[$id_competencia-1]++;

		} //fim do if
		$i++;
	}
	$i = 0;
	$pos=1;
		$peso_total = 0;
		$nota_total = 0;
		$total_total = 0;
	?>
	
	<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:19px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?></td>
          <td width="52%">  <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
    
    <?php
        $perf = mysql_query("SELECT cargo, descricao FROM perfil_cargos WHERE id = '".$linha["id_perfil"]."'");
        if(mysql_num_rows($perf) == 0) { ?>
        <table width="90%" style="font-size: 18px; margin-top: 10px;" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000" align="center">
            <tr>
                <td width="15%"><strong>PERFIL DE CARGO: </strong></td><td>Nenhum</td>
            </tr>
            <tr>
                <td ><strong>DESCRIÇÃO: </strong></td><td>Perfil de cargo onde todas as competências possuem o mesmo peso.</td>
            </tr>
        </table>   
       <? 
        } else {
        $perf = mysql_fetch_array($perf);
        
    ?>
    <table width="90%" style="font-size: 18px; margin-top: 10px;" border="0" cellspacing="0" cellpadding="0" bordercolor="#000000" align="center">
        <tr>
            <td width="15%"><strong>PERFIL DE CARGO: </strong></td><td><?=$perf["cargo"]?></td>
        </tr>
        <tr>
            <td><strong>DESCRIÇÃO: </strong></td><td><?=$perf["descricao"]?></td>
        </tr>
    </table>
    <? } ?>
	<table align="center" width="90%" border="0" style="margin-top:5px;">
	<tr>
		<td align="center" colspan="2" class="style18" style="font-size:15px; margin-bottom:5px;">
	<b>FORMULÁRIO DE AVALIAÇÃO DO PERFIL DO CARGO</b>
		</td>
	</tr>
	
	
	<tr>
		<td colspan="2">
		<? echo $pDescricao; ?>
		</td>
	</tr>
	
	
		<tr><td width="50%">
	<table border="0"width="100%" align="left">
						<tr>
							<td width="50%"><span class="style18">CARACTERÍSTICAS <br>PROFISSIONAIS</span></td>
							<td ><span class="style18">Peso</span></td>
							<td ><span class="style18">Nota</span></td>
							<td ><span class="style18">Total</span></td>
							
						</tr>
	
<?	
	while ($i<10){ 
		$peso = "peso_".$i;
		?>
			
		<tr>
			<td><span class="style18"><? 
			
			echo $pos.".&nbsp;&nbsp;".$datax[$i]; ?></span></td>
			<td><span class="style18"><? echo $pesos[$i];?></span></td>
			<td><span class="style18"><? echo base10(($i+1),$competencias[$i])?></span></td>
			<td><span class="style18">
			<?
				$nota = base10(($i+1),$competencias[$i]);
				$valor_peso = $pesos[$i];
				$total = $nota * $valor_peso;
				echo $total;
				
			?>
			</span>
			</td>
		
		</tr>
	
		
		
<?		$peso_total += $pesos[$i];
		$nota_total += $nota;
		$total_total += $total;


		$i++;
		$pos++;
	}?>	
	
		<tr>
			<td><span class="style18">TOTAIS</span></td>
			<td><span class="style18"><?=$peso_total?></span></td>
			<td><span class="style18"><?
				$nota_total = $total_total/$peso_total;
				//echo number_format($nota_total,2);
				$nota_total = number_format($nota_total,2);
				echo $nota_total;
			
			?></span></td>
			<td><span class="style18"><?=$total_total?></span></td>
		</tr>
		
		
	
	</table>
		</td>
	<td>

	<table border="0" width="100%" align="left">
						<tr>
							<td width="50%"><span class="style18">CARACTERÍSTICAS<br> PESSOAIS</span></td>
							<td ><span class="style18">Peso</span></td>
							<td ><span class="style18">Nota</span></td>
							<td ><span class="style18">Total</span></td>
							
						</tr>
						
						<? 
						
						$peso_total = 0;
						$nota_total2 = 0;
						$total_total2 = 0;
						$i=10;
						   $pos = 1;
						while($i<20){
							$peso = "peso_".$i;
							?>
						<tr>
							<td><span class="style18"><? 
							
							echo $pos.".&nbsp;&nbsp;".$datax[$i]; ?></span></td>
							<td><span class="style18"><? echo $pesos[$i];?></span></td>
							<td><span class="style18"><? echo base10(($i+1),$competencias[$i])?></span></td>
							<td><span class="style18">
								<?
									$nota = base10(($i+1),$competencias[$i]);
									$valor_peso = $pesos[$i];
									$total = $nota * $valor_peso;
									echo $total;
									
								?></span>
							</td>
						
						</tr>
						
					
						
						<? $peso_total += $pesos[$i];
								$nota_total2 += $nota;
								$total_total2 += $total;
						
						
						$i++;$pos++; }?>
						
													
								<tr>
									<td><span class="style18">TOTAIS</span></td>
									<td><span class="style18"><?=$peso_total?></span></td>
									<td><span class="style18"><?
									$nota_total2 = $total_total2/$peso_total;
								//	echo number_format($nota_total2,2);
									$nota_total2 = number_format($nota_total2,2);
									echo $nota_total2;
									?></span></td>
									<td><span class="style18"><?=$total_total2?></span></td>
								</tr>
							
							</table>
							
							</td>
							</tr>			
					
						
						</table>
						<table border="0" align="center" width="79%"> 
							<tr align="left">
									<td width="50%" valign="top">
									<span class="style18">	M.P. GERAL =  <? echo number_format((($nota_total2+$nota_total)/2),2) ?></span>
									</td>	
									<td>
										<table border="0" width="100%">
											<tr>
												<td > <span class="style18">PESOS</span></td>
												<td > <span class="style18">NOTAS</span></td>
												<td colspan="2" > <span class="style18">DATA:  <?=$dia?>/<?=$mes?>/<?=$ano?></span></td>
									
											</tr>
											
											<tr>
												<td><span class="style18" style="font-size:6px;">   3 – INDISPENSÁVEL</span></td>
												<td> <span class="style18"style="font-size:6px;"> 9-10 – MUITO BOM </span></td>
												<td colspan="2"><span class="style18"style="font-size:6px;"> &nbsp;</span></td>
									
											</tr>	
											
											<tr>
												<td><span class="style18" style="font-size:6px;">  2 - MUITA IMPORTÂNCIA</span></td>
												<td><span class="style18" style="font-size:6px;">  7-8 - BOM</span></td>
												<td><span class="style18" style="font-size:6px;"> VISTO:</span></td>
												<td><span class="style18" style="font-size:6px;"> VISTO:</span></td>
									
											</tr>
											
											<tr>
												<td>  <span class="style18"style="font-size:6px;">  1 – DESEJÁVEL</span></td>
												<td> <span class="style18"style="font-size:6px;">  5-6 – MÉDIO</span></td>
												<td> </td>
												<td> </td>
									
											</tr>
											
											<tr>
												<td>   </td>
												<td>  <span class="style18"style="font-size:6px;"> 3-4 – FRACO</span></td>
												<td><span class="style18"style="font-size:6px;"> VISTO:</span></td>
												<td><span class="style18"style="font-size:6px;"> VISTO:</span></td>
									
											</tr>
											
											<tr>
												<td>   </td>
												<td>  <span class="style18"style="font-size:6px;">  0-2 - INSUFICIENTE</span></td>
												<td> </td>
												<td> </td>
									
											</tr>
											
										</table>
									</td>
							</tr>
						</table>
<?
}} //fim do while
					
?>					<div style="heigth:15px;">&nbsp;&nbsp;</div>
					<table width="79%" border="0" align="center">
						<tr>
							<td valign="top"><hr style="height: 1px; width: 70%; color: #666666; margin-top:10px">
						<div style="text-align: center; font-size: 12px">        
						Maria Lúcia Rodrigues Corrêa CRP 1560	
						</div>
						</td>
						</tr>
					</table>
</body>
</html>


<?

function base10 ($pCompentencia, $pNota){

			$sql = " 
       		SELECT f.descricao, f.base10
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
		
			return $a = mysql_result($sql, 0, "base10");
		

}

?>

