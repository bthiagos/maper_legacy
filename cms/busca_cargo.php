<?php
include('conn.php');
$id = $_REQUEST["id"];
$tipo = $_REQUEST["tipo"];

if($tipo == 1){

	$sql = mysql_query("SELECT * FROM aplicacoes WHERE organizacao='".$id."'  GROUP BY cargo order by cargo");//WHERE nome='".$texto."' or descricao like '%".$texto."%'

	$n =2; 
	
	$row = mysql_num_rows($sql);
	if($row >= 1){
		echo 'document.cadastra.id_cargo.disabled = false;';
		echo 'document.cadastra.id_cargo.options[0] = new Option("Cargo(s)",0,false,false);';
		echo 'document.cadastra.id_cargo.options[0].disabled = true;';
		echo 'document.cadastra.id_cargo.options[1] = new Option("------------",0,false,false);';
		echo 'document.cadastra.id_cargo.options[1].disabled = true;';
		while($linha = mysql_fetch_assoc($sql)){
			echo 'document.cadastra.id_cargo.options['.$n.'] = new Option("'.utf8_encode($linha["cargo"]).'", '.$linha["id"].', false, false);';
			$n++;
		}
	}else{
		echo 'document.cadastra.id_cargo.options[0] = new Option("Nenhum Registro", 0, false, false);';
	}
}




?>