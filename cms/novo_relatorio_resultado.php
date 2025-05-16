<?
include ("conn.php");
?>
<?
	include ("library.php");
?>
<?php
$id_aplicacao = $_REQUEST["id"];
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_radar.php');

// BUSCANDO INFORMAï¿½ï¿½ES DA PESSOA QUE FEZ A APLICAï¿½ï¿½O
$sql_pessoa = "SELECT * FROM aplicacoes WHERE id=$id_aplicacao";
$result_pessoal = mysql_query($sql_pessoa);
$dados_pessoa = mysql_fetch_assoc($result_pessoal);

//data da aplicaï¿½ï¿½o
$pdata_aplic = date('d/m/Y', strtotime($dados_pessoa["data_aplic"]));
$pGabarito = $dados_pessoa["respostas"];
 
$i = $j = $total = 0;
$login = 0;
$Opcao = "";
$id_competencia = "";
$sql = "";
$row = "";
$competencias[20];
$nome_competencias[20];

$i = 0;
while ($i < 20) {
	$competencias[$i] = 0;
	$i++;
}

if (strlen($pGabarito) == 100) {

	$sql = " 
       		SELECT c.descricao 
       		FROM  competencias c
	   		ORDER BY c.ordem";

	//EXECUTA A QUERY
	$sql = mysql_query($sql);
	$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");

	for ($i = 0; $i < $row; $i++) {
		$nome_competencias[$i] = mysql_result($sql, $i, "descricao");
	}

	$i = 0;
	while ($i < 100) {

		$Opcao = $pGabarito[$i];

		if (strcmp($Opcao, "a") || strcmp($Opcao, "b")) {
			//QUERY
			$sql = " 
		       		SELECT c.ordem 
		       		FROM  questoes q, competencias c
			   		WHERE q.competencia_id=c.competencias_id and q.ordem = " . ($i + 1) . " and q.sequencia like \"" . $Opcao . "\"";

			//echo $sql."<br/>"; 

			//EXECUTA A QUERY
			$sql = mysql_query($sql);
			$row = mysql_num_rows($sql) or die("erro na busca das questões");

			$id_competencia = mysql_result($sql, 0, "ordem");
			//echo $id_competencia."<br/>";

			$competencias[$id_competencia - 1]++;

		}//fim do if
		$i++;
	} //fim do while
}//fim do if

$a = 0;
$notas_base10 = array();
while ($a < 20) {
	$notas_base10[$a] = base102(($a + 1), $competencias[$a]);
	$a++;
}
//var_dump($notas_base10);

// ------------ GRAFICO RADAR
$titles = array("Capacidade \nde planejamento", "Capacidade \nde organização", "Capacidade \nde acompanhamento", "Estilo \nde liderança", "Estilo \nde comunicação", "Tomada \nde decissão", "Capacidade \nde delegação", "Administração \ndo tempo", "Volume \nde trabalho", "Potencial\ncriativo\ne flexibilidade", "Cap. priorizar e\n trab. \nc/ imprevistos", "Gestão \nde mudanças", "Relacionamento \ncom superiores", "Gestão \nde\n conflitos", "Controle das\n emoções", "Relacionamento\n afetivo", "Relacionamento \nem grupos", "Imagem \npessoal", "Tônus\n vital", "Necessidade \nde\n realização");
//$titles=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");
$data = $notas_base10;

$graph = new RadarGraph(700, 700);

$graph -> title -> Set('Avaliação de Perfil Profissional');
$graph -> title -> SetFont(FF_FONT1, FS_NORMAL, 12);

$graph -> SetTitles($titles);
$graph -> SetCenter(0.5, 0.55);
$graph -> HideTickMarks();
$graph -> SetColor('white');
$graph -> axis -> SetColor('darkgray');
$graph -> grid -> SetColor('darkgray');
$graph -> grid -> Show();

$graph -> axis -> title -> SetFont(FF_FONT1, FS_NORMAL, 10);
$graph -> axis -> title -> SetMargin(10);
$graph -> SetGridDepth(DEPTH_BACK);
$graph -> SetSize(0.65);

