<?php include("conn.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso



// --- INICIO Efetuando o cadastro
if ($_REQUEST['enviar']) {
    
    // Varificacao de campos
    $ok = 1;
    

    if ($_REQUEST["id"]) {
        $id = $_REQUEST["id"];
    }
    
    // Se seu campo estiver OK!
    if (!$ok) {
        // Alert de ERRO!
        alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
    } 
}
// --- FIM    Efetuando o cadastro
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

    <!-- INICIO - DIV global - Emgloba todo o site -->
    <div id="global">
    
        <?php include("topo.php"); ?>   
        
        
        <!-- INICIO - DIV MENU - Menu do Sistema -->
        <?php include("menu.php"); ?>
        <!-- INICIO - DIV MENU - Menu do Sistema -->
        
        <!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
        <div id="principal">
        
        
            <!-- INICIO - DIV info - Barra de informacao -->

            <div id="info" style="height: 25px;"> 
                <div style="font-family: Arial; font-size: 16px; color: #727272;">Consulta de Testes</div>
            </div>

            <!-- INICIO - DIV info - Barra de informacao -->
            
            <form action="aplica_gerencia_nuvem.php?enviar=1" method="post" name="cadastra" enctype="multipart/form-data">
            
            <!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
            <div id="caixa_form">
            
                <div id="linha_form">
                    <div id="label"> <span class="label_fonte">ID ou CPF (Apenas Números): </span> </div><input type="text" size="50" name="id" value="<?=$id?>" class="form_style">
                </div>
 
                
                <p align="center"><input type="submit" value="Procurar" class="form_style"></p>
                
                
            
                </div></form>
        
                <!-- INICIO - DIV info fim - Barra de informacao -->
                <div id="info_fim">
                &nbsp;
                    </div>
                <!-- INICIO - DIV info fim - Barra de informacao -->            
                    
                <? if ($_REQUEST['enviar']) {?>              
            
                <!-- INICIO - DIV info - Barra de informacao -->

                <div id="info" style="height: 25px;"> 

                    <div style="font-family: Arial; font-size: 16px; color: #727272;">Testes Encontrados</div>

                </div>

                <!-- INICIO - DIV info - Barra de informacao -->
        
 
        
                    <!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
                    <div id="caixa_table">
            


                <table width="100%" align="center" class="sortable" cellspacing="3">
                    <tr height="30">
                        <td align="center">#</td>
                        <td align="center">ID</td>
                        <td align="center">Nome</td>
                        <td align="center">CPF</td>
                        <td align="center">Data Aplicação</td>
                        <td align="center">Respostas</td>
                        <td align="center">Notas</td>
                        <td align="center" width="1%" nowrap>A&ccedil;&otilde;es</td>
                    </tr>
                
 

                    <?

                        if ($_REQUEST["id"]) {
                            $id = $_REQUEST["id"];
                        }

                        $sql = "
                            SELECT
                                *
                            FROM
                                aplicacoes
                            WHERE
                                cpf='$id' OR 
                                id='$id'
                        ";  

                        $result = mysql_query($sql);
                        $i = 0;
                        while ($linha = mysql_fetch_assoc($result)) {
                            $i++;
                            //$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
                    ?>          
                
                        <tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
                                <td align="center"  width="1%" nowrap><?=$i?></td>

                                <td align="center" >
                                <?=$linha["id"]?> | <?=$linha["descricao"]?>
                                </td>   
                                
                                <td align="center" >
                                <?=$linha["nome"]?>
                                </td>   
                                
                                <td align="center" >
                                <?=$linha["cpf"]?>
                                </td>

                                <td align="center" >
                                <?=$linha["data_aplic"]?>
                                </td>   

                                <td align="center" >
                                <?=$linha["respostas"]?>
                                </td>  

                                <td align="center" >
                                <?=$linha["notas"]?>
                                </td>  

                                
                                <td align="center" width="1%" nowrap>
                                    <a href="resultado/index.php?id=<?php echo $linha["id"];?>" target="_blank" style="cursor: pointer;"><img src="imagens/icon_novo.gif" title="Devolutiva" alt="NOVO Relatório Digital" border="0"> </a>
                                    <a href="pdi/index.php?id=<?php echo $linha["id"];?>" target="_blank" style="cursor: pointer;"><img src="imagens/icon_PDI.gif" title="PDI" alt="NOVO Relatório PDI" border="0"></a>
                                    <a onclick="abrir_novo_relatorio('<?php echo $linha["id"];?>','')" target="_blank" style="cursor: pointer;"><img src="imagens/icon_devolutiva.gif" title="Devolutiva" alt="NOVO Relatório Coaching c/ Gráficos" border="0"></a>

                                </td>
                        </tr>
                        <?
                        }
                        ?>
                        </table>


            </div> <!-- FIM CAIXA ENGLOBA GERENCIAMENTO -->
 
        
        
        
        
        
            <!-- INICIO - DIV info fim - Barra de informacao -->
            <div id="info_fim">
                &nbsp;
            </div>
            <!-- INICIO - DIV info fim - Barra de informacao -->    
        
            <? }?> 

        </div> <!-- FIM DIV PRINCIPAL -->
         
    </div> <!-- FIM DIV GLOBAL-->
    

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
    alert($frase);
}?>
</html>