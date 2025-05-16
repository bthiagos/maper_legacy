<?
ini_set("memory_limit", "4096M");
ini_set('max_execution_time',  600); 
//ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?

if(!isset($_GET["lang"])) {
	$desc = "descricao";
	$lang = "pt";
} else {
	$lang = $_GET["lang"];
}

if($lang == "pt" or $lang == "br") {
	$desc = "descricao";
}
if($lang == "en") {
	$desc = "descricao_en";
}
if($lang == "es") {
	$desc = "descricao_es";
}


// "Gerar" é um array de checkbox que traz as pessoas que participam do gráfico.

// Checa se vai gerar o gráfico por pessoa selecionada
if($_POST["pessoas"] != 0){
	if($_POST['gerar'] == ""){	
		redireciona('grupoMont_operacional.php');
	}else{
		$grupos = $_POST['gerar'];
	}
	
	for($i=0;$i<count($grupos);$i++){
		if($i==0){
			$where = " WHERE aplicacoes.id = ". $grupos[$i]. "";
		}else{
			$where .= " or aplicacoes.id = ". $grupos[$i]. "";
		}	
	}
}

// Checa se vai gerar o gráfico de todos presentes no grupo
if($_POST["grupos"] != 0){
	$where = $_POST["awhere"];
}


        include ("src/jpgraph.php");
        include ("src/jpgraph_line.php");
        include ("src/jpgraph_bar.php");


		$graCOMPETENCIAS[20];
			$sql = "SELECT
				aplicacoes.id,
				aplicacoes.respostas,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.data_aplic desc ";
			
				//break;
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
				
				//echo $pGabarito."<br>";
				

					if (strlen($pGabarito)==100){

				   		$sql2 = " 
			       		SELECT c.$desc
			       		FROM  competencias c
				   		ORDER BY c.ordem";   
						//EXECUTA A QUERY               
						$sql2 = mysql_query($sql2);       
						$row = mysql_num_rows($sql2) or die("erro na busca dos nomes das competências");    
						
						for ($i=0; $i<$row; $i++){
			   				$nome_competencias[$i] = htmlentities (mysql_result($sql2, $i, $desc));
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
				
				$i = 0;			
				while($i<20){
					for($a=0;$a<=$nPessoas;$a++){
						$graCOMPETENCIAS[$i] = $graCOMPETENCIAS[$i] + $totaCompetencias[$a][$i];
					}
					$i++;
				}
				
				$i=0;	
				while($i<20){
						$graCOMPETENCIA[$i] = round($graCOMPETENCIAS[$i]/$nPessoas);	
						// $graCOMPETENCIA[$i]."<br>";
						$i++;	
				}
				
				
////////////////// GERAR GRAFICO
	
		$datay[0] = "";
		$y = -1;
		$i = 1;
			$linha_arquivo = 1;
		//	echo "<p><b>CompetÃªncias:</b></p>";
			while ($i<22){
				
				$y++;
			

				if ($i >= 0 and $i <= 21) {
					$datay[$i] = $graCOMPETENCIA[$y];
					//$datay[$i] = $competencias[$y];
				}
				
			$total = $total + $competencias[$i];
			$i++;
			$linha_arquivo++;
		}

	
	
	


// BARRA FIXA
//$datay2 = array("",6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,4,6,6,7,"");
//$datay3 = array("",4,4,6,6,5,6,0,5,4,0,4,4,5,4,5,3,4,4,5,5,"");
//$datay2 = array("",6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,6,4,6,7,"");
//$datay3 = array("",4,4,6,6,5,6,0,5,4,0,4,5,4,5,4,3,4,4,5,5,"");
//	
$datay2 = array("",6,5,7,7,6,7,2,7,6,2,5,6,6,6,5,4,6,4,6,7,"");
$datay3 = array("",5,4,5,5,5,5,0,5,5,0,4,5,5,5,4,3,5,4,5,5,"");	

$graph = new Graph(900,700,"auto");
$graph->SetScale("textint",0,10);
$graph->yscale-> ticks->Set(2,2);

$datax = array("");

$sql_comps = mysql_query("SELECT $desc FROM competencias order by ordem ASC");
while($c = mysql_fetch_array($sql_comps)) {
	array_push($datax,$c[$desc]);
}
array_push($datax,"");

//$datax=array("","Capacidade de planejamento","Capacidade de organização","Capacidade de acompanhamento","Estilo de liderança","Estilo de comunicação","Tomada de decisão","Capacidade de delegação","Administração do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Cap. priorizar e trab. c/ imprevistos","Gestão de mudanças","Relacionamento com superiores","Gestão de conflitos","Controle das emoções","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","Tônus vital","Necessidade de realização","");

//$datax=array("","Capacidade de planejamento","Capacidade de organização","Acompanhamento","Liderança","Comunicação","Decisão","Detalhismo","T. de Execução","Intens.Operacional","Flex./Criatividade","Percepção","Adap.as mudanças","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realização","");


//$graph->img->SetMargin(190,320,190,290);          
$graph->img->SetMargin(20,140,20,240); 
$graph->SetShadow();
$graph->SetMarginColor("#ffffff");
//$graph->SetBackgroundColor("#FEFEDF");
$graph->SetColor('#ffffff');

$graph->title->Set("Avaliação do Potencial e Perfil - APP");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->legend->Pos(0.0,0.1,"right","center");


$p1 = new LinePlot($datay);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("blue");
$p1->mark->SetWidth(4);
$p1->SetColor("blue");
$p1->SetWeight(2);
$p1->SetLegend("Perfil Candidatos");


$p2 = new LinePlot($datay2);
$p2->SetFillColor("#FFFF66@0.0");
$p2->mark->SetWidth(0);
$p2->SetColor("#FFFF66");
$p2->SetLegend("Perfil Ideal");


$p3 = new LinePlot($datay3);
$p3->SetFillColor("#ffffff@0.0");
$p3->mark->SetWidth(0);
$p3->SetColor("#ffffff");


$graph->Add($p2);
$graph->Add($p3);
$graph->Add($p1);

$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(90);


$graph->Stroke("graficos_grupos/grupos2.png");
				
/////////////////// fim grafico	

	$zero = $umdois = $tres = $sete = $oitonove = $dez  = $media = 0;
	
	for($a=1;$a<=$nPessoas;$a++){
		if($totaCompetencias[$a][0] ==4 or $totaCompetencias[$a][0]==5 or $totaCompetencias[$a][0]==6){
			$media++;
		}
	
	
	
		if($totaCompetencias[$a][0] ==0){
			$zero++;
		}
	

		if($totaCompetencias[$a][0] ==1 or $totaCompetencias[$a][0] ==2){
			$umdois++;
		}
	
	
	
		if($totaCompetencias[$a][0] ==3){
			$tres++;
		}

	
	
		if($totaCompetencias[$a][0] ==7){
			$sete++;
		}
	
	
	
		if($totaCompetencias[$a][0] ==8 or $totaCompetencias[$a][0] ==9){
			$oitonove++;
		}
	
	
	
		if($totaCompetencias[$a][0] ==10){
			$dez++;
		}
	}
	
	$url3 = "http://www.appweb.com.br/cms/planejamento.php?lang=$lang&media=$media&zero=$zero&umdois=$umdois&tres=$tres&sete=$sete&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
	//echo $url3;
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
	

		if($totaCompetencias[$a][1] ==0 or $totaCompetencias[$a][1] ==1 or $totaCompetencias[$a][1] ==2){
			$zeroumdois++;
		}
	
	
	
		if($totaCompetencias[$a][1] ==3){
			$tres++;
		}
	
	
	
		if($totaCompetencias[$a][1] ==7){
			$sete++;
		}
	
	
	
		if($totaCompetencias[$a][1] ==8 or $totaCompetencias[$a][1] ==9 or $totaCompetencias[$a][1] ==10){
			$oitonovedez++;
		}
	}
			
	$url3 = "http://www.appweb.com.br/cms/organizacao.php?lang=$lang&media=$media&zeroumdois=$zeroumdois&tres=$tres&sete=$sete&oitonovedez=$oitonovedez&nPessoas=$nPessoas";
	//echo $url3;
	executa_url("$url3");
	
	?>
	
<!------    ORGANIZAÇAO     ------>


<!------ COMUNICAÇÃO ------>
<?

$zerotres = $quatro = $setedez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][4] == 5 or $totaCompetencias[$a][4]== 6){
$media++;
}



