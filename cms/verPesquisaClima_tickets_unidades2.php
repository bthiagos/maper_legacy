<?

if ($_REQUEST["cod"]) {
    
    $id_agrupa = $_REQUEST["cod"];
    $id_pesq = $_REQUEST["id_pesq"];
    $unidade = $_REQUEST["unidade"];
    $nome = $_REQUEST["nome"];
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
    
    <?
        // Selecionando Perguntas
        $sql_perguntas = "SELECT * FROM pesquisa_perguntas Inner Join pesquisa_alternativas ON pesquisa_alternativas.id_perguntas = pesquisa_perguntas.id WHERE id_pesquisa = $id_pesq and formato_perguntas=2 ORDER BY pesquisa_perguntas.ordem ASC"; 
        $result_perguntas = mysql_query($sql_perguntas);
        //echo $sql_perguntas;
    ?>
    
	<!-- INICIO - DIV info - Barra de informacao -->
	<div id="info">
        <?
            if($_GET["n"] == 1) { $nome = "Diretoria Técnica Assistencial"; }
            if($_GET["n"] == 2) { $nome = "Diretoria de Hotelaria e Administração"; }
            if($_GET["n"] == 3) { $nome = "Diretoria Financeira"; }
            if($_GET["n"] == 4) { $nome = "Diretoria de Projetos"; }
            if($_GET["n"] == 6) { $nome = "Superintendência"; }
            if($_GET["n"] == 7) { $nome = "Controladoria"; }
            if($_GET["n"] == 5) { $nome = "Diretoria Clínica"; }
        ?>
		Resultado da Pesquisa para a <?=$nome?>
	</div>
    
    <div class="global_pesq">
	<!-- INICIO - DIV info - Barra de informacao -->
    

            <?
                 $i=0;
                
                //Lista as Perguntas
                while($linha_perguntas = mysql_fetch_assoc($result_perguntas)){
                    $i++;
                    $id_perguntas = $linha_perguntas["id"];
                    
                
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
         
         <?php
         if($id_perguntas != "136")
         {              
         ?>
        <div style="margin-bottom: 20px;">
             <!--<img src="gera_grafico_tickets.php?unidade=<?=$unidade;?>&pesq=<?=$id_pesq;?>&pergunta=<?=$linha_perguntas["id_perguntas"];?>&agrupa=<?=$id_agrupa?>" /> -->
             <img src="gera_grafico_tickets2.php?unidade=<?=$unidade;?>&pesq=<?=$id_pesq;?>&pergunta=<?=$linha_perguntas["id_perguntas"];?>&agrupa=<?=$id_agrupa?>" />
         </div>
         <?
         } else {
         ?>
         <div style="margin-bottom: 20px;">
             <!--<img src="gera_grafico_tickets.php?unidade=<?=$unidade;?>&pesq=<?=$id_pesq;?>&pergunta=<?=$linha_perguntas["id_perguntas"];?>&agrupa=<?=$id_agrupa?>" /> -->
             <img src="gera_grafico_tickets2_perg1.php?n=<?=$_GET["n"]?>&unidade=<?=$unidade;?>&pesq=<?=$id_pesq;?>&pergunta=<?=$linha_perguntas["id_perguntas"];?>&agrupa=<?=$id_agrupa?>" />
         </div>
         <? } ?>
                
                <? }// While ?>

    </div>

		

</div>








