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

            SELECT c.descricao_vendas,c.descricao_en,c.descricao_es

            FROM  competencias c

            ORDER BY c.ordem";



    //EXECUTA A QUERY

    $sql = mysql_query($sql);

    $row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");



    for ($i = 0; $i < $row; $i++) {

        $nome_competencias[$i] = mysql_result($sql, $i, "descricao_vendas".$complang);

        if ($lang == "en") {
            $nome_competencias[$i] = mysql_result($sql, $i, "descricao_en");
        }

        if ($lang == "es") {
            $nome_competencias[$i] = mysql_result($sql, $i, "descricao_es");
        }

    }

    if (($lang != "es") && ($lang != "en")) {
        $nome_competencias[2] = "Capacidade de Acompanhamento";
        $nome_competencias[3] = "Capacidade de Persuasão";
        $nome_competencias[13] = "Capacidade para gerenciar objeções";
    }


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

    $txt = $comp["descricao_vendas".$complang];

    //echo $comp["competencias_id"]." - $txt - ";

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

$plot -> SetColor('#4eba98@0.2');

$plot -> SetLineWeight(1);

$plot -> SetFillColor('#4eba98@0.7');



$plot -> mark -> SetType(MARK_IMG_SBALL, 'green');



$graph -> Add($plot);

$mome = "radar_" . $id_aplicacao;

$graph -> Stroke('graficos/' . $mome . '.jpg');

?>



<?



$url3 = "http://cms.mapertest.com.br/teste_graf2_vendas.php?lang=".$lang."&org=".$org."&id=" . $id_aplicacao . "&commit=$commit";

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

    if($lang == "en") { $campo = "descricao_venda_en"; }
    if($lang == "es") { $campo = "descricao_venda_es"; }

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


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
<link rel="shortcut icon" href="favicon.ico" />
<title>Mapertest - Avaliação de Potencial e Perfil Profissional</title>

