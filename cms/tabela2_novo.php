<?



include ("conn.php");

if($_REQUEST["commit"]){

	$commit=$_REQUEST["commit"];

	$tabela_commit = "_commit";

}



$t = "aplicacoes".$tabela_commit;

//CONECTA AO MYSQL                     

$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 

$result = mysql_query($sql);

$linha = mysql_fetch_assoc($result);



//$datax=array("Capacidade de planejamento","Capacidade de organiza��o","Capacidade de acompanhamento","Estilo de lideran�a","Estilo de comunica��o","Tomada de decis�o","Capacidade de delega��o","Administra��o do tempo","Volume de trabalho","Potencial criativo e flexibilidade","Capacidade de priorizar e trabalhar com imprevistos","Gest�o de mudan�as","Relacionamento com superiores","Gest�o de conflitos","Controle das emo��es","Relacionamento afetivo","Relacionamento em grupos","Imagem pessoal","T�nus vital","Necessidade de realiza��o");$comp_sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC");

$datax = array();

$complang = "";

$comp_sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC");

if($lang == "en" or $lang == "es") { $complang = "_".$lang; }

while($comp = mysql_fetch_array($comp_sql)) {

    array_push($datax,$comp["descricao".$complang]);

}



//$datax=array("Capacidade de planejamento","Capacidade de organiza��o","Acompanhamento","Lideran�a","Comunica��o","Decis�o","Detalhismo","T. de Execu��o","Intens.Operacional","Flex./Criatividade","Percep��o","Adap.as mudan�as","R. Autoridade","Adm. de conflitos","Controle Emocional","Afetividade","Sociabilidade","Auto Imagem","Energia Vital","Realiza��o");



$sustentacao = array();

$aceitavel = array();

$critico = array();



$codigo_id = $_REQUEST["id"];



$pGabarito = $linha["respostas"];

//echo $pGabarito;

if (!$pGabarito) {



$pGabarito = $_REQUEST["gabarito"]; 



}







$pNome = $linha["nome"]; 

$pCpf = $linha["cpf"]; 

$pNasc = $linha["nasc"];  

$pPerfil = "Profissional"; 

$pCargo= $linha["cargo"];  

$pSenha= "Spider29";  

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

			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");    

			

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

			$row = mysql_num_rows($sql) or die("erro na busca das questões");    

			

   			$id_competencia  = mysql_result($sql, 0, "ordem");

			$competencias[$id_competencia-1]++;



		} //fim do if

		$i++;

	} //fim do while

	



			$i = 0;

			$linha_arquivo = 1;

		//	echo "<p><b>Competências:</b></p>";

			while ($i<20){

				

				$nota110 = base10(($i+1),$competencias[$i]);

				

				//$nota = $competencias[$i];

				//$compsid = $i+1;

				//$pegarb10 = mysql_query("SELECT base10 FROM feedbacks WHERE competencia_id = '$compsid' AND nota = '$nota'");

				//$pegarb10 = mysql_fetch_array($pegarb10);

				

				//$nota110 = $pegarb10["base10"];

				$liberado = true;

				if($org = 324 || $org = 487) {
					if($i == 9) {
						//$liberado = false;
					}
				}

				
				if($liberado) {

					if ($nota110 <= 4) {

						

						$tabela_critico .= "<div style=\"font-size:9px; padding-left: 15px; margin-bottom:5px;\">".

						$datax[$i]

						."</div>";

					}

						



					if ($nota110 >= 5 and $nota110 <= 6) {

						

						$tabela_aceitavel .= "<div style=\"font-size:9px; padding-left: 15px; margin-bottom:5px;\">".

						$datax[$i]

						."</div>";

					}

					

						

					if ($nota110 >= 7) {

						

						$tabela_sustencao .= "<div style=\"font-size:9px; padding-left: 15px; margin-bottom:5px;\">".

						$datax[$i]

						."</div>";

					}	

				}

				

				

				

			$total = $total + $competencias[$i];

			$i++;

			$linha_arquivo++;

			}

}

	}





function base10 ($pCompentencia, $pNota){



			$sql = " 

       		SELECT f.descricao, f.base10

       		FROM  feedbacks f, competencias c

			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   



			//EXECUTA A QUERY               

			$sql = mysql_query($sql);       

			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");    

			

		

			return $a = mysql_result($sql, 0, "base10");

		



}

	

?>







<table border="0" align="center" width="800" cellspacing="20" border="0"> 

	<tr>

		<td width="163" height="400" class="coluna_auzl<?=$complang?>" style="padding-right: 3px; padding-left: 3px;" valign="top"><br/>

            <?

            $titulo = "Sustentação";

            if($lang == "en") { $titulo = "Sustainable"; }

            if($lang == "es") { $titulo = "Sustentable"; }

            ?>

			<div style="font-family: Arial; font-size: 16px; color: #0e80b4; text-decoration: none; text-align: center;"><br/><strong><?=utf8_decode($titulo)?></strong></div>

			<br/>

			<? echo $tabela_sustencao; ?>


		</td>

		<td width="163" height="400" class="coluna_amarela<?=$complang?>" valign="top"><br/>

            <?

            $titulo = "Aceitável"; 

            if($lang == "en") { $titulo = "Acceptable"; }

            if($lang == "es") { $titulo = "Aceptable"; }

            ?>

			<div style="font-family: Arial; font-size: 16px; color: #3fbeb2; text-decoration: none; text-align: center;"><br/><strong><?=utf8_decode($titulo)?></strong></div>

			<br/>

			<? echo $tabela_aceitavel; ?>

		</td>

		<td width="163" height="400" class="coluna_vermelho<?=$complang?>" valign="top"><br/>

            <?

            $titulo = "Crítico";

            if($lang == "en") { $titulo = "Critical"; }

            if($lang == "es") { $titulo = "Crítico"; } 

            ?>

			<div style="font-family: Arial; font-size: 16px; color: #58479d; text-decoration: none; text-align: center;"><br/><strong><?=utf8_decode($titulo)?></strong></div>

			<br/>

			<? echo $tabela_critico; ?>

		</td>

	</tr>

</table>







