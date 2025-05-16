<? ob_start(); ini_set("allow_url_fopen", "On"); ini_set("display_errors",1); error_reporting(E_ALL & ~ E_DEPRECATED); ?>
<? include("conn.php"); ?>

<?
$anolimitconsulta = (!empty($_POST['anolimitconsulta'])) ? $_POST['anolimitconsulta'] - 1 : 0;

$id_pesquisa = $_GET["id_pesquisa"];
$numero_participantes = mysql_query("SELECT id FROM pc_ticket WHERE id_pesquisa = '$id_pesquisa' and YEAR(created) > {$anolimitconsulta} ");
$numero_participantes = mysql_num_rows($numero_participantes);

$fechadas = "";
$abertas = "";
$filtro_alt = "";
$tamanho = 0;
$em_andamento = "";

if($_POST["fechadas"] == '') {
    $fechadas = "and tipo = 'Fechado'";
}

if($_POST["abertas"] == '') {
    $abertas = "and tipo = 'Aberto'";
}

if($_POST["tam"] != "") {
    $tamanho = $_POST["tam"];
}


if(!isset($_POST["em_andamento"]) and $_POST["em_andamento"] != 1) {
    $em_andamento = " and id_ticket IN (SELECT id FROM pc_ticket WHERE finalizado = '1')";
} else {
    $em_andamento = "";
}

$filtro_alt_ors = "";
$possui_filtro_pergunta = false;

$perguntas = array();
for($i = 0; $i < $tamanho; $i++) {
    $id_perg = $_POST["perg_".$i];
    $id_resp = $_POST["alt_".$i];
    if(!isset($perguntas[$id_perg])) {
        $perguntas[$id_perg] = $id_resp;
    } else {
        $perguntas[$id_perg] .= "|". $id_resp;
    }
}

$in_array_dados = array();

$k = 0;
if(isset($_POST["alt_0"]) and $_POST["alt_0"] != "") {
foreach($perguntas as $perg => $resp) {
    $perg_sql = "SELECT id_ticket FROM pc_resposta WHERE";
    $perg_sql .= " id_pergunta = '$perg' AND (";
    
    $resposta = explode("|", $resp);
    for($i = 0; $i < sizeof($resposta); $i++) {
        $perg_sql .= " id_alternativa = '".$resposta[$i]."' OR ";
    }
    $perg_sql = substr($perg_sql,0,-3);
    
    $perg_sql .= ")";
    
	$perg_sql .= " and YEAR(modified) > {$anolimitconsulta}";
    
    $in_sql = mysql_query($perg_sql);
    while($in_array = mysql_fetch_array($in_sql)) {
        $in_array_dados[$k] .= $in_array["id_ticket"]."|";
        
    }
    $in_array_dados[$k] = substr($in_array_dados[$k],0,-1);
    $k++;
}



if(sizeof($in_array_dados) > 1) {
    for($i = 0; $i < sizeof($in_array_dados); $i++) {
        if(!isset($intersect3)) {
            $intersect = explode("|",$in_array_dados[$i]);
        } else {
            $intersect = $intersect3;
        }
        if(isset($in_array_dados[$i+1])) {
            $intersect2 = explode("|",$in_array_dados[$i+1]);
            $intersect3 = array_intersect($intersect,$intersect2);
        }
    }
} else {
    $intersect3 = explode("|",$in_array_dados[0]);
}

    $filtro_alt = " and id_ticket IN ('".implode("','",$intersect3)."') ";
}



//echo $filtro_alt; die();

$excecao1 = false;
$excecao2 = false;
if($filtro_alt == "" and $em_andamento == "") {
    $excecao1 = true;
    
    $sql_usados = mysql_query("SELECT id FROM pc_ticket WHERE comecado = '1' and id_pesquisa = '$id_pesquisa' and YEAR(created) > {$anolimitconsulta} ");
    $usados = mysql_num_rows($sql_usados);
    
}

if($filtro_alt == "" and $em_andamento != "") {
    $excecao2 = true;
    
    $sql_concluidos = mysql_query("SELECT id FROM pc_ticket WHERE finalizado = '1' and id_pesquisa = '$id_pesquisa' and YEAR(created) > {$anolimitconsulta} ");
    $concluidos = mysql_num_rows($sql_concluidos);
}


$maior = 0;

$k = 0;
$pdf = "";
$id_pesquisa = $_GET["id_pesquisa"];

