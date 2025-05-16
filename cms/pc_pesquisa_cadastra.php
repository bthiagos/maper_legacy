<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?
// Permissao de acesso

// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM pc_pesquisa WHERE id=".$_REQUEST['id'];
    $sql2 = "DELETE FROM pc_ticket WHERE id_pesquisa=".$_REQUEST['id'];
    $sql4 = "DELETE pc_alternativa, pc_pergunta FROM pc_alternativa LEFT JOIN pc_pergunta ON pc_pergunta.id = pc_alternativa.id_pergunta WHERE pc_pergunta.id_pesquisa=".$_REQUEST['id'];
	if (mysql_query($sql) and mysql_query($sql2) and mysql_query($sql4)) {
        
		alert("Pesquisa de Clima excluÌda com sucesso!");
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
	    $retira = array("!","√","¡","¿","¬","…"," ","Õ","”","‘","’","⁄","«","„","·","‡","‚","È","Í","Ì","Û","Ù","ı","˙","Á"," ",";",":","1∫","2∫","3∫","/", ",");
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
   
   if($_POST["day"] != "")
   {
       $data_limite = $_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
   } else {
       $ok = 0;
       $msg .= "Por favor, digite a data limite da pesquisa.".'\n';
   }
   
   if($_FILES["topo"]['name'] != '') {
       $topo = date("Y_m_d_H_i_s_").$_FILES["topo"]['name'];
       if($_FILES["topo"]['type'] != "image/png" and $_FILES["topo"]['type'] != "image/jpeg" and $_FILES["topo"]['type'] != "image/jpg") {
          $ok = 0;
          $msg .= "A extens„o da imagem È inv·lida. Utilize as extensıes JPG ou PNG.";
       }
   }
	
    
   if($ok != 0)
   {

	$sql_cadastra = "INSERT INTO pc_pesquisa (nome, descricao, empresa, mensagem, topo, limite, url, data_limite) VALUES ('$nome', '$descricao', '$empresa', '$mensagem', '$topo', $limite, '$url', '$data_limite');";
	if(mysql_query($sql_cadastra)) {
	    $insid = mysql_insert_id();
	    if($topo != "") { move_uploaded_file($_FILES["topo"]['tmp_name'], "pc_topo/$topo"); }
        
        if($_POST["puxar"] != "") {
            $puxar = $_POST["puxar"];
            
            
            $perg_puxa = mysql_query("SELECT * FROM pc_pergunta WHERE id_pesquisa = '$puxar'") or die(mysql_error());
            while($puxa = mysql_fetch_array($perg_puxa)) {
                $id_puxa = $puxa["id"];
                
                mysql_query("INSERT INTO pc_pergunta (pergunta,tipo,ordem,id_pesquisa) VALUES ('".$puxa["pergunta"]."','".$puxa["tipo"]."','".$puxa["ordem"]."','$insid')") or die(mysql_error());
                $id_novo = mysql_insert_id();
                $alt_puxa = mysql_query("SELECT * FROM pc_alternativa WHERE id_pergunta = '$id_puxa'");
                while($puxa_alt = mysql_fetch_array($alt_puxa)) {
                    mysql_query("INSERT INTO pc_alternativa (id_pergunta,alternativa,campo_digitavel) VALUES ('".$id_novo."','".$puxa_alt["alternativa"]."','".$puxa_alt["campo_digitavel"]."')");
                }
            }
        }
        
        alert("Pesquisa cadastrada com sucesso!");
        //redireciona("?");
    }
   } else {
       alert($msg);
   }	
   
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
		<!-- INICIO - DIV MENU - Menu do Sistema -->
        <script>
            function geraUrlAmigavel(palavra)
            {
                var caracteresInvalidos = '‡ËÏÚ˘‚ÍÓÙ˚‰ÎÔˆ¸·ÈÌÛ˙„ıÁ¿»Ã“Ÿ¬ Œ‘€ƒÀœ÷‹¡…Õ”⁄√’«_ ';
                var caracteresValidos = 'aeiouaeiouaeiouaeiouaocAEIOUAEIOUAEIOUAEIOUAOC--';
                var caracteresIndesejados = "¥`^®~!@#$%&*()+=£¢ß™∫∞{}[]|\\/?:;.,<>\"'";
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
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="height: 37px;">
				<img src="imagens/cadastro_pesquisa.jpg" alt="Gerar Ticket" title="Gerar Ticket" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->

			<form action="?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" >
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
            <div id="linha_form" style="clear: both;">
				<div id="label"> <span class="label_fonte">Nome da Pesquisa*: </span> </div>
           		<input type="text" size="50" name="nome" id="nome" value="<?=$_POST["nome"]?>" class="form_style">
            </div>
            
            <div id="linha_form" style="clear: both; ">
				<div id="label"> <span class="label_fonte">Nome da Empresa*: </span> </div>
                <select name="empresa" id="empresa">
                	<option value="">Selecione a empresa</option>
                	<?php
						$sql_empresa = "SELECT CodUsuario, Nome, Sobrenome, permisao FROM ce_usuario WHERE permisao=6666 ORDER BY Nome";
						$query_empresa = mysql_query($sql_empresa);
						
						while($linha_empresa = mysql_fetch_array($query_empresa)){
					?>
                    <option value="<?= $linha_empresa['CodUsuario'] ?>"><?= $linha_empresa['Nome']." ".$linha_empresa['Sobrenome'] ?></option>
                    <?php
						}
					?>
                </select>
			    <!--<input type="text" size="50" name="empresa" id="empresa" value="<?=$_POST["empresa"]?>" class="form_style">-->
            </div>	
            
            <div id="linha_form" style="clear: both;">
				<div id="label"> <span class="label_fonte">URL*: </span> </div>
           		<input type="text" size="50" name="url" id="url" onkeyup="url_mod(this.value)" value="<?=$_POST["url"]?>" class="form_style"> <span class="label_fonte">http://appweb.com.br/pesquisa/<span id="url_result" style="font-weight: bold;"></span></span>
            </div>
            
            <div id="linha_form" style="clear: both; height: 140px;">
				<div id="label"> <span class="label_fonte">Mensagem da carta: </span><br /><br /><span class="label_fonte"><strong>OBS:</strong> Escreva [TICKET] onde vocÍ quer que o ticket apareÁa na carta.</span> </div>
			    <textarea name="descricao" id="pc_descricao" class="form_style" style="width: 475px; height: 80px; font-family: Arial;"><?=$_POST["descricao"]?></textarea>
                
            </div>	
            
            <div id="linha_form"  style="clear: both; height: 140px;">
				<div id="label"> <span class="label_fonte">Mensagens de Boas Vindas: </span> </div>
			    <textarea name="mensagem" id="pc_mensagem" class="form_style" style="width: 475px; height: 80px; font-family: Arial;"><?=$_POST["mensagem"]?></textarea>
            </div>
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Topo (JPG ou PNG): </span> </div>
			    <input type="file" size="50" name="topo" id="topo_pesq" class="form_style">
            </div>	
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Quantidade de Tickets*: </span> </div>
			    <input type="text" size="3" name="limite" id="limite" value="<?=$_POST["limite"]?>" onkeypress='numeric(event)' class="form_style">
            </div>	
            
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Data limite para a pesquisa: </span> </div>
			    
                <select name="day">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select> / 
				<select name="month">
					<option value="01">Jan</option>
					<option value="02">Fev</option>
					<option value="03">Mar</option>
					<option value="04">Abr</option>
					<option value="05">Mai</option>
					<option value="06">Jun</option>
					<option value="07">Jul</option>
					<option value="08">Ago</option>
					<option value="09">Set</option>
					<option value="10">Out</option>
					<option value="11">Nov</option>
					<option value="12">Dez</option>
				</select> / 
				<select name="year">
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
				</select>			
	<input type="button" value="Exibir calend·rio" onclick="displayCalendarSelectBox(document.forms[0].year,document.forms[0].month,document.forms[0].day,false,false,this)">
            </div>	
             
            <div id="linha_form">
				<div id="label"> <span class="label_fonte">Puxar perguntas de: </span> </div>
			    <select name="puxar" id="puxar" class="form_style">
                    <option value="">Nenhum</option>
                    <?
                        $sql = mysql_query("SELECT id,nome FROM pc_pesquisa ORDER BY nome ASC");
                        while($pesq = mysql_fetch_array($sql)) {
                    ?>
                    <option value="<?=$pesq["id"]?>"><?=$pesq["nome"]?></option>
                    <? } ?>
                </select>
            </div>	

				<p align="center"><input type="submit" name="Submit" value="Cadastrar Pesquisa de Clima" class="form_style" /></p>	
				
			
				</div></form>

			
			
				<!-- INICIO - DIV info fim - Barra de informacao -->
				<div id="info_fim">
				&nbsp;
					</div>
				<!-- INICIO - DIV info fim - Barra de informacao -->		
					
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="margin-top: -25px; height: 37px;">
				<img src="imagens/gerencia_pesquisa.jpg" alt="Cadastro de Usu&aacute;rios" />
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Nome da Pesquisa</td>
                        <td align="center">Empresa</td>
                        <td align="center">Topo</td>
                        <td align="center">Limite de Tickets</td>
                        <td align="center">Perguntas</td>
						<td align="center" width="170">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM pc_pesquisa ORDER BY id desc";
				$result = mysql_query($sql) or die(mysql_error());
				
				while($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><a href="http://appweb.com.br/pesquisa/<?=$linha["url"]?>" target="_blank" style="color: #3D82D3;"><?=$linha["nome"]?></a></td>			
                        <td align="center" ><? $emp = $linha["empresa"]; $emp = mysql_query("SELECT nome FROM ce_usuario WHERE CodUsuario = '$emp'"); echo $linha["nome"];  ?></td>					
					    
                        <td align="center" ><? if($linha["topo"] == "") { echo "Sem topo disponÌvel."; } else { ?><img src="pc_topo/<?=$linha["topo"]?>" width="100" /><? } ?></td>	
                        <td align="center" ><?=$linha["limite"]?></td>
                        <td align="center" ><a href="pc_pergunta.php?id=<?=$linha["id"]?>"><img src="imagens/pc_perguntas.png" /></a></td>		
                        
                        <td align="center" >
                            <a href="pc_filtros.php?id=<?= $linha['id'] ?>" target="_blank"><img src="imagens/icon_barra.png" title="Gerar RelatÛrios" alt="Gerar RelatÛrios" border="0" ></a>
                            <a href="pc_gera_tickets.php?id_pesquisa=<?= $linha['id'] ?>"><img src="imagens/tickets.png" title="Gerar Tickets" alt="Gerar Tickets" border="0" ></a>
                            <img onclick="tickets_mostra('<?=$linha['id']?>')" src="imagens/relatorio_tickets.png" title="RelatÛrio de Ticket" alt="RelatÛrio de Ticket" border="0" style="cursor: pointer;" width="25" />
                            <a href="pc_mostra_tickets.php?id_pesquisa=<?= $linha['id'] ?>"><img src="imagens/icon_ficha.gif" title="Listar Tickets" alt="Listar Tickets" border="0" ></a>
                            
                            
                            
                            <a href="pc_pesquisa_edita.php?id=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
                            <a href="?apagar=1&id=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a Pesquisa de Clima e todos os dados relacionados?')" alt="Apagar" border="0"></a>
                        </td>		
								
					</tr>
                    
                    <?php
                        //GERADOR DE RELATORIO TICKET
                        $id_pesquisa = $linha['id'];
                        
                        $sql_tickets = mysql_query("SELECT p.limite FROM pc_pesquisa p LEFT JOIN pc_ticket t ON t.id_pesquisa = p.id WHERE p.id = '$id_pesquisa' GROUP BY t.codigo");
                        $limite = mysql_result($sql_tickets,0,'limite');
                        $gerados = mysql_num_rows($sql_tickets);
                        
                        $sql_usados = mysql_query("SELECT id FROM pc_ticket WHERE comecado = '1' and id_pesquisa = '$id_pesquisa'");
                        $usados = mysql_num_rows($sql_usados);
                        
                        $sql_concluidos = mysql_query("SELECT id FROM pc_ticket WHERE finalizado = '1' and id_pesquisa = '$id_pesquisa'");
                        $concluidos = mysql_num_rows($sql_concluidos);
                        
                        //echo $limite."/".$gerados."/".$usados."/".$concluidos;
                        $limite_add = $limite * 20 / 400;
                        $cores = array('1E90FF','228B22','CD0000','EEEE00','FFA500','FFB5C5','CDC9C9','9370DB','A52A2A','000000');
                        $limite2 = $limite + $limite_add;
                    ?>
                    <div id="relatorio_<?=$id_pesquisa?>" class="relatorio_tickets">
                        <div class="relatorio_interno">
                            <div style="float: right;"><img src="imagens/x.png" style="cursor: pointer;" onclick="tickets_fecha('<?=$linha['id']?>')" /></div>
                            <h1>RelatÛrio de Tickets</h1>
                            <img src="http://chart.googleapis.com/chart?chxr=0,0,<?=$limite2?>&chxt=y&chbh=a,4,10&chs=700x350&cht=bvg&chco=<?=$cores[0]?>,<?=$cores[1]?>,<?=$cores[2]?>,<?=$cores[4]?>&chds=0,<?=$limite2?>,0,<?=$limite2?>,0,<?=$limite2?>,0,<?=$limite2?>&chd=t:<?=$limite?>|<?=$gerados?>|<?=$usados?>|<?=$concluidos?>&chdl=Tickets+M%C3%A1ximos|Tickets+Gerados|Tickets+Usados|Tickets+Conclu%C3%ADdos&chm=N,000000,0,-1,14&chm=N,000000,0,-1,14|N,000000,1,-1,14|N,000000,2,-1,14|N,000000,3,-1,14" width="700" alt="Tickets" />
                        </div>
                    </div>
                    
				<?
				}
				?>
				</table>
                <style>
                    .relatorio_tickets {
                        display: none;
                        position: fixed;
                        z-index: 99999;
                        top: 0px;
                        left: 0px;
                        width: 100%;
                        height: 100%;
                        text-align: center;
                        background: url('imagens/transp.png');
                    }
                    
                    .relatorio_tickets .relatorio_interno {
                        width: 750px;
                        padding: 20px;
                        text-align: center;
                        background: #FFF;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        margin-left: -350px;
                        margin-top: -175px;
                    }
                    
                    .relatorio_tickets h1 {
                        width: 750px;
                        font-size: 21px;
                        margin: 0px;
                        padding: 0px;
                        margin-bottom: 5px;
                        font-family: Arial;
                    }
                </style>
                <script>
                    function tickets_mostra(qual) {
                        $("#relatorio_"+qual).fadeIn();
                    }
                    
                    function tickets_fecha(qual) {
                        $("#relatorio_"+qual).fadeOut();
                    }
                </script>

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
</html>