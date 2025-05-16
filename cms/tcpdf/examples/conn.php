<?
// Arquivo para conexao com banco de dados

// Servidor
$server = "localhost";

// Senha
$senha = "temp2008";

// Usu�rio
$user = "appwebc_userapp";

// Banco de dados
$db = "appwebc_bdappweb";

// Conex�o com o bando
$conn = mysql_connect($server,$user,$senha) or die("Erro connection: " . mysql_error());

// Selecionando o banco
mysql_select_db($db) or die("Erro database: " . mysql_error());
?>