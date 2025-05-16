<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<? 	
	$ano = date("Y");
if($_POST["button"]){	
	if($_REQUEST["cadastra"]){
		$dia = date("j");
		$mes = date("n");
		$ano = date("Y");
		
		$data = "$ano-$mes-$dia 00:00:00";
		$ok = 1;
		
		$dia = $_POST["dia"];
		$mes = $_POST["mes"];
		$ano = $_POST["ano"];
		$pNascimento = $dia."/".$mes."/".$ano;
		
		
		if($_POST["nome"]){
			$nome = addslashes($_POST["nome"]);
		}else{
			$ok = 0;
		}
		
	
		
		if($_POST["cargo"]){
			$cargo = addslashes($_POST["cargo"]);
		}else{
			$ok = 0;
		}
		
	
		
		if($_POST["ddd"]){
			$ddd = $_POST["ddd"];
		}else{
			$ok = 0;
		}
		
		if($_POST["tel"]){
			$tel = $_POST["tel"];
		}else{
			$ok = 0;
		}
		
		if($_POST["orga"] != "(escolha)"){
			$orga =  $_POST["orga"];		
		}else{
			$ok = 0;
		}
		
		if($_POST["grup"] != "(escolha)"){
			$grupo = $_POST["grup"];		
		}else{
			$ok = 0;
		}
		
		$telefone = "($ddd) - $tel";
		
		for($i=1; $i<=100; $i++){
			$q = "questao_".$i;
			
			if($_POST[$q] != "(escolha)"){
				$questao .= $_POST[$q];
				//echo "Questao marcada - ". $i."<br>" ;
			}else{
			$ok = 0;
			}
			
		}
	
		$cpf = $_POST["cpf"];
		
		
		
			// Validando o E-mail
	if (addslashes(trim($_POST["email"])) == "") {
		$ok = 0;
		$email = addslashes(trim($_POST["email"]));
		alert("Preencha o campo E-amil corretamente!");
	} elseif (!validar_email(addslashes(trim($_POST["email"]))))  {
		$ok = 0;
		alert("Email Inválido!");
		$email = addslashes(trim($_POST["email"]));
	} else {
		$email = addslashes(trim($_POST["email"]));
	}
		
		// Se seu campo estiver OK!
		if (!$ok) {
			// Alert de ERRO!
			alert("Algum campo foi preenchido incorretamente ou está em branco, tente novamente!");
		} else {
				
			if($_POST["button"]){
				$data =  date("Y-m-d H:i:s");
			  //salvando dados no banco
			    $sql = "INSERT INTO aplicacoes (nome,email,telefone,cpf,nasc,organizacao,grupo,cargo,tempo,respostas,data_aplic,status_envio) VALUES ('$nome','$email','$telefone','$cpf','$pNascimento','$orga','$grupo','$cargo','00:00:00','$questao','$data','0')";
				
			    if (mysql_query($sql)) {
			    	alert("Compromisso cadastrado com sucesso!");
			    	redireciona("aplica_gerencia.php");
			    }else{
			    	alert("errosucesso!");// QUERY
			    }
			}
		}
	}
}
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
				<img src="imagens/barra_proc_manual.gif" alt="Processamento Manual" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
				
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
<form id="form1" name="form1" method="post" action="manual2.php?cadastra=1">
  <label></label>
  <label><br />
  </label>
  <table width="450" border="0" cellspacing="2" cellpadding="2" class="label_fonte" style="margin-left: 20px">
    <tr>
      <td width="114">Nome:</td>
      <td width="336"><input name="nome" type="text" id="textfield2" size="50" value="<?=$_POST["nome"]?>" /></td>
    </tr>
    
    <tr>
      <td width="114">Email:</td>
      <td width="336"><input name="email" type="text" id="textfield2" size="50" value="<?=$_POST["email"]?>"/></td>
    </tr>
    
    <tr>
      <td width="114">Organização:</td>
      <td width="336">
      		<?
      		$txt_organizacao = str_replace(" ", "", $_SESSION["organizacaon"]);
            if($_SESSION["organizacaon"] != "") {
                $sql = "SELECT * FROM `organizacoes` WHERE id = '".$txt_organizacao."' ORDER BY `nome` ";
            } else {
                $sql = "SELECT * FROM `organizacoes` ORDER BY `nome`";
            }
          //$sql = "SELECT * FROM `organizacoes` ORDER BY `nome`";
          $result = mysql_query($sql);
          //echo $sql;
          ?>
          <select name="orga" id="select2" tabindex="3" onchange="submit();" style="width:200px;">
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
      </td>
    </tr>
    <? if($_POST["orga"]){
        	$id = $_POST["orga"];
	    	$where = "where `id_organizacao` = $id";
	   	}else{
    		$where = "";
    	}?>
    <tr>
      <td width="114">Grupo:</td>
      <td width="336">
      	<select name="grup" id="select" tabindex="4" style="width:200px;">
          <option value="(escolha)" selected="selected">(escolha)</option>
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
         <? }?>
          
        </select>
      </td>
    </tr>   

    <tr>
      <td>Cargo:</td>
      <td><input name="cargo" type="text" id="textfield6" size="30" value="<?=$cargo?>" /></td>
    </tr> 
    <tr>
      <td>Telefone:</td>
      <td><input name="ddd" type="text" id="textfield6" size="2" maxlength="2" value="<?=$ddd?>"/> - <input name="tel" type="text" id="textfield6" size="8" maxlength="8" value="<?=$tel?>" /></td>
    </tr>
     <tr>
      <td>Nascimento:</td>
      <td>
      	<select name="dia" class="form_style">
					<?
						for ($i=1;$i<=31;$i++) {
							if ($dia == $i) {
								$check = "selected=\"selected\"";
							} else {
								$check = "";
							}
					?>
						<option value="<?=$i?>" <?=$check?>><?=$i?></option>
					<?
						}
					?>
					</select>
					<!-- Select de dia -->
					/
					<!-- Select de mes -->
					<select name="mes" class="form_style">
					<?
						for ($i=1;$i<=12;$i++) {
							if ($mes == $i) {
								$check = "selected=\"selected\"";
							} else {
								$check = "";
							}
					?>
						<option value="<?=$i?>" <?=$check?>><?=ucfirst(string_mes($i));?></option>
					<?
						}
					?>
					</select>
					<!-- Select de mess -->
					/
					<!-- Select de ano -->
					<select name="ano" class="form_style">
					<?
						for ($i=($ano-90);$i<=($ano);$i++) {
							if ($ano == $i) {
								$check = "selected=\"selected\"";
							} else {
								$check = "";
							}
					?>
						<option value="<?=$i?>" <?=$check?>><?=$i;?></option>
					<?
						}
					?>
					</select>
					<!-- Select de ano -->
      </td>
    </tr>
    <tr>
      <td><label>CPF:</label></td>
      <td><input name="cpf" type="text" id="textfield3" size="17" maxlength="14" /></td>
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

  <p>
    <label></label>
    <label class="label_fonte" style="margin-left: 20px">Respostas:
    </label>
  
	 <table align="center" width="70%" cellpadding="1" cellspacing="1">
		
					   	<?  $y =0;
					   		for($i=1; $i<=100; $i++){
					   			$y++;
					   			
					   		if($i < 10){
					   			$n = "0".$i;
					   		}else{
					   			$n = $i;
					   		}
					   			 ?>
					   		 <tr>
					   			<td> 
								<label class="label_fonte">Questao de numero <?=$n?> &nbsp; 
									<select name="questao_<?=$i?>" id="select" tabindex="4" style="width:90px;">
         						 	<option value="(escolha)" selected="selected">(escolha)</option>
         						 	<option value="a"> A </option>
         						 	<option value="b"> B </option>
         						</label>
					   			</td>
					   		</tr>
		 
		   		
					   		<?}?>
  		
  	</table>
   
  </p>
  <p align="center">&nbsp; </p>
  <p style="margin-left: 100px;">
    <input type="submit" name="button" id="button" value="Processar" />
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

		
			
					
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>