$graficos_delete = "";
$cores = array('1E90FF','228B22','CD0000','EEEE00','FFA500','FFB5C5','CDC9C9','9370DB','A52A2A','000000','FFC0CB','B0E2FF','FFEC8B','FFE1FF','90EE90','FF3030','F0FFFF','F08080','FF1493','DDA0DD','483D8B','F5F5DC','BC8F8F');

$perg = mysql_query("SELECT id,pergunta,tipo FROM pc_pergunta WHERE id_pesquisa = '$id_pesquisa' $fechadas $abertas ORDER BY ordem ASC");
$count = 0;
while($pg = mysql_fetch_array($perg)) {

    $idp = $pg["id"];
    $tipo = $pg["tipo"];
    $pergunta = $pg["pergunta"];
    
    $abertas = "";
    
    $pdf .= "<div style='page-break-inside: avoid;'>";
    //ADICIONAR A PERGUNTA NO PDF
    $pdf .= "<div style='width: 100%; height: auto; margin-top: 7px; padding: 10px; border: 1px solid #000; font-family: Arial, Verdana;'>".nl2br($pergunta)."</div>";
        
    if($tipo == 'Fechado') {
        $alts = mysql_query("SELECT id, alternativa FROM pc_alternativa WHERE id_pergunta = '$idp' ORDER BY id ASC");
    
        $respostas = "";
        $alternativas = "";
        $cores_grafico = "";
        $cor = 0;
        while($alt = mysql_fetch_array($alts)) {
            $ida = $alt["id"];
    
            $resp = mysql_query("SELECT id, aberta FROM pc_resposta WHERE id_alternativa = '$ida' and YEAR(modified) > {$anolimitconsulta} and id_pesquisa = '$id_pesquisa' $filtro_alt $em_andamento") or die(mysql_error());
                 
            $total_resp = 0;
            while($res = mysql_fetch_array($resp)) {
                if($res["aberta"] != "") { $abertas .= "<strong>".$alt["alternativa"].":</strong> \"".$res["aberta"]."|&&&|"; }
                $total_resp++;
            }
            //pega numero de palavras da alterativa
            $alternativa_palav = explode(" ",$alt["alternativa"]);
            if(sizeof($alternativa_palav) > 5) { $reticencias = " (...)"; } else { $reticencias = ""; }
            
            $respostas .= $total_resp.",";
            $alternativas .= limit_words($alt["alternativa"], 5).$reticencias."|";
            $cores_grafico .= $cores[$cor]."|";
            $cor++;
        }
        
        $abertas = explode("|&&&|",$abertas);
        array_pop($abertas);
                      
        $cores_grafico = substr($cores_grafico,0,-1);    
        $alternativas = substr($alternativas,0,-1);
        $respostas = substr($respostas,0,-1);    
        $labels = converte_porcentagem($respostas);
        $respostas = converte_porcentagem_sem_sinal($respostas);
        
        $num_resp_total = explode(",",$respostas);
        $num_resp_total = array_sum($num_resp_total);
        
        if($num_resp_total > $maior) {
            $maior = $num_resp_total;
        }

        if($num_resp_total == 0) {
            $pdf .= "<div style='width: 100%; height: auto; text-align: center; padding: 5px; '>Nenhuma resposta registrada para esta pergunta.</div>";
        } else {
        
            $chart = array(
            'chs' => '650x350',
            'cht' => 'p',
            'chco' => $cores_grafico,
            'chd' => 't:'.utf8_encode($respostas),
            'chdl' => utf8_encode($alternativas),
            'chl' => utf8_encode($labels),
            'chtt' => ''
            ); 
             
            $grafnome = "graf_".$k."_".time()."_".$id_pesquisa.".png";
            $graficos_delete .= $grafnome."|";
            grafico($grafnome, $chart);
    
            $pdf .= "<div style='width: 650px; margin-left: auto; margin-right: auto; margin-bottom: 15px; margin-top: 2px;'><img src='pc_grafico/$grafnome' /></div>";
           
            if(isset($_POST["exibir_abertas"]) and $_POST["exibir_abertas"] == 1) {
                for($m = 0; $m < sizeof($abertas); $m++) {
                    $pdf .= "<div style='width: 100%; height: auto; text-align: center; font-style: italic; padding: 5px; '>".utf8_decode($abertas[$m])."\"</div>";
                }
            }
        
        }
    } else {
        $resp_aberta = mysql_query("SELECT aberta FROM pc_resposta WHERE id_pergunta = '$idp'  and YEAR(modified) > {$anolimitconsulta} and id_pesquisa = '$id_pesquisa' $filtro_alt $em_andamento");
        $num_resp_total = mysql_num_rows($resp_aberta);
        if($num_resp_total > $maior) {
            $maior = $num_resp_total;
        }
        
        
        if($num_resp_total == 0) {
            $pdf .= "<div style='width: 100%; height: auto; text-align: center; padding: 5px; '>Nenhuma resposta registrada para esta pergunta.</div>";
        } else {
            while($aberta = mysql_fetch_array($resp_aberta)) {
                $pdf .= "<div style='width: 100%; height: auto; text-align: center; font-style: italic; padding: 5px; '>\"".utf8_decode($aberta["aberta"])."\"</div>";
            }
        }
    }
    
    $k++;
    
    $pdf .= "</div>";
    
    $count++;
}

