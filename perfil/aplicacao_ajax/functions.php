<?php

function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}


function base102($pCompentencia, $pNota, $conn) {
		$sql = "
		SELECT f.descricao, f.base10
		FROM  feedbacks f, competencias c
		WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;

		//EXECUTA A QUERY
		$sql = mysqli_query($conn,$sql);
		echo 1;
		$row = mysqli_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");
		return $a = mysqli_result($sql, 0, "base10");
}

function feedback($pCompentencia, $pNota, $conn) {

	$sql = " 
       		SELECT f.descricao
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;

	//EXECUTA A QUERY
	$sql = mysqli_query($conn,$sql);
	echo 2;
	$row = mysqli_num_rows($sql) or die("erro na busca dos nomes das competências");
	$pos = (mysqli_result($sql, 0));
	return $pos;
}

function ideal($pCompentencia, $conn) {
	$valor = array();

	for ($i = 0; $i < 11; $i++) {
		$valor[$i] = 999;
	}//fecha for

	$sql = "
       		SELECT i.valor 
       		FROM  ideais i, competencias c
			WHERE c.competencias_id = i.competencia_id and c.ordem = " . $pCompentencia . "
	   		ORDER BY i.valor";



	//EXECUTA A QUERy
	$sql = mysqli_query($conn,$sql);
	$row = mysqli_num_rows($sql) or die("erro na busca dos valores ideais das competÃªncias");

	for ($z = 0; $z < $row; $z++) {
		$pos = mysqli_result($sql, $z, "valor");
		$valor[$pos] = $pos;
	}//fecha for

	for ($i = 0; $i < 11; $i++) {
		if ($valor[$i] == 999) {
			$valor[$i] = $i;
			echo "<span class=\"num_normal\" >&nbsp;" . $valor[$i] . "&nbsp;</span> ";
		} else {
			echo "<span class=\"num_yellow\" >&nbsp;" . $valor[$i] . "&nbsp;</span> ";
		}
	}
	//echo "</div>";
}



function base10 ($pCompentencia, $pNota, $conn){
			$sql = " 
       		SELECT f.descricao, f.base10
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;   

			//EXECUTA A QUERY               
			$sql = mysqli_query($conn,$sql);       
			$row = mysqli_num_rows($sql) or die("erro na busca dos nomes das competências");    
			return $a = mysqli_result($sql, 0, "base10");
}

?>