$plot = new RadarPlot($data);
$plot -> SetColor('red@0.2');
$plot -> SetLineWeight(1);
$plot -> SetFillColor('red@0.7');

$plot -> mark -> SetType(MARK_IMG_SBALL, 'red');

$graph -> Add($plot);
$mome = "radar_" . $id_aplicacao;
$graph -> Stroke('graficos/' . $mome . '.jpg');
?>

<?

$url3 = "http://www.appweb.com.br/cms/teste_graf2.php?id=" . $id_aplicacao . "&commit=$commit";
executa_url("$url3");

function ideal($pCompentencia) {

	$valor[11];

	for ($i = 0; $i < 11; $i++) {
		$valor[$i] = 999;
	}//fecha for

	$sql = " 
       		SELECT i.valor 
       		FROM  ideais i, competencias c
			WHERE c.competencias_id = i.competencia_id and c.ordem = " . $pCompentencia . "
	   		ORDER BY i.valor";

	//EXECUTA A QUERY
	$sql = mysql_query($sql);
	$row = mysql_num_rows($sql) or die("erro na busca dos valores ideais das competÃªncias");

	for ($z = 0; $z < $row; $z++) {
		$pos = mysql_result($sql, $z, "valor");
		$valor[$pos] = $pos;
	}//fecha for

	//echo "<div style=\"border: 1px solid #000000; letter-spacing: 70px;\">";
	for ($i = 0; $i < 11; $i++) {
		if ($valor[$i] == 999) {
			$valor[$i] = $i;
			echo "<span class=\"num_normal\" >&nbsp;" . $valor[$i] . "&nbsp;</span> ";
		} else {
			echo "<span class=\"num_yellow\" >&nbsp;" . $valor[$i] . "&nbsp;</span> ";
		}

	}
	//echo "</div>";

}

function feedback($pCompentencia, $pNota) {

	$sql = " 
       		SELECT f.descricao 
       		FROM  feedbacks f, competencias c
			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;

	//EXECUTA A QUERY
	$sql = mysql_query($sql);
	$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");

	$pos = (mysql_result($sql, 0, "descricao"));
	return $pos;

}
?>
<?
// PEGANDO ID DA APLICAï¿½ï¿½O
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; " />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
<style type="text/css">
	.style17 {
		font-family: Arial;
		font-size: 8px;
		font-weight: bold;
	}
	.style18 {
		font-family: Helvetica;
		font-size: 8px;
	}
	body, td, th {
		font-family: Arial, Helvetica, serif;
		font-size: 8px;
	}
	body {
		margin: 0 0 0 0;
		color: 000000;
	}
	.folha {
		page-break-after: always;
	}

	.pagina {
		width: 750px;
		height: 1070px;
		border: 0px solid #000000;
		overflow: hidden;
		background-image: url(bg_rodape.jpg);
		background-repeat: no-repeat;
		background-position: center bottom;
	}

	#cabecalho {
		width: 742px;
		height: 96px;
		border: 4px solid #1172ae;
		-webkit-border-top-left-radius: 30px;
		-webkit-border-bottom-right-radius: 30px;
		-moz-border-radius-topleft: 30px;
		-moz-border-radius-bottomright: 30px;
		border-top-left-radius: 30px;
		border-bottom-right-radius: 30px;
	}

	.tabela {
		width: 530px;
		float: left;
		margin-left: 51px;
		margin-top: 17px;
	}

	.tabela tr td {
		font-family: Arial, Helvetica, serif;
		font-size: 12px;
		text-transform: uppercase;
		min-width: 265px;
	}
	.tabela tr td span {
		color: #2C72B5;
		font-weight: bolder;
	}

	.subtitulos {
		width: 750px;
		margin: 0 0 0 0;
		padding: 0 0 0 0;
		list-style-type: none;
		margin-top: 20px;
	}

	.subtitulos li {
		float: left;
		color: #2C72B5;
		font-weight: bolder;
		font-family: Arial, Helvetica, serif;
		font-size: 14px;
		text-transform: uppercase;
	}

	.caixa_competencia {
		margin: 0 auto;
		font-family: Arial, Helvetica, serif;
		font-size: 12px;
		color: #000000;
		margin-top: 30px;
	}
	.titulo_competencia {
		min-width: 300px;
		font-family: Arial, Helvetica, serif;
		font-size: 13px;
		font-weight: bolder;
		color: #000000;
	}
	.notas_ideias {
		font-family: Arial, Helvetica, serif;
		font-size: 13px;
		font-weight: bolder;
		color: #000000;
	}
	.txt_feedback {
		font-family: Arial, Helvetica, serif;
		font-size: 11px;
		font-weight: bolder;
		color: #000000;
		text-align: justify;
	}
	.nota_pessoa {
		font-family: Arial, Helvetica, serif;
		font-size: 20px;
		font-weight: bolder;
		color: #2C72B5;
		text-align: center;
		float: right;
		padding: 6px 26px;
	}

	.titulotb {
		font-family: Arial, Helvetica, serif;
		font-size: 18px;
		color: #2C72B5;
	}
	.num_normal {

	}
	.num_yellow {
		background-color: #e28900;
		color: #ffffff;
	}

	.txt_explica {
		font-family: Arial, Helvetica, serif;
		font-size: 12px;
		color: #000000;
		line-height: 20px;
	}

	.coluna_auzl {
		background-image: url(bg_azul.jpg);
		background-repeat: no-repeat;
		background-position: center top;
	}
	.coluna_amarela {
		background-image: url(bg_amarelo.jpg);
		background-repeat: no-repeat;
		background-position: center top;
	}
	.coluna_vermelho {
		background-image: url(bg_vermelho.jpg);
		background-repeat: no-repeat;
		background-position: center top;
	}

	.titulo_estilo {
		background-color: #72aad9;
		font-family: Arial, Helvetica, serif;
		font-size: 14px;
		color: #ffffff;
		text-align: center;
		text-transform: uppercase;
	}
	.titulo_rotulo {
		background-color: #e1f1ff;
		font-family: Arial, Helvetica, serif;
		font-size: 14px;
		color: #000000;
		text-align: center;
	}

