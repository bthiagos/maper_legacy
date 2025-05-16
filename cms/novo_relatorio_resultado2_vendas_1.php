<?

include ("conn.php");

include ("library.php");

//ini_set("display_errors",1);


$id_aplicacao = $_REQUEST["id"];

require_once ('jpgraph/src/jpgraph.php');

require_once ('jpgraph/src/jpgraph_radar.php');

$org = $_GET["org"];

$lang = @$_GET["lang"];

if($lang != "br" and $lang != "en" and $lang != "es") { $lang = "br"; }



$cabecalho["cabecalho_br"] = array("NOME","CARGO","CPF","NASCIMENTO","RESPONDIDO EM");

$cabecalho["cabecalho_en"] = array("NAME","JOB TITLE","CPF","BIRTH","ANSWERED IN");

$cabecalho["cabecalho_es"] = array("NOMBRE","TÍTULO PROFESIONAL","CPF","NACIMIENTO","CONTESTADO EN");

$cabecalho = $cabecalho["cabecalho_$lang"];



$theads["theads_br"] = array("Competência","Nota Ideal","Sua Nota");

$theads["theads_en"] = array("Competence","Ideal Rating","Your rating");

$theads["theads_es"] = array("Competencia","Nota Ideal","Su Nota");

$theads = $theads["theads_$lang"];



$complang = "";

if($lang == "en" or $lang == "es") { $complang = "_".$lang; }



// BUSCANDO INFORMAï¿½ï¿½ES DA PESSOA QUE FEZ A APLICAï¿½ï¿½O

$sql_pessoa = "SELECT * FROM aplicacoes WHERE id=$id_aplicacao";

$result_pessoal = mysql_query($sql_pessoa);

$dados_pessoa = mysql_fetch_assoc($result_pessoal);



//data da aplicaï¿½ï¿½o

$pdata_aplic = date('d/m/Y', strtotime($dados_pessoa["data_aplic"]));

$pGabarito = $dados_pessoa["respostas"];

 

$i = $j = $total = 0;

$login = 0;

$Opcao = "";

$id_competencia = "";

$sql = "";

$row = "";

$competencias[20];

$nome_competencias[20];



$i = 0;

while ($i < 20) {

    $competencias[$i] = 0;

    $i++;

}



if (strlen($pGabarito) == 100) {



    $sql = " 

            SELECT c.descricao_venda,c.descricao_en,c.descricao_es

            FROM  competencias c

            ORDER BY c.ordem";



    //EXECUTA A QUERY

    $sql = mysql_query($sql);

    $row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");



    for ($i = 0; $i < $row; $i++) {

        $nome_competencias[$i] = mysql_result($sql, $i, "descricao_venda".$complang);

    }

    $nome_competencias[2] = "Capacidade de acompanhamento";
    $nome_competencias[3] = "Persuasão";
    $nome_competencias[13] = "Capacidade para Lidar com Objeções";



    $i = 0;

    while ($i < 100) {



        $Opcao = $pGabarito[$i];



        if (strcmp($Opcao, "a") || strcmp($Opcao, "b")) {

            //QUERY

            $sql = " 

                    SELECT c.ordem 

                    FROM  questoes q, competencias c

                    WHERE q.competencia_id=c.competencias_id and q.ordem = " . ($i + 1) . " and q.sequencia like \"" . $Opcao . "\"";



            //echo $sql."<br/>"; 



            //EXECUTA A QUERY

            $sql = mysql_query($sql);

            $row = mysql_num_rows($sql) or die("erro na busca das questões");



            $id_competencia = mysql_result($sql, 0, "ordem");

            //echo $id_competencia."<br/>";



            $competencias[$id_competencia - 1]++;



        }//fim do if

        $i++;

    } //fim do while

}//fim do if



$i = 0;

$notas_base10 = array();

