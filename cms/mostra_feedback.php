<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
</head>
<body>
<?php

//CONECTA AO MYSQL                     
include("conn.php");
$t = "aplicacoes".$tabela_commit;
$sql = " SELECT * FROM $t WHERE id=".$_REQUEST["id"]; 
//echo $sql;
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);

$pNome = $linha["nome"]; 
$pCpf = $linha["cpf"]; 
$cpf = formatarCPF_CNPJ($pCpf);
$pNasc = $linha["nasc"];  
$pPerfil = "Profissional"; 
$pCargo= $linha["cargo"];  
$pdata_aplic= date('d/m/Y',strtotime($linha["data_aplic"]));  
$pSenha= "Spider29";  
//$pGabarito = "ababbbbbbbaabbababaaaaaababbbbaabaaaaaaabbbaaabbabbbbbaaaaaabbbbbaaaaabbbbabababbbabbaaaaaaabababbbb";


mysql_close($conn);

?>
</body>
</html>
