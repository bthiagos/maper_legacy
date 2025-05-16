<?php include("conn.php") ?>

<?php
    $id_pesquisa = '14';
    
    $sql_tickets = mysql_query("SELECT p.limite FROM pc_pesquisa p LEFT JOIN pc_ticket t ON t.id_pesquisa = p.id WHERE p.id = '$id_pesquisa' GROUP BY t.codigo");
    $limite = mysql_result($sql_tickets,0,'limite');
    $gerados = mysql_num_rows($sql_tickets);
    
    $sql_usados = mysql_query("SELECT id FROM pc_ticket WHERE comecado = '1' and id_pesquisa = '$id_pesquisa'");
    $usados = mysql_num_rows($sql_usados);
    
    $sql_concluidos = mysql_query("SELECT id FROM pc_ticket WHERE finalizado = '1' and id_pesquisa = '$id_pesquisa'");
    $concluidos = mysql_num_rows($sql_concluidos);
    
    //echo $limite."/".$gerados."/".$usados."/".$concluidos;

    $cores = array('1E90FF','228B22','CD0000','EEEE00','FFA500','FFB5C5','CDC9C9','9370DB','A52A2A','000000');
    $limite2 = $limite + 20;
?>

<img src="http://chart.googleapis.com/chart?chxr=0,0,<?=$limite2?>&chxt=y&chbh=a,4,10&chs=700x350&cht=bvg&chco=<?=$cores[0]?>,<?=$cores[1]?>,<?=$cores[2]?>,<?=$cores[4]?>&chds=0,<?=$limite2?>,0,<?=$limite2?>,0,<?=$limite2?>,0,<?=$limite2?>&chd=t:<?=$limite?>|<?=$gerados?>|<?=$usados?>|<?=$concluidos?>&chdl=Tickets+M%C3%A1ximos|Tickets+Gerados|Tickets+Usados|Tickets+Conclu%C3%ADdos&chm=N,000000,0,-1,14&chm=N,000000,0,-1,14|N,000000,1,-1,14|N,000000,2,-1,14|N,000000,3,-1,14" width="800" alt="Tickets" />