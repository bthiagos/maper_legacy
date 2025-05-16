<?

/* Informa o nível dos erros que serão exibidos */
//error_reporting(E_ALL);
 
/* Habilita a exibição de erros */
//ini_set("display_errors", 1);

include "conn.php";

// Calcula IDADE - Procedure
function calcularIdade($data){
    // separando yyyy, mm, ddd
    list($dia, $mes, $ano) = explode('/', $data);

    // data atual
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

    if (checkdate($mes, $dia, $ano)) {
	    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
	    return $idade;
    } else {
    	return 0;
    }
}


// BUSCANDO IDADE

$sql = "SELECT nasc, organizacao FROM aplicacoes WHERE organizacao=197 or organizacao=517";
$query = mysql_query($sql);

$pessoas = 0;
$total_idade = 0;

while ($linha = mysql_fetch_assoc($query)) {
		if ((calcularIdade($linha["nasc"]) != 0) && (calcularIdade($linha["nasc"]) > 15) && (calcularIdade($linha["nasc"]) < 90) ) {
			echo calcularIdade($linha["nasc"]);
			echo " - ";
			echo $linha["nasc"];
			echo "<br/>";
			$pessoas++;
			$total_idade = $total_idade + intval(calcularIdade($linha["nasc"]));
		}

}

$media = $total_idade / $pessoas;

echo "Total de Pessoas: $pessoas - Total de Idade: $total_idade - Media: $media <br/>";

?>

