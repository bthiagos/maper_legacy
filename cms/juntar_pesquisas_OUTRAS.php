<? 
include("conn.php");
$sql = "select * from pesquisa_enviados WHERE id=52 or id=59";
$result = mysql_query($sql);
	$cont=0;
while($linha = mysql_fetch_assoc($result)){

	
	if($cont==0){
		$var1 = $linha["outra"];
	}
	
	if($cont==1){
		$var2 = $linha["outra"];
	}
	
	$cont++;
}
	$dividir = explode("#",$var1);
	$dividir2 = explode("#",$var2);
	$ultimo_valor=119;
	for($i=0;$i<120;$i++){		
		
		$todas=array();
		if($i != $ultimo_valor){
			$alternativas = explode("|",$dividir[$i]);
			$alternativas2 = explode("|",$dividir2[$i]);
			$valor_tot=0;
			$valor_tot = count($alternativas)-1;
			for($y=0;$y<count($alternativas)-1;$y++){
								
				$todas[$y] = $alternativas[$y]. $alternativas2[$y];
				
			}			
			
			$todas_resp = implode("|",$todas);			
			//echo $i." - ".$dividir[$i]." + ".$dividir2[$i]." = $todas_resp <br>";
			$juntar .= $todas_resp."|#";
		}
		
		
		
	}
	echo "$var1<br><br>$var2<br><br><br>";
	echo $juntar;
?>