<style type="text/css">

    .paginacao {
        display: block;
        text-align: left;
        color: #58479d; 
        position: absolute;
        bottom: 10px;
        left: 30px;
        font-size: 18px;

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

        width: 750px;

        height: 1070px;

        border: 0px solid #000000;

        overflow: hidden;

        /*background-image: url(<?=$img_rodape;?>);*/

        background-image: url(img/img_footer.jpg);

        background-repeat: no-repeat;

        background-position: right bottom;

    }



    #cabecalho {

        width: 742px;

        height: 96px;

        background-image: url(img/topo_relatorio_img.jpg);
        background-repeat: no-repeat;
        background-position: center center;

        <? if ($fgv) { ?>

        background-image: url(logo-fgv-topo2.jpg); 

        background-repeat: no-repeat; 

        background-position: 10px right;  

        <? } ?>  

        <? if ($edel) { ?>

        background-image: url(logo_edel.png); 

        background-repeat: no-repeat; 

        background-position: 10px right;  

        <? } ?>   

        <? if ($horus) { ?>

        background-image: url(logo_horus.png); 

        background-repeat: no-repeat; 

        background-position: 10px right;  

        <? } ?> 

        <? if ($vocacional) { ?>

        background-image: url(logo_vocacional.jpg); 

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

        font-size: 14px;

        font-weight: bolder;

        color: #42bfb3;

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

        color: #59499e;

        text-align: center;

        float: right;

        padding: 6px 26px;

    }



    .titulotb {

        font-family: Arial, Helvetica, serif;

        font-size: 18px;

        color: #42bfb3;

    }

    .num_normal {

        color: #42bfb3;

    }

    .num_yellow {

        background-color: #42bfb3;

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

        background-color: #58479d;

        font-family: Arial, Helvetica, serif;

        font-size: 14px;

        color: #ffffff;

        text-align: center;

        text-transform: uppercase;

    }

    .titulo_rotulo {

        background-color: #e0d7eb;

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
        O Perfil Maper Vendas surgiu do grande conhecimento prático e de inúmeras pesquisas científicas e acadêmicas realizadas há mais de 20 anos pela professora Dra. Maria Lúcia Rodrigues com a significativa contribuição da empresa de consultoria e treinamento Sucesso em Vendas, que já promoveu o desenvolvimento de mais de 100.000 profissionais da área de vendas. Ambos com mais de 30 anos de experiência, reuniram seus conhecimentos oriundos de inúmeros projetos de consultoria e treinamento do Brasil e exterior.
        <br /><br />
        Este relatório é uma poderosa ferramenta para ser usado pelas áreas de RH, gestores comerciais ou profissionais que atuam, ou queiram atuar, na área de vendas. 
        <br /><br />
        De acordo com a característica do mercado em que atua, cultura da empresa e perfil dos clientes, algumas competências podem tornar-se mais importantes que outras. 
        <br /><br />
        Para ter uma análise aprofundada sobre o Perfil analisado faça contato conosco <a href="http://www.sucessoemvendas.com.br" style="display: inline">www.sucessoemvendas.com.br</a> ou <a style="display: inline" href="http://www.mapertest.com.br">www.mapertest.com.br</a>. 
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

<tr width="100%" style="background: #e0d7eb;">

<td class="titulo_rotulo" width="100%" style="font-size: 14px; background: #e0d7eb;" align="justify">

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

<tr width="100%" style="background: #e0d7eb;">

<td class="titulo_rotulo" width="100%" style="font-size: 14px; background: #e0d7eb;" align="justify">

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



<!-- PAGINA 1 -->
    <br/>

   


    <div class="pagina">    

<? include("novo_relatorio_topo.php"); ?>
    
    
        <table width="100%" border="0" style="margin-top: 15px; margin-bottom: 15px;">

            <tr>

                <td width="350" class="titulotb"><strong><?=$theads[0]?></strong></td>

                <td width="270" class="titulotb"><strong><?=$theads[1]?></strong></td>

                <td width="130" align="center" class="titulotb"><strong><?=$theads[2]?></strong></td>

            </tr>

        </table><br/> 

        

        <table width="750" border="0" cellspacing="00">

            

  <?php
        $i = 0;
        $num = 1;

        $linha_arquivo = 1;

    //  echo "<p><b>CompetÃªncias:</b></p>";

        while ($i<10) { 

            //echo $nome_competencias[$i]." - ".$i."<br/>" ;

            $no = $i + 1;

            /*
            if($i>2) { 
            $no = $i;
            }*/

            if($i>6) { 
            $no = $i;
            }


            $libera = true;
            if($i == 6) {  
                $libera = false;
            }
            if($i == 2) { 
                $libera = true;
            }

            //Remover 10
            if($libera) {
            ?>      

              <tr>

                <td width="670" class="titulo_competencia" nowrap="nowrap"><strong><? echo $no; ?> - <? echo $nome_competencias[$i]; ?></strong><span style="margin-left: 70px;" class="notas_ideias"><? ideal($i + 1); ?></span></td>

                <td width="80">&nbsp;</td>

              </tr>

              <tr>

                <td width="620" class="txt_feedback"><? echo feedback(($i + 1), $competencias[$i], $lang); ?><br/><br/></td>

                <td align="center" class="nota_pessoa"><strong><? echo $competencias[$i]; ?></strong></td>

              </tr>

            <?
                $num++;
            } 
            $i++;
        }

        ?>          

        </table>

     <div class="paginacao">
            página [[page_cu]]/[[page_nb]] 
        </div>


    </div>

    

    

    <!-- PAGINA 2 -->

    <br/>

    <div class="pagina">    

<? include("novo_relatorio_topo.php"); ?>

        

        <table width="750" border="0" style="margin-top: 15px; margin-bottom: 15px;">

            <tr>

                <td width="350" class="titulotb"><strong><?=$theads[0]?></strong></td>

                <td width="270" class="titulotb"><strong><?=$theads[1]?></strong></td>

                <td width="130" align="center" class="titulotb"><strong><?=$theads[2]?></strong></td>

            </tr>

        </table><br/> 

        

        <table width="750" border="0" cellspacing="00">

            
 
  <?php

        $i = 10;

    //  echo "<p><b>CompetÃªncias:</b></p>";

        while (($i>=10) && ($i<=19)) { 

         //echo $nome_competencias[$i]." - ".$i."<br/>" ;

        $no = $i;

        //if($org == 324 || $org == 487) {
        //$no = $i;
        //}
        ?>      

          <tr>

            <td width="670" class="titulo_competencia" nowrap="nowrap"><strong><? echo $no; ?> - <? echo $nome_competencias[$i]; ?></strong><span style="margin-left: 70px;" class="notas_ideias"><? ideal($i + 1); ?></span></td>

            <td width="80">&nbsp;</td>

          </tr>

          <tr>

            <td width="620" class="txt_feedback"><? echo feedback(($i + 1), $competencias[$i], $lang); ?><br/><br/></td>

            <td align="center" class="nota_pessoa"><strong><? echo $competencias[$i]; ?></strong></td>

          </tr>

          

          

        <?$i++;

            }

        ?>

          

      

          

        </table>

        <div class="paginacao">
            página [[page_cu]]/[[page_nb]] 
        </div>

    </div>
   

    <!-- PAGINA 4 -->

    <br/>

    <div class="pagina">    

<? include("novo_relatorio_topo.php"); ?>



        <?

        $codigo_id2 = $id_aplicacao . "grafico2.png";

        ?>

        

        

        <p style="text-align: center; margin-top: 55px;">

        <img src="graficos/<?=$mome ?>.jpg" />

        </p>

        


        <div class="paginacao">
            página [[page_cu]]/[[page_nb]] 
        </div>

    </div>

    

    

    <!-- PAGINA 5 -->

    <br/>

    <div class="pagina">    

<? include("novo_relatorio_topo.php"); ?>



        <p class="txt_explica">

        <?

        $explicacao = 'A tabela a seguir possui 3 colunas sendo Sustentação, Aceitável e Crítico.<br />

        Por "Sustentação" entenda pelos "pontos fortes" do candidato / profissional que remetem aos fatores de excelência.<br />

        Na segunda coluna, compreenda que são os fatores aceitáveis, ou seja, estão adequados mas podem evoluir mais. <br />

        Por último, os fatores críticos sugerem as competências que podem prioritariamente ser trabalhadas.<br /><br /> 

        É importante lembrar que essa é uma classificação generalizada e deve ser adequada às competências organizacionais, portanto, ao perfil de cada cargo.';

        

        if($lang == "en") {

        $explicacao = 'The following table has 3 columns and Support, Acceptable and Critical. <br />

        By "Sustainable" is meant by the "strengths" of the candidate referring to excellence factors. <br />

        In the second column comprises factors that are acceptable, ie they are more suitable may evolve. <br />

        Finally, the critical factors suggest the skills that can primarily be worked. <br /> <br />

        It is important to remember that this is a general classification and shall be appropriate to organizational skills, so the profile of each post.';

        }

        

        if($lang == "es") {

        $explicacao = 'La siguiente tabla tiene 3 columnas y soporte técnico, Aceptable y Crítica. <br />

        Por "Sustentable" se entiende por los "puntos fuertes" del candidato se refieren a factores de excelencia. <br />

        En la segunda columna comprende factores que son aceptables, es decir, son más adecuados pueden evolucionar. <br />

        Por último, los factores críticos sugieren las habilidades que principalmente se pueden trabajar. <br /> <br />

        Es importante recordar que esta es una clasificación general y deberá ser adecuado a la capacidad de organización, por lo que el perfil de cada puesto.';

        

        }

        

        echo $explicacao;

        

        ?>

        

        

        </p>

        

        

        <p style="margin-top: 10px; margin-left: 25px;">

            <?include ("tabela2_novo_vendas.php");?>

        </p>

        





        <?

        // ESTILO LIDER

        $nota_competencia3 = $competencias[2];

        $nota_competencia4 = $competencias[3];



        // LIDER INTEGRAL

        if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

            $label_lider = "Líder Integral";

            $txt_estilo = "Professionals who reveal this profile have a good capacity Motivational Leadership (Leadership Style) and also easy to develop people (Support Capacity). Usually can motivate your team to achieve goals and objectives and also stimulate the potential of people promoting their development and revealing some potential, assuming the true role of Leader COACH.";

        

            if($lang == "en") {

                $label_lider = "Integral Leader";

                $txt_estilo = "Los profesionales que revelan este perfil tienen una buena capacidad de Liderazgo Motivacional (Estilo de Liderazgo) y también es fácil de desarrollar personas (apoyo a la capacidad). Por lo general, puede motivar a su equipo para lograr las metas y objetivos, y también estimular el potencial de las personas promoviendo su desarrollo y que revela un cierto potencial, asumiendo el verdadero papel de COACH Líder.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Integral";

                $txt_estilo = "Os profissionais que revelam este perfil apresentam boa capacidade de Liderança Motivacional (Estilo de Liderança) e também facilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente conseguem motivar sua equipe para atingir metas e objetivos e também estimulam o potencial das pessoas promovendo o seu desenvolvimento e revelando alguns potenciais, assumindo o verdadeiro papel de Líder COACH.";

            }

        }



        // LIDER CARISMETICO

        if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

            $label_lider = "Líder Carismático";

            $txt_estilo = "Os profissionais com este perfil geralmente conseguem motivar as pessoas para atingir os desafios, e possuem uma forte liderança inspiradora, contudo podem estar depositando muita energia nesta competï¿½ncia e faltando habilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente são excelentes Líderes motivacionais, mas precisam também desenvolver sua Liderança COACH. ";

        

            if($lang == "en") {

                $label_lider = "Charismatic leader";

                $txt_estilo = "Professionals with this profile usually can motivate people to achieve the challenges, and have a strong inspirational leadership, but may be deposited much energy in this competï¿½ncia and lacking ability to develop people (Support Capacity). Usually are excellent motivational leaders, but also need to develop their leadership COACH.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder carismático";

                $txt_estilo = "Los profesionales con este perfil por lo general puede motivar a la gente para lograr los retos, y tienen un fuerte liderazgo inspirador, pero pueden ser depositado mucha energía en este competï¿½ncia y la capacidad que carecen de desarrollar personas (Apoyo Capacity). Por lo general son excelentes líderes de motivación, pero también tienen que desarrollar su entrenador liderazgo.";

            }

        }



        // LIDER COACH

        if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

            $label_lider = "Líder Educador";

            $txt_estilo = "Os profissionais com este perfil revelam ótima capacidade para desenvolver pessoas (Capacidade de Acompanhamento) e geralmente conseguem estimular o potencial de sua equipe formando novos talentos. Contudo podem aprimorar sua habilidade para também motivar pessoas no intuito de atingir metas e objetivos. Todavia já revelam uma ótima habilidade de Liderança COACH.";

        

            if($lang == "en") {

                $label_lider = "Educator Leader";

                $txt_estilo = "Professionals with this profile shows great ability to develop people (Support Capacity) and often can stimulate the potential of your team forming new talent. However can improve their ability to also motivate people in order to achieve goals and objectives. However already show a great ability to COACH Leadership.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Educador";

                $txt_estilo = "Los profesionales con este perfil muestra una gran capacidad para desarrollar a las personas (Apoyo capacidad) y con frecuencia puede estimular el potencial de su equipo de formación de nuevos talentos. Sin embargo, pueden mejorar su capacidad para motivar a la gente también con el fin de alcanzar las metas y objetivos. Sin embargo ya muestran una gran habilidad para COACH Liderazgo.";

            }

        }



        // LIDER Fiscal

        if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

            $label_lider = "Líder Fiscal";

            $txt_estilo = "Os profissionais com este perfil são do tipo fiscalizadores que cobram sistematicamente de sua equipe as tarefas a serem desenvolvidas e geralmente não permitem que os mesmos expressem seu potencial. Revelam dificuldades para delegar e desenvolver pessoas inibindo o potencial do grupo.";

        

            if($lang == "en") {

                $label_lider = "Fiscal Leader";

                $txt_estilo = "Professionals with this profile are the inspection type that systematically charge of their team tasks to be developed and generally do not allow them to express their potential. Reveal difficulties to delegate and develop people by inhibiting the group's potential.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Fiscal";

                $txt_estilo = "Los profesionales con este perfil son el tipo de inspección que cobran sistemáticamente de sus tareas del equipo a desarrollar y generalmente no les permitan expresar su potencial. Revelar las dificultades a delegado y desarrollar a las personas mediante la inhibición potencial del grupo.";

            }

        }



        // LIDER Influenciador

        if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

            $label_lider = "Líder Influenciador";

            $txt_estilo = "Os profissionais com este perfil apresentam forte capacidade para influenciar pessoas, pois sua Liderança Motivacional é acentuada. Em virtude deste estilo inspirador e contagiante algumas pessoas podem perder a iniciativa em sua ausência. Todavia, conseguem desenvolver pessoas e revelam ótima capacidade para promover e formar equipes.";

        

            if($lang == "en") {

                $label_lider = "Influencer Leader";

                $txt_estilo = "Professionals with this profile have strong ability to influence people, for his Leadership Motivational is sharp. Because of this inspiring and contagious style some people may lose the initiative in his absence. However, people can develop and show great ability to promote and build teams.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Influenciador";

                $txt_estilo = "Los profesionales con este perfil tienen una fuerte capacidad de influir en las personas, por su motivación liderazgo es agudo. Debido a este estilo inspirador y contagioso algunas personas pueden perder la iniciativa en su ausencia. Sin embargo, las personas pueden desarrollar y demostrar una gran capacidad para promover y construir equipos.";

            }

        }



        // LIDER Diretivo

        if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

            $label_lider = "Líder Diretivo";

            $txt_estilo = "Os profissionais com este perfil apresentam facilidade para mobilizar pessoas revelando boa Liderança Motivacional. Contudo podem exceder na cobrança de resultados e metas inibindo o desenvolvimento da equipe. Também podem revelar dificuldades de delegação.";

        

            if($lang == "en") {

                $label_lider = "Directive Leader";

                $txt_estilo = "Professionals with this profile have facility to mobilize people revealing Leadership Motivational good. However may exceed the collection of results and goals inhibiting the development team. They can also reveal delegation of difficulties.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Directivo";

                $txt_estilo = "Los profesionales con este perfil tienen facilidad para movilizar a las personas que revelan motivación de la dirección buena. Sin embargo podrá ser superior al conjunto de resultados y metas que inhiben el equipo de desarrollo. También pueden revelar delegación de dificultades.";

            }

        }



        // LIDER Excï¿½ntrico

        if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

            $label_lider = "Líder Excêntrico";

            $txt_estilo = "Os profissionais com este perfil são muito intensos e tanto apresentam forte Liderança Mobilizadora como cobram em excesso da equipe podendo inibir seu potencial. Este tipo de comportamento pode dificultar o aprendizado e o crescimento do grupo, que ora sente-se estimulado e ou intensamente cobrado.";

        

            if($lang == "en") {

                $label_lider = "Eccentric Leader";

                $txt_estilo = "Professionals with this profile are very intense and both have strong Mobilizing Leadership Team as charge in excess may inhibit their potential. This type of behavior can hinder learning and the growth of the group, which sometimes feels stimulated and/or intensely charged.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Excéntrico";

                $txt_estilo = "Los profesionales con este perfil son muy intenso y ambos tienen un fuerte equipo de liderazgo Movilizador como carga en exceso puede inhibir su potencial. Este tipo de comportamiento puede dificultar el aprendizaje y el crecimiento del grupo, que ahora se siente estimulada e/o intensamente cargada.";

            }

        }



        // LIDER Motivador

        if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

            $label_lider = "Líder Motivador";

            $txt_estilo = "Os profissionais com este perfil conseguem mobilizar as pessoas para atingir metas e objetivos, mas ainda não sabem como desenvolver sua equipe, talvez por ainda desconhecerem como adotar a postura de Líder Treinador.";

        

            if($lang == "en") {

                $label_lider = "Motivating Leader";

                $txt_estilo = "Professionals with this profile can mobilize people to achieve goals and objectives, but do not know how yet to develop your team, perhaps even unaware of how to adopt the Coach Leader posture.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Motivador";

                $txt_estilo = "Los profesionales con este perfil pueden movilizar a las personas para lograr las metas y objetivos, pero no saben cómo todavía para desarrollar su equipo, tal vez ni siquiera es consciente de cómo adoptar la postura Líder Coach.";

            }

        }



        // LIDER Analista/ Em desenvolvimento

        if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

            $label_lider = "Em desenvolvimento";

            $txt_estilo = "Os profissionais com este perfil ainda não assumem a postura de liderança, talvez por não terem interesse em desenvolver esta competência, ou por nunca terem sido estimulados para tal.";

        

            if($lang == "en") {

                $label_lider = "In development";

                $txt_estilo = "Professionals with this profile not take the leadership position, perhaps have no interest in developing this competence or because they were never encouraged to do so.";

            }

            

            if($lang == "es") {

                $label_lider = "En desarrollo";

                $txt_estilo = "Los profesionales con este perfil no tomar la posición de liderazgo, tal vez no tienen ningún interés en el desarrollo de esta competencia o porque nunca se les anima a hacerlo.";

            }

        }



        

    ?>      