</style>
</head>

<body>
	

<!-- PAGINA 1 -->
	<div class="pagina">	
		<div id="cabecalho">
			<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
			<table class="tabela">
				<tr>
					<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
					<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
				</tr>
				<tr>
					<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
					<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
				</tr>
				<tr>
					<td width="265">&nbsp;</td>
					<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
				</tr>
			</table>
		</div>
		
		<table width="750" border="0" style="margin-top: 15px; margin-bottom: 15px;">
			<tr>
				<td width="350" class="titulotb"><strong>Competência</strong></td>
				<td width="290" class="titulotb"><strong>Nota Ideal</strong></td>
				<td width="110" align="center" class="titulotb"><strong>Sua Nota</strong></td>
			</tr>
		</table><br/> 
		
		<table width="750" border="0" cellspacing="00">
			
  <?php
		$i = 0;
		$linha_arquivo = 1;
	//	echo "<p><b>CompetÃªncias:</b></p>";
		while ($i<10) { 
		?>		
		  <tr>
		    <td width="670" class="titulo_competencia" nowrap="nowrap"><strong><? echo($i + 1); ?> - <? echo $nome_competencias[$i]; ?></strong><span style="margin-left: 70px;" class="notas_ideias"><? ideal($i + 1); ?></span></td>
		    <td width="80">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="620" class="txt_feedback"><? echo feedback(($i + 1), $competencias[$i]); ?><br/><br/></td>
		    <td align="center" class="nota_pessoa"><strong><? echo $competencias[$i]; ?></strong></td>
		  </tr>
		  
		  
		<?$i++;
			}
		?>
		  
	  
		  
		</table>
		
	</div>
	
	
	<!-- PAGINA 2 -->
	<br/>
	<div class="pagina">	
		<div id="cabecalho">
			<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
			<table class="tabela">
				<tr>
					<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
					<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
				</tr>
				<tr>
					<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
					<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
				</tr>
				<tr>
					<td width="265">&nbsp;</td>
					<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
				</tr>
			</table>
		</div>
		
		<table width="750" border="0" style="margin-top: 15px; margin-bottom: 15px;">
			<tr>
				<td width="350" class="titulotb"><strong>Competência</strong></td>
				<td width="290" class="titulotb"><strong>Nota Ideal</strong></td>
				<td width="110" align="center" class="titulotb"><strong>Sua Nota</strong></td>
			</tr>
		</table><br/> 
		
		<table width="750" border="0" cellspacing="00">
			
  <?php
		$i = 10;
	//	echo "<p><b>CompetÃªncias:</b></p>";
		while (($i>=10) && ($i<=19)) { 
		?>		
		  <tr>
		    <td width="670" class="titulo_competencia" nowrap="nowrap"><strong><? echo($i + 1); ?> - <? echo $nome_competencias[$i]; ?></strong><span style="margin-left: 70px;" class="notas_ideias"><? ideal($i + 1); ?></span></td>
		    <td width="80">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="620" class="txt_feedback"><? echo feedback(($i + 1), $competencias[$i]); ?><br/><br/></td>
		    <td align="center" class="nota_pessoa"><strong><? echo $competencias[$i]; ?></strong></td>
		  </tr>
		  
		  
		<?$i++;
			}
		?>
		  
	  
		  
		</table>
		
	</div>
	
	<!-- PAGINA 3 -->
	<br/>
	<div class="pagina">	
		<div id="cabecalho">
			<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
			<table class="tabela">
				<tr>
					<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
					<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
				</tr>
				<tr>
					<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
					<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
				</tr>
				<tr>
					<td width="265">&nbsp;</td>
					<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
				</tr>
			</table>
		</div>

		<?
		$codigo_id2 = $id_aplicacao . "grafico2.png";
		?>

		
		<p style="text-align: center; margin-top: 150px;">
		<img src="graficos/<?=$codigo_id2; ?>" width="620" />
		</p>

		
		<? ?>
		
	</div>
	
	<!-- PAGINA 4 -->
	<br/>
	<div class="pagina">	
		<div id="cabecalho">
			<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
			<table class="tabela">
				<tr>
					<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
					<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
				</tr>
				<tr>
					<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
					<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
				</tr>
				<tr>
					<td width="265">&nbsp;</td>
					<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
				</tr>
			</table>
		</div>

		<?
		$codigo_id2 = $id_aplicacao . "grafico2.png";
		?>
		
		
		<p style="text-align: center; margin-top: 55px;">
		<img src="graficos/<?=$mome ?>.jpg" />
		</p>
		
		<? ?>
		
	</div>
	
	
	<!-- PAGINA 5 -->
	<br/>
	<div class="pagina">	
		<div id="cabecalho">
			<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
			<table class="tabela">
				<tr>
					<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
					<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
				</tr>
				<tr>
					<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
					<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
				</tr>
				<tr>
					<td width="265">&nbsp;</td>
					<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
				</tr>
			</table>
		</div>

		<p class="txt_explica">
		A tabela a seguir possui 3 colunas sendo Sustentação, Aceitávell e Crítico.<br />
		Por "Sustentação" entenda pelos "pontos fortes" do candidato / profissional que remetem aos fatores de excelência.<br />
		Na segunda coluna, compreenda que são os fatores aceitáveis, ou seja, estão adequados mas podem evoluir mais. <br />
		Por último, os fatores críticos sugerem as competências que podem prioritariamente ser trabalhadas.<br /><br /> 
		
		É importante lembrar que essa é uma classificação generalizada e deve ser adequada às competências organizacionais, portanto, ao perfil de cada cargo.
		</p>
		
		
		<p style="margin-top: 10px; margin-left: 25px;"><?
			include ("tabela2_novo.php");
 ?></p>
		

		
		
	</div>
	
	<!-- PAGINA 6 -->
	<br/>
	<div class="pagina">	
		<div id="cabecalho">
			<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
			<table class="tabela">
				<tr>
					<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
					<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
				</tr>
				<tr>
					<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
					<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
				</tr>
				<tr>
					<td width="265">&nbsp;</td>
					<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
				</tr>
			</table>
		</div>


		<?
		// ESTILO LIDER
		$nota_competencia3 = $competencias[2];
		$nota_competencia4 = $competencias[3];

		// LIDER INTEGRAL
		if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {
			$label_lider = "Líder Integral";
			$txt_estilo = "Os profissionais que revelam este perfil apresentam boa capacidade de Liderança Motivacional (Estilo de Liderança) e também facilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente conseguem motivar sua equipe para atingir metas e objetivos e também estimulam o potencial das pessoas promovendo o seu desenvolvimento e revelando alguns potenciais, assumindo o verdadeiro papel de Líder COACH.";
		}

		// LIDER CARISMETICO
		if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {
			$label_lider = "Líder Carismático";
			$txt_estilo = "Os profissionais com este perfil geralmente conseguem motivar as pessoas para atingir os desafios, e possuem uma forte liderança inspiradora, contudo podem estar depositando muita energia nesta competï¿½ncia e faltando habilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente são excelentes Líderes motivacionais, mas precisam também desenvolver sua Liderança COACH. ";
		}

		// LIDER COACH
		if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {
			$label_lider = "Líder Educador";
			$txt_estilo = "Os profissionais com este perfil revelam ótima capacidade para desenvolver pessoas (Capacidade de Acompanhamento) e geralmente conseguem estimular o potencial de sua equipe formando novos talentos. Contudo podem aprimorar sua habilidade para também motivar pessoas no intuito de atingir metas e objetivos. Todavia já revelam uma ótima habilidade de Liderança COACH.";
		}

		// LIDER Fiscal
		if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {
			$label_lider = "Líder Fiscal";
			$txt_estilo = "Os profissionais com este perfil são do tipo fiscalizadores que cobram sistematicamente de sua equipe as tarefas a serem desenvolvidas e geralmente não permitem que os mesmos expressem seu potencial. Revelam dificuldades para delegar e desenvolver pessoas inibindo o potencial do grupo.";
		}

		// LIDER Influenciador
		if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {
			$label_lider = "Líder Influenciador";
			$txt_estilo = "Os profissionais com este perfil apresentam forte capacidade para influenciar pessoas, pois sua Liderança Motivacional é acentuada. Em virtude deste estilo inspirador e contagiante algumas pessoas podem perder a iniciativa em sua ausência. Todavia, conseguem desenvolver pessoas e revelam ótima capacidade para promover e formar equipes.";
		}

		// LIDER Diretivo
		if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {
			$label_lider = "Líder Diretivo";
			$txt_estilo = "Os profissionais com este perfil apresentam facilidade para mobilizar pessoas revelando boa Liderança Motivacional. Contudo podem exceder na cobrança de resultados e metas inibindo o desenvolvimento da equipe. Também podem revelar dificuldades de delegação.";
		}

		// LIDER Excï¿½ntrico
		if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {
			$label_lider = "Líder Excêntrico";
			$txt_estilo = "Os profissionais com este perfil são muito intensos e tanto apresentam forte Liderança Mobilizadora como cobram em excesso da equipe podendo inibir seu potencial. Este tipo de comportamento pode dificultar o aprendizado e o crescimento do grupo, que ora sente-se estimulado e ou intensamente cobrado.";
		}

		// LIDER Motivador
		if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {
			$label_lider = "Líder Motivador";
			$txt_estilo = "Os profissionais com este perfil conseguem mobilizar as pessoas para atingir metas e objetivos, mas ainda não sabem como desenvolver sua equipe, talvez por ainda desconhecerem como adotar a postura de Líder Treinador.";
		}

		// LIDER Analista/ Em desenvolvimento
		if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {
			$label_lider = "Em desenvolvimento";
			$txt_estilo = "Os profissionais com este perfil ainda não assumem a postura de liderança, talvez por não terem interesse em desenvolver esta competência, ou por nunca terem sido estimulados para tal. ";
		}

		// CALCULO ESTILO PROF

		// Arrey com todas as mï¿½dias
		$final = array();

		// Buscando notas Base 10
		$i = 0;
		while ($i < 20) {
			$competencias10[$i] = base10(($i + 1), $competencias[$i]);
			$i++;
		}

		//print_r($competencias10);

		//ESTILO NEGOCIADOR
		$total_nota = 0;
		$total_nota += $competencias10[0] + $competencias10[4] + $competencias10[13] + $competencias10[14]  + $competencias10[15] + $competencias10[16];
		//print_r($competencias10);
		//echo $total_nota;
		array_push($final, ($total_nota / 6));
		$nota_negociador = $total_nota / 6;
		$nota_negociador = number_format($nota_negociador, 1, '.', '');

		//ESTILO Executor
		$total_nota = 0;
		$total_nota += $competencias10[7];
		$total_nota += $competencias10[8];
		$total_nota += $competencias10[10];
		$total_nota += $competencias10[18];
		$total_nota += $competencias10[19];
		array_push($final, ($total_nota / 5));
		$nota_executor = $total_nota / 5;
		$nota_executor = number_format($nota_executor, 1, '.', '');

		//ESTILO Mobilizador
		$total_nota = 0;
		$total_nota += $competencias10[2] + $competencias10[3] + $competencias10[4] +  $competencias10[5] +  $competencias10[6];
		array_push($final, ($total_nota / 5));
		//print_r($competencias10);
		//echo $total_nota;
		$nota_mobilizador = $total_nota / 5;
		$nota_mobilizador = number_format($nota_mobilizador, 1, '.', '');

		//ESTILO Analista
		$total_nota = $competencias10[0] +  $competencias10[1] + $competencias10[12];	
		//echo $total_nota / 3;
		
		
		array_push($final, ($total_nota / 3));
		$nota_analista = $total_nota / 3;
		$nota_analista = number_format($nota_analista, 1, '.', '');

		//ESTILO Inovador
		$total_nota = 0;
		$total_nota += $competencias10[9];
		$total_nota += $competencias10[10];
		$total_nota += $competencias10[11];
		array_push($final, ($total_nota / 3));
		$nota_inovador = $total_nota / 3;
		$nota_inovador = number_format($nota_inovador, 1, '.', '');

		// Pegando maior item no array
		$maior_item_array = max($final);

		//Pega a chame do maior item
		$numero_perfil = array_search($maior_item_array, $final);

		switch ($numero_perfil) {
			case 0 :
				$label_perfil = "Negociador";
				break;
			case 1 :
				$label_perfil = "Produtor";
				break;
			case 2 :
				$label_perfil = "Mobilizador";
				break;
			case 3 :
				$label_perfil = "Analista";
				break;
			case 4 :
				$label_perfil = "Inovador";
				break;
		}

		$notamedia = 0;
		$i = 0;
		while ($i < 20) {
			$nota110 = base10(($i + 1), $competencias[$i]);
			$notamedia += $nota110;
			$i++;
		}

		$indice_geral = $notamedia / 20;
	?>
