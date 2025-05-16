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
		Resultado da Pesquisa para a Diretoria Financeira
	</div>
    
    <div class="global_pesq">
        <?php
        //PEGA TODAS AS ÁREAS
            $sql_unidade = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = 7 and formato_perguntas=2 ORDER BY pesquisa_perguntas.id"; 
            $result_unidade = mysql_query($sql_unidade);
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
          
        <? } ?>
        <? if($i <= 72 and $i >= 36) { //Diretoria de Hotelaria e Administração ?>
            <? $a2_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
           
        <? } ?>
        <? if($i <= 97 and $i >= 73) { //Diretoria Financeira ?>
            <? $a3_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
            <? $diretoria_1[$i] = $i; ?>
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
            $_SESSION["diretoria_tickets"] = $dir1_ticket;
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
      
             <div style="margin-bottom: 20px;">
                <img src="geradorCorrigido.php?pergunta=<?=$linha_perguntas["id_perguntas"];?>&ticket=<?=$dir1_ticket?>" />
             </div>
                                  
             <? }// While ?>
         
            
       
    </div>
</div>
</body> 
</html>   