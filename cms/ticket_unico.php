 <?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso



// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM gerador_tickets WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Ticket único excluido com sucesso!");
        redireciona("?");
	}
	
}

// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if($_POST["Submit"] != "" and $_GET["cadastra"] == 1) {
	
		$ok =1;

        if($_POST["orga"] != "")
        {
        $orga = $_POST["orga"];
        }else{
            $ok = 0;
        }

        if($_POST["tipo_ticket"] != "")
        {
        $opera = $_POST["tipo_ticket"];
        }
	   if($ok != 0)
       {

        $numero_ticket = "0".rand(0,9).rand(0,9).rand(0,9).rand(0,9);

        $check = mysql_query("SELECT numero_ticket FROM gerador_tickets WHERE numero_ticket = '$numero_ticket'");
        $check_tot = mysql_num_rows($check);
        while($check_tot != 0) {
            $numero_ticket = "0".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $check = mysql_query("SELECT numero_ticket FROM gerador_tickets WHERE numero_ticket = '$numero_ticket'");
            $check_tot = mysql_num_rows($check);
        }

		$numeros_tickets[$i] = $numeros;
		
		if ($_SESSION["per_adm"] == 5555) {
			$ticket_commit = 1;
		} else {
			$ticket_commit = 0; 
		}
		
		$sql_cadastra = "INSERT INTO gerador_tickets (tipo_ticket,organizacao,numero_ticket,num_pedido,ticket_unico,commit) VALUES ('$opera','$orga','$numero_ticket','0','1','$ticket_commit')";
		mysql_query($sql_cadastra) or die(mysql_error());
        alert("Ticket único cadastrado com sucesso!");
        redireciona("?");
	   } else {
	       alert("Escolha um grupo.");
	   }	
    }
                
// --- FIM    Efetuando o cadastro

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
				<img src="imagens/barra_gera_ticket.gif" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onSubmit="return Validar();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">  
			
			

			
            <div id="linha_form">
                <div id="label"> <span class="label_fonte">Organização: </span> </div>
                <? 
                    if ($_SESSION["per_adm"] == 5555) {
                        //$insert_commit = "1";
                        $select_commit = " and commit=1 ";
                    }
                  $sql = "SELECT * FROM `organizacoes` WHERE pg_organizacao = 1 $select_commit  ORDER BY `nome`";
                  $result = mysql_query($sql);
                  //echo $result;
                  ?>
                <select name="orga" id="select2" >
                  <option value="(escolha)" selected="selected">(escolha)</option>
        
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

                <div id="label"> <span class="label_fonte">Tipo de Ticket: </span> </div>

                <select name="tipo_ticket" id="select" >
                  <option value="" selected="selected">(escolha)</option>
                  <option value="gerencial" >Gerencial</option>
                  <option value="operacional" >Operacional</option>
                  <option value="pdi" >PDI</option>
                  <option value="vendas" >Vendas</option>
                  <option value="vendas1" >Vendas 1ª página</option>
        
                </select> 

            </div>  
			

            
          

      

				<p align="center"><input type="submit" name="Submit" value="Gerar Ticket Único" class="form_style"></p>
				
				
			
				</div></form>
		

			<?
			 if($_REQUEST["localizar"]){
				$palavra = $_POST["palavra"];
			 	
			 	if($palavra != ""){
			 	$texto_palavra = "WHERE nome_cliente like '%$palavra%' or 
			 				cidade like '%$palavra%' or
			 				estado like '%$palavra%'
			 	";
			 	}else{
			 		$texto_palavra ="";
			 	}
			 	
			 	
			}
				
			?>

			
			
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->		
					
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_tickets.gif" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Ticket</td>
                        <td align="center">Tipo de Ticket</td>
						<td align="center">Organização</td>
							<? 
							//$permissao = $_SESSION["per_adm"];
						//	if($permissao == "9999"){?>
						<td align="center"  width="1%" nowrap="nowrap">A&ccedil;&otilde;es</td>
						<?//}?>
					</tr>
				
					
			<?			
				if ($_SESSION["per_adm"] == 5555) {
					$select_commit = " AND commit=1 ";
				} 
			
				$sql = "SELECT * FROM gerador_tickets WHERE ticket_unico != 0  $select_commit ORDER BY id desc";
				$result = mysql_query($sql) or die(mysql_error());
				
				while($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["numero_ticket"]?> </td>        
                        <td align="center" >
                            <?
                            if($linha["tipo_ticket"] == "gerencial") { echo "Gerencial"; }
                            if($linha["tipo_ticket"] == "operacional") { echo "Operacional"; }
                            if($linha["tipo_ticket"] == "vendas") { echo "Vendas"; }
                            if($linha["tipo_ticket"] == "vendas1") { echo "Vendas 1ª página"; }
                                
                            ?>
                            
                        </td>      				
					    <td align="center" >
                        <?php
                        
                        $org = mysql_query("SELECT * FROM organizacoes WHERE id = '".$linha["organizacao"]."' ");
                        $org = mysql_fetch_array($org);
                        echo $org["nome"];

                        ?>                        
                        </td>		
                        
                        <td align="center" width="1%" nowrap="nowrap" >
                        
                        	<a rel="shadowbox[Mixed]width=600;height=170" href="ticket_unico_envia.php?id=<?=$linha["id"]?>"  title="Enviar Ticket por E-mail">
                        		<img src="imagens/icon_sendmail.png" border="0" title="Enviar Ticket por E-mail" alt="Enviar Ticket por E-mail"  />
                        	</a>
                        
                        	<a href="?apagar=1&cod=<?=$linha["id"]?>">
                        		<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o ticket único?')" alt="Apagar" border="0">
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