<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?php //include("pc_valida_id_pesquisa.php"); ?>
<?php
	
$msg = "";	
	
function getLimitTickets ($cod_usuario, $id_pesquisa) {
	$sql_limite = "SELECT limite FROM pc_pesquisa WHERE id=$id_pesquisa LIMIT 1";
	$query_limite = mysql_query($sql_limite) or die(mysql_error());
	
	return mysql_result($query_limite, 0, 'limite');
}


function geraTickets ($id_pesquisa, $qtd_requerido) {
	
	// PEGA ID E LIMITE DA PESQUISA
	$sql_id_pesquisa = "SELECT nome,empresa, limite, tickets_gerados FROM pc_pesquisa WHERE id=$id_pesquisa LIMIT 1";
	$query_id_pesquisa = mysql_query($sql_id_pesquisa) or die(mysql_error());

	$empresa_pesquisa = mysql_result($query_id_pesquisa, 0, 'nome');
	$limite_pesquisa = mysql_result($query_id_pesquisa, 0, 'limite');
	$ticket_gerado_pesquisa = mysql_result($query_id_pesquisa, 0, 'tickets_gerados');
	
	// TESTA SE O LIMITE REQUERIDO NÃO É MAIO QUE A QUANTIDADE RESTANTE
	
	if( ($limite_pesquisa - $ticket_gerado_pesquisa) < $qtd_requerido ){
		alert("Você requeria uma quantidade de tickets maior do que ainda restam!");
		redireciona("?");
	}
	else {
		
		for($i=1; $i<=$qtd_requerido; $i++){
			
			$sql_insert = "INSERT INTO pc_ticket (id_pesquisa) VALUES ($id_pesquisa)";
			$query_insert = mysql_query($sql_insert) or die(mysql_error());
			
			$codigo_gerado = substr(strtoupper(criaURL($empresa_pesquisa)), 0, 4).mysql_insert_id().str_pad(rand(1, 9999), 4, "0", STR_PAD_LEFT);
			
			$sql_update = "UPDATE pc_ticket SET codigo='$codigo_gerado' WHERE id=".mysql_insert_id();
			$query_update = mysql_query($sql_update) or die(mysql_error());
			
		}
		
		$sql_aumenta_gerado = "UPDATE pc_pesquisa SET tickets_gerados = (tickets_gerados + $qtd_requerido) WHERE id=$id_pesquisa LIMIT 1";
		$query_aumenta_gerad = mysql_query($sql_aumenta_gerado) or die(mysql_error());
		
		alert("$qtd_requerido de Tickets gerados com sucesso!");
		redireciona("?id_pesquisa=$id_pesquisa");

	}
	
}

// SE FOR ENVIADA A AÇÃO DE GERAR TICKETS
if(isset($_GET['gerar'])){
	
	$qtd = $_POST['qtd'];
	$id_pesquisa = $_POST['id_pesquisa'];
	
	geraTickets($id_pesquisa, $qtd);
	
}

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
        
        <?php
			
			$id_pesquisa = $_GET['id_pesquisa'];
			
			$sql_pesquisa = "SELECT nome, empresa, limite, tickets_gerados FROM pc_pesquisa WHERE id=$id_pesquisa LIMIT 1";
			$query_pesquisa = mysql_query($sql_pesquisa) or die(mysql_error());
			$dados_pesquisa = mysql_fetch_array($query_pesquisa);
			
			$qtd_restante_tickets = $dados_pesquisa['limite']-$dados_pesquisa['tickets_gerados'];
				
		?>
        
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_gera_ticket.gif" alt="Geração de Tickets" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			<form action="pc_gera_tickets.php?gerar" method="post"  name="tickets">
				
                <input type="hidden" value="<?= $id_pesquisa ?>" name="id_pesquisa" />
                
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
            	
                <p align="center">
				<div id="linha_form">
					<div id="label" style="width: 600px;"> <span class="label_fonte">Pesquisa: <strong><?= $dados_pesquisa['nome'] ?></strong></span> </div>
                </div></p>
                
                <p align="center">
				<div id="linha_form">
					<div id="label" style="width: 600px;"> <span class="label_fonte">Você pode gerar até: <strong><?= $qtd_restante_tickets ?> tickets</strong></span> </div>
                </div></p>
                
                
                <p align="center">
				<div id="linha_form">
					<div id="label" style="width: 280px;"> <span class="label_fonte">Digite a quantidade de tickets que deseja gerar: </span> </div><input id="txtChar" type="text" size="5" name="qtd" class="form_style" onkeypress='return SomenteNumero(event)' />
				</div></p>
             
                <script language='JavaScript'>
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
</script>
                <p align="center"><input type="submit" value="Gerar" class="form_style"> <button class="form_style" type="button" onclick="location.href='pc_mostra_pesquisas.php'">Voltar</button></p>
                
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>