<br/><br/>
<table width="750" align="center">
<tr width="750">
<td colspan="5" width="400" class="titulo_estilo" style="font-size: 16px;"> DEFINIÇÕES DOS ESTILOS PROFISSIONAIS APP®</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify" >
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Negociador</strong> - Revela habilidade de relacionamento interpessoal, convive bem em grupos

e estabelece bom relacionamento afetivo, separando relações pessoais de profissionais.

Comunica-se com clareza e objetividade e procura se fazer entender para atingir seus

objetivos. Gerencia bem suas emoções tanto em situações tensas como nos impasses do

dia a dia. É um profissional que aprecia trabalhar com pessoas. Geralmente revelam

grande aptidão para trabalhar em  <strong>áreas comerciais e/ou de vendas.</strong>
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Produtor</strong> - - Apresenta alta produtividade no atingimento de suas metas ou na execução de

suas tarefas. Consegue trabalhar bem com prazos e pressão de tempo e aprecia muito

atingir suas metas. Confia em seu potencial

profissionais que possuem identidade com <strong>atividades que exijam rapidez no cumprimento de prazos e imprevistos. </strong>
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Mobilizador</strong> - R- Revela grande habilidade para obter resultados por meio das pessoas e

aprecia gerenciar e mobilizar as pessoas para atingir metas e objetivos. Estimula e