<? if(!isset($_GET['sn'])) { ?>

    <table width="300" align="center">

    <tr>

    <td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "Seu Índice Geral";

    if($lang == "en") { $desc = "Your General Index"; }

    if($lang == "es") { $desc = "Su Índice General"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

    </tr>

    <tr>

    <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;<?=$indice_geral; ?>&nbsp;&nbsp;&nbsp;</td>

    </tr>
    </table>

    <br/><br/>



    <!--<table width="600" align="center">

    <tr>

        <td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

        <?

        $desc = "ÍNDICE DE ADEQUAÇÃO AOS CARGOS";

        if($lang == "en") { $desc = "ROLE ADEQUATION INDEX"; }

        if($lang == "es") { $desc = "ÍNDICE DE ADECUACIÓN A POSICIONES"; }

        echo $desc;

        ?>

        &nbsp;&nbsp;&nbsp;</td>

        <td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

        <?

        $desc = "ÍNDICE MÉDIO";

        if($lang == "en") { $desc = "AVERAGE INDEX"; }

        if($lang == "es") { $desc = "ÍNDICE PROMEDIO"; }

        echo $desc;

        ?>

        &nbsp;&nbsp;&nbsp;</td>

    </tr>

    <tr>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

        <?

        $desc = "INÍCIO DE CARREIRA";

        if($lang == "en") { $desc = "CAREER START"; }

        if($lang == "es") { $desc = "INICIO DE CARRERA"; }

        echo $desc;

        ?>

        &nbsp;&nbsp;&nbsp;</td>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;5,0 a 6,0&nbsp;&nbsp;&nbsp;</td>

    </tr>

    <tr>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

        <?

        $desc = "ENCARREGADO / ANALISTA";

        if($lang == "en") { $desc = "REPONSIBLE / ANALYST"; }

        if($lang == "es") { $desc = "A CARGO / ANALISTA"; }

        echo $desc;

        ?>

        &nbsp;&nbsp;&nbsp;</td>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;6,0 a 7,0&nbsp;&nbsp;&nbsp;</td>

    </tr>

    <tr>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

        <?

        $desc = "GERENTES";

        if($lang == "en") { $desc = "MANAGERS"; }

        if($lang == "es") { $desc = "GERENTES"; }

        echo $desc;

        ?>

        &nbsp;&nbsp;&nbsp;</td>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;7,0 a 8,0&nbsp;&nbsp;&nbsp;</td>

    </tr>

    <tr>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

        <?

        $desc = "DIRETOR";

        if($lang == "en") { $desc = "DIRECTOR"; }

        if($lang == "es") { $desc = "DIRECTOR"; }

        echo $desc;

        ?>

        &nbsp;&nbsp;&nbsp;</td>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;8,0 a 9,0&nbsp;&nbsp;&nbsp;</td>

    </tr>

    </table>







    <br/><br/>-->

            
<? } ?>

        <div class="paginacao">
            página [[page_cu]]/[[page_nb]] 
        </div>


    </div>

    

    <!-- PAGINA 6 -->


<!-- PAGINA 7 -->
<!--
<br/>

<div class="pagina">

<? include("novo_relatorio_topo.php"); ?>



<br/><br/>

<p align="center;">

    <img src="GRAFICO<?=$complang?>.jpg" width="340" align="center" />

</p>    



<table align="center">

    <tr>

        <td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;Seu Estilo de Liderança&nbsp;&nbsp;&nbsp;</td>

    </tr>

    <tr>

        <td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;<?=$label_lider; ?>&nbsp;&nbsp;&nbsp;</td>

    </tr>

</table>



<br/><br/>





<table width="750" align="center">

<tr width="750">

<td colspan="5" width="400" class="titulo_estilo" style="font-size: 16px;"> ESTILOS APP® DE LIDERANÇA</td>

</tr>

<tr width="780">

<td class="titulo_rotulo" width="630" style="font-size: 10px;" align="justify" >

<p style="text-align: justify !important; margin: 0 0 0 0 0;">





<?

$desc = "

<strong>Líder Integral</strong> - Os profissionais que revelam este perfil apresentam boa capacidade



de Liderança Motivacional (Estilo de Liderança) e também facilidade para 



desenvolver pessoas (Capacidade de Acompanhamento). Geralmente conseguem 



motivar sua equipe para atingir metas e objetivos e também estimulam o potencial das 



pessoas promovendo o seu desenvolvimento e revelando alguns potenciais, assumindo 



o verdadeiro papel de Líder COACH.";



if($lang == "en") {

    $desc = "

<strong>Integral Leader </strong> - The professionals who reveal this profile have a good capacity



Motivational Leadership (Leadership Style) and also to ease



develop people (Support Capacity). generally can



motivate your team to achieve goals and objectives and also stimulate the potential of



people promoting their development and revealing some potential, assuming



the true role of COACH Leader.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Integral </strong> - Los profesionales que revelan este perfil tienen una buena capacidad



Liderazgo Motivacional (Estilo de Liderazgo) y también para aliviar



desarrollar personas (apoyo a la capacidad). En general puede



motivar a su equipo para lograr las metas y objetivos, y también estimular el potencial de



personas que promueven su desarrollo y que revelan un cierto potencial, asumiendo



el verdadero papel de Líder COACH.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Carismático</strong> - Os profissionais com este perfil geralmente conseguem motivar



as pessoas para atingir os desafios, e possuem uma forte liderança inspiradora, contudo 



podem estar depositando muita energia nesta competência e faltando habilidade para 



desenvolver pessoas (Capacidade de Acompanhamento). Geralmente são excelentes 



líderes motivacionais, mas precisam também desenvolver sua Liderança COACH.";



if($lang == "en") {

    $desc = "

<strong>Charismatic Leader</strong> - Professionals with this profile usually can motivate



people to meet the challenges, and have a strong inspirational leadership, however



may be deposited much energy in this jurisdiction and lacking ability to



develop people (Support Capacity). Usually are excellent



motivational leaders, but also need to develop their leadership COACH.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Carismático </strong> - Los profesionales con este perfil por lo general pueden motivar



personas para afrontar los retos, y tienen un fuerte liderazgo inspirador, sin embargo



pueden depositarse mucha energía en esta jurisdicción y falta capacidad de



desarrollar personas (apoyo a la capacidad). Por lo general son excelentes



líderes de motivación, pero también tienen que desarrollar su entrenador liderazgo.";   

}



echo trim($desc);

?>





</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Educador</strong> - Os profissionais com este perfil revelam ótima capacidade para



desenvolver pessoas (Capacidade de Acompanhamento) e geralmente conseguem 



estimular o potencial de sua equipe formando novos talentos. Contudo podem 



aprimorar sua habilidade para também motivar pessoas no intuito de atingir metas e 



objetivos. Todavia já revelam uma ótima habilidade de Liderança COACH.";



if($lang == "en") {

    $desc = "

<strong>Educational Leader </strong> - Professionals with this profile shows great ability to



develop people (Support Capacity) and generally can



stimulate the potential of your team forming new talent. However can



enhance its ability to also motivate people in order to achieve goals and



goals. However already show a great ability to COACH Leadership.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Educativo </strong> - Los profesionales con este perfil muestra una gran capacidad de



desarrollar personas (apoyo a la capacidad) y, en general puede



estimular el potencial de su equipo de formación de nuevos talentos. Sin embargo puede



mejorar su capacidad para motivar a la gente también con el fin de alcanzar las metas y



metas. Sin embargo ya muestran una gran capacidad de COACH en liderazgo.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify" >

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Fiscal</strong> - Os profissionais com este perfil são do tipo fiscalizadores que cobram



sistematicamente de sua equipe as tarefas a serem desenvolvidas e geralmente não 



permitem que os mesmos expressem seu potencial. Revelam dificuldades para delegar 



e desenvolver pessoas inibindo o potencial do grupo.";



if($lang == "en") {

    $desc = "

<strong>Fiscal Leader </strong> - Professionals with this profile are the inspection type that charge



tasks systematically of his team to be developed and generally not



allow them to express their potential. Reveal difficulties to delegate



and develop people by inhibiting the group's potential.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Fiscal </strong> - Los profesionales con este perfil son el tipo de inspección que cobran



tareas sistemáticamente de su equipo a ser desarrollados y generalmente no



les permitan expresar su potencial. Revelar las dificultades para delegar



y desarrollar a las personas mediante la inhibición potencial del grupo.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Influenciador</strong> - 

Os profissionais com este perfil apresentam forte capacidade



para influenciar pessoas, pois sua Liderança Motivacional é acentuada. Contudo, conseguem desenvolver pessoas e revelam ótima capacidade para promover e formar sua equipe.";



if($lang == "en") {

    $desc = "

<strong>Influencer Leader </strong> -

Professionals with this profile have strong capacity



to influence people because its Leadership Motivational is sharp. However, people can develop and show great ability to promote and train your team.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Influyente </strong> -

Los profesionales con este perfil tienen capacidad fuerte



para influir en la gente porque su motivación liderazgo es agudo. Sin embargo, las personas pueden desarrollar y demostrar una gran capacidad para promover y formar a su equipo.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Diretivo</strong> - 

Os profissionais com este perfil apresentam facilidade para mobilizar



pessoas revelando ótima Liderança Motivacional. Contudo podem exceder na 



cobrança de resultados e metas inibindo o desenvolvimento da equipe. Também 



podem revelar dificuldades de delegação.";



if($lang == "en") {

    $desc = "

<strong>Directive Leader </strong> -

Professionals with this profile have facility to mobilize



Motivational Leadership great people revealing. However may exceed the



collection results and goals inhibiting the development team. also



can reveal delegation of difficulties.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Directivo </strong> -

Los profesionales con este perfil tienen facilidad para movilizar



Liderazgo motivación gran pueblo revelando. Sin embargo podrá ser superior al



resultados de la recogida y las metas que inhiben el equipo de desarrollo. también



puede revelar delegación de dificultades.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Excêntrico</strong> - 

Os profissionais com este perfil são muito intensos e tanto



apresentam forte Liderança Mobilizadora como cobram em excesso da equipe 



podendo inibir seu potencial. Este tipo de comportamento dúbio pode dificultar o



aprendizado e o crescimento do grupo, que ora sentem-se estimulados e ou



intensamente cobrados.";



if($lang == "en") {

    $desc = "

<strong>Eccentric Leader </strong> -

Professionals with this profile are very intense and both



Mobilizing have strong leadership as charge in excess of the team



and inhibiting their potential. This kind of dubious behavior can hinder



learning and the growth of the group, which now feel encouraged and or



intensely charged.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Excéntrico</strong> -

Los profesionales con este perfil son muy intensos y ambos



La movilización tiene un fuerte liderazgo como carga en exceso del equipo



y la inhibición de su potencial. Este tipo de comportamiento dudoso puede dificultar



el aprendizaje y el crecimiento del grupo, que ahora se siente alentado y o



intensamente cargada.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Líder Motivador</strong> - Os profissionais com este perfil conseguem mobilizar as pessoas



para atingir metas e objetivos, mas ainda não sabem como desenvolver sua equipe, 



talvez por ainda desconhecerem como adotar a postura de Líder Treinador.";



if($lang == "en") {

    $desc = "

<strong>Motivator Leader </strong> - Professionals with this profile can mobilize people



to achieve goals and objectives, but do not yet know how to develop your team,



perhaps still unaware of how to adopt the posture of Coach Leader.";   

}

if($lang == "es") {

$desc = "

<strong>Líder Motivador</strong> - Los profesionales con este perfil puede movilizar a la gente



para alcanzar las metas y objetivos, pero aún no saben cómo desarrollar su equipo,



quizás todavía desconocen cómo adoptar la postura de Líder Coach.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

<tr width="750">

<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">

<p style="text-align: justify !important; margin: 0 0 0 0 0;">



<?

$desc = "

<strong>Em desenvolvimento</strong> - Os profissionais com este perfil ainda não assumem a postura



de liderança, talvez por não terem interesse em desenvolver esta competência, ou por 



nunca terem sido estimulados para tal.";



if($lang == "en") {

    $desc = "

<strong>In development </strong> - Professionals with this profile not assume the posture



leadership, perhaps because they have no interest in developing this competence or



have never been encouraged to do so.";   

}

if($lang == "es") {

$desc = "

<strong>En desarrollo </strong> - Los profesionales con este perfil no asumen la postura



liderazgo, tal vez porque no tienen interés en el desarrollo de esta competencia o



nunca han sido alentados a hacerlo.";   

}



echo trim($desc);

?>



</p>

</td>

</tr>

</table>



<br/><br/>





</div>
-->

    <!-- PAGINA 5 -->

    <br/>

    <div class="pagina">    

<? include("novo_relatorio_topo.php"); ?>

        <p style="margin-top: 10px; margin-left: 10px;">

        <? if($lang == "en") { ?>
            <img src="quadro_app_web_vendas2.png" height="388" />
        <? } else { ?>
            <img src="quadro_app_web_vendas2.png" height="388" />
        <? } ?>
        </p>

            


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

