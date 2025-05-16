<?php include("conn.php"); ?>

<?php include("logon.php"); ?>

<?php include("library.php"); ?>

<?



//echo __FILE__;

$actual_year = date("Y");

//echo phpinfo();

if($_SESSION["organizacaon"]){

	$organizacaon = $_SESSION["organizacaon"];

}



$userid = $_SESSION["id_usuario_adm"];

$getorg1 = mysql_query("SELECT organizacao FROM ce_usuario WHERE CodUsuario = '$userid'");

$getorg1 = mysql_fetch_array($getorg1);

$getorg1 = $getorg1["organizacao"];



 

// --- INICIO Efetuando a exlcusao

if ($_REQUEST['apagar']) {

	$sql = "DELETE FROM aplicacoes WHERE id='".$_REQUEST['cod']."'";

	if (mysql_query($sql)) {

		alert("Aplicação excluida com sucesso!");

	}

	

}



if($_GET["feito"] != "")

{

    alert("E-mail enviado com sucesso!");

    redireciona("?");

}



if($_GET["erro"] != "")

{

    alert("Erro! Confira se o e-mail é válido.");

    redireciona("?");

}





// --- FIM    Efetuando a exlcusao

//echo date("d/m/Y H:i:s");



if($_GET["corrigir"] == "sim") {

$sql = mysql_query("SELECT * FROM aplicacoes WHERE length(respostas) < 100");

while($linha = mysql_fetch_array($sql)) {

    $id = $linha["id"];

    $resp = $linha["respostas"];

    

    $resp2 = $resp;

    while(strlen($resp2) < 100) {

    $rand = rand(0,1);

    if($rand == 1) { $add = "a"; } else { $add = "b"; }

    $resp2 .= $add;

    }

    mysql_query("UPDATE aplicacoes SET respostas = '$resp2' WHERE id = '$id'");

}

}



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

	function get_mes($mes) {  

	   switch ($mes) {

            case "01":    $mes = Janeiro;     break;

            case "02":    $mes = Fevereiro;   break;

            case "03":    $mes = Março;       break;

            case "04":    $mes = Abril;       break;

            case "05":    $mes = Maio;        break;

            case "06":    $mes = Junho;       break;

            case "07":    $mes = Julho;       break;

            case "08":    $mes = Agosto;      break;

            case "09":    $mes = Setembro;    break;

            case "10":    $mes = Outubro;     break;

            case "11":    $mes = Novembro;    break;

            case "12":    $mes = Dezembro;    break; 

        }

        return $mes;

	}	

    

    function data_formata($data) {

        $date = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);

        return $date;

    }

?>





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<?php include("header.php"); ?>

<script src="js/editinplace.js"></script>

<style type="text/css">



.pgoff {font-family: Aril, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}

a.pg {font-family: Arial, Arial, Helvetica; font-size:11px; color: #666666; text-decoration: none}

.pg{font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}

a:hover.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}