promove o desenvolvimento das equipes sob sua responsabilidade e delega com

facilidade. Confia em seu potencial e sabe tomar decisões com assertividade sem se

omitir ou se precipitar. Geralmente ascendem rapidamente nas empresas <strong>assumindo

posições de liderança</strong>, pois conseguem conquistar seguidores facilmente.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify" >
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Analista</strong> - Revela um perfil de análise e planejamento e interessa-se mais por atividades

em que possa lidar com detalhes e concentração. Prefere ser orientado do que liderar e

necessita de direcionamento para a execução de suas tarefas. Revelam aderência por 

<strong>atividades de assessoria e suporte</strong>.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Inovador</strong> - 
Revela interesse por atividades em que possa ter liberdade para expressar

suas ideias e opiniões. Prefere trabalhos sem rotinas ou rigor excessivo, pois a

necessidade permanente de mudança é inerente ao seu perfil. Geralmente <strong>são pessoas

mais criativas e inventivas</strong> e têm aversão a situações burocráticas. Lidam bem com

imprevistos sem se estressar e se adaptam facilmente a novas situações.
</p>
</td>
</tr>
</table>

<br/><br/>
<table width="400" align="center">
<tr>
<td colspan="5" class="titulo_estilo" style="font-size: 16px;"> Suas Notas do Estilo APP®</td>
</tr>
<tr>
<td class="titulo_estilo" style="font-size: 12px;">Negociador</td>
<td class="titulo_estilo" style="font-size: 12px;">Produtor</td>
<td class="titulo_estilo" style="font-size: 12px;">Mobilizador</td>
<td class="titulo_estilo" style="font-size: 12px;">Analista</td>
<td class="titulo_estilo" style="font-size: 12px;">Inovador</td>
</tr>
<tr>
<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_negociador; ?></td>
<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_executor; ?></td>
<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_mobilizador; ?></td>
<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_analista; ?></td>
<td class="titulo_rotulo" style="font-size: 12px;"><?=$nota_inovador; ?></td>
</tr>
</table>
<br/><br/>
<table width="300" align="center">
<!--
<tr>
<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;Estilo Profissional&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
<td class="titulo_rotulo" height="30" align="center" valign="middle">
&nbsp;&nbsp;&nbsp;<?=$label_perfil;?>&nbsp;&nbsp;
</td>
</tr>
-->
<tr>
<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;Seu índice Geral&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;<?=$indice_geral; ?>&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
<br/><br/>
<table width="600" align="center">
<tr>
	<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;ÍNDICE DE ADEQUAÇÃO AOS CARGOS&nbsp;&nbsp;&nbsp;</td>
	<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;ÍNDICE MÉDIO&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;INÍCIO DE CARREIRA&nbsp;&nbsp;&nbsp;</td>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;5,0 a 6,0&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;ENCARREGADO / ANALISTA&nbsp;&nbsp;&nbsp;</td>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;6,0 a 7,0&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;GERENTES&nbsp;&nbsp;&nbsp;</td>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;7,0 a 8,0&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;DIRETOR&nbsp;&nbsp;&nbsp;</td>
	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;8,0 a 9,0&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>



