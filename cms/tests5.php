<?php
    include("conn.php");
    
    $sql = "SELECT * FROM respostas_clima_ticket
            WHERE id_pesquisa = 7 and texto_outras != ''";
    
    $sql = mysql_query($sql);
    
    echo "<table>";
    while($alt = mysql_fetch_array($sql))
    {
        echo "<tr><td>".$alt["texto_outras"]."</td></tr>";
    }
    echo "</table>";
?>