$num = 0;
while ($i < 20) {

    $liberado = true;

    if($i == 6) {
        $liberado = false;
    }
    if($i == 2) {
        $liberado = true;
    }

    if($liberado) {
        $notas_base10[$num] = base102(($i + 1), $competencias[$i]);
        
        $num++;
    }
    $i++;
}
$i=0;

//var_dump($notas_base10);



// ------------ GRAFICO RADAR



//$titles = array("Capacidade \nde planejamento", "Capacidade \nde organização", "Capacidade \nde acompanhamento", "Estilo \nde liderança", "Estilo \nde comunicação", "Tomada \nde decissão", "Capacidade \nde delegação", "Administração \ndo tempo", "Volume \nde trabalho", "Potencial\ncriativo\ne flexibilidade", "Cap. priorizar e\n trab. \nc/ imprevistos", "Gestão \nde mudanças", "Relacionamento \ncom superiores", "Gestão \nde\n conflitos", "Controle das\n emoções", "Relacionamento\n afetivo", "Relacionamento \nem grupos", "Imagem \npessoal", "Tônus\n vital", "Necessidade \nde\n realização");

$titles = array();

$comp_sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC");



$c = 1;

$complang = "";

if($lang == "en" or $lang == "es") { $complang = "_".$lang; }

while($comp = mysql_fetch_array($comp_sql)) {

    $txt = $comp["descricao".$complang];

    $txt = preg_replace('/ /', "\n", $txt, 1);
 
    

    if($comp["competencias_id"] == 11 || $comp["competencias_id"] == 10 || $comp["competencias_id"] == 1) { 

         $txt = preg_replace('/ /', "\n", $txt, 3);

         $txt = preg_replace('/ /', "\n", $txt, 6);

    }

    $liberado = true;

    if($comp["competencias_id"] ==7) {
        $liberado = false;
    }
    if($comp["competencias_id"] ==3) {
        $liberado = true;
    }


    if($liberado) {
        if($comp["competencias_id"] == 3) {
            $txt = "Capacidade de acompanhamento";
        }
        if($comp["competencias_id"] == 4) {
            $txt = "Persuasão";
        }
        if($comp["competencias_id"] == 13) {
            $txt = "Capacidade para Lidar\ncom Objeções";
        }
        array_push($titles,$txt);
    }

    $c++;

}



//$titles=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");

$data = $notas_base10;



$graph = new RadarGraph(700, 800);



$titulo = "Avaliação de Perfil Profissional";

if($lang == "en") { $titulo = "Professional Profile Evaluation"; }

if($lang == "es") { $titulo = "Evaluación de Perfil Profesional"; }



$graph -> title -> Set($titulo);

$graph -> title -> SetFont(FF_FONT1, FS_NORMAL, 12);



$graph -> SetTitles($titles);

$graph -> SetCenter(0.5, 0.55);

$graph -> HideTickMarks();

$graph -> SetColor('white');

$graph -> axis -> SetColor('darkgray');

$graph -> grid -> SetColor('darkgray');

$graph -> grid -> Show();



$graph -> axis -> title -> SetFont(FF_FONT1, FS_NORMAL, 10);

$graph -> axis -> title -> SetMargin(10);

$graph -> SetGridDepth(DEPTH_BACK);

$graph -> SetSize(0.65);



$plot = new RadarPlot($data);

$plot -> SetColor('red@0.2');

$plot -> SetLineWeight(1);

$plot -> SetFillColor('red@0.7');



$plot -> mark -> SetType(MARK_IMG_SBALL, 'red');



$graph -> Add($plot);

$mome = "radar_" . $id_aplicacao;

$graph -> Stroke('graficos/' . $mome . '.jpg');

?>



<?



$url3 = "http://www.appweb.com.br/cms/teste_graf2_vendas.php?lang=".$lang."&org=".$org."&id=" . $id_aplicacao . "&commit=$commit";

executa_url("$url3");



