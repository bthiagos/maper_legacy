<? include("conn.php");?>

<?

$cod= $_REQUEST["cod"];

$sql = "SELECT * FROM tickets_clima WHERE id_agrupa=".$cod;
$result = mysql_query($sql);

?>

<? while ($linha = mysql_fetch_assoc($result)) {?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AppWeb</title>

<style type="text/css">

p {
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	
}

</style>


</head>

<body>


<table width="90%" border="0" align="center">
	<tr>
		<td width="177px"><img src="logo_appweb2.jpg" alt="AppWeb" border="0" /></td>
		<td>&nbsp;&nbsp;</td>
		<td width="240px" align="right"></td>
	</tr>	
	<tr>
		<td colspan="3">
		<p><font size="2">Prezado Colaborador da SIC,</font></p>

 
		<p><font size="2">Você está recebendo o link para responder a Pesquisa de Clima Interno da sociedade SIC, conforme informamos <br/>anteriormente. </font></p>
		
		<p><font size="2">O preenchimento do questionário leva em média 20 minutos e você poderá acessá-
lo por meio do endereço <a href="http://www.appweb.com.br/pesquisa_clima">http://www.appweb.com.br/pesquisa_clima</a> . Será solicitado o número de seu Ticket que é <b><?=$linha["ticket"]?></b>
 </font></p>	
 		
        <p><font size="2">A EDUCARH é uma empresa de consultoria que atua especificamente na área de Educação e Recursos Humanos e<br/>processará todas as informações dos questionários, garantindo a confidencialidade da pesquisa.</font></p>
		
        <p><font size="2">Estamos à sua disposição para os esclarecimentos que se fizerem necessários por meio dos telefones 3293-2590, <br /> ou 9215-2227, ou e-mail contato@marialuciarodrigues.com. </font></p>
        
		<p>&nbsp;</p>
		
		<p><font size="2">Cordialmentes,</font></p>
		<p>&nbsp;</p>
			
		<p><font size="2">
		<b>Maria Lúcia Rodrigues</b><br />
		Sócia Diretora<br />
		</font>
		</p>
        
        <p>&nbsp;</p>
        <p><font size="2"><i><b>Participe! Mudanças somente ocorrem com o comprometimento e envolvimento de todos.</b></i></font></p>
		
		
		</td>
	</tr>


</table>
</body>
</html>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<? } ?>
