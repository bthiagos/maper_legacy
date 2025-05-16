<?php
include("conn.php");
include ("src/jpgraph.php");
include ("src/jpgraph_pie.php");
include ("src/jpgraph_pie3d.php");

$id_pesq = $_REQUEST["pesq"];
$id_perg = $_REQUEST["pergunta"];
$id_agrupa = $_REQUEST["agrupa"];
$unidade = $_REQUEST["unidade"];

//Alternativas
// Buscando informações da Pergunta 
$sql_perguntas2 = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $id_pesq and formato_perguntas=2 and id_perguntas='".$id_perg."' ORDER BY pesquisa_perguntas.id"; 
$result_perguntas2 = mysql_query($sql_perguntas2);
$linha_result = mysql_fetch_assoc($result_perguntas2);


// Pegando Alternativas
$total_alternativas = $linha_result["alternativas"];

// Dividindo as Alternativas em um array
$alternativas = explode("|",$total_alternativas);
$total_alternativas_num = count($alternativas);

array_pop($alternativas);



// Montando OR

$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = $id_pesq AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = $id_agrupa AND
respostas_clima_ticket.resposta = $unidade
";

$array_or = array();

for ($i=0;$i<=$total_alternativas_num-2;$i++) {
    $num_respostas[$i] = 0;   
}


//print_r($num_respostas);

$result_or = mysql_query($sql_or);
while ($linha_or = mysql_fetch_assoc($result_or)) {
    $stringa = $linha_or["ticket"];
    array_push($array_or,$stringa);
}
    
    for ($j=0;$j<=count($array_or);$j++) {
        //Pegando Resultado
        $sql = "
            SELECT respostas_clima_ticket.ticket, tickets_clima.ticket, tickets_clima.id_agrupa,respostas_clima_ticket.resposta as resp
            FROM
            respostas_clima_ticket
            Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
            WHERE id_pesquisa='$id_pesq' and id_pergunta='$id_perg' and tickets_clima.id_agrupa='$id_agrupa' and respostas_clima_ticket.ticket='".$array_or[$j]."'
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        $linha = mysql_fetch_assoc($reslta_resp);
        $resp = $linha["resp"];
        $num_respostas[$resp]++;
        //echo $resp."<br/>";
        
    }

//Tirando ultimo item o array
$resp_fim = array();

for ($i=0;$i<=count($num_respostas);$i++) {
    $resp_fim[$i] = $num_respostas[$i];
}



array_pop($num_respostas);    
//print_r($resp_fim);


if (count($num_respostas) > count($alternativas)) {
    array_pop($num_respostas);
}

if (count($alternativas) > count($num_respostas)) {
    array_pop($alternativas);
}


$data = $num_respostas;

/*
print_r($data);
echo "<br/>";
print_r($alternativas);
*/

$graph = new PieGraph(700,600);
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

$p1->SetLegends($alternativas);
$p1->ShowBorder(false);

// Explode all slices
//$p1->ExplodeAll();
$p1->SetSize(0.3);
$graph->legend->Pos(0.01,0.01);
$graph->Add($p1);
$graph->Stroke();

?> 