function ideal($pCompentencia) {



    $valor[11];



    for ($i = 0; $i < 11; $i++) {

        $valor[$i] = 999;

    }//fecha for



    $sql = " 

            SELECT i.valor 

            FROM  ideais i, competencias c

            WHERE c.competencias_id = i.competencia_id and c.ordem = " . $pCompentencia . "

            ORDER BY i.valor";



    //EXECUTA A QUERY

    $sql = mysql_query($sql);

    $row = mysql_num_rows($sql) or die("erro na busca dos valores ideais das competÃªncias");



    for ($z = 0; $z < $row; $z++) {

        $pos = mysql_result($sql, $z, "valor");

        $valor[$pos] = $pos;

    }//fecha for



    //echo "<div style=\"border: 1px solid #000000; letter-spacing: 70px;\">";

    for ($i = 0; $i < 11; $i++) {

        if($pCompentencia == 1 || $pCompentencia == 2) {
            if($i == 6) {
                $valor[$i] = 999;
            }
        }
        if($pCompentencia == 19) {
            if($i == 7) {
                $valor[$i] = 7;
            }
        }
        if($pCompentencia == 20) {
            if($i == 8) {
                $valor[$i] = 8;
            }
            if($i == 5) {
                $valor[$i] = 999;
            }
        }

        if ($valor[$i] == 999) {

            $valor[$i] = $i;

            echo "<span class=\"num_normal\" >&nbsp;" .$valor[$i] . "&nbsp;</span> ";

        } else {
       

            echo "<span class=\"num_yellow\" >&nbsp;" . $valor[$i] . "&nbsp;</span> ";

        }



    }

    //echo "</div>";



}



function feedback($pCompentencia, $pNota, $lang) {

    $campo = "descricao_venda";

    //if($lang == "en") { $campo = "descricao_en"; }
    //if($lang == "es") { $campo = "descricao_es"; }

    $sql = " 

            SELECT f.$campo

            FROM  feedbacks f, competencias c

            WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;



    //EXECUTA A QUERY

    $sql = mysql_query($sql);

    $row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");



    $pos = (mysql_result($sql, 0, $campo));

    return $pos;



}

?>

<?

// PEGANDO ID DA APLICAï¿½ï¿½O

//echo $dados_pessoa["organizacao"];



// RODAPE FGV

