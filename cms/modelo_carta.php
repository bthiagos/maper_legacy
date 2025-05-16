<? include("conn.php");?>

<?

$num_pedido = $_REQUEST["cod"];



?>

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

<?

$sql = "SELECT
gerador_tickets_pedidos.cnpj,
gerador_tickets_pedidos.nome_cliente,
gerador_tickets_pedidos.email,
gerador_tickets_pedidos.nome_responsavel,
gerador_tickets_pedidos.data_gerado,
date_format(gerador_tickets_pedidos.data_gerado,'%d/%m/%Y - %H:%m' ) AS data_convertida2,
gerador_tickets.num_pedido,
gerador_tickets.numero_ticket
FROM
gerador_tickets
Inner Join gerador_tickets_pedidos ON gerador_tickets_pedidos.id = gerador_tickets.num_pedido WHERE num_pedido = $num_pedido";
$result = mysql_query($sql);
$linha = mysql_fetch_assoc($result);
$num_rows = mysql_num_rows($result);

if($num_rows > 1){
	$ticktss = "Tickets";
	$s = "s";
}else{
	$ticktss = "Ticket";
	$s = "";
}
?>


<table width="90%" border="0" align="center">
	<tr>
		<td width="177px"><img src="logo_appweb2.jpg" alt="AppWeb" border="0" /></td>
		<td>&nbsp;&nbsp;</td>
		<td width="240px" align="right"><img src="logo_comit.jpg" alt="Comit" border="0" style="float: right" /></td>
	</tr>	
	<tr>
		<td colspan="3">
		<p><font size="2">Prezado Cliente,</font></p>

 
		<p><font size="2">Conforme o seu pedido, estamos lhe encaminhando <?=$num_rows?> <?=$ticktss?> de Acesso ao APP Web - Sistema on-line de Avaliação de<br /> Potencial e Perfil.</font></p>
		
			
		<p>
		<font size="3" face="Arial"><b>Pedido nº: <?=$linha["num_pedido"]?></b></font><br />
		<font size="2">Cliente: <b><?=$linha["nome_cliente"]?></b></font><br />
		<font size="2">Responsável: <b><?=$linha["nome_responsavel"]?></b></font><br />		
		<font size="2">E-mail: <b><?=$linha["email"]?></b></font><br />		
		<font size="2">CNPJ/CPF: <b><?=$linha["cnpj"]?></b></font><br />
		<font size="2">Data: <b><?=$linha["data_convertida2"]?></b>		
		</font></p>

		<p><font size="2">Para utilizá-lo<?=$s?> basta acessar o site </font><font color="Red" size="2">www.commit.com.br/appweb</font>, <font size="2">preencher o Formulário de Aplicação e digitar<br /> no campo "Ticket" o<?=$s?> número<?=$s?> abaixo:</font>
		</p>
	
		
		
		<p>
		<font color="Red" size="4">Quantidade de tickets: <b><?=$num_rows?></b></font>
		</p>
		
		
		<p><font size="2">
		<b>Número<?=$s?> do<?=$s?> Ticket<?=$s?>:</b></font>
		</p>
		
		
		<p style="margin-left: 30px"><font size="2">
		<table width="100%">
		<tr>
		<?
				$sql = "
					SELECT
					gerador_tickets.numero_ticket
					FROM
					gerador_tickets
					WHERE num_pedido = $num_pedido order by numero_ticket 
				";
				$result = mysql_query($sql);
				$i = 0;
				while ($linha = mysql_fetch_assoc($result)) {
					$i++;
				?>
				<td width="20%"><?=$linha["numero_ticket"]?></td>
					
				
				<?
					if ($i == 9) {
						echo "</tr><tr>";
						$i = 0;
					}
					?>
					
				<?}?>
		</font>
		</tr>
		</table>
		</p>
		
		
		<p>
		<font color="Red" size="2"><b><i>Importante:</i></b></font> <font size="2">cada numeração do Ticket corresponde a uma Avaliação.</font>
		</p>
		
		
		<p>	<font size="2">	
		<b>A cada avaliação efetuada, o sistema APP Web Commit enviará um o relatório de análise de potencial para a caixa de e-mails do responsável acima destacado.</b>
		</font></p>
		
		
		<p>	<font size="2">	
		Não hesite em nos contatar para quaisquer outros esclarecimentos através da nossa central de atendimento: 0800.17.9988, – em SP (11) 3067.1414.
		</font></p>
		
		
		<p>&nbsp;</p>
		
		<p><font size="2">Atenciosamente,</font></p>
		<p>&nbsp;</p>
			
		<p><font size="2">
		<b>Commit Produtos Motivacionais Ltda</b><br />
		appweb@commit.com.br<br />
		www.commit.com.br<br />
		</font>
		</p>
		
		
		</td>
	</tr>


</table>
</body>
</html>