<br/><br/>






</div>

<!-- PAGINA 7 -->
<br/>
<div class="pagina">
<div id="cabecalho">
<img src="logo_appweb3.jpg" style="float: left; margin-top: 15px; margin-left: 15px; " />
<table class="tabela">
<tr>
<td width="265"><span>Nome: </span> <?=$dados_pessoa["nome"]; ?></td>
<td width="265"><span>CPF: </span> <?=mask($dados_pessoa["cpf"], '###.###.###-##'); ?></td>
</tr>
<tr>
<td width="265"><span>Cargo: </span> <?=$dados_pessoa["cargo"]; ?></td>
<td width="265"><span>Nasc.: </span> <?=$dados_pessoa["nasc"]; ?></td>
</tr>
<tr>
<td width="265">&nbsp;</td>
<td width="265"><span>Respondido em: </span> <?=$pdata_aplic; ?></td>
</tr>
</table>
</div>


<br/><br/>
<p align="center;">
	<img src="GRAFICO.jpg" width="340" align="center" >
</p>	

<table align="center">
	<tr>
		<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;Seu Estilo de Liderança&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;<?=$label_lider; ?>&nbsp;&nbsp;&nbsp;</td>
	</tr>
</table>

<br/><br/>


<table width="750" align="center">
<tr width="750">
<td colspan="5" width="400" class="titulo_estilo" style="font-size: 16px;"> ESTILOS APP® DE LIDERANÇA</td>
</tr>
<tr width="780">
<td class="titulo_rotulo" width="630" style="font-size: 10px;" align="justify" >
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Integral</strong> - Os profissionais que revelam este perfil apresentam boa capacidade

