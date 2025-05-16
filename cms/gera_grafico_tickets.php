<?php
include("conn.php");
include ("src/jpgraph.php");
include ("src/jpgraph_pie.php");
include ("src/jpgraph_pie3d.php");

$id_pesq = $_REQUEST["pesq"];
$id_perg = $_REQUEST["pergunta"];
$id_agrupa = $_REQUEST["agrupa"];

// Buscando informações da Pergunta 
$sql_perguntas2 = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $id_pesq and formato_perguntas=2 and id_perguntas='".$id_perg."' ORDER BY pesquisa_perguntas.id"; 
$result_perguntas2 = mysql_query($sql_perguntas2);
$linha_result = mysql_fetch_assoc($result_perguntas2);

//echo $sql_perguntas2;

// Pegando Alternativas
$total_alternativas = $linha_result["alternativas"];

// Dividindo as Alternativas em um array
$alternativas = explode("|",$total_alternativas);
//print_r($alternativas);

//Total de Alternativas
$num_total_alternativas = (count($alternativas)-1);

//Array num respsotas
$num_respostas = array();
$todas_alternativas = array();

// Capiturando o total de respostas de cada alternativa
for ($i=0;$i<=$num_total_alternativas-1;$i++) {
    
    //Pegando Resultado
    $sql = "
        SELECT respostas_clima_ticket.ticket, tickets_clima.ticket, tickets_clima.id_agrupa
        FROM
        respostas_clima_ticket
        Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
        WHERE id_pesquisa='$id_pesq' and id_pergunta='$id_perg' and resposta='$i' and tickets_clima.id_agrupa='$id_agrupa'
    ";
    $reslta_resp = mysql_query($sql);
    $total = mysql_num_rows($reslta_resp);
    $num_respostas[$i] = $total;
    $todas_alternativas[$i] = $alternativas[$i];
    
}
$data = $num_respostas;
//print_r($data);

if(!empty($data) and array_sum($data) != 0)
{
if($id_perg == "133" or $id_perg == "1823")
{
$graph = new PieGraph(1300,850);
} else {
    $graph = new PieGraph(650,550);
}
//$graph->SetMarginColor('gray');
$graph->SetShadow();
//$graph->SetShadow();

$graph->SetBox(true);

// Setup margin and titles
//$graph->title->Set("Exemplo: Horas de Trabalho");

$p1 = new PiePlot($data);
$p1->SetCenter(0.35,0.5);

// Setup slice labels and move them into the plot
$p1->SetCenter(0.35,0.5);

// No border
$p1->ShowBorder(false);

// Label font and color setup
$p1->value->SetFont(FF_FONT1,FS_BOLD);
$p1->value->SetColor("darkred");

$p1->SetLegends($todas_alternativas);
$p1->ShowBorder(false);

// Explode all slices
//$p1->ExplodeAll();
$p1->SetSize(0.3);
$graph->legend->Pos(0.02,0.01);
$graph->Add($p1);
$graph->Stroke();
}
?> 