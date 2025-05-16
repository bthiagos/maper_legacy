<?php include("conn.php"); ?>

<?php

    $sql = "SELECT DISTINCT ticket FROM respostas_clima_ticket";
    $sql = mysql_query($sql);
    while($resp = mysql_fetch_array($sql))
    {
        $ticket = $resp["ticket"];
        $randomval = rand(0, 3);
        
        $rands = rand(0,5);
        if($rands != 5)
        {
            $randomval = 3;
        }
        
        //$ins = "INSERT INTO respostas_clima_ticket (ticket, id_pesquisa, id_pergunta, id_alternativa, resposta, formato, texto_outras, data_resposta) VALUES ('$ticket', '7','1824','$randomval','$randomval',2,0,'2011-02-28 19:53:40')";
        $ins2 = "INSERT INTO respostas_clima_ticket (ticket, id_pesquisa, id_pergunta, id_alternativa, resposta, formato, texto_outras, data_resposta) VALUES ('$ticket', '7','1822','$randomval','$randomval',2,0,'2011-02-28 19:53:40')";
    
        //mysql_query($ins);
        mysql_query($ins2);
        
    }

//mysql_query("DELETE FROM respostas_clima_ticket WHERE id_pergunta = '1822'");
?>