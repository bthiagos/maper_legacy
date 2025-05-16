<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<? 

if (($_REQUEST["altera"]) && ($_POST["alterar_orga"])) {
    
    $orga = $_POST["orga_id"];
    $grupo = $_POST["grupo_orga"];
    $id = $_REQUEST["cod"];
    
    $sql = "UPDATE aplicacoes SET grupo='$grupo' WHERE id='$id'";
    //echo $sql;
    
    if (mysql_query($sql)) {
        alert("Modificação realaizada com sucesso!");
        //redireciona("aplica_gerencia.php");      
    }
    
}

	if($_REQUEST["cod"]){
	
		$user = $_REQUEST["cod"];
		
		$sql = "SELECT
				aplicacoes.id,
				aplicacoes.nome,
				aplicacoes.email,
				aplicacoes.telefone,
				aplicacoes.cpf,
				aplicacoes.nasc,
				aplicacoes.cargo,
				aplicacoes.tempo,
				aplicacoes.respostas,
				aplicacoes.data_aplic,
				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,
				organizacoes.nome as orga,
				grupos.nome as grupo,
                grupos.id as id_grupo,
				organizacoes.id as id_orga,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id WHERE aplicacoes.id = $user";
		
		$result = mysql_query($sql);
		$linha = mysql_fetch_assoc($result);
		$nome = $linha["nome"];
		$email = $linha["email"];
		$telefone = $linha["telefone"];
		$cpf = $linha["cpf"];
		$nasc = $linha["nasc"];
		$cargo = $linha["cargo"];
		$orga = $linha["orga"];
		$grupo = $linha["grupo"];
        $orga_id = $linha["id_orga"];
        $grupo_id = $linha["id_grupo"];
	}	
    
    //echo $orga;
    
    
    
	?>

	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

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
				<img src="imagens/barra_avaliacao_realizadas.gif" alt="Avaliacoes Aplicadas" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
				
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
<form id="form1" name="form1" method="post" action="#">
  <label></label>
  <label><br />
  </label>
  <table width="450" border="0" cellspacing="2" cellpadding="2" class="label_fonte" style="margin-left: 20px">
    <tr>
      <td width="114"><b>Nome</b>:</td>
      <td width="336"><?=$nome?></td>
    </tr>
    
    <tr>
      <td width="114"><b>Email</b>:</td>
      <td width="336"><?=$email?></td>
    </tr>
    
    <tr>
      <td width="114"><b>Organização</b>:</td>
      <td width="336"><?=$orga?>
      		
      </td>
    </tr>
    
    <tr>
      <td width="114"><b>Grupo</b>:</td>
      <td width="336"><?=$grupo?>
      </td>
    </tr>   

    <tr>
      <td><b>Cargo</b>:</td>
      <td><?=$cargo?></td>
    </tr> 
    <tr>
      <td><b>Telefone</b>:</td>
      <td><?=$telefone?></td>
    </tr>
     <tr>
      <td><b>Nascimento</b>:</td>
      <td>
      	<?=$nasc?>
      </td>
    </tr>
    <tr>
      <td><b><label>CPF</b>:</label></td>
      <td><?=$cpf?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
 <!--   <tr>
      <td><label>Código:</label></td>
      <td><input name="senha" type="password" id="textfield7" size="15" maxlength="14" /></td>
    </tr> -->
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

  

  <p style="margin-left: 100px;">
 		<a href="aplica_gerencia.php" class="ordena">Voltar</a>
    <label> </label></p>
  <p align="center">&nbsp; </p>

  
			
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	

		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">
				<img src="imagens/barra_avaliacao_realizadas.gif" alt="Avaliações Realizadas" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="?cod=<?=$_REQUEST["cod"]?>&altera=1" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">	
				
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Organização:</span> </div>
					
						
						<?
                            //echo $_POST["orga_id"];
                          $sql = "SELECT organizacoes.nome FROM organizacoes LEFT JOIN ce_usuario ON organizacoes.id = ce_usuario.organizacao WHERE ce_usuario.CodUsuario = '".$_SESSION["id_usuario_adm"]."'";  
				          
                          $result = mysql_query($sql) or die(mysql_error());
                          $result = mysql_fetch_array($result);
				          //echo $result;
				          ?>
				    
				        	<span class="label_fonte" style="text-transform: uppercase;"><?=$result["nome"]?></span>
				   
				</div>	
                
                
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Grupo:</span> </div>
					
						
						<?
                          if ($_POST["orga_id"]) {
                            $id_orga = $_POST["orga_id"];
                          } else {
                            $id_orga = $orga_id;
                          }
				          $sql = "SELECT * FROM grupos WHERE id_organizacao = '$id_orga'";
				          $result = mysql_query($sql);
				          //echo $result;
				          ?>
				          <select name="grupo_orga" style="width:200px;">
				          <option value="" selected="selected" >Selecione</option>
				
				          <? while ($linha = mysql_fetch_assoc($result)) { 
				          	$id = $orga_id;
				          	if($linha["id"] == $grupo_id){
				          		$select = " SELECTED ";
				          	}else{
				          		$select = " ";
				          	}
				          	
				          	?>
				          	<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
					         <? }?>
        			</select>
				</div>	


				<p align="center"><input type="submit" value="modificar" name="alterar_orga" class="form_style" name="localizar"></p>
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
			
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>	
					
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>