if (($dados_pessoa["organizacao"] == "418")) {

    $fgv = 1;

    $img_rodape = "appweb-editado.png";

} else {

    $img_rodape = "rosape-appweb-sem-logo.png";

    $fgv = 0;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; " />

<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>

<style type="text/css">

    .padding-aumentado td {
        padding: 7px 2px 7px 2px;
    }

    .padding-aumentado2 td {
        padding: 7px 0px 7px 0px;
    }
    .paginacao {
        display: block;
        text-align: right;
        color: #FFF; 
        position: absolute;
        bottom: 10px;
        right: -10px;
    }

    .paginacao {
    }

    .style17 {

        font-family: Arial;

        font-size: 8px;

        font-weight: bold;

    }

    .style18 {

        font-family: Helvetica;

        font-size: 8px;

    }

    body, td, th {

        font-family: Arial, Helvetica, serif;

        font-size: 8px;

    }

    body {

        margin: 0 0 0 0;

        color: 000000;

    }

    .folha {

        page-break-after: always;

    }



    .pagina {
        position: relative;
        width: 760px;

        height: 1070px;

        border: 0px solid #000000;

        overflow: hidden;

        background-image: url(<?=$img_rodape;?>);

        background-repeat: no-repeat;

        background-position: center bottom;

    }



    #cabecalho {

        width: 742px;

        height: 96px;

        border: 4px solid #1172ae;

        -webkit-border-top-left-radius: 30px;

        -webkit-border-bottom-right-radius: 30px;

        -moz-border-radius-topleft: 30px;

        -moz-border-radius-bottomright: 30px;

        border-top-left-radius: 30px;

        border-bottom-right-radius: 30px;

        /*background-image: url(logo_sucesso.jpg); */

        background-repeat: no-repeat; 

        background-position: 10px right;  

        <? if ($fgv) { ?>

        background-image: url(logo-fgv-topo2.jpg); 

        background-repeat: no-repeat; 

        background-position: 10px right;  

        <? } ?>   

        

    }



    .tabela {

        width: 470px;

        float: left;

        margin-left: 7px;

        margin-top: 17px;

    }



    .tabela tr td {

        font-family: Arial, Helvetica, serif;

        font-size: 12px;

        text-transform: uppercase;

        min-width: 230px;

    }

    .tabela tr td span {

        color: #2C72B5;

        font-weight: bolder;

    }



    .subtitulos {

        width: 750px;

        margin: 0 0 0 0;

        padding: 0 0 0 0;

        list-style-type: none;

        margin-top: 20px;

    }



    .subtitulos li {

        float: left;

        color: #2C72B5;

        font-weight: bolder;

        font-family: Arial, Helvetica, serif;

        font-size: 14px;

        text-transform: uppercase;

    }



    .caixa_competencia {

        margin: 0 auto;

        font-family: Arial, Helvetica, serif;

        font-size: 12px;

        color: #000000;

        margin-top: 30px;

    }

    .titulo_competencia {

        min-width: 300px;

        font-family: Arial, Helvetica, serif;

        font-size: 13px;

        font-weight: bolder;

        color: #000000;

    }

    .notas_ideias {

        font-family: Arial, Helvetica, serif;

        font-size: 13px;

        font-weight: bolder;

        color: #000000;

    }

    .txt_feedback {

        font-family: Arial, Helvetica, serif;

        font-size: 11px;

        font-weight: bolder;

        color: #000000;

        text-align: justify;

    }

    .nota_pessoa {

        font-family: Arial, Helvetica, serif;

        font-size: 20px;

        font-weight: bolder;

        color: #2C72B5;

        text-align: center;

        float: right;

        padding: 6px 26px;

    }



    .titulotb {

        font-family: Arial, Helvetica, serif;

        font-size: 18px;

        color: #2C72B5;

    }

    .num_normal {



    }

    .num_yellow {

        background-color: #e28900;

        color: #ffffff;

    }



    .txt_explica {

        font-family: Arial, Helvetica, serif;

        font-size: 12px;

        color: #000000;

        line-height: 20px;

    }



    .coluna_auzl {

        background-image: url(bg_azul.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    

    .coluna_auzl_en {

        background-image: url(bg_azul_en.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    

    .coluna_auzl_es {

        background-image: url(bg_azul_es.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    

    .coluna_amarela {

        background-image: url(bg_amarelo.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    

    .coluna_amarela_en {

        background-image: url(bg_amarelo_en.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    

    .coluna_amarela_es {

        background-image: url(bg_amarelo_es.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    .coluna_vermelho {

        background-image: url(bg_vermelho.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    

    .coluna_vermelho_en {

        background-image: url(bg_vermelho_en.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }

    .coluna_vermelho_es {

        background-image: url(bg_vermelho_es.jpg);

        background-repeat: no-repeat;

        background-position: center top;

    }



    .titulo_estilo {

        background-color: #72aad9;

        font-family: Arial, Helvetica, serif;

        font-size: 14px;

        color: #ffffff;

        text-align: center;

        text-transform: uppercase;

    }

    .titulo_rotulo {

        background-color: #e1f1ff;

        font-family: Arial, Helvetica, serif;

        font-size: 14px;

        color: #000000;

        text-align: center;

    }



</style>

</head>



<body>

    
<?php

// CALCULO ESTILO PROF

// Arrey com todas as mï¿½dias

$final = array();



// Buscando notas Base 10

$i = 0;

while ($i < 20) {

    $competencias10[$i] = base102(($i + 1), $competencias[$i]);

    if($i == 6) { $competencias10[$i] = 0; }


    $i++;

}



//print_r($competencias10);



//ESTILO NEGOCIADOR

$total_nota = 0;

$total_nota += $competencias10[0] + $competencias10[4] + $competencias10[13] + $competencias10[14]  + $competencias10[15] + $competencias10[16];

//print_r($competencias10);

//echo $total_nota;

array_push($final, ($total_nota / 6));

$nota_negociador = $total_nota / 6;

$nota_negociador = number_format($nota_negociador, 1, '.', '');



//ESTILO Executor

$total_nota = 0;

$total_nota += $competencias10[7];

$total_nota += $competencias10[8];

$total_nota += $competencias10[10];

$total_nota += $competencias10[18];

$total_nota += $competencias10[19];

array_push($final, ($total_nota / 5));

$nota_executor = $total_nota / 5;

$nota_executor = number_format($nota_executor, 1, '.', '');



//ESTILO Mobilizador

$total_nota = 0;

$total_nota += $competencias10[2] + $competencias10[3] + $competencias10[4] +  $competencias10[5] +  $competencias10[6];

array_push($final, ($total_nota / 5));

//print_r($competencias10);

//echo $total_nota;

$nota_mobilizador = $total_nota / 5;

$nota_mobilizador = number_format($nota_mobilizador, 1, '.', '');



//ESTILO Analista

$total_nota = $competencias10[0] +  $competencias10[1] + $competencias10[12];   

//echo $total_nota / 3;





array_push($final, ($total_nota / 3));

$nota_analista = $total_nota / 3;

$nota_analista = number_format($nota_analista, 1, '.', '');



//ESTILO Inovador

$total_nota = 0;

$total_nota += $competencias10[9];

$total_nota += $competencias10[10];

$total_nota += $competencias10[11];

array_push($final, ($total_nota / 3));

$nota_inovador = $total_nota / 3;

$nota_inovador = number_format($nota_inovador, 1, '.', '');



// Pegando maior item no array

$maior_item_array = max($final);



//Pega a chame do maior item

$numero_perfil = array_search($maior_item_array, $final);



switch ($numero_perfil) {

    case 0 :

        $label_perfil = "Vendedor Negociador";

        if($lang == "en") {

            $label_perfil = "Salesman Negotiator";   

        }

        if($lang == "es") {

            $label_perfil = "Vendedor Negociador";   

        }

        break;

    case 1 :

        $label_perfil = "Vendedor Produtor";

        if($lang == "en") {

            $label_perfil = "Salesman Producer";   

        }

        if($lang == "es") {

            $label_perfil = "Vendedor Productor";   

        }

        break;

    case 2 :

        $label_perfil = "Vendedor Mobilizador";

        if($lang == "en") {

            $label_perfil = "Salesman Mobilizer";   

        }

        if($lang == "es") {

            $label_perfil = "Vendedor Movilizador";   

        }

        break;

    case 3 :

        $label_perfil = "Vendedor Técnico";

        if($lang == "en") {

            $label_perfil = "Salesman Technician";   

        }

        if($lang == "es") {

            $label_perfil = "Vendedor Técnico";   

        }

        break;

    case 4 :

        $label_perfil = "Vendedor Inovador";

        if($lang == "en") {

            $label_perfil = "Salesman Innovator";   

        }

        if($lang == "es") {

            $label_perfil = "Vendedor Innovador";   

        }

        break;

}



$notamedia = 0;

$i = 0;

while ($i < 20) {

    $nota110 = base102(($i + 1), $competencias[$i]);

    //elimina comp Capacidade de Delegação
    if($i == 6) { $nota110 = 0; }

    $notamedia += $nota110;

    $i++;

}



$indice_geral = $notamedia / 20;


$indice_geral = $notamedia / 19;
$indice_geral = number_format($indice_geral,1,",",".");


?>

 <div class="pagina">    

<? include("novo_relatorio_topo.php"); ?>

<br />
<table width="300" align="center">
    <tr>
    <td align="center" style="font-size: 12px;">
        <img src="title1.jpg" width="230" style="margin-bottom: 10px;" /><br />
    </td>
    </tr>
    <tr>
    <td style="font-size: 14px; line-height: 130%;">
        O Perfil APPWeb Vendas surgiu do grande conhecimento prático e de inúmeras pesquisas científicas e acadêmicas realizadas há mais de 20 anos pela professora Dra. Maria Lúcia Rodrigues com a significativa contribuição da empresa de consultoria e treinamento Sucesso em Vendas, que já promoveu o desenvolvimento de mais de 100.000 profissionais da área de vendas. Ambos com mais de 30 anos de experiência, reuniram seus conhecimentos oriundos de inúmeros projetos de consultoria e treinamento do Brasil e exterior.
        <br /><br />
        Este relatório é uma poderosa ferramenta para ser usado pelas áreas de RH, gestores comerciais ou profissionais que atuam, ou queiram atuar, na área de vendas. 
        <br /><br />
        De acordo com a característica do mercado em que atua, cultura da empresa e perfil dos clientes, algumas competências podem tornar-se mais importantes que outras. 
        <br /><br />
        Para ter uma análise aprofundada sobre o Perfil analisado faça contato conosco <a href="http://www.sucessoemvendas.com.br" style="display: inline">www.sucessoemvendas.com.br</a> ou <a style="display: inline" href="http://www.appweb.com.br">www.appweb.com.br</a>. 
        <br /><br />
    </td>
    </tr>  
</table>


<table width="100%" align="center" class="padding-aumentado">
<tr>
    <td colspan="5" align="center" style="font-size: 12px;">
        <img src="title2.jpg" width="360" style="margin-bottom: 10px;" />
    </td>
    </tr>
<tr>

<td colspan="5" class="titulo_estilo" style="font-size: 16px;">

<?

$desc = "SUAS NOTAS DO ESTILO APP®";

if($lang == "en") { $desc = "YOUR GRADE FROM APP® STYLE"; }

if($lang == "es") { $desc = "SUS NOTAS DE ESTILO APP®"; }

echo $desc;

?>





</td>

</tr>

<tr>

<td class="titulo_estilo" style="font-size: 12px;">

<?

$desc = "Vendedor Negociador";

if($lang == "en") { $desc = "Salesman Negociator"; }

if($lang == "es") { $desc = "Vendedor Negociador"; }

echo $desc;

?>

</td>

<td class="titulo_estilo" style="font-size: 12px;">

<?

$desc = "Vendedor Produtor";

if($lang == "en") { $desc = "Salesman Producer"; }

if($lang == "es") { $desc = "Vendedor Productor"; }

echo $desc;

?>

</td>

<td class="titulo_estilo" style="font-size: 12px;">

<?

$desc = "Vendedor Mobilizador";

if($lang == "en") { $desc = "Vendedor Mobilizer"; }

if($lang == "es") { $desc = "Vendedor Movilizador"; }

echo $desc;

?>

</td>

<td class="titulo_estilo" style="font-size: 12px;">

<?

$desc = "Vendedor Técnico";

if($lang == "en") { $desc = "Salesman Technician"; }

if($lang == "es") { $desc = "Vendedor Analista"; }

echo $desc;

?>

</td>

<td class="titulo_estilo" style="font-size: 12px;">

<?

$desc = "Vendedor Inovador";

if($lang == "en") { $desc = "Salesman Innovator"; }

if($lang == "es") { $desc = "Vendedor Innovador"; }

echo $desc;

?>

</td>

</tr>

<tr>

<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_negociador; ?></td>

<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_executor; ?></td>

<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_mobilizador; ?></td>

<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_analista; ?></td>

<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_inovador; ?></td>

</tr>

</table>

<br />

<!--
<p style="margin-top: 0px; margin-left: 10px;">

<img src="quadro_app_web_profissional_vendas.png" height="380" />

</p>
-->

<table width="98%" align="center" class="padding-aumentado2">

<tr>
    <td colspan="5" align="center" style="font-size: 12px;">
        <img src="title3.jpg" width="360" style="margin-bottom: 10px;" />
    </td>
</tr>
 
 <!--
<tr>

<td colspan="5" width="100%" class="titulo_estilo" style="font-size: 16px;">



<?

$desc = "DEFINIÇÕES DOS ESTILOS PROFISSIONAIS APP®";

if($lang == "en") { $desc = "DEFINITIONS OF APP® PROFESSIONAL STYLES"; }

if($lang == "es") { $desc = "DEFINICIONES DE ESTILOS DE PROFESIONALES APP®"; }

echo $desc;

?>

</td>

</tr>
-->

<tr width="100%">

<td class="titulo_rotulo" width="100%" style="font-size: 14px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>1 - Vendedor Mobilizador</strong> - Vendedores com este estilo possuem capacidade para mobilizar pessoas por meio de seu poder de persuasão. Revelam bom estilo de comunicação e motivam o cliente a tomar decisões. Quanto mais relacional for o modelo de vendas em que trabalha, maior deverá ser o seu escore neste estilo.";



if($lang == "en") {

    $desc = "

<strong>Salesman Mobilizer </strong> - reveals great ability to get results through people and



appreciates manage and mobilize people to achieve goals and objectives. stimulates and



promotes the development of the teams under his responsibility and delegates with



ease. Trust your potential and know make decisions without assertiveness



omit or precipitate. Generally ascend rapidly in companies <strong>assuming



leadership positions </strong>, because they can easily gain followers.";   

}

if($lang == "es") {

$desc = "

<strong>Vendedor Movilizador </strong> - revela una gran capacidad de conseguir resultados a través de las personas y



aprecia gestionar y movilizar a las personas para lograr las metas y objetivos. Estimula y



promueve el desarrollo de los equipos bajo su responsabilidad y con delegados



facilidad. Confíe en su potencial y saber tomar decisiones sin la asertividad



omitir o precipitar. Generalmente ascender rápidamente en las empresas <strong>asumiendo



puestos de dirección </strong>, ya que pueden obtener fácilmente seguidores.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="100%" style="background: #f0f7fe;">

<td class="titulo_rotulo" width="100%" style="font-size: 14px; background: #f0f7fe;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>2 - Vendedor Negociador</strong> - Vendedores com este etilo apresentam bom relacionamento pessoal e em grupos, conseguindo separar relações pessoais das profissionais. Lidam bem conflitos e defendem suas ideias. Quanto mais complexas forem as negociações e maiores os ciclos de vendas no modelo em que trabalha, maior deverá ser o seu escore neste estilo. 
";



if($lang == "en") {

    $desc = "

<strong>Salesman Negotiator</strong> - Reveals interpersonal skill, gets along well in groups



and establishes good affective relationship, separating personal relations professionals.



Communicates clearly and objectively and tries to make himself understood to achieve their



goals. And manage their emotions both in tense situations as in the impasses



day by day. It is a professional who enjoys working with people. usually reveal



great ability to work in <strong>shopping areas and / or sales. </strong>";   

}

if($lang == "es") {

$desc = "

<strong>Vendedor Negociador</strong> - Revela habilidades interpersonales, se lleva bien en grupos



y establece una buena relación afectiva, separando los profesionales de relaciones personales.



Se comunica de manera clara y objetiva y trata de hacerse entender para lograr su



metas. Y manejar sus emociones, tanto en situaciones de tensión como en los callejones sin salida



día a día. Es un profesional que le gusta trabajar con la gente. Por lo general, revelar



gran capacidad de trabajar en áreas <strong>de compras y / o ventas. </strong>";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="100%">

<td class="titulo_rotulo" width="100%" style="font-size: 14px;" align="justify" >

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>3 - Vendedor Técnico</strong> - Vendedores com este estilo são organizados e detalhistas. Quanto mais técnica for a venda e o poder de convencimento for através da capacidade consultiva do vendedor, maior deverá ser o seu escore nesse estilo.
";



if($lang == "en") {

    $desc = "

<strong>Salesman Technician </strong> - reveals an analytical profile and planning and is interested more for activities



that can handle detail and concentration. Prefer to be oriented than lead and



needs direction for the execution of their tasks. Reveal adherence by



<strong>advice and support activities </strong>.";   

}

if($lang == "es") {

$desc = "

<strong>Vendedor Tecnico </strong> - revela un perfil de análisis y planificación y se interesa más por las actividades



que puede manejar detalles y la concentración. Prefiero estar orientadas de plomo y



necesita la dirección para la ejecución de sus tareas. Revelar la adhesión de los



actividades <strong>de asesoramiento y apoyo </strong>.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="100%" style="background: #f0f7fe;">

<td class="titulo_rotulo" width="100%" style="font-size: 14px; background: #f0f7fe;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>4 - Vendedor Produtor</strong> - Vendedores com este estilo apresentam boa administração do tempo e trabalham bem com imprevistos. Possuem necessidade de realização e dimensionam bem seu volume de trabalho. Quanto menor forem os sistemas de controle da produtividade do vendedor,  pela distância física do gestor ou relação empregatícia, maior deverá ser o seu escore nesse estilo.
";



if($lang == "en") {

    $desc = "

<strong>Salesman Producer </strong> - - It has high productivity in the achievement of your goals or performing



their tasks. Can work well with deadlines and time pressure and enjoys very



achieve your goals. Relies on its potential



professionals who have identity with <strong>activities that require speed in meeting deadlines and unforeseen. </strong>";   

}

if($lang == "es") {

$desc = "

<strong>Vendedor Productor </strong> - - Tiene una alta productividad en el logro de sus objetivos o la realización de



sus tareas. Puede trabajar bien con los plazos y la presión del tiempo y disfruta de muy



alcanzar sus metas. Se basa en su potencial



profesionales que tienen identidad con <strong>actividades que requieren velocidad en cumplimiento de los plazos y los imprevistos. </strong>";   

}



echo trim($desc);

?>







</p>

</td>

</tr>




<tr width="100%">

<td class="titulo_rotulo" width="100%" style="font-size: 14px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>5 - Vendedor Inovador</strong> - 

Vendedores com este estilo revelam interesse por negócios em que possam ter liberdade para expressar suas ideias e opiniões. Preferem trabalhos sem rotinas e evitam tipos de vendas mais técnicas, pois a necessidade permanente de mudança é inerente ao seu perfil.
";



if($lang == "en") {

    $desc = "

<strong>Salesman Innovative </strong> -

Shows interest in activities that may have freedom to express



their ideas and opinions. Prefer work without routines or hardship because



permanent need for change is inherent to their profile. Usually <strong>are people



more creative and inventive </strong> and have an aversion to bureaucratic situations. Deal well with



unforeseen without stress and adapt easily to new situations.";   

}

if($lang == "es") {

$desc = "

<strong>Vendedor Innovador </strong> -

Muestra interés en actividades que puedan tener la libertad de expresar



sus ideas y opiniones. Prefiero trabajar sin rutinas o dificultades porque



necesidad permanente de cambio es inherente a su perfil. Por lo general, <strong>son personas



más creativo e inventivo </strong> y tienen una aversión a situaciones burocráticas. Encaja bien con



imprevista y sin estrés y adaptarse fácilmente a nuevas situaciones.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

</table>

<br />







<div class="paginacao">
    página [[page_cu]]/[[page_nb]] 
</div>



</div>



</body>

</html>



<?

    function base102($pCompentencia, $pNota) {



        $sql = "
        SELECT f.descricao_venda, f.base10, f.base10_vendas
        FROM  feedbacks f, competencias c
        WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;



        //EXECUTA A QUERY

        $sql = mysql_query($sql);

        $row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");

        if(mysql_result($sql, 0, "base10_vendas") != null && mysql_result($sql, 0, "base10_vendas") != "") {
            return $a = mysql_result($sql, 0, "base10_vendas");
        } else {
            return $a = mysql_result($sql, 0, "base10");
        }


    }

?>