<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {		

				$sql = "DELETE FROM depoimentos WHERE id=".$_REQUEST['cod'];
				if (mysql_query($sql)) {
					alert("Excluido com sucesso!");
				}
	
}
// --- FIM    Efetuando a exlcusao



// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
	// Nome
	if (!($_POST["titulo"] == "")) {
		$titulo = addslashes($_POST["titulo"]);
	} else {
		$ok = 0;
	}
	
	// Texto
	if (!($_POST["texto"] == "")) {
		$texto = $_POST["texto"];
	} else {
		$ok = 0;
	}
	
		
	if ($ok) {

		$data = date("Y-m-d");
					
		    //salvando dados no banco
		    $sql = "INSERT INTO aempresa (titulo,texto) values ('$titulo','$texto')";
		    if (mysql_query($sql)) {
		    	alert("Conteúdo cadastrada com sucesso!");
		    	redireciona("aempresa.php");
		    } else {
		    	// QUERY
		    	
		    	alert("Erro ao cadastra!");
		    	redireciona("aempresa.php");
		    }
		    


	} // OK
	
} // REQUEST

// --- FIM    Efetuando o cadastro

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

<body>


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
				<img src="imagens/barra_listagem_emails.gif" alt="Gerenciamento de Emails" title="Gerenciamento de Emails" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
            
			<form action="?envia=1" method="POST" onsubmit="return valida_fromto();">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
                <input type="hidden" name="pmes" id="pmes" value="<?=$_REQUEST["pmes"]?>" />
				
				<div id="linha_form">
						<div id="label"> <span class="label_fonte">Organização:</span> </div>
						
							
							<?
							if($organizacaon){
								$whereorga = " WHERE id='$organizacaon'";
							}
					          $sql = "SELECT * FROM `organizacoes` $whereorga ORDER BY `nome`";
					          $result = mysql_query($sql);
					          //echo $result;
					          ?>
					          <select name="orga" id="orgs" style="width:200px;" >
					          <option value="" selected="selected">Todos</option>
					
					          <? while ($linha = mysql_fetch_assoc($result)) { 
					          	$id = $_REQUEST["orga"];
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
					<div id="label"> <span class="label_fonte">Quando:</span> </div>

                    <span id="por_periodo">
                     <span class="label_fonte">De:</span>
                     	<input type="text" name="from" id="from" value="<?=$_REQUEST["from"]?>" size="7" /> <span class="label_fonte">Até:</span> <input type="text" size="7" name="to" value="<?=$_REQUEST["to"]?>" id="to" />
                    </span>
                </div>	
                
                <script>

                </script>
                

   
                
                <div style="width: 180px; margin-left: auto; margin-top: 10px; margin-right: auto;">
					<div style="float: left; width: 80px;"><input type="submit" value="Localizar" class="form_style" name="localizar"></div>
                </div>
                
                <div style="clear: both; margin-top: 10px; padding-bottom: 10px;"></div>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>	
				
				
			<? if ($_REQUEST["envia"]) {?>
		<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_listagem_emails.gif" alt="Gerenciamento de Emails" title="Gerenciamento de Emails" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Emails</td>
					</tr>
				
					
			<?
				
				if ($_POST["orga"]) {
					$where_orga = " AND organizacao='".$_POST["orga"]."' ";
				}
				
				
				if (($_POST["from"]) && ($_POST["to"])) {					
					//Ajustando Data Inicial
					$data_inicial = explode("/", $_POST["from"]);
					$data_inicial_string = $data_inicial[2]."-".$data_inicial[1]."-".$data_inicial[0];

					//Ajustando Data final
					$data_final = explode("/", $_POST["to"]);
					$data_final_string = $data_final[2]."-".$data_final[1]."-".$data_final[0];				
					
					$where_data = " AND data_aplic BETWEEN '$data_inicial_string' AND '$data_final_string' ";	
				}
				
				$sql = "
				SELECT DISTINCT
				aplicacoes.email
				FROM
				aplicacoes
				WHERE
				aplicacoes.email <>  ''
				$where_orga
				$where_data
				";
				
				//echo $sql;
				
				$result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
					$data = $linha["data"];
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["email"]?></td>
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
			
			
			<?}?>
			
			
			
			
					
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>