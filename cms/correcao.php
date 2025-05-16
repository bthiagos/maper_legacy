<?php
    include("conn.php");
        
    $sql = "SELECT p.perguntas, a.alternativas FROM pesquisa_perguntas as p
    INNER JOIN pesquisa_alternativas as a ON a.id_perguntas = p.id
    WHERE p.id_pesquisa = '7' and a.formato_perguntas ='2' GROUP BY p.perguntas ORDER BY p.ordem ASC";
    
    $query = mysql_query($sql);
    while($linha = mysql_fetch_array($query)){
        echo $linha["perguntas"]."<br/>";
        $alternativas = explode("|",$linha["alternativas"]);   
        
        echo "<table border='1' cellspacing='0' cellpadding='0'>"
        echo "<tr>";
        for($i = 0; $i < sizeof($alternativas); $i++) 
        {
            echo "<td>".$alternativas[$i]."</td>";   
        }
        echo "</tr>";
        echo "</table>";
        echo "<hr></hr>";
    }
    
?>