<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM pc_pesquisa WHERE id=".$_REQUEST['id'];
	if (mysql_query($sql)) {
		alert("Pesquisa de Clima excluída com sucesso!");
        redireciona("?");
	}
	
}

// --- FIM    Efetuando a exlcusao


// --- INICIO Efetuando o cadastro
if($_GET["cadastra"] == 1) {
	$ok =1;
    $msg = "";

   if($_POST["nome"] != "")
   {
       $nome = $_POST["nome"];	   
   } else {
       $ok = 0;
       $msg .= "Por favor, digite o nome da pesquisa.".'\n';
   }
   
   if($_POST["url"] != "")
   {
       $url = $_POST["url"];
	    $retira = array("!","Ã","Á","À","Â","É","Ê","Í","Ó","Ô","Õ","Ú","Ç","ã","á","à","â","é","ê","í","ó","ô","õ","ú","ç"," ",";",":","1º","2º","3º","/", ",");
		$coloca = array("","a","a","a","a","e","e","i","o","o","o","u","c","a","a","a","a","e","e","i","o","o","o","u","c","-","","","primeiro","segundo","terceiro","-","");
	
		$nova_url = str_replace($retira,$coloca,$url);
	
    	$url = strtolower($nova_url);
   } else {
        $ok = 0;
       $msg .= "Por favor, digite a URL da pesquisa.".'\n';
   }
   
   if($_POST["descricao"] != "")
   {
       $descricao = $_POST["descricao"];
   } else {
   }
   
   if($_POST["empresa"] != "")
   {
        $empresa = $_POST["empresa"];			   
   } else {
       $ok = 0;
       $msg .= "Por favor, digite o nome da empresa.".'\n';
   }
   
   if($_POST["mensagem"] != "")
   {
       $mensagem = $_POST["mensagem"]; 
   } else {
   }
   
   if($_POST["limite"] != "")
   {
       $limite = $_POST["limite"];
   } else {
       $ok = 0;
       $msg .= "Por favor, digite a quantidade de tickets.".'\n';
   }
   
   if($_POST["data_limite"] != "")
   {
       $data_limite = $_POST["data_limite"];
   } else {
       $ok = 0;
       $msg .= "Por favor, digite a data limite da pesquisa.".'\n';
   }
   
   if($_FILES["topo"]['name'] != '') {
       $unlink = mysql_query("SELECT topo FROM pc_pesquisa WHERE id = '".$_GET["id"]."'");
       $unlink = mysql_result($unlink,0,"topo");
       @unlink("pc_topo/".$unlink); 
       $topo = date("Y_m_d_H_i_s_").$_FILES["topo"]['name'];
       if($_FILES["topo"]['type'] != "image/png" and $_FILES["topo"]['type'] != "image/jpeg" and $_FILES["topo"]['type'] != "image/jpg") {
          $ok = 0;
          $msg .= "A extensão da imagem é inválida. Utilize as extensões JPG ou PNG.";
       }
       
       $file_upd = "topo = '$topo', ";
   }
	
    
   if($ok != 0)
   {

	$sql_cadastra = "UPDATE pc_pesquisa SET nome = '$nome', descricao =  '$descricao', empresa = '$empresa', mensagem = '$mensagem', $file_upd limite = $limite , url = '$url', data_limite='$data_limite' WHERE id = ".$_GET["id"];

	if(mysql_query($sql_cadastra)) {
	    if($topo != "") { move_uploaded_file($_FILES["topo"]['tmp_name'], "pc_topo/$topo"); }
        alert("Pesquisa cadastrada com sucesso!");
        redireciona("pc_pesquisa_cadastra.php");
    }
   } else {
       alert($msg);
   }	
   
   //echo $sql_cadastra;
   
   echo mysql_error();
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
        <script>
            function geraUrlAmigavel(palavra)
            {
                var caracteresInvalidos = 'àèìòùâêîôûäëïöüáéíóúãõçÀÈÌÒÙÂÊÎÔÛÄËÏÖÜÁÉÍÓÚÃÕÇ_ ';
                var caracteresValidos = 'aeiouaeiouaeiouaeiouaocAEIOUAEIOUAEIOUAEIOUAOC--';
                var caracteresIndesejados = "´`^¨~!@#$%&*()+=£¢§ªº°{}[]|\\/?:;.,<>\"'";
                novaPalavra = "";
                contador = 0;
                for(i=0;(i<palavra.length && i<=140);i++)
                {
                    letra = palavra.charAt(i);
                    if(caracteresIndesejados.indexOf(letra) == -1)
                    {
                        if (caracteresInvalidos.indexOf(letra) == -1)
                            {
                                novaPalavra += letra;
                                contador ++;
                            }
                            else
                            {
                                if(!(novaPalavra.charAt(contador-1) == "-" && caracteresValidos.charAt(caracteresInvalidos.indexOf(letra)) == "-"))
                                {
                                    novaPalavra += caracteresValidos.charAt(caracteresInvalidos.indexOf(letra));
                                    contador ++;
                                }
                            }
                    }
                }
                return novaPalavra;
            }
                
            function url_mod(v) {
                $("#url_result").html("");
                
                var valor = geraUrlAmigavel(v);
                valor = valor.toString().toLowerCase();
                $("#url_result").html(valor);
                
            }
        </script>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="height: 37px">
				<img src="imagens/edita_pesquisa.jpg" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->

			<form action="?id=<?=$_GET["id"]?>&cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" >
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
            <?php
                $edit = mysql_query("SELECT * FROM pc_pesquisa WHERE id = '".$_GET["id"]."'");
                $nome = mysql_result($edit,0,"nome");
                $descricao = mysql_result($edit,0,"descricao");
                $empresa = mysql_result($edit,0,"empresa");
                $mensagem = mysql_result($edit,0,"mensagem");
                $topo = mysql_result($edit,0,"topo");
				$cod_usuario = mysql_result($edit,0,"cod_usuario");
                $limite = mysql_result($edit,0,"limite");
				$data_limite = mysql_result($edit,0,"data_limite");
                $url = mysql_result($edit,0,"url");
            ?>
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Nome da Pesquisa*: </span> </div>
			    <input type="text" size="50" name="nome" id="nome" value="<?=$nome?>" class="form_style">
            </div>	
            
            <div id="linha_form" style="clear: both;">
				<div id="label"> <span class="label_fonte">Nome da Empresa*: </span> </div>
                <select name="empresa" id="empresa">
                	<option value="">Selecione a empresa</option>
                	<?php
						$sql_empresa = "SELECT CodUsuario, Nome, Sobrenome, permisao FROM ce_usuario WHERE permisao=6666 ORDER BY Nome";
						$query_empresa = mysql_query($sql_empresa);
						
						while($linha_empresa = mysql_fetch_array($query_empresa)){
					?>
                    <option value="<?= $linha_empresa['CodUsuario'] ?>" <? if($linha_empresa['CodUsuario'] == $empresa) { ?> selected="selected" <? } ?>><?= $linha_empresa['Nome']." ".$linha_empresa['Sobrenome'] ?></option>
                    <?php
						}
					?>
                </select>
			    <!--<input type="text" size="50" name="empresa" id="empresa" value="<?=$empresa[0]?>" class="form_style">-->
            </div>	
            
            
            <div id="linha_form" style="clear: both;">
				<div id="label"> <span class="label_fonte">URL*: </span> </div>
           		<input type="text" size="50" name="url" id="url" onkeyup="url_mod(this.value)" value="<?=$url?>" class="form_style"> <span class="label_fonte">http://appweb.com.br/pesquisa/<span id="url_result" style="font-weight: bold;"><?=$url?></span></span>
            </div>
            
            <div id="linha_form" style="height: 140px;">
				<div id="label"> <span class="label_fonte">Mensagem da carta: </span><br /><br /><span class="label_fonte"><strong>OBS:</strong> Escreva [TICKET] onde você quer que o ticket apareça na carta.</span> </div>
			    <textarea name="descricao" id="pc_descricao" class="form_style" style="width: 475px; height: 80px; font-family: Arial;"><?=$descricao?></textarea>
            </div>	
            
            <div id="linha_form" style="height: 140px;">
				<div id="label"> <span class="label_fonte">Mensagens de Boas Vindas: </span> </div>
			    <textarea name="mensagem" id="pc_mensagem" class="form_style" style="width: 475px; height: 80px; font-family: Arial;"><?=$mensagem?></textarea>
            </div>
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Topo (JPG ou PNG): </span> </div>
			    <input type="file" size="50" name="topo" id="topo_pesq" class="form_style">
            </div>
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Quantidade de Tickets*: </span> </div>
			    <input type="text" size="3" name="limite" id="limite" value="<?=$limite?>" onkeypress='numeric(event)' class="form_style">
            </div>	
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Data limite para a pesquisa: </span> </div>
			    <input type="text" size="10" name="data_limite" id="data_limite" value="<?=$data_limite?>" class="form_style"  onclick="displayCalendar(document.forms[0].data_limite,'yyyy-mm-dd',this)">
            </div>	

				<p align="center"><input type="submit" name="Submit" value="Alterar Pesquisa de Clima" class="form_style" /></p>	
				
			
				</div></form>

			
			
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->		
					

			<!-- INICIO - DIV info fim - Barra de informacao -->			
			
			
		
		</div> <!-- FIM DIV PRINCIPAL -->
		 
	</div> <!-- FIM DIV GLOBAL-->
	

</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>