<?
//Arquivo para conexao com banco de dados
// Servidor
$server = "167.99.177.121";
// Senha
$senha = "5kKMvHDeY0L5";
// Usu�rio
$user = "mysqladmin";
// Banco de dados
$db = "appweb_sistema";
//
// Conex�o com o bando
$conn = mysql_connect($server,$user,$senha) or die("Erro connection: " . mysql_error());
// Selecionando o banco
mysql_select_db($db) or die("Erro database: " . mysql_error());
$base_cms = "https://cms.mapertest.com.br/";
$base_perfil = "https://perfil.mapertest.com.br/";

?>


