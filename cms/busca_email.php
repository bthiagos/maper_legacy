<?php
include('conn.php');
$id = $_REQUEST["id"];
$tipo = $_REQUEST["tipo"];

if($tipo == 1){

	$sql = mysql_query("SELECT * FROM clima_Email WHERE grupo='".$id."' Order by nome");//WHERE nome='".$texto."' or descricao like '%".$texto."%'

	$n =0; 
	
	$row = mysql_num_rows($sql);
	if($row >= 1){
		
		while($linha = mysql_fetch_assoc($sql)){
			$nome = utf8_encode($linha["nome"]);
			echo 'document.cadastro.id_email.disabled = false;';
			echo 'document.cadastro.id_email.options['.$n.'] = new Option("'.$nome.' : '.$linha["email"].'", '.$linha["id"].', false, false);';
			$n++;
		}
	}else{
		echo 'document.cadastro.id_email.options[0] = new Option("Nenhum Registro", 0, false, false);';
	}
}




?>