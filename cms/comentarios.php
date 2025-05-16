<link href="css/css.css" rel="stylesheet" type="text/css" />
<?php
include("conn.php");


// COMENTÁRIOS UNIDADE 0 ---------------------

echo "<div class=\"coment_unidade\">Unidade SIC</div>";

$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 0
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.outras = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["texto_outras"]?>
            </div>
<?
        }
        
    }
    
$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 0
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.formato = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["resposta"]?>
            </div>
<?
        }
        
    }
// COMENTÁRIOS UNIDADE 0 ---------------------

 
 
 
 
 
 
 
 
 
 
 
 
 // COMENTÁRIOS UNIDADE 1 ---------------------

echo "<div class=\"coment_unidade\">Unidade Belo Horizonte</div>";

$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 1
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.outras = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["texto_outras"]?>
            </div>
<?
        }
        
    }
    
$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 1
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.formato = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["resposta"]?>
            </div>
<?
        }
        
    }
// COMENTÁRIOS UNIDADE 1 ---------------------













// COMENTÁRIOS UNIDADE 2 ---------------------

echo "<div class=\"coment_unidade\">Unidade Contagem</div>";

$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 2
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.outras = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label"> 
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["texto_outras"]?>
            </div>
<?
        }
        
    }
    
$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 2
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.formato = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["resposta"]?>
            </div>
<?
        }
        
    }
// COMENTÁRIOS UNIDADE 2 ---------------------






// COMENTÁRIOS UNIDADE 3 ---------------------

echo "<div class=\"coment_unidade\">Unidade Nova Lima</div>";

$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 3
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.outras = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["texto_outras"]?>
            </div>
<?
        }
        
    }
    
$sql_or = "
SELECT
respostas_clima_ticket.ticket
FROM
respostas_clima_ticket
Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
WHERE
respostas_clima_ticket.id_pesquisa = 16 AND
respostas_clima_ticket.id_alternativa = 1 AND
tickets_clima.id_agrupa = 2 AND
respostas_clima_ticket.resposta = 3
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
            SELECT
            respostas_clima_ticket.id,
            respostas_clima_ticket.ticket,
            respostas_clima_ticket.id_pesquisa,
            respostas_clima_ticket.id_pergunta,
            respostas_clima_ticket.id_alternativa,
            respostas_clima_ticket.resposta,
            respostas_clima_ticket.formato,
            respostas_clima_ticket.outras,
            respostas_clima_ticket.texto_outras,
            respostas_clima_ticket.data_resposta
            FROM
            respostas_clima_ticket
            WHERE
            respostas_clima_ticket.ticket = '".$array_or[$j]."' and
            respostas_clima_ticket.formato = 1
        ";
        
        //echo $sql."<br/><br/>";
        $reslta_resp = mysql_query($sql);
        while ($linha = mysql_fetch_assoc($reslta_resp)) {
?>
            <div class="coment_label">
            <strong>Questão:</strong> <?=$linha["id_alternativa"]?><br />
            Comentário: <?=$linha["resposta"]?>
            </div>
<?
        }
        
    }
// COMENTÁRIOS UNIDADE 0 ---------------------