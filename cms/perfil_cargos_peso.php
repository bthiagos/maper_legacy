<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<script src="js/jquery.js"></script>

<?
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM perfil_cargos WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Perfil de cargo excluido com sucesso!");
	}
	
}

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
            
// --- INICIO Efetuando o cadastro
if ($_REQUEST['cadastra']) {
	
	// Varificacao de campos
	$ok = 1;
	$sqlok = 1;
    
    for($i = 1; $i <= 20; $i++) {
    	if (!($_POST["peso_".$i] == "")) {
    		$peso = $_POST["peso_".$i];
            
            if(!$editar) {
                $sql = "INSERT INTO perfil_cargos_itens SET peso = '$peso', id_competencia = '$i', id_perfil= '".$_GET["cod"]."'";
			} else {
			    $sql = "UPDATE perfil_cargos_itens SET peso = '$peso' WHERE id_perfil= '".$_GET["cod"]."' and id_competencia = '$i'";
			}
            if (!mysql_query($sql)) {
			    $sqlok = 0; 
			}
    	} else {
    		$ok = 0;
    	}
    }
	
	
	// Se seu campo estiver OK!
	if (!$ok) {
		// Alert de ERRO!
		alert("Algum peso não foi escolhido.");
	} else {

			// Gravando dados no banco
						
			// Confirmacao de insert
			if ($sqlok) {
				alert("Pesos cadastrados com sucesso!");
				redireciona("perfil_cargos.php");
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
	       <?php
                $perfil_nome = mysql_query("SELECT * FROM perfil_cargos WHERE id = '".$_GET["cod"]."'");
                $perfil_nome = mysql_fetch_array($perfil_nome);
                $perfil_nome = $perfil_nome["cargo"];
            ?>
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info" style="font-family: Arial; font-size: 25px;">
				Pesos para o perfil <b><?=$perfil_nome?></b>
			</div>
            
			<!-- INICIO - DIV info - Barra de informacao -->

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
            <script>            
                function check() {
                    var ok = true;
                    <? $counter = 1; ?>
                    <? while($counter < 21) { ?>
                        if($("#peso_<?=$counter?>").val() == '') {
                            ok = false;
                        }
                    <? $counter++; ?>
                    <? } ?>
                    if(!ok) {
                        alert("Por favor, escolha um peso para todas as competências.");
                        return false;
                    }
                }
            </script>
			<form action="?cadastra=1&cod=<?=$_GET["cod"]?>" method="post" onsubmit="return check();" name="cadastro">
			                
            </script>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
                    <div style="font-size: 15px; font-family: Arial; width: 300px; text-align: center; height: 25px; margin-left: auto; margin-right: auto; background-color: #EBEBEB; padding-top:5px; margin-top: 10px;">Clique nos pesos desejados para marcar.</div>
                    <div style="width: 1005px; margin-left: auto; margin-right: auto; padding-left: 55px; margin-top: 20px;">
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
                            <td style="width: 370px; border-top: 1px solid #ADADAD;""><?=$comp["descricao"]?></td>
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
                            <td style="width: 370px;border-top: 1px solid #ADADAD;"><?=$comp["descricao"]?></td>
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

					<p align="center" style="clear: both; padding-top: 20px;"><input type="submit" value="Cadastrar Pesos" class="form_style"></p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			

				
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