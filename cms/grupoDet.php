<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


			<?	
				///unlink('graficos_grupos/planejamento.png');
			
				//ARRAY COM A SOMA DAS COMPETENCIAS				
				$totaCompetencias = array();
				
				if ($_REQUEST["grupo"] != ""){
					$id_orga = $_REQUEST["grupo"];					
					$where = "WHERE organizacoes.id = '$id_orga'";
				}else{
					redireciona("aplica_gerencia.php");
				}
			
				$sql = "SELECT
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,				
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
				grupos.nome as grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.data_aplic desc
				
				
				";
				
				
				$result = mysql_query($sql);
				$nPessoas = mysql_num_rows($result);
				$y=1;
				while ($linha = mysql_fetch_assoc($result)) {
					$i++;
					$i = $j = $total = 0; $login =0;
					$Opcao = "";
					$id_competencia = "";
					$sql = "";
					$row = "";				
					$competencias [20];
				
				while ($i<20){
					$competencias[$i]=0;
					$i++;
				}
				
				$nome_competencias[20];
				$pGabarito = "";
				$pGabarito = $linha["respostas"];
				
				

					if (strlen($pGabarito)==100){

				   		$sql2 = " 
			       		SELECT c.descricao 
			       		FROM  competencias c
				   		ORDER BY c.ordem";   
			
						//EXECUTA A QUERY               
						$sql2 = mysql_query($sql2);       
						$row = mysql_num_rows($sql2) or die("erro na busca dos nomes das competÃªncias");    
						
						for ($i=0; $i<$row; $i++){
			   				$nome_competencias[$i] = htmlentities (mysql_result($sql2, $i, "descricao"));
						}
			
			
						$i = 0;
						while ($i<100){
							
							$Opcao = $pGabarito[$i];
							
							if (strcmp($Opcao, "a") || strcmp($Opcao, "b")){
								//QUERY  
						   		$sql3 = " 
					       		SELECT c.ordem 
					       		FROM  questoes q, competencias c
						   		WHERE q.competencia_id=c.competencias_id and q.ordem = ". ($i+1) . " and q.sequencia like \"" . $Opcao . "\"";   
					
								//EXECUTA A QUERY               
								$sql3 = mysql_query($sql3);       
								$row = mysql_num_rows($sql3) or die("erro na busca das questÃµes");    
								
					   			$id_competencia  = mysql_result($sql3, 0, "ordem");
								$competencias[$id_competencia-1]++;
					
							} //fim do if
							$i++;
						}		 //fim do while
															
				}
				$i = 0;
				while ($i<20){						 
					 $totaCompetencias[$y][$i] = $competencias[$i];					 
					 $i++;
				}
				
				$y++;
				}				
				?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
<style type="text/css">
.style17 {font-family: Arial; font-size: 8px; font-weight: bold; }
.style18 {font-family: Helvetica; font-size: 8px; }
body,td,th {
	font-family: Arial, Helvetica, serif;
	font-size: 8px;
}
body {
	margin-left: 8px;
	margin-top: 0px;
	margin-right: 10px;
	margin-bottom: 0px;
}
.folha {
    page-break-after: always;
}



</style>
</head>
<body>


<!------    PLANEJAMENTO     ------>
<p>

	<? 
	$zero = $umdois = $tres = $sete = $oitonove = $dez  = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==4 or $totaCompetencias[$a][0]==5 or $totaCompetencias[$a][0]==6){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==0){
			$zero++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==1 or $totaCompetencias[$a][0] ==2){
			$umdois++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==3){
			$tres++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==7){
			$sete++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==8 or $totaCompetencias[$a][0] ==9){
			$oitonove++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==10){
			$dez++;
		}
	}
	
	$url3 = "http://www.appweb.com.br/cms/planejamento.php?media=$media&zero=$zero&umdois=$umdois&tres=$tres&sete=$sete&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
	executa_url("$url3");
	
	?>

<!------    PLANEJAMENTO     ------>



