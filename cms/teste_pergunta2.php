<?


include('conn.php');
		
	$ok=1;

		$sql_perguntas = "SELECT pesquisa_perguntas.id as idperguntas,perguntas FROM
						pesquisa_perguntas
						
						ORDER BY pos";
		$result_perguntas = mysql_query($sql_perguntas);
		//PEGA O NOME DE CADA PERGUNTA
		while ($linha_perguntas = mysql_fetch_assoc($result_perguntas)) {
			
			$id_perguntas = "alternativa_".$linha_perguntas["idperguntas"];
			
			if(!isset($_POST[$id_perguntas])){
				$ok=0;
			}elseif($_POST[$id_perguntas] ==""){
				$ok=0;
			}
			
			
			
		}
	
	
	if (!$ok) {
		// Alert de ERRO!
		echo "Algum campo foi preenchido incorretamente ou está em branco, tente novamente!";	
		echo '<script>location.href="teste_pergunta.php"</script>';
	}else{
		
		$sql_perguntas_texto = "SELECT pesquisa_perguntas.id as idperguntas,texto,perguntas FROM
						pesquisa_perguntas
						WHERE aberta = '1'
						";
		$result_perguntas_texto = mysql_query($sql_perguntas_texto);
		//PEGA O NOME DE CADA PERGUNTA
		while ($linha_perguntas_texto = mysql_fetch_assoc($result_perguntas_texto)) {
			
			$id_perguntas_texto = "alternativa_".$linha_perguntas_texto["idperguntas"];
			
			if($_POST[$id_perguntas_texto]){
				$texto = $linha_perguntas_texto["texto"]."|".$_POST[$id_perguntas_texto];	
			
				$sql_texto = "UPDATE pesquisa_perguntas SET texto='$texto' WHERE id=".$linha_perguntas_texto["idperguntas"];
				$result_texto = mysql_query($sql_texto);
				echo $sql_texto."<br>";
			}
			
			
			
		}
		
		
		//break;
		
		$sql_perguntas2 = "SELECT * FROM pesquisa_alternativas ORDER BY id_perguntas";
		$result_perguntas2 = mysql_query($sql_perguntas2);
		//PEGA O NOME DE CADA PERGUNTA
		while ($linha_perguntas2 = mysql_fetch_assoc($result_perguntas2)) {
			$id_perguntas = "alternativa_".$linha_perguntas2["id_perguntas"];
			
			
				$indice = $_POST[$id_perguntas];
				
				$todas_respostas = explode("|",$linha_perguntas2["respostas"]);
				
				$total_num = 1 * $todas_respostas[$indice];
				$total_num++;
				$todas_respostas[$indice] = $total_num++;
				$respostas = implode("|",$todas_respostas);
			
				
				$sql = "UPDATE pesquisa_alternativas SET respostas='$respostas' WHERE id=".$linha_perguntas2["id"];
				$result = mysql_query($sql);
				
				
		}
		echo "Voto computado com Sucesso!";
		
		
	}



?>