<? 
include("conn.php");
$sql = "select * from pesquisa_enviados WHERE id=55";
$result = mysql_query($sql);
	$cont=0;
while($linha = mysql_fetch_assoc($result)){

	
	if($cont==0){
		$var1 = $linha["respostas"];
	}
	
	if($cont==1){
		$var2 = $linha["respostas"];
	}
	
	$cont++;
}
	$dividir = explode("#",$var1);
	$dividir2 = explode("#",$var2);
	$ultimo_valor=119;
	for($i=0;$i<120;$i++){		
		if($i == $ultimo_valor){
			$juntar_ultimos = $dividir[$i]."<br><br><br><br>".$dividir2[$i];
		}
		$todas=array();
		if($i != $ultimo_valor){
			$N=$i+1;
			echo "PERGUTA DE NUMERO $N<BR>";;
			$alternativas = explode("|",$dividir[$i]);
			$alternativas2 = explode("|",$dividir2[$i]);
			$valor_tot=0;
			$valor_tot = count($alternativas)-1;
			for($y=0;$y<count($alternativas)-1;$y++){
				
				if($valor_tot == $y){					
				$todas[$y] = $alternativas[$y] + $alternativas2[$y]."|";
				}else{					
				$todas[$y] = $alternativas[$y] + $alternativas2[$y];
				echo $alternativas[$y]."<br>";
				}
			}			
			
			$todas_resp = implode("|",$todas);			
			echo " <hr> <br>";
			$juntar .= $todas_resp."|#";
		}
		
		
		
	}
	
?>