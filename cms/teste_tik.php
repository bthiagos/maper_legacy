<?php include("conn.php"); ?>
<?php include("library.php"); ?>

<?
$num_pedido = 1251166280;
$email .= "vinicius@agenciapenta.com.br;";
$email .= "carlos@agenciapenta.com.br;";
$email .= "daniel@agenciapenta.com.br;";
//$email .= "kdu.lopes1@gmail.com;";
$nome= "vinicius";
dispara_email_tickets($num_pedido,$nome,$email);

?>