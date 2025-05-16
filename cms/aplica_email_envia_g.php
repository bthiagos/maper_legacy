<?php include("conn.php"); ?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Email contato Oba!</title>
</head>
<? require('class.phpmailer.php'); ?>
Enviando e-mails...
<?php
$id = $_GET["id"];
$idg = $_GET["grupo"];
$org = $_GET["orga"];
$getinfo = mysql_query("SELECT * FROM aplicacoes WHERE grupo = '$idg'");

while($info = mysql_fetch_array($getinfo))
{
    $nome=strip_tags(trim($info["nome"]));
    $email=strip_tags(trim($info["email"]));
    $email = "thales@agenciapenta.com.br";

    $nome = utf8_encode($nome);


$mail = new PHPMailer(); //instancia a classe PHPMailer
$mail->IsSMTP(); //define que o email ser� enviado por SMTP
$mail->SMTPAuth   = true;  
$mail->SMTPSecure = "ssl";  
$mail->Port       = 465;  
$mail->Host       = "comlinux3.citis.com.br";      // sets GMAIL as the SMTP server  
$mail->Username =   "noreply@appweb.com.br";  
$mail->Password =   "App2205Ate"; 
$mail->SetFrom('noreply@appweb.com.br', 'APPWEB'); //define o remetente da mensagem, altere para o real$mail->AddAddress('thales@agenciapenta.com.br', 'Contato'); //define o destino da mensagem, altere para o desejado
$mail->Subject = 'APPWEB - Relatório '.$nome; //define o assunto da mensagem
//contato@obaeventos.net
$body = "
<span style='font-size: 12px; font-family: Arial, Verdana;'>
    Olá ".$nome.",<br /><br />
    Os resultados da sua avaliação foram computados. Clique no link abaixo para visualizar o relatório.
</span><br /><br />
<span style='font-size: 12px; font-family: Arial, Verdana;'><a href='http://appweb.com.br/cms/testepdf.php?id=".$id."&orga=".$org."' target='_blank'>
Relatório: ".$nome."
</a></span><br /><br />
<span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe APPWEB</span>";

//a variavel $body define o corpo da mensagem
$mail->MsgHTML(utf8_decode($body)); //configura o email como HTML

$mail->Send();
echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?feito=1">';
}
//fim

//contato@obaeventos.net

?>
<body>
</body>
</html>