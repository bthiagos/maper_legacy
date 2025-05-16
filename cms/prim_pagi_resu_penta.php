<? include("library.php");?>
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
<p>
<?php
$letras = array();

$codigo_id = $_REQUEST["id"]; 
$orga = $_REQUEST["orga"]; 
if($_REQUEST["commit"]){
	$commit=$_REQUEST["commit"];
	$tabela_commit = "_commit";
}
//CONECTA AO MYSQL                     
include("conn.php");
$t = "aplicacoes".$tabela_commit;
$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 
//echo $sql;
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
$pdata_aplic= date('d/m/Y',strtotime($linha["data_aplic"]));  
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
   				$nome_competencias[$i] = mysql_result($sql, $i, "descricao");
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
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="border: 1px #000000 solid; background-image: url(fun_table.gif); background-repeat: repeat-y; margin-top: 15px;">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" style="margin-top: 0px"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><span style="font-size:8px;"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?></span><br /><strong>Respondido em: </strong> <?php echo $pdata_aplic;?>
           </td>
         <td width="52%">  <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></span></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table width="90%" border="0" cellspacing="0" cellpadding="1"  align="center">
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="11%" nowrap><span class="style17">Critério</span></td>
    <td width="5%" align="center"><span class="style17">Nota</span></td>
    <td width="40%" align="left"><span class="style17"> Avaliação</span></td>
  </tr>    

  <?php
	$i = 0;
	$linha_arquivo = 1;
//	echo "<p><b>CompetÃªncias:</b></p>";
	while ($i<20){ 
		?>
	
		<tr><td width="2%" valign="top">		
		<? echo ($i+1); ?>
		</td><td width="11%" style="font-size:8px;">
		<? echo $nome_competencias[$i] . "<br>"; 
		ideal ($i+1); ?>
		</td><td  width="5%" valign="middle" align="center">
		<? echo $competencias[$i]; ?>
		</td><td align="left" style="font-size:8px; font-align:center;"><div style="width: 100%; text-align: justify">
		<? $texto = feedback(($i+1),$competencias[$i]); ?>
		<p style="margin-top: 0px;">	
			<? 
				$num_linhas = 0;
				$caracteres = 0; 
			   
			$novotexto = wordwrap($texto, 100, "<br />");
			echo $novotexto;
			?>
		</p>
		</div></td></tr>
		<?
		if ($linha_arquivo == 10 && $i < 19) {
		?>
		</table>
		
		<hr style="height: 1px; width: 80%; color: #666666; margin-top:2px">
		<div style="margin-top: 1px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
		
		<div class="folha">&nbsp;</div>
		
<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:10px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg"/></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em: </strong><?php echo $pdata_aplic;?></td>
          <td width="52%">  <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<table width="90%" border="0" cellspacing="0" cellpadding="2"  align="center">
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="11%" nowrap><span class="style17">Critério</span></td>
    <td width="5%" align="center"><span class="style17">Nota</span></td>
    <td width="40%" align="left"><span class="style17"> Avaliação</span></td>
  </tr>    

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
			
			$pos = (mysql_result($sql, 0, "descricao"));
			return $pos;

}


mysql_close($conn);

?>






</table>
		<div style="width:80%; height: 10px"></div>
		<hr style="height: 1px; width: 80%; color: #666666; margin-top: 25px">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		
<div class="folha">&nbsp;</div>







<? 	 $codigo_id2 = $codigo_id."grafico2.png"; 
$codigo_id = $codigo_id."grafico.png"; 

?>


		<? if($orga != 999999){ ?>
<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em: </strong> <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<br/>
<p style="margin-top: 0px;"><center><img src="graficos/<?=$codigo_id2?>"/></center></p>
<br/>

<p style="margin-top: 10px;"><center><img src="graficos/<?=$codigo_id?>"/></center></p>

	
		<hr style="height: 1px; width: 80%; color: #666666; margin-top:20px">
		<div style="margin-top: 20px; text-align: center; font-size: 12px">www.appweb.com.br</div>
<div class="folha">&nbsp;</div>



		
<table width="90%" border="0"  cellspacing="0" style="margin-top: 18px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"" bordercolor="#000000" align="center">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg" width="159" height="65" /></td>
    <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="48%"><strong>Nome: </strong><?php echo $pNome;?><br />
            <strong>CPF: </strong><?php echo $cpf;?><br /><strong>Respondido em:</strong> <?php echo $pdata_aplic;?>
           </td>
          <td width="52%"> <strong>Nasc: </strong><?php echo $pNasc;?><br />
            <strong>Cargo: </strong> <?php echo $pCargo;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p style="margin-left: 30px;">
A tabela a seguir possui 3 colunas sendo Sustentação, Aceitável e Crítico.<br />
Por "Sustentação" entenda pelos "pontos fortes" do candidato que remetem aos fatores de excelência.<br />
Na segunda coluna, compreenda que são os fatores aceitáveis, ou seja, estão adequados mas podem evoluir mais. <br />
Por último, os fatores críticos sugerem as competências que podem prioritariamente ser trabalhadas.<br /><br /> 

É importante lembrar que essa é uma classificação generalizada e deve ser adequada às competências organizacionais, portanto, ao perfil de cada cargo.</p>

<p style="margin-top: 10px; margin-left: 25px;"><? include("tabela2.php"); ?></p>


		<hr style="height: 1px; width: 80%; color: #666666; margin-top:30%">
		<div style="margin-top: 5px; text-align: center; font-size: 12px">www.appweb.com.br</div>
		<?}?>
<script language='JavaScript'>history.go(1);</script>
</body>
</html>
