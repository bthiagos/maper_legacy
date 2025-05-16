<?php session_start(); ?>
<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>


<?

            /*
                $array = "6566,7789,10860,6527,5293,9261,8222,9390,6740,7478,5537,8234,6792,8599,7131,7828,9515,7833,5227,7484,6532,5161,8374,8984,5342,7624,5198,6528,7521,7508,6534,8610,7271,7317,10851,5230,8316,7443,8352,7435,8981,8227,7253,7825,6535,5137,8619,7714,8693,5228,6830,8887,9626,10850,5123,5116,7434,6931,5489,7830,9186,5256,7313,7643,5347,7813,8657,6939,5184,7129,6565,6853,6525,5177,7130,5235,5340,7438,7530,8622,5158,6838,6557,8232,5182,9264,6816,7522,5295,5236,7441,7635,10814,6524,7703,5131";
                $array_ex = explode(",",$array);
                $array = str_replace(",","' OR aplicacoes.id = '",$array);
                $array .= "')";
              */  

                
				
//echo __FILE__;
if($_POST["pessoas"]) {
            ?>
                <form name="form1" target="_blank" action="perfil_cargos_links.php" method="POST">
                    <input type="hidden" name="aplicacoes" value="<?=implode("/",$_POST["aplicacoes"])?>" />
                </form>
                <script>
                    document.form1.submit();
                </script>
            <?
        }
 
//echo phpinfo();
if($_POST["orga"] != "") {
    $_SESSION["orga"] = $_POST["orga"];
}

if($_POST["orga2"] != "") {
    $_SESSION["orga2"] = $_POST["orga2"];
}

if($_SESSION["organizacaon"]){
	$organizacaon = $_SESSION["organizacaon"];
}
// --- INICIO Efetuando a exlcusao
if ($_REQUEST['apagar']) {
	
	$sql = "DELETE FROM aplicacoes WHERE id=".$_REQUEST['cod'];
	if (mysql_query($sql)) {
		alert("Aplicação excluida com sucesso!");
	}
	
}

if ($_SESSION["per_adm"] == 5555) {
	//$insert_commit = "1";
	$select_commit = " and organizacoes.commit=1 ";
}

// --- FIM    Efetuando a exlcusao
//echo date("d/m/Y H:i:s");
?>

<?php				$where = "";
					//######### INICIO Paginação
				
					    $numreg = 110; // Quantos registros por página vai ser mostrado
					  if (!isset($pg)) {
					       $pg = 0;
					    }
					   $pg = $_REQUEST["pg"];
					    $inicial = $pg * $numreg;
					   
					//######### FIM dados Paginação
					
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<style type="text/css">

