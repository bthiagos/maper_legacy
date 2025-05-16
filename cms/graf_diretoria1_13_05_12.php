<? session_start(); ?>

<?php include("conn.php"); ?>
<?php include("library.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body style="font-family:tahoma; font-size:12px;">

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>
<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
	<?php include("topo.php"); ?>	
    
    
	<!-- INICIO - DIV info - Barra de informacao -->
	<div id="info" style="font-size: 20px;">
		<?
            if($_GET["n"] == 1) { $nome = "Diretoria Técnica Assistencial"; }
            if($_GET["n"] == 2) { $nome = "Diretoria de Hotelaria e Administração"; }
            if($_GET["n"] == 3) { $nome = "Diretoria Financeira"; }
            if($_GET["n"] == 4) { $nome = "Diretoria de Projetos"; }
            if($_GET["n"] == 6) { $nome = "Superintendência"; }
            if($_GET["n"] == 7) { $nome = "Controladoria"; }
            if($_GET["n"] == 5) { $nome = "Diretoria Clínica"; }
        ?>
		Resultado da Pesquisa para a Diretoria Técnica Assistencial
	</div>
    
    <div class="global_pesq">
        <?php
        //PEGA TODAS AS ÁREAS
            $sql_unidade = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = 7 and formato_perguntas=2 ORDER BY pesquisa_perguntas.id"; 
            $result_unidade = mysql_query($sql_unidade) or die(mysql_error());
            $linha_unidade = mysql_fetch_assoc($result_unidade);
            $alternativas_unidade = $linha_unidade["alternativas"];
            $unidades = explode("|",$alternativas_unidade);
           
        ?>
        
        <? //DIVIDE EM DIRETORIAS ?>
        <?
        $_SESSION["diretoria_1"] = "";                                
    ?>
    
    <? for ($i=0;$i<=count($unidades)-3;$i++) {?>
 
        <? if($i <= 35) { //Diretoria Técnica Assistencial ?>
            <? $a1_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_1[$i] = $i; ?>
        <? } ?>
        <? if($i <= 72 and $i >= 36) { //Diretoria de Hotelaria e Administração ?>
            <? $a2_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_2[$i] = $i; ?>
        <? } ?>
        <? if($i <= 97 and $i >= 73) { //Diretoria Financeira ?>
            <? $a3_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_3[$i] = $i; ?>
        <? } ?>
        <? if($i <= 99 and $i >= 97) { //Diretoria de Projetos ?>
            <? $a4_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_4[$i] = $i; ?>
        <? } ?>
        <? if($i >= 105 and $i <= 108) { //Diretoria Clínica ?>
            <? $a5_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_5[$i] = $i; ?>
        <? } ?>
        
        <? if($i >= 100 and $i <= 101) { //Diretoria Clínica ?>
            <? $a6_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_6[$i] = $i; ?>
        <? } ?>
        
        <? if($i >= 102 and $i <= 104) { //Diretoria Clínica ?>
            <? $a7_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_7[$i] = $i; ?>
        <? } ?>
    <? } ?>
    
    <?php
        $_SESSION["diretoria_1"] = $diretoria_1;

    ?>
     
        <?php
            $_SESSION["diretoria_tickets"] = "";
            //SELECIONA OS TICKETS

            for($dir1 = 0; $dir1 < sizeof($diretoria_1); $dir1++) {
                
                $dir1_or .= "resposta = '".$dir1."' OR ";
            }
            $dir1_or = substr($dir1_or,0,-4);
            $dir1_or = "(".$dir1_or.")";
            
            $dir1_query = "SELECT * FROM respostas_clima_ticket WHERE id_pesquisa = '7' and id_pergunta = '133' AND $dir1_or";
            $dir1_query = mysql_query($dir1_query) or die(mysql_error());
            while($dir1_fetch = mysql_fetch_array($dir1_query)) {
                $dir1_ticket .= $dir1_fetch["ticket"].",";
            }
            
            $dir1_ticket = substr($dir1_ticket,0,-1);
  
            //$dir1_ticket = explode("/",$dir1_ticket);
            //array_pop($dir1_ticket);
            
           
            // Selecionando Perguntas
            $sql_perguntas = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = '7' and formato_perguntas='2' ORDER BY pesquisa_perguntas.ordem"; 
            $result_perguntas = mysql_query($sql_perguntas) or die(mysql_error());
            ?>    
    
        
      
                <?
                $i=0;
                //Lista as Perguntas
                
                while($linha_perguntas = mysql_fetch_assoc($result_perguntas)) {
                    $i++;
                    $id_perguntas = $linha_perguntas["id"];
                    
                    $id_perg = $linha_perguntas["id"];
                ?>
    
                
            <div class="perg_pesq">
                <?
                    	//SE EXISTIR UM TEXTO DE INTRODUCAO
                    	if($linha_perguntas["texto"] != ""){	
                ?>
                            <p><?=nl2br($linha_perguntas["texto"])?></p>
            
                        <? }// IF?>
                                
                        
            
                        <p><strong><?=$i?>. <?=$linha_perguntas["perguntas"]?></strong></p>
             </div>       
      
                <?
                
                // Pegando Alternativas
                $total_alternativas = $linha_perguntas["alternativas"];
                
                // Dividindo as Alternativas em um array
                $alternativas = explode("|",$total_alternativas);
                //print_r($alternativas);
                
                //Total de Alternativas
                $num_total_alternativas = (count($alternativas)-1);
                
                //Array num respsotas
                $num_respostas = array();
                $todas_alternativas = array();
                    
           
     
                    
                //AQUI TEMOS TODAS AS ALTERNATIVAS DA PERGUNTA
                // Capiturando o total de respostas de cada alternativa
                // é aqui que eu tenho que pegar os dados agrupados por diretoria
               
                    
                    for ($j=0;$j<=$num_total_alternativas-1;$j++) {
                        //Pegando Resultado
                        
                        $sql = "
                            SELECT respostas_clima_ticket.ticket, tickets_clima.ticket, tickets_clima.id_agrupa
                            FROM
                            respostas_clima_ticket
                            Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
                            WHERE id_pesquisa='7' and id_pergunta='$id_perg' and resposta='$j' and tickets_clima.id_agrupa='8'
                        ";
                        //TEMOS QUE VERIFICAR O $i, comparar $i com $diretoria_1[$i] se for diferente ignora isso aqui, se for igual continua
                        $reslta_resp = mysql_query($sql) or die(mysql_error());
                        $total = mysql_num_rows($reslta_resp);
                        
                        $todas_alternativas[$j] = $alternativas[$j];
                        
                        $num_respostas[$j] = $total;
                   
                   
                }
                
               
                ?>
                
                <table style="margin-top: 15px; width: 600px;" border="1" cellspacing="0" cellpadding="0">
                    <tr>
                    <? for($f = 0; $f < sizeof($todas_alternativas); $f++) { ?>
                        <td width="50" style="background: #EBEBEB;"><?=$todas_alternativas[$f]?></td>
                    <? } ?>
                    </tr>
                    
                    <tr>
                    <? for($e = 0; $e < sizeof($num_respostas); $e++) { ?>
                        <td width="50"><?=$num_respostas[$e]?></td>
                    <? } ?>
                    </tr>

                </table>
                
                <? 
                    $todas_alternativas[$j] = "";
                    $num_respostas[$j] = "";
                ?>
                                  
             <? }// While ?>
         
            
       
    </div>
</div>
</body> 
</html>   