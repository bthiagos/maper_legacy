<?php include("conn.php"); ?>
<?
// definimos o tipo de arquivo
header("Content-type: application/msexcel");

// Como será gravado o arquivo
header("Content-Disposition: attachment; filename=Extrato.xls");

$w = $_GET["w"]; //palavra
$o = $_GET["o"]; //organizacao
$g = $_GET["g"]; //grupo
$m = $_GET["m"]; //mes

$where = "";

if($w != ""){
	if($where == "" ){
		$where = "WHERE aplicacoes.nome like '%$w%'";
	}else{
		$where .= " and aplicacoes.nome like '%$w%'";
	}
}

if($g != ""){
	$where .= " and aplicacoes.grupo = '$g'";
}

if($m != ""){
    if($where == "") { 
       $where = "WHERE month(aplicacoes.data_aplic) = '$m'";
    } else {
	   $where .= " and month(aplicacoes.data_aplic) = '$m'";
	}
}


if($o != ""){
	if($where == ""){
		$where = "WHERE organizacoes.id='$o'";
	}else{
        $where .= " and organizacoes.id='$o'";
	}
}

$ordenar = "aplicacoes.grupo, organizacoes.nome, aplicacoes.nome,";

$sql = "SELECT
	aplicacoes.id,
	aplicacoes.nome,
	aplicacoes.email,
	aplicacoes.telefone,
	aplicacoes.cpf,
	aplicacoes.nasc,
    aplicacoes.organizacao,
    aplicacoes.grupo,                
	aplicacoes.cargo,
	aplicacoes.tempo,
	aplicacoes.respostas,
	aplicacoes.data_aplic,
	date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
	organizacoes.nome as orga,
    grupos.id as grupoid,
	grupos.nome as grupo,
	organizacoes.id as id_orga,
	aplicacoes.status_envio
	FROM
	aplicacoes
	left Join grupos ON aplicacoes.grupo = grupos.id
	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY $ordenar aplicacoes.data_aplic DESC";

	$result = mysql_query($sql);	
    $total = mysql_num_rows($result);

// montando a tabela
echo "<table border='1' bordercolor='#666666'>";
  echo "<tr><td colspan='7' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato - ".date("d/m/Y")."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";
  echo "<tr style='height: 30px;'>";
    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">#</td>
		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Data</td>
		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Nome</td>
		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Tempo</td>
		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Organização</td>
		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Grupo</td>
		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Cargo</td>';
  echo "</tr>";
$i=1;


while ($linha = mysql_fetch_array($result)){
  echo "<tr style='height: 25px;'>";
    echo '<td style="vertical-align: middle; color: #333333;" align="center" >'.$i.'</td>
		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["databr"].'</td>
		<td style="vertical-align: middle; color: #333333;" align="left" >'.$linha["nome"].'</td>
		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["tempo"].'</td>
		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["orga"].'</td>
		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["grupo"].'</td>
        <td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["cargo"].'</td>';
  echo "</tr>";
  $i++;
}
echo "</table>"; 
?>