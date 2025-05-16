<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso



// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
    
    $sql = "DELETE FROM ebook_email WHERE id=".$_REQUEST['cod'];
    if (mysql_query($sql)) {
        alert("E-mail excluído com sucesso!");
        redireciona("?");
    }
    
}
?>





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<link rel="stylesheet" type="text/css" href="css/shadowbox.css">

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
            <div id="info">
                <h2>Copiar e-mails</h2>
            </div>
            <!-- INICIO - DIV info - Barra de informacao -->
            
            <form action="?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return Validar();">
            
            <!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
            <div id="caixa_form">  
            
            

            
            <div id="linha_form" style="height: 167px;">
                <div id="label"> <span class="label_fonte">Lista para COPIAR e COLAR no campo "Para:" do seu e-mail </span> </div>
                <textarea style="width: 600px; height: 150px; font-family: Arial;"><?
                        $sql = mysql_query("SELECT * FROM ebook_email ORDER BY data DESC");
                        while($e = mysql_fetch_assoc($sql)) {
                            echo $e["email"].";";
                        }
                    ?></textarea>
            </div>  
            
                </div></form>
        



            
            
                <!-- INICIO - DIV info fim - Barra de informacao -->
                <div id="info_fim">
                &nbsp;
                    </div>
                <!-- INICIO - DIV info fim - Barra de informacao -->        
                    
            <!-- INICIO - DIV info - Barra de informacao -->
            <div id="info">
                <h2>Gerenciar E-mails</h2>
            </div>
            <!-- INICIO - DIV info - Barra de informacao -->
            
            
            <!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
            <div id="caixa_table">
            

                <table width="100%" align="center" class="sortable" cellspacing="3">
                    <tr height="30">
                        <td align="center">E-mail</td>
                        <td align="center">Data do Registro</td>
                        <td align="center"  width="1%" nowrap="nowrap">A&ccedil;&otilde;es</td>
                        <?//}?>
                    </tr>
                
                    
            <?          
            
                $sql = "SELECT *,DATE_FORMAT(data,'%d/%m/%Y %H:%i:%s') as dt FROM ebook_email ORDER BY data DESC";
                $result = mysql_query($sql) or die(mysql_error());
                
                while($linha = mysql_fetch_assoc($result)) {
            
            ?>                  
                    <tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
                        <td align="center" ><?=$linha["email"]?> </td>
                        <td align="center" ><?=$linha["dt"]?> </td>          
                        
                        <td align="center" width="1%" nowrap="nowrap" >
                        
                            <a href="?apagar=1&cod=<?=$linha["id"]?>">
                                <img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o email?')" alt="Apagar" border="0">
                            </a>
                        </td>       
                                
                    </tr>
                <?
                }
                ?>
                </table>


            </div>
            <!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->         

                
            <!-- INICIO - DIV info fim - Barra de informacao -->
            <div id="info_fim">
                &nbsp;
            </div>
            <!-- INICIO - DIV info fim - Barra de informacao -->            
            
            
        
        </div> <!-- FIM DIV PRINCIPAL -->
         
    </div> <!-- FIM DIV GLOBAL-->
    

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
    alert($frase);
}?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="js/shadowbox.js"></script>
<script type="text/javascript">
    Shadowbox.init();
</script>
</html>