<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$pedido = $_REQUEST['cod'];
	$sql = "DELETE FROM gerador_tickets_pedidos WHERE id=".$_REQUEST['cod'];
	$sql2 = "DELETE FROM gerador_tickets WHERE num_pedido=".$_REQUEST['cod'];
	if (mysql_query($sql)and(mysql_query($sql2))) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if($_POST["Submit"] != "" and $_GET["cadastra"] == 1) {
	
    if($_POST["orga"] != "" and $_POST["grup"] != "") 
    {
    ?>
    <script>
    window.open('tickets_relatorio.php?org=<?=$_POST["orga"]?>&gru=<?=$_POST["grup"]?>','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=800,height=550');  
    </script>
    <?
    } else {
        alert("É necessário escolher uma organização e um grupo!");
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
			<div id="info">
				<img src="imagens/barra_gera_ticket.gif" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return Validar();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">


			<div id="linha_form">
				<div id="label"> <span class="label_fonte">Organização: </span> </div>
			    <? 
                  $sql = "SELECT * FROM `organizacoes` WHERE pg_organizacao = 1 ORDER BY `nome`";
                  $result = mysql_query($sql);
                  //echo $result;
                  ?>
                <select name="orga" id="select2"  onchange="submit();">
                  <option value="" selected="selected">(escolha)</option>
        
                  <? while ($linha = mysql_fetch_assoc($result)) { 
                  	$id = $_POST["orga"];
                  	if($linha["id"] == $id){
                  		$select = " SELECTED ";
                  	}else{
                  		$select = " ";
                  	}
                  	
                  	?>
                  	<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
                 <? }?>
                </select>            
            </div>	
			
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Grupo: </span> </div>
                <? if($_POST["orga"]){
                	$id = $_POST["orga"];
        	    	$where = "where `id_organizacao` = $id";
        	   	}else{
            		$where = "where `id_organizacao` = $id";
            	}?>
        
        
                <select name="grup" id="select" >
                  <option value="" selected="selected">(escolha)</option>
                  <?
                  $sql = "SELECT *
        				FROM `grupos`
        				$where
        				ORDER BY `nome`";
                  $result = mysql_query($sql);
                  //echo $result;
                  ?>
                  
                 <? while ($linha = mysql_fetch_assoc($result)) {
                 	
                 	$id = $_POST["grup"];
                  	if($linha["id"] == $id){
                  		$select = " SELECTED ";
                  	}else{
                  		$select = " ";
                  	}
                 	
                 	?>
                  	<option value="<?=$linha["id"]?>" <?=$select?>><?=$linha["nome"]?></option>
                 <? } ?>
                </select>
                
			</div>	
			

				<p align="center"><input type="submit" name="Submit" value="Gerar Relatório" class="form_style"></p>
				
            </form>
		
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
</html>