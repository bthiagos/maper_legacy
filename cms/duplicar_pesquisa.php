<?
include("conn.php");
include("library.php");
$codigo = $_REQUEST["cod"];

$sql_pesquisa = mysql_query("SELECT * FROM pesquisas WHERE id = $codigo");
$result_pesquisa = mysql_fetch_assoc($sql_pesquisa);
$nome_pesquisa = "COPIA - ".$result_pesquisa["nome"];
$texto_pesquisa = $result_pesquisa["texto"];


$nova_pesquisa = "INSERT INTO pesquisas (nome,texto) VALUES ('$nome_pesquisa','$texto_pesquisa')";
mysql_query($nova_pesquisa);

$sql_nova_pesquisa = "SELECT * FROM pesquisas ORDER BY id desc";
$result_nova_pesquisa = mysql_query($sql_nova_pesquisa);
$linha_nova_pesquisa = mysql_fetch_assoc($result_nova_pesquisa);
$cod_nova_pesquisa = $linha_nova_pesquisa["id"];



$sql_perguntas = "SELECT * FROM pesquisa_perguntas
Inner Join pesquisa_alternativas ON pesquisa_perguntas.id = pesquisa_alternativas.id_perguntas WHERE id_pesquisa = $codigo ORDER BY pesquisa_perguntas.id"; 
$result_perguntas = mysql_query($sql_perguntas);

	while($linha_perguntas = mysql_fetch_assoc($result_perguntas)){
		$perguntas = $linha_perguntas["perguntas"];
		$texto = $linha_perguntas["texto"];
		$insert_perguntas = "INSERT INTO pesquisa_perguntas (perguntas,texto,id_pesquisa) VALUES ('$perguntas','$texto','$cod_nova_pesquisa')";
		mysql_query($insert_perguntas);		
	}
	
	
	
$sql_alternativas = "SELECT * FROM pesquisa_perguntas
Inner Join pesquisa_alternativas ON pesquisa_perguntas.id = pesquisa_alternativas.id_perguntas WHERE id_pesquisa = $codigo ORDER BY pesquisa_perguntas.id"; 
$result_alternativas = mysql_query($sql_alternativas);
///echo $sql_alternativas;
	$i=0;
	while($linha_alternativas = mysql_fetch_assoc($result_alternativas)){
		
		$id_perguntas = $linha_alternativas["id"];
		$formato_alternativas = $linha_alternativas["formato_perguntas"];
		$texto_aberta = $linha_alternativas["texto_aberta"];
		$alternativas = $linha_alternativas["alternativas"];
		$outras = $linha_alternativas["outras"];
		$texto_outras = $linha_alternativas["texto_outras"];
		
		$insert[$i]= "INSERT INTO pesquisa_alternativas (id_perguntas,formato_perguntas,texto_aberta,alternativas,outras,texto_outras) VALUES ('xxxx','$formato_alternativas','$texto_aberta','$alternativas','$outras','$texto_outras');";	
		$i++;
			
	}
	
	$sql_alternativas = "SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = $cod_nova_pesquisa ORDER BY pesquisa_perguntas.id"; 
	$result_alternativas = mysql_query($sql_alternativas);
///echo $sql_alternativas;
	$y=0;
	while($linha_alternativas = mysql_fetch_assoc($result_alternativas)){
		
		$id_perguntas = $linha_alternativas["id"];
		$var = $insert[$y];		
		$insert2[$y] = str_ireplace("xxxx","$id_perguntas",$var);
		mysql_query($insert2[$y]);
		$y++;	
	}	
	
		alert("Pesquisa Duplicada com sucesso");
		redireciona("cadastrar_pesquisas.php");
	


?>