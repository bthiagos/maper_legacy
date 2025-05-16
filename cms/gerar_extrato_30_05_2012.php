<?php include("conn.php"); ?>

<?

// definimos o tipo de arquivo 

header("Content-type: application/msexcel");



// Como será gravado o arquivo

header("Content-Disposition: attachment; filename=extrato_".date("d")."_".date("m")."_".date("Y").".xls");





//**************** GERAR NA TELA ************************         

function get_mes($mes) {  

   switch ($mes) {

        case "01":    $mes = Janeiro;     break;

        case "02":    $mes = Fevereiro;   break;

        case "03":    $mes = Março;       break;

        case "04":    $mes = Abril;       break;

        case "05":    $mes = Maio;        break;

        case "06":    $mes = Junho;       break;

        case "07":    $mes = Julho;       break;

        case "08":    $mes = Agosto;      break;

        case "09":    $mes = Setembro;    break;

        case "10":    $mes = Outubro;     break;

        case "11":    $mes = Novembro;    break;

        case "12":    $mes = Dezembro;    break; 

    }

    return $mes;

}	



function data_formata($data) {

    $date = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);

    return $date;

}



$w = $_REQUEST["n"]; //palavra

$o = $_REQUEST["o"]; //organizacao

$g = $_REQUEST["g"]; //grupo

$f = $_REQUEST["f"]; //from

$t = $_REQUEST["t"]; //to

$m = $_REQUEST["m"]; //mes

$p = $_REQUEST["p"]; //mes





$where = "";



if($w != ""){

	if($where == "" ){

		$where = "WHERE aplicacoes.nome like '%$w%'";

	}else{

		$where .= " and aplicacoes.nome like '%$w%'";

	}

}





if($g != ""){

	if($where == ""){

		$where = "WHERE aplicacoes.grupo='$g'";

	}else{

        $where .= " and aplicacoes.grupo='$g'";

	}

}





if($o != ""){

	if($where == ""){

		$where = "WHERE organizacoes.id='$o'";

	}else{

        $where .= " and organizacoes.id='$o'";

	}

}





if($f != "" and $t == ""){

	$from = $f;

    $to = $f;

    $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

    $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

    

    if($where == "") { 

       $where .= " WHERE aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

    } else {

	   $where .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

	}

}





if($m != ""){

	$mes = $m;
  $ano = date("Y");

	if($where == "" ){

		$where .= " WHERE MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$ano'";

	}else{

		$where .= " and MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$ano'";

	}

}





if($f != "" and $t != ""){

	$from = $f;

    $to = $t;

    

    $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

    $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

    

    if($where == "") { 

       $where .= " WHERE aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

    } else {

	   $where .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

	}

}



if($where !="") { $where .= " and organizacoes.id != '' and grupos.id != ''"; } else { $where = "WHERE organizacoes.id != '' and grupos.id != ''"; }

  



$ordenar = "aplicacoes.data_aplic";

 

?>

    <style>

        .cinza {

            background-color: #D3D3D3;

        }

    </style>

<?





$limite = "LIMIT ".$inicial.",".$numreg;



if($_GET["where"] != "") {

    $where = $_GET["where"];

}

//print_r($array_contabilizado);

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

	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY $ordenar DESC";



	$result = mysql_query($sql);	

    //$total = mysql_num_rows($result);

    //echo $sql;

 $sql2 = "SELECT

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

	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY $ordenar DESC";



	$result2 = mysql_query($sql2);	

    $total = mysql_num_rows($result2);



    

	$quantreg = $total;

  	$quant_pg = ceil($quantreg/$numreg);

	$quant_pg++;

	//echo $sql;

	if($quantreg == 0){

		echo "<span class=\"label_fonte\">Nenhum registro</span>";

	}

	

// montando a tabela