function converte_porcentagem($respostas) {
    $resps = explode(",",$respostas);
    $resultado = "";
    for($i = 0; $i < sizeof($resps); $i++) {
        $total = array_sum($resps);
        if($resps[$i] != 0 and $total != 0) {
            $porc = ($resps[$i] * 100) / $total;
            $resultado .= round($porc)."%|";
        } else {
            $resultado .= "0%|";
        }
        
    }
    
    return substr($resultado,0,-1);
}

function converte_porcentagem_sem_sinal($respostas) {
    $resps = explode(",",$respostas);
    $resultado = "";
    for($i = 0; $i < sizeof($resps); $i++) {
        $total = array_sum($resps);
        if($resps[$i] != 0 and $total != 0) {
            $porc = ($resps[$i] * 100) / $total;
            $resultado .= round($porc).",";
        } else {
            $resultado .= "0,";
        }
        
    }
    
    return substr($resultado,0,-1);
}


function grafico($nome, $chart){

    $fullpath = "pc_grafico/".$nome;
    
    $url = "http://chart.googleapis.com/chart";

    
    $getData = http_build_query($chart);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $getData);

    $rawdata=curl_exec($ch);
    
    curl_close ($ch);
    if(file_exists($fullpath)){
        unlink($fullpath);
    }
    
    $fp = fopen($fullpath,'x');
    fwrite($fp, $rawdata);
    fclose($fp);
}

function limit_words($string, $word_limit)
{
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

$pdf = utf8_encode($pdf);

$getEmpresa = mysql_query("SELECT ce_usuario.nome,pc_pesquisa.nome as nome_empresa FROM ce_usuario LEFT JOIN pc_pesquisa ON pc_pesquisa.empresa = ce_usuario.CodUsuario WHERE pc_pesquisa.id = $id_pesquisa");
$nomeEmpresa = utf8_encode(mysql_result($getEmpresa,0,"nome_empresa"));

if($excecao1) { $maior = $usados; }
if($excecao2) { $maior = $concluidos; }

include("MPDF54/mpdf.php");
$mpdf=new mPDF();
$mpdf->SetHTMLHeader('
<table width="100%" style="vertical-align: bottom;color: #000000; border-bottom:2px solid #3e74cd; font-family:Arial">
       <tr>
               <td width="33%"><img src="imagens/appweb_relatorio.png" /></td>
               <td width="33%" align="center" style="font-weight: bold;color:#3e74cd; font-size:18px;">Pesquisa de Clima<br />'.$nomeEmpresa.'</td>
               <td width="33%" align="right" style="color:#797979; font-size:12px;">'.$maior.'/'.$numero_participantes.'<br />{DATE j/m/Y}</td>
       </tr>
</table>  
'); 
$mpdf->SetHTMLFooter('
<table width="100%" style="vertical-align: bottom; font-family: Arial; font-size: 8pt; color: #000000; font-weight: bold; border-top:1px solid #d8d8d8">
       <tr>
               <td width="33%" style="color:#3e74cd"><a hrer="http://www.appweb.com.br" style="color:#3e74cd">www.appweb.com.br</a></td>
               <td width="33%" align="center" style="font-weight: bold;color:#797979">{PAGENO}/{nbpg}</td>
               <td width="33%" style="text-align: right; color:#3e74cd">APP Web - Perfil profissional</td>
       </tr>
</table>');
$mpdf->WriteHTML($pdf);
$mpdf->Output(); 
 
$graficos_delete = explode("|",$graficos_delete);
for($d = 0; $d < sizeof($graficos_delete); $d++) {
    @unlink("pc_grafico/".$graficos_delete[$d]);
}


exit;

?>