<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

if($_GET["okay"] != "")
{
    $order_select = mysql_query("SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = '".$_GET["id_pesquisa"]."' ORDER BY id ASC");
    $ko = 1;
    while($ord = mysql_fetch_array($order_select))
    {
        $idord = $ord["id"];
        mysql_query("UPDATE pesquisa_perguntas SET ordem = '$ko' WHERE id = '$idord'");
        $ko++;
    }
}

if($_GET["ord"] != "")
{
    $idgo = $_GET["ord"];
    $ir = $_POST["ordem"];
    
    //PEGA A ORDEM E ADICIONA UM A TODOS ACIMA

    
    mysql_query("UPDATE pesquisa_perguntas SET ordem = ordem + 1 WHERE ordem >= $ir and id_pesquisa = '".$_GET["id_pesquisa"]."'");  
    mysql_query("UPDATE pesquisa_perguntas SET ordem = $ir WHERE id = $idgo");  
    
    $ord_n = 1;
    $getall_perg = mysql_query("SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = '".$_GET["id_pesquisa"]."' ORDER BY ordem ASC");
    while($pergs = mysql_fetch_array($getall_perg))
    {
        mysql_query("UPDATE pesquisa_perguntas SET ordem = '$ord_n' WHERE id = '".$pergs["id"]."'");
        $ord_n++;   
    }
    
    redireciona("pesquisa_perguntas.php?pesquisa=1&id_pesquisa=$id_pesquisa");
}

$frase = "";
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	$id_pesquisa =$_REQUEST['id_pesquisa'];
	
	$sql = "DELETE FROM pesquisa_perguntas WHERE id=".$_REQUEST['cod'];
	$sql2 = "DELETE FROM pesquisa_alternativas WHERE id_perguntas=".$_REQUEST['cod'];
	mysql_query($sql2);
	if (mysql_query($sql)) {
		$frase = "Pergunta excluido com sucesso!";
		alert($frase);
		redireciona("pesquisa_perguntas.php?pesquisa=1&id_pesquisa=$id_pesquisa");
	}
	
}

