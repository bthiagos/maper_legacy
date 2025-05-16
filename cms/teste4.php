<?php
    include("conn.php");
    
    $sql = "SELECT * FROM pesquisa_perguntas
            WHERE id_pesquisa = 7 ORDER BY ordem ASC";
    
    $sql = mysql_query($sql);
    
    while($alt = mysql_fetch_array($sql))
    {
        $idp = $alt["id"];
        $skl = mysql_query("SELECT * FROM pesquisa_alternativas WHERE id_perguntas = '$idp'");
        while($perg = mysql_fetch_array($skl))
        {
            $nats = explode("|",$perg["alternativas"]);
            for($i = 0; $i < count($nats)-1; $i++)
            {
                if($nats[$i] != "Informações adicionais" and $nats[$i] != "Informações Adicionais")
                {
                    echo "0|";
                }
            }
        }
        
        echo "#";
    }
?>