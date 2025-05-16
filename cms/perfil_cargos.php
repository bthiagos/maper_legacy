<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM perfil_cargos WHERE id=".$_REQUEST['cod'];
    $sql2 = "DELETE FROM perfil_cargos_itens WHERE id_perfil=".$_REQUEST['cod'];
    $sql3 = "UPDATE aplicacoes SET id_perfil = '0' WHERE id_perfil=".$_REQUEST['cod'];
	if (mysql_query($sql) and mysql_query($sql2) and mysql_query($sql3)) {
		alert("Perfil de cargo excluido com sucesso!");
	}
	
}
if(isset($_SESSION["organizacaon"])) {
    $organizacaon = $_SESSION["organizacaon"];
}

// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	

	$ok = 1;
    $msg = "";
	$sqlok = 1;
    
    if($permissao == "99991")
    {
                    
    if (!($_POST["organizacao"] == "")) {
		$organizacao = $_POST["organizacao"];
	} else {
		$ok = 0;
        $msg .= "Por favor escolha uma organização.".'\n';
	}
    
    }
    
	if (!($_POST["cargo"] == "")) {
		$cargo = $_POST["cargo"];

	} else {
	   $msg .= "Por favor digite um cargo.".'\n';
		$ok = 0;
	}
	
    if (!($_POST["descricao"] == "")) {
		$descricao = $_POST["descricao"];
	} else {
	
	}
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert($msg);
	} else {

			// Gravando dados no banco
            if($permissao == "99991") {                       
			 $sql = "INSERT INTO perfil_cargos SET cargo = '$cargo',descricao = '$descricao',id_organizacao = '$organizacao'";
            } else {
              $sql = "INSERT INTO perfil_cargos SET cargo = '$cargo',descricao = '$descricao',id_organizacao = '$organizacaon'";
            }
			// Confirmacao de insert
			if (mysql_query($sql)) {
			    $lastid = mysql_insert_id();
                for($i = 1; $i <= 20; $i++) {
                	if (!($_POST["peso_".$i] == "")) {
                		$peso = $_POST["peso_".$i];
                       
            			$sql = "INSERT INTO perfil_cargos_itens SET peso = '$peso', id_perfil= '$lastid',id_competencia = '$i'";
                        if (!mysql_query($sql)) {
            			    $sqlok = 0; 
            			}
                	} else {
                		$ok = 0;
                	}
                }
                if($sqlok) {
    				alert("O perfil de cargo foi cadastrado com sucesso!");
    				redireciona("perfil_cargos.php");
			    } 
            }
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
			<div id="info" style="font-family: Arial; font-size: 16px; color: #646464; height: 23px;">
				Cadastrar perfil de cargo
			</div>

			<!-- INICIO - DIV info - Barra de informacao -->
			<?php
                $edit = mysql_query("SELECT * FROM perfil_cargos WHERE id = '".$_GET["cod"]."'");
                $edit = mysql_fetch_array($edit);
                $cargo = $edit["cargo"];
                $descricao = $edit["descricao"];
                $organizacao = $edit["id_organizacao"];
                
                $cod = $_GET["cod"];
                $edit = mysql_query("SELECT * FROM perfil_cargos_itens WHERE id_perfil = '$cod'");
                if(mysql_num_rows($edit) != 0) {
                    $editar = true;
                    while($ed = mysql_fetch_array($edit)) {
                    $peso_ed = $ed["peso"];
                    $comp_ed = $ed["id_competencia"];
                    
                ?>
                    <script>
                        $(document).ready(function() {
                            $("#peso<?=$peso_ed?>_<?=$comp_ed?>").removeClass("peso").addClass("peso_fixo");
                            $("#peso_<?=$comp_ed?>").val(<?=$peso_ed?>);
                        })
                    </script>
                <?
                    }   
                } else {
                    $editar = false;
                }
            ?>
            
            
            
            
			<!-- INICIO - DIV info - Barra de informacao -->
			<script>            
                function check() {
                    var ok = true;
                    var igual1 = 0;
                    var igual2 = 0;
                    var igual3 = 0;
                    <? $counter = 1; ?>
                    <? while($counter < 21) { ?>
                        if($("#peso_<?=$counter?>").val() == '') {
                            ok = false;
                        }
                        if($("#peso_<?=$counter?>").val() == '1') {
                            igual1++;    
                        }
                        if($("#peso_<?=$counter?>").val() == '2') {
                            igual2++;    
                        }
                        if($("#peso_<?=$counter?>").val() == '3') {
                            igual3++;    
                        }
                    <? $counter++; ?>
                    <? } ?>
                    if(!ok) {
                        alert("Por favor, escolha um peso para todas as competências.");
                        return false;
                    } else {
                        if((igual1 == 20) || (igual2 == 20) || (igual3 == 20)) {
                            alert("Você atribuiu o mesmo peso para as competências.\nNa definição de perfil de cargo é importante que você atribua pesos DIFERENTES.");
                            return false;
                        }
                    }
                }
            </script>
			<form action="?cadastra=1&cod=<?=$_GET["cod"]?>" method="post"  name="cadastro" onsubmit="return check();">
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
            <script>
                $(document).ready(function() {
                    $("#etapa2").hide();
                })
                
                function etapa1() {
                    $("#etapa2aba").removeClass("etapa2").addClass("semetapa");
                    $("#etapa1aba").removeClass("semetapa").addClass("etapa1");
                    $("#etapa2").hide();
                    $("#etapa1").show();
                }
            
                function etapa2() {
                    var msg = '';
                    var ok = true;
                    <?php
                        if($permissao == "99991")
                        {
                    ?>
                    if($("#organizacao").val() == "") {
                        msg += 'Por favor selecione a organização.\n';
                        ok = false;
                    }
                    <?  } ?>
                    if($("#cargo").val() == "") {
                        msg += 'Por favor digite um cargo.\n';
                        ok = false;
                    }
                    if($("#descricao").val() == "") {
                        msg += 'Por favor digite uma descrição para o cargo.';
                        ok = false;
                    }
                    
                    if(ok) {
                        $("#etapa2aba").removeClass("semetapa").addClass("etapa2");
                        $("#etapa1aba").removeClass("etapa1").addClass("semetapa");
                        $("#etapa1").hide();
                        $("#etapa2").show();
                    } else {
                        alert(msg);
                    }
                }
            </script>
            
			<div id="caixa_form">
            <style>
                .etapa1 {
                    background: url('imagens/etapa1.jpg') no-repeat;
                }
                .etapa2{
                    background: url('imagens/etapa2.jpg') no-repeat;
                }
                .semetapa{
                    background: white;
                }
            </style>
            <div style="margin-left: 30px; margin-bottom: 20px; margin-top: 10px; font-family: Arial; font-size: 11px;">
            <div id="etapa1aba" class="etapa1" onclick="etapa1();" style="cursor: pointer; width: 140px; height: 30px; border-left: 1px solid #969696; border-top: 1px solid #969696; border-bottom: 1px solid #969696; float: left; padding: 5px;">
                <div style="margin-left: 15px;"><span style="font-weight: bold; font-size: 13px;">Etapa 1</span><br />
                Criar perfil de cargo</div>
            </div>
            <div id="etapa2aba" class="semetapa" onclick="etapa2();" style="cursor: pointer; width: 140px; height: 30px; border-right: 1px solid #969696; border-top: 1px solid #969696; border-bottom: 1px solid #969696; float: left; padding: 5px;">
                <div style="margin-left: 25px;"><span style="font-weight: bold; font-size: 13px;">Etapa 2</span><br />
                Atribuir Pesos</div>
            </div>
            </div>
            
            <div id="etapa1">
            <div style="clear: both;"></div>
            
            <?php
                if($permissao == "99991")
                {
            ?>
			    <div id="linha_form">
					<div id="label"> <span class="label_fonte">Organização: </span> </div>
                    <select name="organizacao" style='width: 450px;' id="organizacao">
                        <option value="">Selecione</option>
                        <?php
                            $sql = mysql_query("SELECT * FROM organizacoes ORDER BY nome ASC");
                            while($org = mysql_fetch_array($sql)) {
                        ?>
                        <option value="<?=$org["id"]?>" <? if($organizacao == $org["id"]) { echo "selected"; } ?>><?=$org["nome"]?></option>
                        <? } ?>
                    </select>
				</div>
            <? } ?> 
                 
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Cargo: </span> </div><input id="cargo" type="text" style='width: 450px;' name="cargo" value="<?=$cargo?>" class="form_style">
				</div>
				
				<div id="linha_form">
					<div id="label"> <span class="label_fonte">Descrição: </span> </div><textarea id="descricao" name="descricao" style="width: 450px; height: 100px;" class="form_style"><?=$descricao?></textarea>
				</div>
				
		

					<p align="center" style="clear: both; margin-top: 90px;"><input type="button" value="  Próxima Etapa  >>" onclick="etapa2();" class="form_style"></p>
			</div>		
			
            
            <div id="etapa2">
                <style>
                .peso {
                    width: 15px;
                    height: 22px;
                    font-size: 15px;
                    cursor: pointer;
                    color: #ADADAD;
                }
                
                .peso_fixo {
                    color: #000;
                    height: 22px;
                    font-size: 18px;
                    font-weight: bold;
                }
                
                .peso:hover {
                    color: #000;
                    height: 22px;
                    font-size: 18px;
                    font-weight: bold;
                
                }
                
                .tb tr {
                    height: 30px;
                }
            </style>
            
      	        <div style="font-size: 15px; font-family: Arial; width: 300px; text-align: center; height: 25px; margin-left: auto; margin-right: auto; background-color: #EBEBEB; padding-top:5px; margin-top: 10px;">Clique nos pesos desejados para marcar.</div>
                    <div style="width: 840px; margin-left: auto; margin-right: auto; padding-left: 55px; margin-top: 20px;">
			        <table cellpadding="0" cellspacing="0" class="tb" style="font-family: Arial, Verdana; font-size: 13px; float: left;">
                    <tr>
                        <td style="width: 30px;" align="center"><b>#</b></td>
                        <td align="center"><b>Competências</b></td>
                        <td align="center" colspan="3"><b>Pesos</b></td>
                    </tr>

                    <?php
                        $cont = 0;
                        $sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC LIMIT 0,10");
                        while($comp = mysql_fetch_array($sql)) {
                        $cont++;
                        
                    ?>
                        <tr style="border-top: 1px solid #ADADAD;">
                            <td align="center" style="border-top: 1px solid #ADADAD;"><?=$comp["ordem"]?></td>
                            <td style="width: 280px; border-top: 1px solid #ADADAD;""><?=$comp["descricao"]?></td>
                            <td align="center" class="peso" id="peso1_<?=$cont?>" style="border-top: 1px solid #ADADAD;">1</td>
                            <td align="center" class="peso" id="peso2_<?=$cont?>" style="border-top: 1px solid #ADADAD;">2</td>
                            <td align="center" class="peso" id="peso3_<?=$cont?>" style="border-top: 1px solid #ADADAD;">3</td>
                            
                            <td></td>
                        </tr>
                        
                        <script>
                        $(function() {
                    		$("#peso1_<?=$cont?>").click(function() {
                    			$("#peso1_<?=$cont?>").removeClass("peso").addClass("peso_fixo");
                                $("#peso2_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso3_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso_<?=$cont?>").val('1');
                    		});
                            
                            $("#peso2_<?=$cont?>").click(function() {
                    			$("#peso1_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso2_<?=$cont?>").removeClass("peso").addClass("peso_fixo");
                                $("#peso3_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso_<?=$cont?>").val('2');
                    		});
                            
                            $("#peso3_<?=$cont?>").click(function() {
                    			$("#peso1_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso2_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso3_<?=$cont?>").removeClass("peso").addClass("peso_fixo");
                    		    $("#peso_<?=$cont?>").val('3');
                            });
                    	}); 
                    	</script>
                        
                        <input type="hidden" name="peso_<?=$cont?>" id="peso_<?=$cont?>" />
                        
                    <? } ?>
                    </table>
                    
                    <table cellpadding="0" cellspacing="0" class="tb" style="font-family: Arial, Verdana; font-size: 13px; float: left; margin-left: 25px; padding-left: 25px; border-left: 1px solid silver;">
                    <tr>
                        <td style="width: 30px;" align="center"><b>#</b></td>
                        <td align="center"><b>Competências</b></td>
                        <td align="center" colspan="3"><b>Pesos<b></td>
                        
                        <td style="width: 60px;"></td>
                    </tr>
                    
                    <?php
                        $cont = 10;
                        $sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC LIMIT 10,10");
                        while($comp = mysql_fetch_array($sql)) {
                        $cont++;
                        
                    ?>
                        <tr>
                            <td align="center" style="border-top: 1px solid #ADADAD;"><?=$comp["ordem"]?></td>
                            <td style="width: 280px;border-top: 1px solid #ADADAD;"><?=$comp["descricao"]?></td>
                            <td align="center" class="peso" id="peso1_<?=$cont?>" style="border-top: 1px solid #ADADAD;">1</td>
                            <td align="center" class="peso" id="peso2_<?=$cont?>" style="border-top: 1px solid #ADADAD;">2</td>
                            <td align="center" class="peso" id="peso3_<?=$cont?>" style="border-top: 1px solid #ADADAD;">3</td>
                        </tr>
  
                    <script>
                        $(function() {
                    		$("#peso1_<?=$cont?>").click(function() {
                    			$("#peso1_<?=$cont?>").removeClass("peso").addClass("peso_fixo");
                                $("#peso2_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso3_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso_<?=$cont?>").val('1');
                    		});
                            
                            $("#peso2_<?=$cont?>").click(function() {
                    			$("#peso1_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso2_<?=$cont?>").removeClass("peso").addClass("peso_fixo");
                                $("#peso3_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso_<?=$cont?>").val('2');
                    		});
                            
                            $("#peso3_<?=$cont?>").click(function() {
                    			$("#peso1_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso2_<?=$cont?>").removeClass("peso_fixo").addClass("peso");
                                $("#peso3_<?=$cont?>").removeClass("peso").addClass("peso_fixo");
                    		    $("#peso_<?=$cont?>").val('3');
                            });
                    	}); 
                    	</script>
                        
                        <input type="hidden" name="peso_<?=$cont?>" id="peso_<?=$cont?>" />
                        
                    
                    <? } ?>
                    </tr>
                        
                    </table> 
                    </div>
                	<p align="center" style="clear: both; padding-top: 20px;"><input type="submit" value="  Cadastrar Perfil de Cargo  " class="form_style"></p>
			</div>
            
            </div>
			</form>

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
            <!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
            <!-- INICIO - DIV info fim - Barra de informacao -->
		<div id="info" style="font-family: Arial; font-size: 16px; color: #646464; height: 23px;">
			 <div style="float: left;">Gerenciar perfis de cargo</div>

             <button type="button" onclick="location.href='perfil_cargos_relatorio.php'" id="link_botao"  class="form_style" name="pessoas" style="cursor: pointer; float:right; margin-top: -5px; ">Selecionar Aplicações</button> 
             </div>
			
            
			<div id="caixa_table">
			

				<table width="100%" align="center" class="sortable" cellspacing="3">
					<tr height="30">
						<td align="center">Cargos</td>
						<td align="center">Descrição</td>
						<td align="center">Organização</td>
						<td align="center">A&ccedil;&otilde;es</td>
					</tr>
				
					
			<?
			if ($_SESSION["per_adm"] == 5555) {
				//$insert_commit = "1";
				$select_commit = " organizacoes.commit=1 ";
			}
            if($organizacaon) {
				$sql = "SELECT perfil_cargos.id,perfil_cargos.cargo,perfil_cargos.descricao,organizacoes.nome,organizacoes.commit FROM perfil_cargos LEFT JOIN organizacoes ON organizacoes.id = perfil_cargos.id_organizacao WHERE $select_commit perfil_cargos.id_organizacao = '$organizacaon' ORDER BY perfil_cargos.cargo ASC";
			} else {
                $sql = "SELECT perfil_cargos.id,perfil_cargos.cargo,perfil_cargos.descricao,organizacoes.nome,organizacoes.commit FROM perfil_cargos LEFT JOIN organizacoes ON organizacoes.id = perfil_cargos.id_organizacao WHERE $select_commit ORDER BY perfil_cargos.cargo ASC";
			}
			
				//echo $sql;
			
                $result = mysql_query($sql);
				
				while ($linha = mysql_fetch_assoc($result)) {
			
			?>					
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$linha["cargo"]?> </td>
						<td align="center" ><?=$linha["descricao"]?> </td>
						<td align="center" ><?=$linha["nome"]?> </td>
						<td align="center" width="1%" nowrap>
							<a href="perfil_cargos_alt.php?edit=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_editar.gif" alt="Editar" border="0"></a>
							<?php
                                $check = mysql_query("SELECT * FROM aplicacoes WHERE id_perfil = '".$linha["id"]."'");
                                if(mysql_num_rows($check) != 0) {
                                ?>
                                <a href="?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Há aplicações que usam este perfil de cargo. Tem certeza que deseja excluir este perfil de cargo? Se excluir, as aplicações permanecerão armazenadas, porém sem nenhum perfil de cargo.')" alt="Apagar" border="0"></a>
                                <?
                                } else {
                                ?>
                                <a href="?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir o perfil de cargo?')" alt="Apagar" border="0"></a>
                                <?
                                }
                                ?>
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