if($totaCompetencias[$a][4] == 0 or $totaCompetencias[$a][4]==1 or $totaCompetencias[$a][4]==2 or $totaCompetencias[$a][4]==3){
$zerotres++;
}


if($totaCompetencias[$a][4] ==4){
$quatro++;
}



if($totaCompetencias[$a][4] ==7 or $totaCompetencias[$a][4] ==8 or $totaCompetencias[$a][4] ==9 or $totaCompetencias[$a][4] ==10 ){
$setedez++;
}
}

$url3 = "http://www.appweb.com.br/cms/comunicacao.php?lang=$lang&media=$media&zerotres=$zerotres&quatro=$quatro&setedez=$setedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ COMUNICAÇÃO ------>



<!------ TEMPO DE EXECUÇÃO ------>
<?
//zeroum doistres quatro oitonove dez
$zeroum = $doistres = $quatro = $oitonove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][7] == 5 or $totaCompetencias[$a][7]== 6 or $totaCompetencias[$a][7]== 7){
$media++;
}



if($totaCompetencias[$a][7] == 0 or $totaCompetencias[$a][7]==1){
$zeroum++;
}



if($totaCompetencias[$a][7] == 2 or $totaCompetencias[$a][7]==3){
$doistres++;
}



if($totaCompetencias[$a][7] == 4){
$quatro++;
}