<!------    ORGANIZAÇAO     ------>


	<? 
	$zeroumdois = $tres = $sete = $oitonovedez = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==4 or $totaCompetencias[$a][1]==5 or $totaCompetencias[$a][1]==6){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==0 or $totaCompetencias[$a][1] ==1 or $totaCompetencias[$a][1] ==2){
			$zeroumdois++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==3){
			$tres++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==7){
			$sete++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][1] ==8 or $totaCompetencias[$a][1] ==9 or $totaCompetencias[$a][1] ==10){
			$oitonovedez++;
		}
	}
			
	$url3 = "http://www.appweb.com.br/cms/organizacao.php?media=$media&zeroumdois=$zeroumdois&tres=$tres&sete=$sete&oitonovedez=$oitonovedez&nPessoas=$nPessoas";
	//echo $url3;
	executa_url("$url3");
	
	?>
	
	<? 
	
	$zeroumdoistres = $quatro = $cinco = $oito = $novedez = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] == 6 or $totaCompetencias[$a][2]== 7){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==0 or $totaCompetencias[$a][2]==1 or $totaCompetencias[$a][2]==2 or $totaCompetencias[$a][2]==3){
			$zeroumdoistres++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==4){
			$quatro++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==5){
			$cinco++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==8){
			$oito++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][2] ==9 or $totaCompetencias[$a][2] ==10){
			$novedez++;
		}
	}
			
	$url3 = "http://www.appweb.com.br/cms/acompanhamento.php?media=$media&zeroumdoistres=$zeroumdoistres&quatro=$quatro&cinco=$cinco&oito=$oito&novedez=$novedez&nPessoas=$nPessoas";
	//echo $url3;
	executa_url("$url3");
	
	?>
	
<!------    ACOMPANHAMENTO     ------>



<!------    LIDERANÇA    ------>

	<? 
	
	$zeroquatro = $cinco = $dez = $oitonove = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] == 6 or $totaCompetencias[$a][3]== 7){
			$media++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] == 0 or $totaCompetencias[$a][3]==1 or $totaCompetencias[$a][3]==2 or $totaCompetencias[$a][3]==3or $totaCompetencias[$a][3]==4){
			$zeroquatro++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] ==5){
			$cinco++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] ==8 or $totaCompetencias[$a][3] ==9 ){
			$oitonove++;
		}
	}
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][3] ==10){
			$dez++;
		}
	}
	

			
	$url3 = "http://www.appweb.com.br/cms/lideranca.php?media=$media&zeroquatro=$zeroquatro&cinco=$cinco&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
	//echo $url3;
	executa_url("$url3");
	
	?>
	

<!------    LIDERANÇA    ------>

<!------ COMUNICAÇÃO ------>

<?

$zerotres = $quatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] == 5 or $totaCompetencias[$a][4]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] == 0 or $totaCompetencias[$a][4]==1 or $totaCompetencias[$a][4]==2 or $totaCompetencias[$a][4]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] ==4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] ==7 or $totaCompetencias[$a][4] ==8 or $totaCompetencias[$a][4] ==9 or $totaCompetencias[$a][4] ==10 ){
$setedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/comunicacao.php?media=$media&zerotres=$zerotres&quatro=$quatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ COMUNICAÇÃO ------>


<!------ DECISÃO ------>


<?

$zeroum = $doisquatro = $cinco = $oitodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 6 or $totaCompetencias[$a][5]== 7){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 0 or $totaCompetencias[$a][5]==1){
$zeroum++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 2 or $totaCompetencias[$a][5]==3 or $totaCompetencias[$a][5]==4){
$doisquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] == 5){
$cinco++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][5] ==8 or $totaCompetencias[$a][5] ==9 or $totaCompetencias[$a][5] ==10){
$oitodez++;
}
}

$url3 = "http://www.appweb.com.br/cms/decisao.php?media=$media&zeroum=$zeroum&doisquatro=$doisquatro&cinco=$cinco&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ DECISÃO ------>


<!------ DETALHISMO/DELEGAÇÃO ------>

<?

$doistres = $quatro = $cincoseis = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 0 or $totaCompetencias[$a][6]== 1){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 2 or $totaCompetencias[$a][6]==3){
$doistres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] == 5 or $totaCompetencias[$a][6]==6){
$cincoseis++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][6] ==7 or $totaCompetencias[$a][6] ==8 or $totaCompetencias[$a][6] ==9 or $totaCompetencias[$a][6] ==10){
$setedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/detalhismo.php?media=$media&doistres=$doistres&quatro=$quatro&cincoseis=$cincoseis&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ DETALHISMO/DELEGAÇÃO ------>

<!------ TEMPO DE EXECUÇÃO ------>


<?
//zeroum doistres quatro oitonove dez
$zeroum = $doistres = $quatro = $oitonove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 5 or $totaCompetencias[$a][7]== 6 or $totaCompetencias[$a][7]== 7){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 0 or $totaCompetencias[$a][7]==1){
$zeroum++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 2 or $totaCompetencias[$a][7]==3){
$doistres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] ==8 or $totaCompetencias[$a][7] ==9){
$oitonove++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] ==10){
$dez++;
}
}

