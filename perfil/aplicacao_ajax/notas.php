<?php 
	include("../conn.php");
	include("functions.php");

	function calcula_notas($respostas) {


			// # INICIO | BUSCANDO INFORMAÇÕES DE COMPETÊNCIAS E NOTAS
			$lang ="";
			$complang = "";
			if($lang == "en" or $lang == "es") { $complang = "_".$lang; }
			$i = $j = $total = 0;
			$login = 0;
			$Opcao = "";
			$id_competencia = "";
			$sql = "";
			$row = "";
			$competencias = array();
			$nome_competencias[20] = array();
			$i = 0;


			while ($i < 20) {
			  $competencias[$i] = 0;
			  $i++;
			}



			if (strlen($pGabarito) == 100) {

			  $sql = "
			          SELECT c.descricao,c.descricao_en,c.descricao_es
			          FROM  competencias c
			          ORDER BY c.ordem
			        ";

			  //EXECUTA A QUERY
			  $sql = mysqli_query($conn,$sql);
			  $row = mysqli_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");

			  for ($i = 0; $i < $row; $i++) {
			    $nome_competencias[$i] = mysqli_result($sql, $i, "descricao".$complang);
			  }

			$string_competencias = implode("|", $nome_competencias);
			//echo $string_competencias;

			  $i = 0;
			  while ($i < 100) {
			    $Opcao = $pGabarito[$i];

			    if (strcmp($Opcao, "a") || strcmp($Opcao, "b")) {

			      //QUERY

			      $sql = " 
			              SELECT c.ordem 
			              FROM  questoes q, competencias c
			              WHERE q.competencia_id=c.competencias_id and q.ordem = " . ($i + 1) . " and q.sequencia like \"" . $Opcao . "\"";

			      $sql = mysqli_query($conn,$sql);
			      $row = mysqli_num_rows($sql) or die("erro na busca das questões");
			      $id_competencia = mysqli_result($sql, 0, "ordem");
			      $competencias[$id_competencia - 1]++;

			    }//fim do if

			    $i++;

			  } //fim do while

			}//fim do if

			$i = 0;
			$notas_base10 = array();
			$num = 0;
			while ($i < 20) {
			  $liberado = true;
			  if($org == 324 || $org == 487) {
			    //if($i == 9) {
			    //  $liberado = false;
			    //}
			  }

			  if($liberado) {
			    $notas_base10[$num] = base102(($i + 1), $competencias[$i],$conn);
			    
			    $num++;
			  }
			  $i++;
			}
			$i=0; 

			//print_r($competencias);

			//Concatenendo notas:

			$string_notas = implode("|", $competencias);


		return $string_notas;

	}

	echo calcula_notas("abbabbbbbaaaabababaaaabababbbabbaaaaababbbbaabababbbbbabbbbababaaabaaabbbaabbbabaaabbaaabaaaabbbabab");

 ?>