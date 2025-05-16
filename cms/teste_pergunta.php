
<form action="teste_pergunta2.php" method="post" name="cadastro">

<?


include('conn.php');


		$sql_perguntas = "SELECT pesquisa_perguntas.id as idperguntas,perguntas FROM
						pesquisa_perguntas
						
						ORDER BY pos";
		$result_perguntas = mysql_query($sql_perguntas);
		//PEGA O NOME DE CADA PERGUNTA
		while ($linha_perguntas = mysql_fetch_assoc($result_perguntas)) {
			
			$id_perguntas = $linha_perguntas["idperguntas"];
			echo "<p>".$linha_perguntas["perguntas"]."</p>";
			
			$sql_alternativas = "SELECT * FROM pesquisa_alternativas WHERE id_perguntas =".$linha_perguntas["idperguntas"];
			$result_alternativas = mysql_query($sql_alternativas);
			$alternativas ="";
			$todas_alternativas="";
			if(mysql_num_rows($result_alternativas) > 0){
			//IMPRIMI CADA ALTERNATIVA
			while ($linha_alternativas = mysql_fetch_assoc($result_alternativas)) {
				
					$alternativas = $linha_alternativas["alternativas"];						
					$todas_alternativas = explode("|",$alternativas);
				
					
					for ($i=0;$i<(count($todas_alternativas)-1);$i++) {
					
					?>	
					<p><input type="radio" name="alternativa_<?=$id_perguntas?>" value="<?=$i;?>"> <?=$todas_alternativas[$i];?></p>	<br/>					
					<?		
					}
							
				
			}
			}else{?>
				<p><textarea  name="alternativa_<?=$id_perguntas?>"></textarea></p>	<br/>					
			<?}
			
		}


?>
<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
</form>