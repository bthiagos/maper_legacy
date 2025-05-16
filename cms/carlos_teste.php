
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
<style type="text/css">
.style17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.folha {
    page-break-after: always;
}



</style>
</head>

<body>
<p>
<?php
$codigo_id = $_REQUEST["id"]; 
//CONECTA AO MYSQL                     
include("conn.php");
$sql = " SELECT * FROM aplicacoes WHERE id=".$_REQUEST["id"]; 
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

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
	} //fim do while
	
?>
</p>






<table width="100%" border="0">
  <tr valign="top">
    <td><table width="100%" border="1">
      <tr>
        <td width="25%"><img src="../logo_appweb.jpg" width="159" height="65" /></td>
        <td width="75%"><table width="100%" border="0">
          <tr>
            <td width="16%"><b>Nome:</b></td>
            <td width="34%"><?php echo $pNome;?></td>
            <td width="16%"><b>Perfil:</b></td>
            <td width="34%"><?php echo $pPerfil;?></td>
          </tr>
          <tr>
            <td><b>CPF:</b></td>
            <td><?php echo $pCpf;?></td>
            <td><b>Cargo:</b></td>
            <td><?php echo $pCargo;?></td>
          </tr>
          <tr>
            <td><b>Nasc:</b></td>
            <td><?php echo $pNasc;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
      <table width="100%" border="0">
        <tr style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
          <td width="6%">&nbsp;</td>
          <td width="32%"><span class="style17">Critério</span></td>
          <td width="9%"><span class="style17">Nota</span></td>
          <td width="53%"><span class="style17"> Avaliação</span></td>
        </tr>
      </table>      
      <table width="100%" border="0">
			      <?php
				
				$i = 0;
				$linha_arquivo = 1;
				while ($i<20){
					echo "<tr> <td width=\"6%\">";		
					echo ($i+1);
					echo "</td><td width=\"32%\">";
					echo $nome_competencias[$i] . "<br>"; 
					ideal ($i+1);
					echo "</td><td  width=\"9%\" valign=\"middle\" align=\"center\" >";
					echo $competencias[$i];
					echo "</td><td  width=\"53%\">";
					feedback(($i+1),$competencias[$i]);
					echo "</td></tr>";
					
					if ($linha_arquivo == 6) {
			?>
			
		      </table>
			  <div class="folha">&nbsp;</div>
       

	 <table width="100%" border="1">
      <tr>
        <td width="25%"><img src="../logo_appweb.jpg" width="159" height="65" /></td>
        <td width="75%"><table width="100%" border="0">
          <tr>
            <td width="16%"><b>Nome:</b></td>
            <td width="34%"><?php echo $pNome;?></td>
            <td width="16%"><b>Perfil:</b></td>
            <td width="34%"><?php echo $pPerfil;?></td>
          </tr>
          <tr>
            <td><b>CPF:</b></td>
            <td><?php echo $pCpf;?></td>
            <td><b>Cargo:</b></td>
            <td><?php echo $pCargo;?></td>
          </tr>
          <tr>
            <td><b>Nasc:</b></td>
            <td><?php echo $pNasc;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
      <table width="100%" border="0">
        <tr style="font-family:Arial, Helvetica, sans-serif; font-size:11px">
          <td width="6%">&nbsp;</td>
          <td width="32%"><span class="style17">Critério</span></td>
          <td width="9%"><span class="style17">Nota</span></td>
          <td width="53%"><span class="style17"> Avaliação</span></td>
        </tr>
      </table>      
			  
      
      <?
			$linha_arquivo = 0;
		}
		
		
		$total = $total + $competencias[$i];
		$i++;
		$linha_arquivo++;
	}
//	echo "Total = " . $total;
//	echo "<p><b>ConcluÃ­do</b></p>";
}//fim do if
}//fim do if


function ideal ($pCompentencia){

	$valor[11];
	
	for ($i=0;$i<11;$i++){
		$valor[$i]=999;
	} //fecha for

			$sql = " 
       		SELECT i.valor 
       		FROM  ideais i, competencias c
			WHERE c.competencias_id = i.competencia_id and c.ordem = " . $pCompentencia . "
	   		ORDER BY i.valor";  

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos valores ideais das competÃªncias");    
			
			for ($z=0;$z<$row;$z++){
				 $pos =  mysql_result($sql, $z, "valor");
				 $valor[$pos] = $pos;
			} //fecha for
			
		echo "<br>";
	//echo "<div style=\"border: 1px solid #000000; letter-spacing: 70px;\">";
	for ($i=0;$i<11;$i++){
		if ($valor[$i]==999) {
			$valor[$i] = $i;
			echo $valor[$i] ." ";
		} else {echo " &nbsp;<b><u>".$valor[$i]."</u></b> &nbsp;"; }
		
	}
	//echo "</div>";
	echo "<br>";

}


function feedback ($pCompentencia, $pNota){

			$sql = " 
       		SELECT f.descricao 
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   

			//EXECUTA A QUERY               
			$sql = mysql_query($sql);       
			$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");    
			
			echo "<br>";
			echo htmlentities (mysql_result($sql, 0, "descricao"));
			echo "<br><br>";

}

mysql_close($conn);

?>

<? $codigo_id2 = $codigo_id."grafico2.png"; 
$codigo_id = $codigo_id."grafico.png"; 
?>
      
			  
			  
			  
     </td>
  </tr>
</table>

<p style="margin-top: 10px;"><center><img src="graficos/<?=$codigo_id?>"/></center></p><br/><br/><br/>
<center><img src="graficos/<?=$codigo_id2?>"/></center>


<script language='JavaScript'>history.go(1);</script>
</body>
</html>