a:visited.pg {font-family: Arial, Arial, Helvetica; font-size: 11px; color: #666666; text-decoration: none}

</style>

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

        <? if($permissao == 99991) { ?>

		<script>

        

            function valida_fromto() {

              

                if($("#to").val() != "") {

                    if($("#from").val() == "") {

                        alert("Escolha uma data inicial.");

                        return false;

                    }

                }

            }

        

            $(document).ready(function() {

               

                    $("#grupo").attr("disabled",true);

                    get_grupos(<?=$_REQUEST["grupos"]?>);

            })

           

            function get_grupos(post) {

    

            value = $("#orgs").val();

            

            if(value) {

            if(post) {

                $("#grupo").removeAttr("disabled");

            }

            

            $.ajax({ 

    			url: 'pegar_grupos.php',

    			type: 'POST',

    			data: ({

    				id: value,

                    last: post

    			}),

                

    			 success: function(data){

    		     

    		     if(data != "fail") {

    			    $("#grupo").removeAttr("disabled");

                    $("#grupo").html('<option value="">Todos</option>');

    			    $("#grupo").append(data);

                 } else {

                    $("#grupo").html('<option value="">Todos</option>');

                    $("#grupo").attr("disabled",true);

                 }

    			}					  

    	   });            

                }

          }

        </script>

        <? } ?>

		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->

		<div id="principal">

		

			<!-- INICIO - DIV info - Barra de informacao -->

			<div id="info">

				<img src="imagens/barra_avaliacao_realizadas.gif" alt="Avaliações Realizadas" />

			</div>

			<!-- INICIO - DIV info - Barra de informacao -->

			<?php

                $where = $_GET["w"];

			

				    if($_SESSION["organizacaon"] != "") {

				        $where = "WHERE organizacoes.id = '".$_SESSION["organizacaon"]."'";

                        

				    } else {

                    

    					if ($_REQUEST["orga"] != ""){

    						$id_orga = $_REQUEST["orga"];

    					   

    						$where = "WHERE organizacoes.id = $id_orga";

    					}else{

    				

    						if ($_REQUEST["orga"] != ""){

    							$id_orga = $_REQUEST["orga"];

    							

    							$where = "WHERE organizacoes.id = $id_orga";

    						

    						}

    					}	

                    }

				

				if($_REQUEST["nome"] != ""){

					$nome_pesq = $_REQUEST["nome"];

					if($where == ""){

						$where .= "WHERE aplicacoes.nome like '%$nome_pesq%'";

					}else{

						$where .= " and aplicacoes.nome like '%$nome_pesq%'";

					}

				}

                

                

                if($_REQUEST["mes"] != ""){

					$mes = $_REQUEST["mes"];

					if($where == "" ){

						$where .= " WHERE MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$actual_year'";

					}else{

						$where .= " and MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$actual_year'";

					}

				}

                

                if($_REQUEST["grupos"] != ""){

					$grupo = $_REQUEST["grupos"];

					$where .= " and aplicacoes.grupo = '$grupo'";

					

				}

                

                if($_REQUEST["from"] != "" and $_REQUEST["to"] == ""){

					$from = $_REQUEST["from"];

                    $to = $_REQUEST["from"];

                    $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

                    $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

                    

                    if($where == "") { 

                       $where .= " WHERE aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                    } else {

					   $where .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

					}

				}

                

                if($_REQUEST["from"] != "" and $_REQUEST["to"] != ""){

					$from = $_REQUEST["from"];

                    $to = $_REQUEST["to"];

                    

                    $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

                    $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

                    

                    if($where == "") { 

                       $where .= " WHERE aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                    } else {

					   $where .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

					}

				}

                

                

          

                if($where == "") { 

                   $where .= " WHERE aplicacoes.aplicativo = 1";

                } else {

				   $where .= " and aplicacoes.aplicativo = 1";

				}

               

            ?>

            

			<form action="aplica_gerencia_aplicativo.php" method="POST" onsubmit="return valida_fromto();">

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o formulario -->

			<div id="caixa_form">

                <input type="hidden" name="pmes" id="pmes" value="<?=$_REQUEST["pmes"]?>" />

				<div id="linha_form">

					<div id="label"> <span class="label_fonte">Nome:</span> </div>



						<input class="form_style" type="text" size="50" name="nome" value="<?=$_REQUEST["nome"]?>">

				      

				</div>	



                

                <div id="linha_form">

					<div id="label"> <span class="label_fonte">Quando:</span> </div>



                    <span id="por_mes">

                     <span class="label_fonte">Mês:</span>

                     <select name="mes" id="mes">

                        <option value="">Todos</option>

                        <option value="01" <? if($_REQUEST["mes"] == "01") { echo "selected"; } ?>>Janeiro</option>

                        <option value="02" <? if($_REQUEST["mes"] == "02") { echo "selected"; } ?>>Fevereiro</option>

                        <option value="03" <? if($_REQUEST["mes"] == "03") { echo "selected"; } ?>>Março</option>

                        <option value="04" <? if($_REQUEST["mes"] == "04") { echo "selected"; } ?>>Abril</option>

                        <option value="05" <? if($_REQUEST["mes"] == "05") { echo "selected"; } ?>>Maio</option>

                        <option value="06" <? if($_REQUEST["mes"] == "06") { echo "selected"; } ?>>Junho</option>

                        <option value="07" <? if($_REQUEST["mes"] == "07") { echo "selected"; } ?>>Julho</option>

                        <option value="08" <? if($_REQUEST["mes"] == "08") { echo "selected"; } ?>>Agosto</option>

                        <option value="09" <? if($_REQUEST["mes"] == "09") { echo "selected"; } ?>>Setembro</option>

                        <option value="10" <? if($_REQUEST["mes"] == "10") { echo "selected"; } ?>>Outubro</option>

                        <option value="11" <? if($_REQUEST["mes"] == "11") { echo "selected"; } ?>>Novembro</option>

                        <option value="12" <? if($_REQUEST["mes"] == "12") { echo "selected"; } ?>>Dezembro</option>



                     </select>

                     <span class="label_fonte"><a href="javascript:por_periodo();">Por período</a></span>

                    </span> 

                    <span id="por_periodo">

                     <span class="label_fonte">De:</span> <input type="text" name="from" id="from" value="<?=$_REQUEST["from"]?>" size="7" /> <span class="label_fonte">Até:</span> <input type="text" size="7" name="to" value="<?=$_REQUEST["to"]?>" id="to" />

				     <span class="label_fonte"><a href="javascript:por_mes();">Por mês</a></span>

                    </span>

                </div>	

                

                <script>

                    $(document).ready(function() {

                        if($("#pmes").val() != "1") { 

                            $("#por_periodo").hide();

                        } else {

                            $("#por_mes").hide();

                        }

                    })

                

                    function por_periodo() {

                        $("#por_mes").hide();

                        $("#por_periodo").show();

                        $("#mes").val("");

                        $("#pmes").val("1");

                     

                    }

                    

                    function por_mes() {

                        $("#por_mes").show();

                        $("#por_periodo").hide();

                        $("#from").val("");

                        $("#to").val("");

                        $("#pmes").val("0"); 

                        

                    }

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

			
            <!--
			<div style="width: 95%; margin-left: auto; margin-right: auto; text-align: right; margin-bottom: 7px; margin-top: -38px; font-family: Arial; font-size: 12px; ">

                Exibir relatórios em formato: <input type="radio" name="exportar" onclick="rel_pdf();" checked /> PDF<input type="radio" name="exportar" style="margin-left: 15px;" onclick="rel_word();" /> DOC

            </div>-->

            <script>

                $(document).ready(function() {

                    //$(".word_export").hide();

                })

            

                function rel_pdf() {

                    $(".word_export").hide();

                    $(".pdf_export").show();

                }

                

                function rel_word() {

                    $(".pdf_export").hide();

                    $(".word_export").show();

                }

            </script>

			

			<!-- INICIO - DIV caixa_form - Div que ira englobar todo o conteudo -->

            

			<div id="caixa_table">

            <?php

                if(!isset($_REQUEST["extrato"])) 

                {

            ?>			



				<table width="100%" align="center" class="sortable" cellspacing="3">

					<tr height="30">

						<td align="center">#</td>

						<td align="center" width="50">Data</td>

						<td align="center">Nome</td>

                        <td align="center">Telefone (Whatsapp)</td>
                        <td align="center">Tempo</td>
                        <td align="center">Ticket</td>

						<td align="center">A&ccedil;&otilde;es</td>

					</tr>

				

					

			<?

                if($_GET["ord"] != "")

                {

                    $ordenar = "aplicacoes.grupo, organizacoes.nome, aplicacoes.nome,";

                } else {

                    $ordenar = "";

                }

                

                

                if($permissao != 99991) {

                    if($where == "") { 

                       $where .= " WHERE aplicacoes.organizacao = '$getorg1'";

                    } else {

					   $where .= " and aplicacoes.organizacao >= '$getorg1'";

					}

                }



                $limite = "LIMIT ".$inicial.",".$numreg;

                

				$sql = "SELECT

				aplicacoes.aplicativo,

				aplicacoes.id,

                aplicacoes.id_perfil,

				aplicacoes.nome,

				aplicacoes.email,

				aplicacoes.telefone,

				aplicacoes.cpf,

				aplicacoes.nasc,

                aplicacoes.organizacao,

                aplicacoes.grupo,                

				aplicacoes.cargo,

				aplicacoes.tempo,

				aplicacoes.respostas,

				aplicacoes.data_aplic,

				date_format(data_aplic ,'%d/%m/%y %H:%i:%s') AS `databr`,

				aplicacoes.status_envio

				FROM

				aplicacoes $where  GROUP BY respostas ORDER BY $ordenar aplicacoes.data_aplic DESC

				$limite";

				$result = mysql_query($sql);

				$i = $inicial;

				

				$sql2 = "SELECT

				aplicacoes.aplicativo,

				aplicacoes.id,

                aplicacoes.id_perfil,

				aplicacoes.nome,

				aplicacoes.email,

				aplicacoes.telefone,

				aplicacoes.organizacao,

                aplicacoes.grupo,

				aplicacoes.cpf,

				aplicacoes.nasc,

				aplicacoes.cargo,

				aplicacoes.tempo,

				aplicacoes.respostas,

				aplicacoes.data_aplic,

				date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

				FROM

				aplicacoes $where ORDER BY $ordenar aplicacoes.data_aplic DESC

				";

				$result2 = mysql_query($sql2);

				

	

				

				$quantreg = mysql_num_rows($result2);

			  	$quant_pg = ceil($quantreg/$numreg);

				$quant_pg++;

				//echo $sql;

				if($quantreg == 0){

					echo "<span class=\"label_fonte\">Nenhum registro</span>";

				}

				

				//echo $sql2;

                $k= 0;

                $i= 0;

                

                ?>

				

                <script>

                    var tam = 0;

                </script>

                    

                

                <?

                while ($linha = mysql_fetch_assoc($result)) {

               

                $i++;

				$url = "http://www.appweb.com.br/cms/prim_pagi_resu_penta.php?id=".$linha["id"];

				$nome_session = "url_".$linha["id"];

				if(1==1)

                {

                    

                

                    

                //$resultado_url = executa_url($url);

				//$_SESSION["$nome_session"] = $resultado_url;

				//echo $_SESSION[$nome_session];

				

			?>				

                    <script>

                        

                        $('.sendhow').click(function(){

            				if ($('input[type=radio][name=sendhow]:checked').val() == "Grupo"){

            					$('.candmail').hide();

            				}else{

            					

                                $('.candmail').show();

            				}

            			})

			

            			

                    </script>

            

                    <!-- OVERLAYS -->

                    <script>

                    $(document).ready(function() {

                        $("img[rel]").overlay({mask: '#000'});

                    });

                    </script>

                    

                    <div class="simple_overlay" id="mies<?=$k?>">

                    	<div style="padding: 10px;">

                        <form name="form" action="aplica_email_envia.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>&grupo=<?=$linha["grupoid"]?>" method="POST" onsubmit="return confere();">

                        <div style="clear: both; margin-bottom: 10px;margin-top: 50px"><img src="imagens/enviar_rel.jpg" /></div>

                    	   <div style="clear: both; border-top: 1px dotted #666; margin-top: 50px; margin-bottom: 10px;"></div>

                           

                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">

                               <b>Relatório: </b>

                           </div>

                           <div style="float: left; margin-left: 5px; margin-bottom: 15px;">

                               <select id="relatorio" name="relatorio">
                                   <option value="">Selecione</option>
                                   <option value="7">Novo Relatório - Português</option>
                                   <option value="8">Novo Relatório - Inglês</option>
                                   <option value="9">Novo Relatório - Espanhol</option>
                                   <!--
                                   <option value="1">Relatório Base 10 com Gráficos</option>
                                   <option value="2">Relatório Base 10 sem Gráficos</option>
                                   <option value="4">Relatório Coaching com Gráfico</option>
                                   <option value="5">Relatório Coaching sem Gráfico</option>
                                   <option value="6">Relatório de Estilos</option>
                                   -->
                               </select>

                           </div>

                           <div style="clear: both; border-top: 1px dotted #666; margin-top: 0px; margin-bottom: 10px;"></div>

                           

                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">

                              <b>Enviar por:</b>

                           </div>

                           <div style="clear: both;"></div>

                           <div style="font-size: 12px; font-family: Arial, Verdana;">

                               <div><input type="radio" class="sendhow" name="sendhow" value="Grupo" /> Grupo - <?=$linha["orga"]?>, <?=$linha["grupo"]?></div>

                               <div style="margin-top: 5px;"><input type="radio" name="sendhow" value="Individual" class="sendhow" /> Individual - <?=$linha["nome"]?></div>

                           </div>   

                           

                           <div style="clear: both; border-top: 1px dotted #666; margin-top: 10px; margin-bottom: 10px;"></div>

                           <div style="float: left; font-size: 12px; font-family: Arial, Verdana; vertical-align: center; line-height: 23px;">

                               <b>Enviar para:</b>

                           </div>

                           <div style="clear: both;"></div>

                           <div style="font-size: 12px; font-family: Arial, Verdana;">

                               <div><input type="radio" name="sendto" class="sendto" value="Candidato" /> Candidato<span class="candmail"> - Email: <input type="text" size="25" value="<?=$linha["email"]?>" name="mailcandidato" /></span></div>

                               

                               <div><input type="radio" name="sendto" class="sendto" value="Empresa" /> Empresa - Email:  <input type="text" name="mailempresa" size="26" /></div>

                           </div> 

                           <div style="text-align: center;"><input type="submit" value="    Enviar E-mail    " style="margin-top: 15px;" /></div>  

                    	</form>

                        </div>

                    </div>

                    <!-- OVERLAYS -->



					<tr height="30" class="cel_fonte" onMouseOver="this.className='cel_fonte_hover'" onMouseOut="this.className='cel_fonte'">

						<td align="center" ><?=$i;?></td>

						<td align="center" ><?=$linha["databr"]?></td>

                        <td align="left" ><?=$linha["nome"]?></td>

                        <td align="center" ><?=$linha["telefone"]?></td>


						<td align="center" ><?=substr($linha["tempo"],3,5)?> </td>
                        <td align="center" ><?=$linha["ticket"]?></td>



                        

                      

						<td align="center" width="1%" nowrap>

								

							<!-- Gráfico coletivo por montagem de grupo 

							<a href="grupoMont.php" target="_blank"><img src="imagens/grupoMont.png" width="25px" height="25px" title="Gráfico coletivo por montagem de grupo" alt="Gráfico coletivo por montagem de grupo" border="0"></a> 

							

							

							

							Gráfico total de um determinado grupo

							<a href="grupoDet.php?grupo=<?php echo $linha["id_orga"];?>&orga=999999" target="_blank"><img src="imagens/grupoDet.png" width="25px" height="25px" title="Gráfico total de um determinado grupo" alt="Gráfico total de um determinado grupo" border="0"></a> 

							 Icone pdf vendido sem grafico -->

							<span class="word_export" style="display: none">	

								<!-- Icone pdf vendido com grafico -->

							<a href="pdf_vendido_word.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_grafB10.jpg" title="Relatório Base 10 c/ Gráficos" alt="Relatório Base 10 c/ Gráficos" border="0"></a> 

							<!-- Icone pdf vendido com grafico -->

							

							

							<!-- Icone pdf vendido sem grafico -->

							<a href="pdf_vendido_word.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdfB10.jpg" title="Relatório Base 10 s/ Gráficos" alt="Relatório Base 10 s/ Gráficos" border="0"></a> 

							<!-- Icone pdf vendido sem grafico -->

							

							

                            

							<!-- Icone de edicao -->

							<!--<a href="form_laudo.php?alterar=1&cod=<?=$linha["id"]?>" target="_blank">

								<img src="imagens/icon_gerar_laudo.gif" title="Formulário de Avaliação de Perfil de Cargo" alt="Formulário de Avaliação de Perfil de Cargo" border="0"></a>

                            -->

							 

							<a href="testepdf_word.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Relatório Coaching c/ Gráficos" alt="NOVO Relatório Coaching c/ Gráficos" border="0"></a> 
                            

							<a href="testepdf_word.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Relatório Coaching c/ Gráficos" alt="Relatório Coaching c/ Gráficos" border="0"></a> 



							<a href="testepdf_word.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdf.jpg" title="Relatório Coaching s/ Gráficos" alt="Relatório Coaching s/ Gráficos" border="0"></a> 

							</span>

                            

                            <span class="pdf_export">	

								<!-- Icone pdf vendido com grafico -->

							<!--<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_grafB10.jpg" title="Relatório Base 10 c/ Gráficos" alt="Relatório Base 10 c/ Gráficos" border="0"></a> -->
							<!-- Icone pdf vendido com grafico -->

							

							

							<!-- Icone pdf vendido sem grafico -->

							<!--<a href="pdf_vendido.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdfB10.jpg" title="Relatório Base 10 s/ Gráficos" alt="Relatório Base 10 s/ Gráficos" border="0"></a> --> 

							<!-- Icone pdf vendido sem grafico -->

							

							

                            

							<!-- Icone de edicao -->

							<!--<a href="form_laudo.php?alterar=1&cod=<?=$linha["id"]?>" target="_blank">

								<img src="imagens/icon_gerar_laudo.gif" title="Formulário de Avaliação de Perfil de Cargo" alt="Formulário de Avaliação de Perfil de Cargo" border="0"></a>

                            -->

							

                            <!--href="novo_relatorio_monta.php?id=<?php echo $linha["id"];?>&orga=1"-->

							<a onclick="abrir_novo_relatorio('<?php echo $linha["id"];?>')" target="_blank" style="cursor: pointer;"><img src="imagens/icon_novorel.gif" title="NOVO Relatório Coaching c/ Gráficos" alt=" NOVO Relatório Coaching c/ Gráficos" border="0"></a>
                            <a onclick="abrir_novo_relatorio2('<?php echo $linha["id"];?>')" target="_blank" style="cursor: pointer;"><img src="imagens/icon_novorel2.gif" title="Modelo Operacional" alt="Modelo Operacional" border="0"></a>
							<!-- 

							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=1" target="_blank"><img src="imagens/icon_graf.jpg" title="Relatório Coaching c/ Gráficos" alt="Relatório Coaching c/ Gráficos" border="0"></a> 



							<a href="testepdf.php?id=<?php echo $linha["id"];?>&orga=999999" target="_blank"><img src="imagens/icon_pdf.jpg" title="Relatório Coaching s/ Gráficos" alt="Relatório Coaching s/ Gráficos" border="0"></a> 
                            -->
							</span>

                            

                            <span id="triggers">

                                <img src="imagens/manda_imail.gif" title="Enviar E-mail Por Pessoa" alt="Enviar E-mail" border="0" rel="#mies<?=$k?>" style="cursor: pointer;" />

                            </span>

                            

                            <!--<a href="aplica_email_envia.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>" onclick="javascript: return confirm('Tem certeza que deseja enviar o relatório de avaliação de <?="&quot;"?><?=$linha["nome"]?><?="&quot;"?> para o e-mail <?="&quot;"?><?=$linha["email"]?><?="&quot;"?>?')"><img src="imagens/manda_imail.gif" title="Enviar E-mail Por Pessoa" alt="Enviar E-mail" border="0" /></a>

                            

                            <a href="aplica_email_envia_g.php?id=<?php echo $linha["id"];?>&orga=<?=$linha["id_orga"]?>&grupo=<?=$linha["grupoid"]?>" onclick="javascript: return confirm('Tem certeza que deseja enviar o relatório de avaliação para TODOS DO GRUPO <?="&quot;"?><?=$linha["grupo"]?><?="&quot;"?>?')"><img src="imagens/manda_imail2.gif" title="Enviar E-mail Por Grupo" alt="Enviar E-mail" border="0" /></a>

							-->

                            <? if(($permissao == "3333")){ ?>          					

                            	<a href="aplica_org_alt.php?alterar=1&cod=<?=$linha["id"]?>">

								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0"></a>

                            <? } ?>

                            <? if(($permissao == "99991") or ($permissao == "99992")){ ?>

           					

							<a href="aplica_alt.php?alterar=1&cod=<?=$linha["id"]?>">

								<img src="imagens/icon_editar.gif" title="Editar" alt="Editar" border="0"></a>

							<a href="aplica_gerencia_aplicativo.php?apagar=1&cod=<?=$linha["id"]?>"><img src="imagens/icon_apagar.gif" onclick="javascript: return confirm('Deseja realmente excluir a avaliação de <?=$linha["nome"]?> ?')" title="Apagar" alt="Apagar" border="0"></a>

							<?}?>

							</td>

					</tr>

				

				<?

				}

                $k++;

                }

				?>

				

					<tr>

					<td align="center" colspan="8" >

                    

                    <div style="width: 1000px; overflow: hidden;">



				 <?   // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior

                  $w = $_REQUEST["nome"]; //palavra

                $o = $_REQUEST["orga"]; //organizacao

                $g = $_REQUEST["grupos"]; //grupo

                $f = $_REQUEST["from"]; //from

                $t = $_REQUEST["to"]; //to

                $m = $_REQUEST["mes"]; //to

                $p = $_REQUEST["pessoas"]; //to



                

				    if ( $pg > 0) {

				        echo "<a href=".$PHP_SELF."?pg=".($pg-1)."&orga=$id_orga&nome=$w&orga=$o&grupos=$g&from=$f&to=$t&mes=$m&pessoas=1 class=pg><b>&laquo; anterior</b></a>";

				    } else {

				        echo "<span class=pg><b>&laquo; anterior</b></span>";

				    }

				     for($i_pg=1;$i_pg<$quant_pg;$i_pg++) {

				        // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente

				        if ($pg == ($i_pg-1)) {

				            echo "&nbsp;<span class=pg>[$i_pg]</span>&nbsp;";

				        } else {

				            $i_pg2 = $i_pg-1;

				            echo "&nbsp;<a href=".$PHP_SELF."?pg=$i_pg2&orga=$id_orga&nome=$w&orga=$o&grupos=$g&from=$f&to=$t&mes=$m&pessoas=1 class=pg><b>$i_pg</b></a>&nbsp;";

				        }

				    }

				    

				    // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima

				    if (($pg+2) < $quant_pg) {

				        echo "<a href=".$PHP_SELF."?pg=".($pg+1)."&orga=$id_orga&nome=$w&orga=$o&grupos=$g&from=$f&to=$t&mes=$m&pessoas=1 class=\"pg\"><b>próximo &raquo;</b></a>";

				    } else {

				        echo "<span class=pg>próximo &raquo;</span>";

				    }

                

				?>

                </div>



				</td>

					</tr>

					</table>

                <? } else { ?>

                

                <?

                //**************** GERAR NA TELA ************************         

                    

                ?>

                <div style="margin-top: -25px; padding-bottom: 7px;"><a href="gerar_extrato_30_05_2012.php?w=<?=$_REQUEST["nome"]?>&o=<?=$_REQUEST["orga"]?>&g=<?=$_REQUEST["grupos"]?>&f=<?=$_REQUEST["from"]?>&t=<?=$_REQUEST["to"]?>&m=<?=$_REQUEST["mes"]?>&p=<?=$_REQUEST["pessoas"]?>" ><img src="imagens/gerar_extrato_excel.jpg" /></a></div>

                

                <?

                    

                $w = $_REQUEST["nome"]; //palavra

                $o = $_REQUEST["orga"]; //organizacao

                $g = $_REQUEST["grupos"]; //grupo

                $f = $_REQUEST["from"]; //from

                $t = $_REQUEST["to"]; //to

                $m = $_REQUEST["mes"]; //to

                $p = $_REQUEST["pessoas"]; //to



                

                $where = "";

                

                if($w != ""){

                	if($where == "" ){

                		$where = "WHERE aplicacoes.nome like '%$w%'";

                	}else{

                		$where .= " and aplicacoes.nome like '%$w%'";

                	}

                }

                

                

                if($g != ""){

                	if($where == ""){

                		$where = "WHERE aplicacoes.grupo='$g'";

                	}else{

                        $where .= " and aplicacoes.grupo='$g'";

                	}

                }

                

                

                if($o != ""){

                	if($where == ""){

                		$where = "WHERE organizacoes.id='$o'";

                	}else{

                        $where .= " and organizacoes.id='$o'";

                	}

                }

                

                

                if($f != "" and $t == ""){

                	$from = $f;

                    $to = $f;

                    $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

                    $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

                    

                    if($where == "") { 

                       $where .= " WHERE aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                    } else {

                	   $where .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                	}

                }

                

                

                if($m != ""){

					$mes = $m;

					if($where == "" ){

						$where .= " WHERE MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$actual_year'";

					}else{

						$where .= " and MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$actual_year'";

					}

				}

                

                

                if($f != "" and $t != ""){

                	$from = $f;

                    $to = $t;

                    

                    $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

                    $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

                    

                    if($where == "") { 

                       $where .= " WHERE aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                    } else {

                	   $where .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                	}

                }

                

                if($where !="") { $where .= " and organizacoes.id != '' and grupos.id != ''"; } else { $where = "WHERE organizacoes.id != '' and grupos.id != ''"; }

                  

                $limite = "LIMIT ".$inicial.",".$numreg;

                

                if($_GET["where"] != "") {

                    $where = $_GET["where"];

                }

                //print_r($array_contabilizado);

                $sql = "SELECT

                	aplicacoes.id,

                	aplicacoes.nome,

                	aplicacoes.email,

                	aplicacoes.telefone,

                	aplicacoes.cpf,

                	aplicacoes.nasc,

                    aplicacoes.organizacao,

                    aplicacoes.grupo,                

                	aplicacoes.cargo,

                	aplicacoes.tempo,

                	aplicacoes.respostas,

                	aplicacoes.data_aplic,

                	date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

                	organizacoes.nome as orga,

                    grupos.id as grupoid,

                	grupos.nome as grupo,

                	organizacoes.id as id_orga,

                	aplicacoes.status_envio

                	FROM

                	aplicacoes

                	left Join grupos ON aplicacoes.grupo = grupos.id

                	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.data_aplic DESC $limite";



                	$result = mysql_query($sql);	

                    //$total = mysql_num_rows($result);

                    //echo $sql;

                 $sql2 = "SELECT

                	aplicacoes.id,

                	aplicacoes.nome,

                	aplicacoes.email,

                	aplicacoes.telefone,

                	aplicacoes.cpf,

                	aplicacoes.nasc,

                    aplicacoes.organizacao,

                    aplicacoes.grupo,                

                	aplicacoes.cargo,

                	aplicacoes.tempo,

                	aplicacoes.respostas,

                	aplicacoes.data_aplic,

                	date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

                	organizacoes.nome as orga,

                    grupos.id as grupoid,

                	grupos.nome as grupo,

                	organizacoes.id as id_orga,

                	aplicacoes.status_envio

                	FROM

                	aplicacoes

                	left Join grupos ON aplicacoes.grupo = grupos.id

                	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where ORDER BY aplicacoes.data_aplic DESC";



                	$result2 = mysql_query($sql2);	

                 	$total = mysql_num_rows($result2);

                

                    

    				$quantreg = $total;

    			  	$quant_pg = ceil($quantreg/$numreg);

    				$quant_pg++;

    				//echo $sql;

    				if($quantreg == 0){

    					echo "<span class=\"label_fonte\">Nenhum registro</span>";

    				}

    				

				$sql_organizacoes = "SELECT

                    DISTINCT 

                    grupos.id as grupoid,

                	COUNT(grupos.id) as gcount,           

                    aplicacoes.id,

                	aplicacoes.nome,

                	aplicacoes.email,

                	aplicacoes.telefone,

                	aplicacoes.cpf,

                	aplicacoes.nasc,

                    aplicacoes.organizacao,

                    aplicacoes.grupo,                

                	aplicacoes.cargo,

                	aplicacoes.tempo,

                	aplicacoes.respostas,

                	aplicacoes.data_aplic,

                	date_format(data_aplic ,'%d/%m/%Y %H:%i:%s') AS `databr`,

                	organizacoes.nome as orga,

                	grupos.nome as grupo,

                	organizacoes.id as id_orga,

                	aplicacoes.status_envio

                	FROM

                	aplicacoes

                	left Join grupos ON aplicacoes.grupo = grupos.id

                	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id $where GROUP BY organizacoes.id, grupos.id ORDER BY organizacoes.nome, grupos.nome ASC";

                  

                  $sql_organizacoes_q = mysql_query($sql_organizacoes) or die(mysql_error());

                 

                  $sql_organizacoes_c = mysql_query($sql_organizacoes) or die(mysql_error());

                  while($org_c = mysql_fetch_array($sql_organizacoes_c)) {

                    $todas_orgas .= $org_c["id_orga"]."&&&";

                    //$total += $org_c["gcount"];

                    $orga_grup .= $org_c["id_orga"]."///".$org_c["grupoid"]."&&&";

                  }

                  $orga_grup = explode("&&&",$orga_grup);

                  array_pop($orga_grup);

                  $todas_orgas = explode("&&&",$todas_orgas);

                  $todas_orgas = array_count_values($todas_orgas);

                 

    				

                // montando a tabela

                echo "<table border='1' cellspacing='0' cellpadding='0' bordercolor='#666666' style='margin-bottom: 5px; width: 100%; font-size: 11px; font-family: Arial;'>";

                  if($mes != "") {

                    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato do Mês de ".get_mes($mes)."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

                  }

                  if($from != "" and $to == "") {

                    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato do dia ".data_formata($from)."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

                  }

                  

                  if($from != "" and $to != "") {

                    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato do período de ".data_formata($from)." até ".data_formata($to)."<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

                  }

                  

                  if($from == "" and $to == "" and $mes == "") {

                    echo "<tr><td colspan='4' align='center' style='background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;'>Extrato<br /><span style='font-size: 11px;'>Total: ".$total."</span></td></tr>";

                  }

                  

                  echo "<tr style='height: 30px;'>";

                    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">#</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Organização</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Grupo</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Quantidade</td>';

                  echo "</tr>";

                  

                  $i = 1;

                  

                  

                  //AQUI COMEÇA A TABELA DE ORGANIZAÇÕES E GRUPOS

                  while($org = mysql_fetch_array($sql_organizacoes_q)) {

                  $id_org = $org["organizacao"];

                  $orga = $org["id_orga"];

                  $rowspan_original = $todas_orgas[$id_org];

                  $rowspan = $todas_orgas[$id_org] + 1; 

                  

                  if($org["grupo"] != "") {

                  echo "<tr style='height: 30px;border-bottom: 2px solid #000'>";

                  

                  //PROBLEMA: SABER SE A PROX LINHA É CONTINUAÇÃO DO ROWSPAN OU NÂO

                  $array_check = explode("&&&",$jafoi);

                 if($rowspan > 1) {

                    if(!in_array($orga,$array_check)) {

                      

                      echo '<td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle" rowspan="'.$rowspan.'">'.$i.'</td>

            	   	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle" rowspan="'.$rowspan.'">'.$org["orga"].'</td>

            		  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["grupo"].'</td>

            		  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["gcount"].'</td>';

                      $i++;

                    } else {

                      echo '<td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["grupo"].'</td>

            		  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["gcount"].'</td>';

                    }

                

                 } else {

                      echo '<td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$i.'</td>

            	   	  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["orga"].'</td>

            		  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["grupo"].'</td>

            		  <td style="vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">'.$org["gcount"].'</td>';

                      $i++;

                 } 

              

                  echo "</tr>";

                  $jafoi .= $org["id_orga"]."&&&";

                  

                  //TOTAL SOMA DE GRUPOS

                  $jafoi_array = explode("&&&",$jafoi);

                  $quantos_ja_foram = array_count_values($jafoi_array);

                  if($quantos_ja_foram[$orga] == $rowspan_original) {

                  

                  

                    echo "<tr style='height: 30px; border-bottom: 2px solid #000'>";

                    echo '<td style="vertical-align: middle; color: #666666; font-weight: bold; background-color: #E8E8E8;" align="center" valign="middle">TOTAL</td>

          		    <td style="vertical-align: middle; color: #666666; font-weight: bold; background-color: #E8E8E8; font-size: 16px; " align="center" valign="middle">'; 

                    //PEGAR SOMA DE GRUPOS

                    

                    

                    //REAPLICAÇÃO DOS FILTROS

                    $total_org = 0;

                     if($w != ""){

                  		$where_tot .= " and aplicacoes.nome like '%$w%'";

                    	

                    }

                    

                    if($f != "" and $t == ""){

                    	$from = $f;

                        $to = $f;

                        $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

                        $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";

                        $where_tot .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                    	

                    }

                    

                    

                    if($m != ""){

    					$mes = $m;

                        $where_tot .= " and MONTH(aplicacoes.data_aplic) = '$mes' and YEAR(aplicacoes.data_aplic) = '$actual_year'";

    					

    				}

                    

                    

                    if($f != "" and $t != ""){

                    	$from = $f;

                        $to = $t;

                        

                        $from = substr($from,6,4)."-".substr($from,3,2)."-".substr($from,0,2)." "."00:00:00";

                        $to = substr($to,6,4)."-".substr($to,3,2)."-".substr($to,0,2)." "."23:59:59";



                  	    $where_tot .= " and aplicacoes.data_aplic >= '$from' and aplicacoes.data_aplic <= '$to'";

                    	

                    }

                    //REAPLICAÇÃO DOS FILTROS

                    

                    for($j = 0; $j < sizeof($orga_grup); $j++) {

                        $orga_e_grup = explode("///",$orga_grup[$j]);

                        $og = $orga_e_grup[0];

                        $gp = $orga_e_grup[1];

                        

                    

                        //echo $og."//".$orga."___";

                        

                        if($og == $orga) {

                            $sql_gp = "SELECT

                            DISTINCT 

                            grupos.id as grupoid,

                        	COUNT(grupos.id) as gcount,           

                        	organizacoes.nome as orga,

                        	grupos.nome as grupo,

                        	organizacoes.id as id_orga

                        	FROM

                        	aplicacoes

                        	left Join grupos ON aplicacoes.grupo = grupos.id

                        	left Join organizacoes ON aplicacoes.organizacao = organizacoes.id WHERE (organizacoes.id = '$og' and grupos.id = '$gp') $where_tot GROUP BY grupos.id ORDER BY organizacoes.nome, grupos.nome ASC";

                            //echo $sql_gp;

                            $sql_gp = mysql_query($sql_gp);

                            while($gps = mysql_fetch_array($sql_gp)) {

                                $total_org += $gps["gcount"]; 

                            }

                        }

                    }

                    echo $total_org;

                    

                    echo '</td>';

                    echo "</tr>";

                  }

                  

              }

                  

                  

            }

                echo "</table>";

                if($_REQUEST["pessoas"] == '1') {

                echo "<hr />";

                

                echo "<table border='1' cellspacing='0' cellpadding='0' bordercolor='#666666' style='margin-top: 10px; width: 100%; font-size: 11px; font-family: Arial;'>";

                  echo "<tr style='height: 30px;'>";

                    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold; font-size: 20px;" align="center" colspan="7" valign="middle">Pessoas</td>';

                  echo "</tr>";

                  

                  echo "<tr style='height: 30px;'>";

                    echo '<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" width="15" valign="middle">#</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Data</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Nome</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Tempo</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Organização</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Grupo</td>

                		<td style="background: #EEEEEE; vertical-align: middle; color: #666666; font-weight: bold;" align="center" valign="middle">Cargo</td>';

                  echo "</tr>";

                  

                

                  if($_GET["pg"] == "" or $_GET["pg"] == "0") {

                  $k = 1;

                  } else {



                    $k = $_GET["pg"] * 110;

                    $k = $k +1;

                    

                  }

                

                

                while ($linha = mysql_fetch_array($result)){

                  echo "<tr style='height: 25px;'>";

                    echo '<td style="vertical-align: middle; color: #333333;" align="center" width="15" >'.$k.'</td>

                		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["databr"].'</td>

                		<td style="vertical-align: middle; color: #333333;" align="left" >'.$linha["nome"].'</td>

                		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["tempo"].'</td>

                		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["orga"].'</td>

                		<td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["grupo"].'</td>

                        <td style="vertical-align: middle; color: #333333;" align="center" >'.$linha["cargo"].'</td>';

                  echo "</tr>";

                  $k++;

                }

                ?>

                <tr>

					<td align="center" colspan="8" >

                    

                    <div style="width: 1000px; overflow: hidden;">



				 <?   // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior

                 

				    if ( $pg > 0) {

				        echo "<a href=".$PHP_SELF."?extrato=1&pg=".($pg-1)."&orga=$id_orga&nome=$w&orga=$o&grupos=$g&from=$f&to=$t&mes=$m&pessoas=1  class=pg><b>&laquo; anterior</b></a>";

				    } else {

				        echo "<span class=pg><b>&laquo; anterior</b></span>";

				    }

				     for($i_pg=1;$i_pg<$quant_pg;$i_pg++) {

				        // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente

				        if ($pg == ($i_pg-1)) {

				            echo "&nbsp;<span class=pg>[$i_pg]</span>&nbsp;";

				        } else {

				            $i_pg2 = $i_pg-1;

				            echo "&nbsp;<a href=".$PHP_SELF."?extrato=1&pg=$i_pg2&orga=$id_orga&nome=$w&orga=$o&grupos=$g&from=$f&to=$t&mes=$m&pessoas=1 class=pg><b>$i_pg</b></a>&nbsp;";

				        }

				    }

				    

				    // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima

				    if (($pg+2) < $quant_pg) {

				        echo "<a href=".$PHP_SELF."?extrato=1&pg=".($pg+1)."&orga=$id_orga&nome=$w&orga=$o&grupos=$g&from=$f&to=$t&mes=$m&pessoas=1 class=\"pg\"><b>próximo &raquo;</b></a>";

				    } else {

				        echo "<span class=pg>próximo &raquo;</span>";

				    }

                



                

				?>

                </div>

    

    				</td>

				</tr>

                <?php

                

                echo "</table>"; 

                //**************** GERAR NA TELA ************************  

                }

                ?>

                

                <? } ?>



			</div>

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



<?php mysql_close(); ?>

<!-- QuickMenu Structure [Menu 0] -->



<div class="fundo-linguagem" style="display: none;">

    <div class="linguagem">

        <div class="fechar" onclick="$(this).parent().parent().fadeOut()">X</div>

        <div class="escolha">Escolha sua linguagem / Choose your language / Elige tu idioma</div>

        <div class="bandeiras">

            <a id="novo_relatorio_br" target="_blank" href="?lang=br"><img src="../img/flag_br.jpg" /></a>

            <a id="novo_relatorio_en" target="_blank" href="?linguagem=en"><img src="../img/flag_en.jpg" /></a>

            <a id="novo_relatorio_es" target="_blank" href="?linguagem=es"><img src="../img/flag_es.jpg" /></a>

        </div>

    </div>

</div>

<script>
function abrir_novo_relatorio(id) {
    $("#novo_relatorio_br").attr("href","novo_relatorio_monta2.php?id="+id+"&orga=1&lang=br");
    $("#novo_relatorio_en").attr("href","novo_relatorio_monta2.php?id="+id+"&orga=1&lang=en");
    $("#novo_relatorio_es").attr("href","novo_relatorio_monta2.php?id="+id+"&orga=1&lang=es");
    $(".fundo-linguagem").fadeIn();
} 
function abrir_novo_relatorio2(id) {
    $("#novo_relatorio_br").attr("href","novo_relatorio_operacional.php?id="+id+"&orga=1&lang=br");
    $("#novo_relatorio_en").attr("href","novo_relatorio_operacional.php?id="+id+"&orga=1&lang=en");
    $("#novo_relatorio_es").attr("href","novo_relatorio_operacional.php?id="+id+"&orga=1&lang=es");
    $(".fundo-linguagem").fadeIn();
} 
</script>



<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->

</body>

<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>

</html>