// --- FIM    Efetuando a exlcusao

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	
		
	// EMPRESA 
	if (!($_POST["pergunta"] == "")) {
		$pergunta  = trim($_POST["pergunta"]);
	} else {
		$ok = 0;
	}
	
	// EMPRESA 
	if (!($_POST["id_pesquisa"] == "")) {
		$id_pesquisa  = trim($_POST["id_pesquisa"]);
	} else {
		$ok = 0;
	}
	
	$texto = $_REQUEST["texto"];
    
    $depois = $_POST["depois"];
	mysql_query("UPDATE pesquisa_perguntas SET ordem = ordem + 1 WHERE ordem > '$depois'");
    
	
	if ($ok) {

		// Gravando dados no banco
			$sql = "INSERT INTO pesquisa_perguntas (perguntas,texto,id_pesquisa,ordem) VALUES ('$pergunta','$texto','$id_pesquisa','$depois')";
			
			// Confirmacao de insert
			if (mysql_query($sql)) {
				alert("Pergunta cadastrado com sucesso!");
				redireciona("pesquisa_perguntas.php?pesquisa=1&id_pesquisa=$id_pesquisa");
				
			} 	else {
				alert("Pergunta não cadastrado , Erro ao no cadastro!");
				redireciona("pesquisa_perguntas.php");
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

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Cadastro das Perguntas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="pesquisa_perguntas.php?cadastra=1" method="post" name="cadastro" enctype="multipart/form-data">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Escolha a pesquisa: </span> </div>
					<select name="id_pesquisa" class="form_style">
						<option value=""> Selecione </option>
						<?
							$sql_pesquisa = "SELECT * FROM pesquisas";
							$result_pesquisa = mysql_query($sql_pesquisa);
							while($linha_pesquisa = mysql_fetch_assoc($result_pesquisa)){?>
								
								<option value="<?=$linha_pesquisa["id"]?>"><?=$linha_pesquisa["nome"]?></option>
								
								
						<?	}											
						?>				
					</select>
				</div>
			
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Texto de instrução : </span> </div><textarea rows="3" cols="80" name="texto" class="form_style"></textarea>
				</div>
				
				
				<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Digite a pergunta: </span> </div><textarea rows="3" cols="80" name="pergunta" class="form_style"><?=$pergunta?></textarea>
				</div>
			
                <div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Adicionar depois de: </span> </div>
                    <select name="depois">
                        <?php
                            $sel = mysql_query("SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = '".$_GET["id_pesquisa"]."' ORDER BY ordem ASC");
                            $n = 1;
                            while($perg = mysql_fetch_array($sel))
                            {
                                if($n < 10)
                                {
                                    $v = "0".$n;
                                } else { $v = $n; }
                                echo "<option value='".$perg["ordem"]."'>".$v.". ".$perg["perguntas"]."</option>";
                            $n++;
                            }
                        ?>
                    </select>
				</div>
			
            
				<p align="center"><input type="submit" value="Cadastrar" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->			
			
					
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Filtrar por pesquisa: </span> </div>
					<form action="pesquisa_perguntas.php?pesquisa=1" name="pesquisar" enctype="multipart/form-data" method="POST">
					<select name="id_pesquisa2" class="form_style">
						<option value=""> Selecione </option>
						<?
							$sql_pesquisa = "SELECT * FROM pesquisas";
							$result_pesquisa = mysql_query($sql_pesquisa);
							while($linha_pesquisa = mysql_fetch_assoc($result_pesquisa)){?>
								
								<option value="<?=$linha_pesquisa["id"]?>"><?=$linha_pesquisa["nome"]?></option>
								
								
						<?	}											
						?>				
					</select>
					
					<p align="center"><input type="submit" value="Filtrar" class="form_style"></p>
					</form>
				</div>


			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->	
				
			<? if($_REQUEST["pesquisa"]){
				
				$where="";
				
				if($_POST["id_pesquisa2"] != ""){
					
					$id_pesquisa = $_POST["id_pesquisa2"];
					$where = "WHERE id_pesquisa = $id_pesquisa";
					
				}elseif($_REQUEST["id_pesquisa"]){
					$id_pesquisa = $_REQUEST["id_pesquisa"];
					$where = "WHERE id_pesquisa = $id_pesquisa";
					
				}else{
					$where = "";
				}
				?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="font-family: arial; font-size: 12px; color: #666666">
				<b>Gerenciamento das Perguntas</b>
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			

			<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center" >Item </td>	
                       	<td align="center" >Ordem</td>
						<td align="center" >Pesquisa</td>	
                        <td align="center" >Instrução</td>							
						<td align="center" >Pergunta</td>						
						<td align="center" >Definir alternativa(s) </td>						
						<td align="center" width="10%" nowrap>A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
				$sql = "SELECT * FROM pesquisa_perguntas $where ORDER BY ordem ASC";
				//echo $sql;
				$result = mysql_query($sql);
				$i=0;
				while ($linha = mysql_fetch_assoc($result)) {
					//$novadata = substr($data,8,2) . "/" .substr($data,5,2) . "/" . substr($data,0,4);
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" width="3%"  >
						
						<?  $i++;
							echo $i;
						?>
						
						</td>
                        
                        <td align="center" >
                        
                            <form action="?ord=<?=$linha["id"]?>&pesquisa=<?=$_GET["pesquisa"]?>&id_pesquisa=<?=$_GET["id_pesquisa"]?>" method="POST">
                                <select name="ordem" onchange="submit();">
                                    <?php 
                                        $ordnao= $linha["ordem"];
                                        echo "<option value=''>Ir</option>";
                                        $order_select = mysql_query("SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = '".$_GET["id_pesquisa"]."' ORDER BY ordem ASC");
                                        $o = 1;
                                        while($ord = mysql_fetch_array($order_select))
                                        {
                                            if($ordnao != $ord["ordem"])
                                            {
                                            echo "<option value = '".$ord["ordem"]."'>".$ord["ordem"]."</option>";
                                            }
                                            $o++;
                                        }
                                    ?>
                                </select>
                            </form>
                            
                        </td>
                        
						
						<td align="center" width="3%"  >
						
						<?  
							$sql_pesquisa2 = "SELECT * FROM pesquisas WHERE id =".$linha["id_pesquisa"];
							$result_pesquisa2 = mysql_query($sql_pesquisa2);
							$linha_pesquisa2 = mysql_fetch_assoc($result_pesquisa2);
							echo $linha_pesquisa2["nome"];
						?>
						
						</td>
                        <td align="center" width="350"><?=$linha["texto"];?></td>
						<td align="center"><?=$linha["perguntas"];?></td>
						<td align="center">
						<a href="pesquisa_alternativas.php?cod=<?=$linha["id"]?>" ><img src="imagens/icon_alternativas.gif" title="Cadastrar Alternativas" alt="Cadastrar Alternativas" border="0"></a>
							
						</td>
						
						
						<td align="center" width="1%" nowrap>
							<!-- Icone de edicao -->
							<a href="pesquisa_perguntas_alt.php?edit=1&cod=<?=$linha["id"]?>">
								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0">
							</a>
							
							<!-- Icone de Exclusao -->
							<a href="pesquisa_perguntas.php?apagar=1&cod=<?=$linha["id"]?>&id_pesquisa=<?=$linha["id_pesquisa"]?>">
								<img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a Pergunta ?')" title="Apagar" alt="Apagar" border="0">
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
			
			
			
			<?}?>
				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
<?if ($frase) {
	alert($frase);
}?>
</html>