de Liderança Motivacional (Estilo de Liderança) e também facilidade para 

desenvolver pessoas (Capacidade de Acompanhamento). Geralmente conseguem 

motivar sua equipe para atingir metas e objetivos e também estimulam o potencial das 

pessoas promovendo o seu desenvolvimento e revelando alguns potenciais, assumindo 

o verdadeiro papel de Líder COACH.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Carismático</strong> - Os profissionais com este perfil geralmente conseguem motivar

as pessoas para atingir os desafios, e possuem uma forte liderança inspiradora, contudo 

podem estar depositando muita energia nesta competência e faltando habilidade para 

desenvolver pessoas (Capacidade de Acompanhamento). Geralmente são excelentes 

líderes motivacionais, mas precisam também desenvolver sua Liderança COACH.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Educador</strong> - Os profissionais com este perfil revelam ótima capacidade para

desenvolver pessoas (Capacidade de Acompanhamento) e geralmente conseguem 

estimular o potencial de sua equipe formando novos talentos. Contudo podem 

aprimorar sua habilidade para também motivar pessoas no intuito de atingir metas e 

objetivos. Todavia já revelam uma ótima habilidade de Liderança COACH.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify" >
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Fiscal</strong> - Os profissionais com este perfil são do tipo fiscalizadores que cobram