if($totaCompetencias[$a][7] ==8 or $totaCompetencias[$a][7] ==9){
$oitonove++;
}


if($totaCompetencias[$a][7] ==10){
$dez++;
}
}

$url3 = "http://www.appweb.com.br/cms/tempoexecucao.php?lang=$lang&media=$media&zeroum=$zeroum&doistres=$doistres&quatro=$quatro&oitonove=$oitonove&dez=$dez&nPessoas=$nPessoas";
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



if($totaCompetencias[$a][8] == 0 or $totaCompetencias[$a][8]==1 or $totaCompetencias[$a][8]==2 or $totaCompetencias[$a][8]==3){
$zerotres++;
}


if($totaCompetencias[$a][8] == 7 or $totaCompetencias[$a][8]==8){
$seteoito++;
}



if($totaCompetencias[$a][8] == 9){
$nove++;
}



if($totaCompetencias[$a][8] ==10){
$dez++;
}
}

$url3 = "http://www.appweb.com.br/cms/intensidade.php?lang=$lang&media=$media&zerotres=$zerotres&seteoito=$seteoito&nove=$nove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ INTENSIDADE OPERACIONAL ------>


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

$url3 = "http://www.appweb.com.br/cms/percepsao.php?lang=$lang&media=$media&zerotres=$zerotres&seis=$seis&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ PERCEPÇÃO / PRIORIZAÇÃO ------>

<!------ ADAPTABILIDADE A MUNDANÇAS ------>

<?

$zeroquatro = $setenove = $dez = $media = 0;

for($a=1;$a<=$nPessoas;$a++){
if($totaCompetencias[$a][11] == 5 or $totaCompetencias[$a][11]== 6){
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

$url3 = "http://www.appweb.com.br/cms/mudancas.php?lang=$lang&media=$media&zeroquatro=$zeroquatro&setenove=$setenove&dez=$dez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ ADAPTABILIDADE A MUNDANÇAS ------>


<div class="folha">&nbsp;</div>

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

$url3 = "http://www.appweb.com.br/cms/administracaodeconflitos.php?lang=$lang&media=$media&zerodois=$zerodois&tresquatro=$tresquatro&setedez=$setedez&nPessoas=$nPessoas";
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

$url3 = "http://www.appweb.com.br/cms/controleemocional.php?lang=$lang&media=$media&zerodois=$zerodois&tres=$tres&sete=$sete&oitodez=$oitodez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ CONTROLE EMOCIONAL ------>


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

$url3 = "http://www.appweb.com.br/cms/sociabilidade.php?lang=$lang&media=$media&zerotres=$zerotres&seteoito=$seteoito&novedez=$novedez&nPessoas=$nPessoas";
//echo $url3;
executa_url("$url3");

?>
<!------ SOCIABILIDADE ------>


<? 

   
	//$where = str_ireplace('=','ig',$where);
	//$where = str_ireplace(' ','sp',$where);
	
	//break;
	
	//redireciona("grupoMont_pdf.php?wherea=$where");?>
    
    <form id="formu" name="formu" action="grupoMont_pdf.php?lang=<?=$lang?>&v=2" method="POST">
        <input type="hidden" name="wherea" value="<?=$where?>" />
    </form>
   
    
    <script>
        document.formu.submit();
    </script>
    
</body>
</html>
		