$url3 = "http://www.appweb.com.br/cms/tempoexecucao.php?media=$media&zeroum=$zeroum&doistres=$doistres&quatro=$quatro&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ TEMPO DE EXECUÇÃO ------>


<!------ INTENSIDADE OPERACIONAL ------>

<?
//zerotres seteoito nove dez
$zerotres = $seteoito = $nove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 4 or $totaCompetencias[$a][8]== 5 or $totaCompetencias[$a][8]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 0 or $totaCompetencias[$a][8]==1 or $totaCompetencias[$a][8]==2 or $totaCompetencias[$a][8]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 7 or $totaCompetencias[$a][8]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] == 9){
$nove++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][8] ==10){
$dez++;
}
}

$url3 = "http://www.appweb.com.br/cms/intensidade.php?media=$media&zerotres=$zerotres&seteoito=$seteoito&nove=$nove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ INTENSIDADE OPERACIONAL ------>


<!------ FLEXIBILIDADE - CRIATIVIDADE ------>

<?
//tres quatroseis setedez
$tres = $quatroseis = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 0 or $totaCompetencias[$a][9]== 1 or $totaCompetencias[$a][9]== 2){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 3){
$tres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 4 or $totaCompetencias[$a][9]==5 or $totaCompetencias[$a][9]==6){
$quatroseis++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][9] == 7 or $totaCompetencias[$a][9]==8 or $totaCompetencias[$a][9]==9 or $totaCompetencias[$a][9]==10){
$setedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/criatividade.php?media=$media&tres=$tres&quatroseis=$quatroseis&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ FLEXIBILIDADE - CRIATIVIDADE ------>


<!------ PERCEPÇÃO / PRIORIZAÇÃO ------>
<?

//zerotres seis seteoito novedez
$zerotres = $seis = $seteoito = $novedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 4 or $totaCompetencias[$a][10]== 5){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 0 or $totaCompetencias[$a][10]==1 or $totaCompetencias[$a][10]==2 or $totaCompetencias[$a][10]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 6){
$seis++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] == 7 or $totaCompetencias[$a][10]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][10] ==9 or $totaCompetencias[$a][10]==10){
$novedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/percepsao.php?media=$media&zerotres=$zerotres&seis=$seis&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ PERCEPÇÃO / PRIORIZAÇÃO ------>

<!------ ADAPTABILIDADE A MUNDANÇAS ------>

<?

$zeroquatro = $setenove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 0 or $totaCompetencias[$a][11]== 1 or $totaCompetencias[$a][11]== 2){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 0 or $totaCompetencias[$a][11]==1 or $totaCompetencias[$a][11]==2 or $totaCompetencias[$a][11]==3 or $totaCompetencias[$a][11]==4){
$zeroquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 7 or $totaCompetencias[$a][11]==8 or $totaCompetencias[$a][11]==9){
$setenove++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 10){
$dez++;
}
}

$url3 = "http://www.appweb.com.br/cms/mudancas.php?media=$media&zeroquatro=$zeroquatro&setenove=$setenove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ ADAPTABILIDADE A MUNDANÇAS ------>


<!------ RELAÇÃO COM AUTORIDADE ------>

<?

$zerotres = $seteoito = $novedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 4 or $totaCompetencias[$a][12]== 5 or $totaCompetencias[$a][12]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 0 or $totaCompetencias[$a][12]==1 or $totaCompetencias[$a][12]==2 or $totaCompetencias[$a][12]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 7 or $totaCompetencias[$a][12]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][12] == 9 or $totaCompetencias[$a][12]==10){
$novedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/autoridade.php?media=$media&zerotres=$zerotres&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ RELAÇÃO COM AUTORIDADE ------>

<!------ ADMINISTRAÇÃO DE CONFLITOS ------>


<?

$zerodois = $tresquatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 5 or $totaCompetencias[$a][13]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 0 or $totaCompetencias[$a][13]==1 or $totaCompetencias[$a][13]==2){
$zerodois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 3 or $totaCompetencias[$a][13]==4){
$tresquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][13] == 7 or $totaCompetencias[$a][13]==8 or $totaCompetencias[$a][13]==9 or $totaCompetencias[$a][13]==10){
$setedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/administracaodeconflitos.php?media=$media&zerodois=$zerodois&tresquatro=$tresquatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>


<!------ ADMINISTRAÇÃO DE CONFLITOS ------>


<!------ CONTROLE EMOCIONAL ------>

<?

$zerodois = $tres = $sete = $oitodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 4 or $totaCompetencias[$a][14]== 5 or $totaCompetencias[$a][14]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 0 or $totaCompetencias[$a][14]==1 or $totaCompetencias[$a][14]==2){
$zerodois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 3){
$tres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] == 7){
$sete++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][14] ==8 or $totaCompetencias[$a][14]==9 or $totaCompetencias[$a][14]==10){
$oitodez++;
}
}