sistematicamente de sua equipe as tarefas a serem desenvolvidas e geralmente não 

permitem que os mesmos expressem seu potencial. Revelam dificuldades para delegar 

e desenvolver pessoas inibindo o potencial do grupo.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Influenciador</strong> - 
Os profissionais com este perfil apresentam forte capacidade

para influenciar pessoas, pois sua Liderança Motivacional é acentuada. Contudo, conseguem desenvolver pessoas e revelam ótima capacidade para promover e formar sua equipe.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Diretivo</strong> - 
Os profissionais com este perfil apresentam facilidade para mobilizar

pessoas revelando ótima Liderança Motivacional. Contudo podem exceder na 

cobrança de resultados e metas inibindo o desenvolvimento da equipe. Também 

podem revelar dificuldades de delegação.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Excêntrico</strong> - 
Os profissionais com este perfil são muito intensos e tanto

apresentam forte Liderança Mobilizadora como cobram em excesso da equipe 

podendo inibir seu potencial. Este tipo de comportamento dúbio pode dificultar o

aprendizado e o crescimento do grupo, que ora sentem-se estimulados e ou

intensamente cobrados.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Líder Motivador</strong> - Os profissionais com este perfil conseguem mobilizar as pessoas

para atingir metas e objetivos, mas ainda não sabem como desenvolver sua equipe, 

talvez por ainda desconhecerem como adotar a postura de Líder Treinador.
</p>
</td>
</tr>
<tr width="750">
<td class="titulo_rotulo" width="600" style="font-size: 10px;" align="justify">
<p style="text-align: justify !important; margin: 0 0 0 0 0;">
<strong>Em desenvolvimento</strong> - Os profissionais com este perfil ainda não assumem a postura

de liderança, talvez por não terem interesse em desenvolver esta competência, ou por 

nunca terem sido estimulados para tal.
</p>
</td>
</tr>
</table>

<br/><br/>


</div>

</body>
</html>

<?
	function base102($pCompentencia, $pNota) {

		$sql = "
SELECT f.descricao, f.base10
FROM  feedbacks f, competencias c
WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;

		//EXECUTA A QUERY
		$sql = mysql_query($sql);
		$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");

		return $a = mysql_result($sql, 0, "base10");

	}
?>