<?php

	$id_pesquisa = $_GET['id_pesquisa'];
	$cod_usuario = $_SESSION['id_usuario_adm'];
    $perm = $_SESSION["per_adm"];
    
    if($perm != "99991" and $perm != "99992") {
    
	$sql_valida_usuario = "SELECT id FROM pc_pesquisa WHERE id='$id_pesquisa' AND empresa='$cod_usuario' LIMIT 1";
    	$query_valida_usuario = mysql_query($sql_valida_usuario) or die(mysql_error());
    	
    	if(mysql_num_rows($query_valida_usuario) == 0){
    		echo  "<script language=\"javascript\">
    		alert('Acesso negado!');
    		history.back(); 
    		</script>";
    	}
	
    }
?>