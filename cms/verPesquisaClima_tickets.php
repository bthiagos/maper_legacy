<?

if ($_REQUEST["cod"]) {
    
    $id_agrupa = $_REQUEST["cod"];
    $id_pesq = $_REQUEST["id_pesq"];
    
}

?>

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
		Resultado por Unidade
	</div>
    
    <div class="global_pesq">
    
        
    <?
    /*
        // Selecionando Perguntas
        $sql_unidade2 = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $id_pesq and formato_perguntas=2 ORDER BY pesquisa_perguntas.id"; 
        $result_unidade2 = mysql_query($sql_unidade2);
        $linha_unidade2 = mysql_fetch_assoc($result_unidade2);
        $alternativas_unidade2 = $linha_unidade2["texto_outras"];
        $unidades2 = explode("|",$alternativas_unidade2);
        
    ?>
    

    
    <? for ($i=0;$i<=count($unidades2)-3;$i++) {?>
        <div>Resultado para <a href="verPesquisaClima_tickets_unidades.php?cod=<?=$id_agrupa?>&id_pesq=<?=$id_pesq?>&unidade=<?=$i?>&nome=<?=$unidades[$i]?>"><?=$unidades[$i]?></a> - Total de <?=total_resposta($id_pesq,$id_agrupa,$i)?> resposta(s)</div>
          
    <? } */?>
    
    
    <?
        // Selecionando Perguntas
        $sql_unidade = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $id_pesq and formato_perguntas=2 ORDER BY pesquisa_perguntas.id"; 
        $result_unidade = mysql_query($sql_unidade);
        $linha_unidade = mysql_fetch_assoc($result_unidade);
        $alternativas_unidade = $linha_unidade["alternativas"];
        $unidades = explode("|",$alternativas_unidade);
        
    ?>
    

    
    <? for ($i=0;$i<=count($unidades)-3;$i++) {?>
        <div>Resultado para <a href="verPesquisaClima_tickets_unidades.php?cod=<?=$id_agrupa?>&id_pesq=<?=$id_pesq?>&unidade=<?=$i?>&nome=<?=$unidades[$i]?>"><?=$unidades[$i]?></a> - Total de <?=total_resposta($id_pesq,$id_agrupa,$i)?> resposta(s)</div>
          
        
        <? if($i <= 35) { //Diretoria Técnica Assistencial ?>
            <? $a1_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
        <? if($i <= 72 and $i >= 36) { //Diretoria de Hotelaria e Administração ?>
            <? $a2_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
        <? if($i <= 97 and $i >= 73) { //Diretoria Financeira ?>
            <? $a3_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
        <? if($i <= 99 and $i >= 97) { //Diretoria de Projetos ?>
            <? $a4_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
        <? if($i >= 105 and $i <= 108) { //Diretoria Clínica ?>
            <? $a5_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
        
        <? if($i >= 100 and $i <= 101) { //Diretoria Clínica ?>
            <? $a6_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
        
        <? if($i >= 102 and $i <= 104) { //Diretoria Clínica ?>
            <? $a7_resp += total_resposta($id_pesq,$id_agrupa,$i); ?>
        <? } ?>
    <? } ?>
    
    <br />
    
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria1.php?id_pesq=7&cod=8">Diretoria Técnica Assistencial</a> - Total de <?=$a1_resp?> resposta(s)<br />
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria2.php?id_pesq=7&cod=8">Diretoria de Hotelaria e Administração</a> - Total de <?=$a2_resp?> resposta(s)<br />
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria3.php?id_pesq=7&cod=8">Diretoria Financeira</a> - Total de <?=$a3_resp?> resposta(s)<br />
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria4.php?id_pesq=7&cod=8">Diretoria de Projetos</a> - Total de <?=$a4_resp?> resposta(s)<br />
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria5.php?id_pesq=7&cod=8">Diretoria Clínica</a> - Total de <?=$a5_resp?> resposta(s)<br />
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria6.php?id_pesq=7&cod=8">Superintendência</a> - Total de <?=$a6_resp?> resposta(s)<br />
    Resultado para <a href="http://appweb.com.br/cms/graf_diretoria7.php?id_pesq=7&cod=8">Controladoria</a> - Total de <?=$a7_resp?> resposta(s)<br />

    
    
    
    </div>
    
    
    
    <?
        // Selecionando Perguntas
        $sql_perguntas = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $id_pesq and formato_perguntas=2 ORDER BY pesquisa_perguntas.ordem"; 
        $result_perguntas = mysql_query($sql_perguntas);
        //echo $sql_perguntas;
        
        
    ?>
    

	<!-- INICIO - DIV info - Barra de informacao -->
	<div id="info" style="font-size: 20px;">
		Resultado da Pesquisa
	</div>
    
    <div class="global_pesq">
	<!-- INICIO - DIV info - Barra de informacao -->
    

            <?
                 $i=0;
                
                //Lista as Perguntas
                while($linha_perguntas = mysql_fetch_assoc($result_perguntas)) {
                    
                
                    $i++;
                    $id_perguntas = $linha_perguntas["id"];
                    
                    $id_perg = $linha_perguntas["id"];
                    //echo $id_perguntas;
  
                        
                    
                    
            ?>
            <? //$a = 'http://www.appweb.com.br/cms/gera_grafico_tickets.php?pesq='.$id_pesq.'&pergunta='.$linha_perguntas["id_perguntas"].'&agrupa='.$id_agrupa; 
               //if($id_perguntas != 173 and $id_perguntas != 176 and $id_perguntas != 1823 and $id_perguntas != 1824 and $id_perguntas != 1825)
              
                
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
            
            <?
            if($linha_perguntas["id_perguntas"] != 176)
            {
                if($linha_perguntas["id_perguntas"] != 170)
                {
            ?>
            <img src="gera_grafico_tickets.php?pesq=<?=$id_pesq;?>&pergunta=<?=$linha_perguntas["id_perguntas"];?>&agrupa=<?=$id_agrupa?>" />
            <? } else { ?>
            <img src="grafico37.png" />
            <? } ?>
            <? } else { ?>
            <img src="grafico42.png" />
            <? } ?>
         </div>
                              
                <? }// While ?>

    </div>

		

</div>