$url3 = "http://www.appweb.com.br/cms/controleemocional.php?media=$media&zerodois=$zerodois&tres=$tres&sete=$sete&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ CONTROLE EMOCIONAL ------>


<!------ AFETIVIDADE ------>

<?

$zerodois = $cinco = $seisdez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 3 or $totaCompetencias[$a][15]== 4){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 0 or $totaCompetencias[$a][15]==1 or $totaCompetencias[$a][15]==2){
$zerodois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 5){
$cinco++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][15] == 6 or $totaCompetencias[$a][15]==7 or $totaCompetencias[$a][15]==8 or $totaCompetencias[$a][15]==9 or $totaCompetencias[$a][15]==10){
$seisdez++;
}
}

$url3 = "http://www.appweb.com.br/cms/afetividade.php?media=$media&zerodois=$zerodois&cinco=$cinco&seisdez=$seisdez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>

<!------ AFETIVIDADE ------>

<!------ SOCIABILIDADE ------>

<?

$zerotres = $seteoito = $novedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 4 or $totaCompetencias[$a][16]== 5 or $totaCompetencias[$a][16]== 6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 0 or $totaCompetencias[$a][16]==1 or $totaCompetencias[$a][16]==2 or $totaCompetencias[$a][16]==3){
$zerotres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 7 or $totaCompetencias[$a][16]==8){
$seteoito++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][16] == 9 or $totaCompetencias[$a][16]==10){
$novedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/sociabilidade.php?media=$media&zerotres=$zerotres&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ SOCIABILIDADE ------>
<!------ AUTO-IMAGEM ------>

<?

$zero = $umdois = $tres = $cincodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 4){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 0){
$zero++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 1 or $totaCompetencias[$a][17]==2){
$umdois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] == 3){
$tres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][17] ==5 or $totaCompetencias[$a][17]==6 or $totaCompetencias[$a][17]==7 or $totaCompetencias[$a][17]==8 or $totaCompetencias[$a][17]==9 or $totaCompetencias[$a][17]==10){
$cincodez++;
}
}

$url3 = "http://www.appweb.com.br/cms/autoimagem.php?media=$media&zero=$zero&umdois=$umdois&tres=$tres&cincodez=$cincodez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ AUTO-IMAGEM ------>

<!------ ENERGIA VITAL ------>

<?

$zero = $umdois = $tresquatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 5 or $totaCompetencias[$a][18]==6){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 0){
$zero++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 1 or $totaCompetencias[$a][18]==2){
$umdois++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18] == 3 or $totaCompetencias[$a][18]==4){
$tresquatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][18]==7 or $totaCompetencias[$a][18]==8 or $totaCompetencias[$a][18]==9 or $totaCompetencias[$a][18]==10){
$setedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/energiavital.php?media=$media&zero=$zero&umdois=$umdois&tresquatro=$tresquatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ ENERGIA VITAL ------>

<!------ REALIZAÇÃO ------>

<?

$umtres = $quatro = $oitodez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 5 or $totaCompetencias[$a][19]== 6 or $totaCompetencias[$a][19]== 7){
$media++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 0 or$totaCompetencias[$a][19] == 1 or $totaCompetencias[$a][19]==2 or $totaCompetencias[$a][19]==3){
$umtres++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 4){
$quatro++;
}
}

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][19] == 8 or $totaCompetencias[$a][19]==9 or $totaCompetencias[$a][19]==10){
$oitodez++;
}
}

$url3 = "http://www.appweb.com.br/cms/realizacao.php?media=$media&umtres=$umtres&quatro=$quatro&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ REALIZAÇÃO ------>
<? redireciona('grupoDet_pdf.php');?>

</body>
</html>
		