.pgoff {font-family: Aril, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a.pg {font-family: Arial, Arial, Helvetica; font-size:11px; color: #666666; text-decoration: none}
.pg{font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a:hover.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
a:visited.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}
</style>


<body>

<script src="js/jquery_ui.js"></script>
<script src="js/editinplace.js"></script>
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
				Atribuir perfis e gerar relatório
			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
			<form action="perfil_cargos_relatorio.php" method="POST">
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->
			<div id="caixa_form">
			
			<? if(($permissao == "99991") or ($permissao == "99992")){ ?>
			<div id="linha_form">
					<div id="label"> <span class="label_fonte">Organização:</span> </div>
					
						
						<?
						
			          $sql = "SELECT * FROM `organizacoes` $whereorga $select_commit ORDER BY `nome`";
			          $result = mysql_query($sql);
			          //echo $result;
			          ?>
			          <select name="orga2" onchange="submit();" class="form_style" style="width:200px;">
			          <option value="" selected="selected">Selecione</option>
			
			          <? while ($linha = mysql_fetch_assoc($result)) { 
			          	$id2 = $_SESSION["orga2"];
                       
			          	if($linha["id"] == $id2){
			          		$select = " SELECTED ";
			          	}else{
			          		$select = " ";
			          	}
			          	
			          	?>
			          	<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
				         <? }?>
        			</select>
			</div>	

			<?}?>
					
			<div id="linha_form_auto">
					<div id="label"> <span class="label_fonte">Grupos:  <i>(Pressione CTRL para escolher varias opções)</i></span> </div>
					
						
						<?
						if($organizacaon){
							$whereorga = " WHERE id_organizacao='$organizacaon'";
						}
						if($id2){
							$whereorga = "WHERE id_organizacao='$id2'";
						}
					
				          $sql = "SELECT
									grupos.nome AS nomegrupo,
									grupos.id,
									grupos.id_organizacao,
									organizacoes.commit,
									organizacoes.nome AS anomeorga
									FROM grupos INNER JOIN organizacoes ON grupos.id_organizacao = organizacoes.id
									 $whereorga $select_commit ORDER BY `anomeorga`";
				          $result = mysql_query($sql);
				          
				         // echo $sql;
				          ?>
				          <select name="orga[]" multiple size="10" class="form_style" style="width:400px;">
				
				          <? while ($linha = mysql_fetch_assoc($result)) { 
				          
				          
				          	?>
				          	<option value="<?=$linha["id"]?>/<?=$linha["id_organizacao"]?>" <?=$select?> ><?=$linha["anomeorga"]?> - <?=$linha["nomegrupo"]?></option>
					         <? }?>
        			</select>
				</div>	

				<p align="center"><input type="submit" value="Localizar" class="form_style" name="localizar"></p>
				
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->			
			
			</form>

            
          
            <?php
          
                if($_POST["atribuir"]) {
                    $perfil_selecionado = $_POST["perfil"];
                    $pes = $_POST["aplicacoes"];
                    for($i = 0; $i < sizeof($pes); $i++) {
                        $id_perfil = $pes[$i];
                        mysql_query("UPDATE aplicacoes SET id_perfil = '$perfil_selecionado' WHERE id = '$id_perfil'");
                        
                    }
                }
                
            ?>
			<? if($_SESSION["orga"] == "" ){?>
              <div id="info" style="font-family: Arial; font-size: 16px; color: #646464; height: 23px;">
			    
                 <button type="button" onclick="location.href='perfil_cargos.php'" id="link_botao"  class="form_style" name="pessoas" style="cursor: pointer; float:right; margin-top: -5px; ">Gerenciar Perfis</button> 
			</div>
            <? } ?>
          
			<? if($_SESSION["orga"] != "" ){?>
              <div id="info" style="font-family: Arial; font-size: 16px; color: #646464; height: 23px;">
			     Aplicações
                 
                 <button type="button" onclick="location.href='perfil_cargos.php'" id="link_botao"  class="form_style" name="pessoas" style="cursor: pointer; float:right; margin-top: -5px; ">Gerenciar Perfis</button> 
			</div>
           
            
			<form action="?" method="POST" >
			
			
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->
			<div id="caixa_table">
			
				
				<table width="100%" align="center" class="sortable" cellspacing="3">
					
				
					<tr height="30">
						<td align="center">#</td>
						<td align="center">Data</td>
						<td align="center">Nome</td>
						<td align="center">Tempo</td>
						<td align="center">Organização</td>
						<td align="center">Grupo</td>
						<td align="center">Cargo</td>
                        <td align="center">Perfil de Cargo</td>

						<td align="center" colspan="2">A&ccedil;&otilde;es</td>
					</tr>
				
                     <tr height="30">			
						<td align="center" colspan="9" style="font-family: Arial;">
					  		 TODOS
						</td>
                          			
						<td align="center" width="1%" nowrap>
						<input type="checkbox" value="0" id="selectAll" name="opcao[]"  />
						</td>
					</tr>
										
			<?			
					
				$id_orga = $_SESSION["orga"];			
				$where = "";
				
				for($i=0;$i<count($id_orga);$i++){
				    $gp_og = explode("/",$id_orga[$i]);
                    $gp = $gp_og[0];
                    $og = $gp_og[1];
					if($where==""){
						$where = " WHERE (aplicacoes.grupo = '". $gp. "' and aplicacoes.organizacao = '$og')";
					}else{
						$where .= " or (aplicacoes.grupo = '". $gp. "' and aplicacoes.organizacao = '$og')";
					}	
				}
			
				if($organizacaon){
					if($where!=""){
						$where .= " and organizacoes.id='$organizacaon'";
					}else{
						$where = " WHERE organizacoes.id='$organizacaon'";
					}
				}
                
                
				$sql = "SELECT
				aplicacoes.id,
                aplicacoes.id_perfil,
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
				organizacoes.id as id_orga,
				organizacoes.commit,
				aplicacoes.status_envio
				FROM
				aplicacoes
				left Join grupos ON aplicacoes.grupo = grupos.id
				left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where $select_commit ORDER BY aplicacoes.nome asc 
				";
				
                $result = mysql_query($sql);
				
				
				//echo $sql;
				$i=0;
				//break;
                
                $sql = mysql_query("SELECT * FROM perfil_cargos ORDER BY cargo ASC");
                $opts = "Nenhum,";
                while($perfil = mysql_fetch_array($sql)) {
                    $opts .= $perfil["cargo"].",";
                }
                $opts = substr($opts,0,-1);
                
                ?>
                <script>
                    var tam = 0;
                </script>
                <?        
				while ($linha = mysql_fetch_assoc($result)) {
              
                ?>
                <script>
                    tam++;
                </script>
                <?        
				$i++;
				//$resultado_url = executa_url($url);
				//$_SESSION["$nome_session"] = $resultado_url;
				//echo $_SESSION[$nome_session];
				
			?>				
					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">
						<td align="center" ><?=$i;?></td>
						<td align="center" ><?=$linha["databr"]?></td>
						<td align="left" ><?=$linha["nome"]?></td>
						<td align="center" ><?=$linha["tempo"]?> </td>
						<td align="center" ><?=$linha["orga"]?> </td>
						<td align="center" >
						<?
						  echo $linha["grupo"];
							
						?>
						</td>
						<td align="center" ><?=$linha["cargo"]?> </td>
                        <td align="center" >
                        <style>
                            .inplace_save {
                                cursor: pointer;
                            }
                            .inplace_cancel {
                                cursor: pointer;
                            }
                        </style>
                        
                        <script>
                        $(document).ready(function(){
                            $("#editme<?=$i?>").editInPlace({
                        		url: "perfil_cargos_salvar.php",
                                //callback: function(unused, enteredText) { return enteredText; },
                                params: "id=<?=$linha["id"]?>",
                        		field_type: "select",
                                show_buttons: true,
                                save_button: '<br /><a class="inplace_save">Salvar</a>',
                                cancel_button: '<a class="inplace_cancel">Cancelar</a>',
                        		select_options: "<?=$opts?>"
                        	});
                         });
                        </script>
                        <p id="editme_zero" >
                        
                        <?php
                            $perf = mysql_query("SELECT * FROM perfil_cargos WHERE id = '".$linha["id_perfil"]."'");
                            if(mysql_num_rows($perf) == 0) {
                                echo "Nenhum";
                            } else {
                            $perf = mysql_fetch_array($perf);
                            echo $perf["cargo"];
                            }
                        ?>
                        </p>
  
                        
                        </td>
                        <td align="center" width="1%" nowrap>
                            <a target="_blank" href="perfil_cargos_gerar.php?aplicacoes=<?=$linha["id"]?>" ><img src="imagens/icon_gerar_laudo.gif" title="Gerar Relatório" alt="Gerar Relatório" /></a>
							
						</td>
						<td align="center" width="1%" nowrap>
 
							<input type="checkbox" value="<?=$linha["id"]?>" id="cb_<?=$i?>" name="aplicacoes[]" >
						</td>
					</tr>
				
				<?
				}
                
				?>
				
					
					</table>
                    
                    <div id="perfil_pop" class="simple_overlay">
                        <center>
                        <div style="margin-top: 35px; font-family: Arial; font-size: 16px; font-weight: bold;">Atribuir Perfis de Cargo</div>
                        <div style="margin-top: 20px; width: 300px; font-size: 13px; font-family: Arial;">Selecione um perfil de cargo para atribuir à todas as pessoas selecionadas na lista de aplicações.</div>
                        <?php
                            $oarray = $_SESSION["orga"];
                            for($i = 0; $i < sizeof($_SESSION["orga"]); $i++) {
                                    $orgp = explode("/",$oarray[$i]);
                                    $wheres .= "id_organizacao = '".$orgp[1]."' or ";
                                }
                            $wheres = substr($wheres,0,-3);
                          
                        ?>
                        <select name="perfil" style="margin-top: 20px; width: 220px; margin-bottom: 20px; margin-left: auto; margin-right: auto;">
                            
                            <option value="">Nenhum</option>
                            <?php

                                
                                $sql = mysql_query("SELECT * FROM perfil_cargos WHERE $wheres ORDER BY cargo ASC");
                                while($car = mysql_fetch_array($sql)) {
                                    echo "<option value='".$car["id"]."'>".$car["cargo"]."</option>";
                                }
                            ?>  
                         </select>
                         <br />
                         <input type="submit" value="Confirmar" class="form_style" name="atribuir" /> 
                         </center>
                    </div>
                           
                    <div id="links_pop" class="simple_overlay2">    
                    <div style="overflow: scroll; height: 400px;">
                    <div style="font-family: Arial, Verdana; font-size: 13px; font-weight: bold; padding-left: 30px; padding-top: 15px; padding-right: 30px;">Clique no(s) link(s) abaixo para fazer o download do relatório.</div>
                        <script>
                
                        
                        
                        function checar() {

                            i = 0;
                            temvalor = false;
                            while(i < tam) {
                            i++;
                            var cb = "#cb_"+i; 
                            
                            $("#links").html('');
                            if($(cb).is(':checked')) {
                                temvalor = true;
                                
                                    valor = $(cb).val();
                                    
                                    $.ajax({
                                    url: 'ajax_buscanome.php',
                                    type: 'POST',
                                    data: ({
                                    	id: valor
                                    }),
                                      
                                     success: function(data){
                                    	  $("#links").append("<li><a style='color: #000;' href='perfil_cargos_gerar.php?aplicacoes="+data+"</a></li>");			
                                        
                                    }					  
                                    });  
                                
                                
                            }
                            
                            }
                            if(!temvalor) {
                                alert("É necessário escolher pelo menos uma aplicação.");
                            } else {
                                $("#links_pop").overlay().load();
                            }
                        }
                             
                        </script>
                        <div><ul id="links"></ul></div>
                        </div>
                    </div>
                           
                           
					<input type="hidden" value="<?=$where?>" name="awhere" />
 					<p align="center">
                        <button type="button" id="perfil_botao" class="form_style" style="cursor: pointer;" >Atribuir Perfil de Cargo</button>
 						<button type="button" id="link_botao" onclick="checar();" class="form_style" name="pessoas" style="cursor: pointer;" style="margin-left: 15px;">Visualizar Formulário</button> 
 					</p>
			</div>
			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->			
			</form>
            
            
            
            <script>
              $(document).ready(function() {
                  $("#perfil_botao").click(function() {
                      $("#perfil_pop").overlay().load();
                  });
                
                    // select the overlay element - and "make it an overlay"
                  $("#perfil_pop").overlay({
                
                    // custom top position
                    top: 260,
                
                    // some mask tweaks suitable for facebox-looking dialogs
                    mask: {
                
                    // you might also consider a "transparent" color for the mask
                    color: '#000',
                
                    // load mask a little faster
                    loadSpeed: 200,
                
                    // very transparent
                    opacity: 0.5
                    },
                
                    // disable this for modal dialog-type of overlays
                    closeOnClick: false
                    });
                    });
                    
                $(document).ready(function() {
                
                    // select the overlay element - and "make it an overlay"
                  $("#links_pop").overlay({
                
                    // custom top position
                    top: 260,
                
                    // some mask tweaks suitable for facebox-looking dialogs
                    mask: {
                
                    // you might also consider a "transparent" color for the mask
                    color: '#000',
                
                    // load mask a little faster
                    loadSpeed: 200,
                
                    // very transparent
                    opacity: 0.5
                    },
                
                    // disable this for modal dialog-type of overlays
                    closeOnClick: false
                    });
                    });
                </script>
				
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