echo "<table border='1' cellspacing='0' cellpadding='0' bordercolor='#666666' style='margin-bottom: 5px; width: 100%; font-size: 11px; font-family: Arial;'>";

  if($m != "" and $f == "" and $to == "") {

    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato do Mês de ".get_mes($m)."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

  }

  if($f != "" and $t == "") {

    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato do dia ".data_formata($from)."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

  }

  

  if($f != "" and $t != "") {

    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato do período de ".data_formata($from)." até ".data_formata($to)."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

  }

  

  if($f == "" and $t == "" and $m == "") {

    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

  }

  

  echo "<tr style='height: 30px;'>";

    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">#</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Organização</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Grupo</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Quantidade</td>';

  echo "</tr>";

  

  $sql_organizacoes = "SELECT

    DISTINCT 

    grupos.id as grupoid,

	COUNT(grupos.id) as gcount,           

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

	grupos.nome as grupo,

	organizacoes.id as id_orga,

	aplicacoes.status_envio

	FROM

	aplicacoes

	left Join grupos ON aplicacoes.grupo = grupos.id

	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where GROUP BY organizacoes.id, grupos.id ORDER BY organizacoes.nome, grupos.nome ASC";

  

  $sql_organizacoes_q = mysql_query($sql_organizacoes) or die(mysql_error());



  $sql_organizacoes_c = mysql_query($sql_organizacoes) or die(mysql_error());

  while($org_c = mysql_fetch_array($sql_organizacoes_c)) {

    $todas_orgas .= $org_c["id_orga"]."&&&";

    

    $orga_grup .= $org_c["id_orga"]."///".$org_c["grupoid"]."&&&";

  }

  $orga_grup = explode("&&&",$orga_grup);

  

  $todas_orgas = explode("&&&",$todas_orgas);

  $todas_orgas = array_count_values($todas_orgas);

 

  $i = 1;

  

  

  //AQUI COMEÇA A TABELA DE ORGANIZAÇÕES E GRUPOS

  while($org = mysql_fetch_array($sql_organizacoes_q)) {

  $id_org = $org["organizacao"];

  $orga = $org["id_orga"];

  $rowspan_original = $todas_orgas[$id_org];

  $rowspan = $todas_orgas[$id_org] + 1; 

  

  if($org["grupo"] != "") {

  echo "<tr style='height: 30px;'>";

  

  //PROBLEMA: SABER SE A PROX LINHA É CONTINUAÇÃO DO ROWSPAN OU NÂO

  $array_check = explode("&&&",$jafoi);

 if($rowspan > 1) {

    if(!in_array($orga,$array_check)) {

      

      echo '<td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle" rowspan="'.$rowspan.'">'.$i.'</td>

   	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle" rowspan="'.$rowspan.'">'.$org["orga"].'</td>

	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["grupo"].'</td>

	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["gcount"].'</td>';

      $i++;

    } else {

      echo '<td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["grupo"].'</td>

	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["gcount"].'</td>';

    }



 } else {

      echo '<td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$i.'</td>

   	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["orga"].'</td>

	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["grupo"].'</td>

	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["gcount"].'</td>';

      $i++;

 } 



  echo "</tr>";

  $jafoi .= $org["id_orga"]."&&&";

  

  //TOTAL SOMA DE GRUPOS

  $jafoi_array = explode("&&&",$jafoi);

  $quantos_ja_foram = array_count_values($jafoi_array);

  if($quantos_ja_foram[$orga] == $rowspan_original) {

  

  

    echo "<tr style='height: 30px; '>";

    echo '<td style="vertical-align: middle; color: #666666; font-weight: bold; background-color: #E8E8E8;" align="center" valign="middle">TOTAL</td>

    <td style="vertical-align: middle; color: #666666; font-weight: bold; background-color: #E8E8E8; font-size: 16px; " align="center" valign="middle">'; 

    //PEGAR SOMA DE GRUPOS

    

    //FILTROS

        if($w != ""){

  		$where_tot .= " and aplicacoes.nome like '%$w%'";

    	

    }

    

    if($f != "" and $t == ""){

    	$from = $f;

        $to = $f;

        $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

        $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

        $where_tot .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

    	

    }

    

    

    if($m){

		$mes = $m;

        $where_tot .= " and MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '2012'";

		

	}

    

    

    if($f != "" and $t != ""){

    	$from = $f;

        $to = $t;

        

        $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

        $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";



  	    $where_tot .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

    	

    }

    

    $total_org = 0;

    for($j = 0; $j < sizeof($orga_grup); $j++) {

        $orga_e_grup = explode("///",$orga_grup[$j]);

        $og = $orga_e_grup[0];

        $gp = $orga_e_grup[1];

                

        //echo $og."//".$orga."___";

        

        if($og == $orga) {

            $sql_gp = "SELECT

            DISTINCT 

            grupos.id as grupoid,

        	COUNT(grupos.id) as gcount,           

        	organizacoes.nome as orga,

        	grupos.nome as grupo,

        	organizacoes.id as id_orga,

        	aplicacoes.status_envio

        	FROM

        	aplicacoes

        	left Join grupos ON aplicacoes.grupo = grupos.id

        	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id WHERE (organizacoes.id = '$og' and grupos.id = '$gp') $where_tot GROUP BY grupos.id ORDER BY organizacoes.nome, grupos.nome ASC";

            //echo $sql_gp;

            $sql_gp = mysql_query($sql_gp);

            while($gps = mysql_fetch_array($sql_gp)) {

                $total_org += $gps["gcount"]; 

            }

        }

    }

    echo $total_org;

    

    echo '</td>';

    echo "</tr>";

  }

  

}

  

  

}

echo "</table>";

if($p == '1') {

echo "<hr />";



echo "<table border='1' cellspacing='0' cellpadding='0' bordercolor='#666666' style='margin-top: 10px; width: 100%; font-size: 11px; font-family: Arial;'>";

  echo "<tr style='height: 30px;'>";

    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;" align="center" colspan="7" valign="middle">Pessoas</td>';

  echo "</tr>";

  

  echo "<tr style='height: 30px;'>";

    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" width="15" valign="middle">#</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Data</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Nome</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Tempo</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Organização</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Grupo</td>

		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Cargo</td>';

  echo "</tr>";

  



  if($_GET["pg"] == "" or $_GET["pg"] == "0") {

  $k = 1;

  } else {



    $k = $_GET["pg"] * 110;

    $k = $k +1;

    

  }





while ($linha = mysql_fetch_array($result)){

  echo "<tr style='height: 25px;'>";

    echo '<td style="vertical-align: middle; color: #333333;" align="center" width="15" >'.$k.'</td>

		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["databr"].'</td>

		<td style="vertical-align: middle; color: #333333;" align="left" >'.$linha["nome"].'</td>

		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["tempo"].'</td>

		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["orga"].'</td>

		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["grupo"].'</td>

        <td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["cargo"].'</td>';

  echo "</tr>";

  $k++;

}

?>



<?php



echo "</table>"; 

//**************** GERAR NA TELA ************************  

}

?>

<?php mysql_close(); ?>