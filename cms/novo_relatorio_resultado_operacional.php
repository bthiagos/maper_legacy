<?

include ("conn.php");

include ("library.php");



$id_aplicacao = $_REQUEST["id"];

require_once ('jpgraph/src/jpgraph.php');

require_once ('jpgraph/src/jpgraph_radar.php');



$lang = @$_GET["lang"];

if($lang != "br" and $lang != "en" and $lang != "es") { $lang = "br"; }

$nome_rel = urldecode($_GET["nome_relatorio"]);

$cabecalho["cabecalho_br"] = array("NOME","CARGO","CPF","NASCIMENTO","RESPONDIDO EM");

$cabecalho["cabecalho_en"] = array("NAME","JOB TITLE","CPF","BIRTH","ANSWERED IN");

$cabecalho["cabecalho_es"] = array("NOMBRE","TÍTULO PROFESIONAL","CPF","NACIMIENTO","CONTESTADO EN");

$cabecalho = $cabecalho["cabecalho_$lang"];



$theads["theads_br"] = array("Competência","Nota Ideal","Sua Nota");

$theads["theads_en"] = array("Competence","Ideal Rating","Your rating");

$theads["theads_es"] = array("Competencia","Nota Ideal","Su Nota");

$theads = $theads["theads_$lang"];



$complang = "";

if($lang == "en" or $lang == "es") { $complang = "_".$lang; }



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

       		SELECT c.descricao,c.descricao_en,c.descricao_es

       		FROM  competencias c

	   		ORDER BY c.ordem";



	//EXECUTA A QUERY

	$sql = mysql_query($sql);

	$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");



	for ($i = 0; $i < $row; $i++) {

		$nome_competencias[$i] = mysql_result($sql, $i, "descricao".$complang);

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



$i = 0;

$notas_base10 = array();

$num = 0;
while ($i < 20) {


	if($i != 2 && $i != 3 && $i != 5 && $i != 6 && $i != 9 && $i != 12 && $i != 15 && $i != 17 && $i != 18 && $i != 19) {
		$notas_base10[$num] = base102(($i + 1), $competencias[$i]);
		
		$num++;
	}
	$i++;
}
$i=0;


// ------------ GRAFICO RADAR



//$titles = array("Capacidade \nde planejamento", "Capacidade \nde organização", "Capacidade \nde acompanhamento", "Estilo \nde liderança", "Estilo \nde comunicação", "Tomada \nde decissão", "Capacidade \nde delegação", "Administração \ndo tempo", "Volume \nde trabalho", "Potencial\ncriativo\ne flexibilidade", "Cap. priorizar e\n trab. \nc/ imprevistos", "Gestão \nde mudanças", "Relacionamento \ncom superiores", "Gestão \nde\n conflitos", "Controle das\n emoções", "Relacionamento\n afetivo", "Relacionamento \nem grupos", "Imagem \npessoal", "Tônus\n vital", "Necessidade \nde\n realização");

$titles = array();

$comp_sql = mysql_query("SELECT * FROM competencias ORDER BY ordem ASC");



$c = 1;

$complang = "";

if($lang == "en" or $lang == "es") { $complang = "_".$lang; }

while($comp = mysql_fetch_array($comp_sql)) {

    $txt = $comp["descricao".$complang];

    $txt = preg_replace('/ /', "\n", $txt, 1);

    

    if($comp["competencias_id"] == 11 || $comp["competencias_id"] == 10 || $comp["competencias_id"] == 1) { 

         $txt = preg_replace('/ /', "\n", $txt, 3);

         $txt = preg_replace('/ /', "\n", $txt, 6);

    }

    array_push($titles,$txt);

    $c++;

}

$titles = array("Capacidade \nde planejamento", "Capacidade \nde organização", "Estilo \nde comunicação", "Administração \ndo tempo", "Volume \nde trabalho", "Capacidade de priorizar e\n trabalhar com imprevistos", "Gestão \nde mudanças", "Gestão \nde\n conflitos", "Controle das\n emoções", "Relacionamento \nem grupos");




//$titles=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");

$data = $notas_base10;


$graph = new RadarGraph(700, 800);



$titulo = "Avaliação de Perfil Profissional";

if($lang == "en") { $titulo = "Professional Profile Evaluation"; }

if($lang == "es") { $titulo = "Evaluación de Perfil Profesional"; }



$graph -> title -> Set($titulo);

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

$plot -> SetColor('#4eba98@0.2');

$plot -> SetLineWeight(1);

$plot -> SetFillColor('#4eba98@0.7');



$plot -> mark -> SetType(MARK_IMG_SBALL, 'green');



$graph -> Add($plot);

$mome = "radar_" . $id_aplicacao;

$graph -> Stroke('graficos/' . $mome . '.jpg');

?>



<?



$url3 = "http://cms.mapertest.com.br/teste_graf2.php?lang=".$lang."&id=" . $id_aplicacao . "&commit=$commit";

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



function feedback($pCompentencia, $pNota, $lang) {

    $campo = "descricao";

    if($lang == "en") { $campo = "descricao_en"; }

    if($lang == "es") { $campo = "descricao_es"; }

	$sql = " 

       		SELECT f.$campo

       		FROM  feedbacks f, competencias c

			WHERE c.competencias_id = f.competencia_id and c.ordem = " . $pCompentencia . " and f.nota = " . $pNota;



	//EXECUTA A QUERY

	$sql = mysql_query($sql);

	$row = mysql_num_rows($sql) or die("erro na busca dos nomes das competências");



	$pos = (mysql_result($sql, 0, $campo));

	return $pos;



}

?>

<?

// PEGANDO ID DA APLICAï¿½ï¿½O

//echo $dados_pessoa["organizacao"];



// RODAPE FGV

if (($dados_pessoa["organizacao"] == "418")) {

	$fgv = 1;

	$img_rodape = "appweb-editado.png";

} else {

	$img_rodape = "rosape-appweb-sem-logo.png";

	$fgv = 0;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
<link rel="shortcut icon" href="favicon.ico" />
<title>Mapertest - Avaliação de Potencial e Perfil Profissional</title>

<style type="text/css">

	.paginacao {
        display: block;
        text-align: left;
        color: #58479d; 
        position: absolute;
        bottom: 10px;
        left: 30px;
        font-size: 18px;

    }

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

		/*background-image: url(<?=$img_rodape;?>);*/

		background-image: url(img/img_footer.jpg);

		background-repeat: no-repeat;

		background-position: right bottom;

	}



	#cabecalho {

		width: 742px;

		height: 96px;

		background-image: url(img/topo_relatorio_img.jpg);
		background-repeat: no-repeat;
		background-position: center center;

		<? if ($fgv) { ?>

		background-image: url(logo-fgv-topo2.jpg); 

		background-repeat: no-repeat; 

		background-position: 10px right;  

		<? } ?>  

		<? if ($edel) { ?>

		background-image: url(logo_edel.png); 

		background-repeat: no-repeat; 

		background-position: 10px right;  

		<? } ?>   

		<? if ($horus) { ?>

		background-image: url(logo_horus.png); 

		background-repeat: no-repeat; 

		background-position: 10px right;  

		<? } ?> 

		<? if ($vocacional) { ?>

		background-image: url(logo_vocacional.jpg); 

		background-repeat: no-repeat; 

		background-position: 10px right;  

		<? } ?>   

		

	}



	.tabela {

		width: 470px;

		float: left;

		margin-left: 7px;

		margin-top: 17px;

	}



	.tabela tr td {

		font-family: Arial, Helvetica, serif;

		font-size: 12px;

		text-transform: uppercase;

		min-width: 230px;

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

		font-size: 14px;

		font-weight: bolder;

		color: #42bfb3;

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

		color: #59499e;

		text-align: center;

		float: right;

		padding: 6px 26px;

	}



	.titulotb {

		font-family: Arial, Helvetica, serif;

		font-size: 18px;

		color: #42bfb3;

	}

	.num_normal {

		color: #42bfb3;

	}

	.num_yellow {

		background-color: #42bfb3;

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

    

    .coluna_auzl_en {

		background-image: url(bg_azul_en.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

    

    .coluna_auzl_es {

		background-image: url(bg_azul_es.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

    

	.coluna_amarela {

		background-image: url(bg_amarelo.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

    

    .coluna_amarela_en {

		background-image: url(bg_amarelo_en.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

    

    .coluna_amarela_es {

		background-image: url(bg_amarelo_es.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

	.coluna_vermelho {

		background-image: url(bg_vermelho.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

    

    .coluna_vermelho_en {

		background-image: url(bg_vermelho_en.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}

    .coluna_vermelho_es {

		background-image: url(bg_vermelho_es.jpg);

		background-repeat: no-repeat;

		background-position: center top;

	}



	.titulo_estilo {

		background-color: #58479d;

		font-family: Arial, Helvetica, serif;

		font-size: 14px;

		color: #ffffff;

		text-align: center;

		text-transform: uppercase;

	}

	.titulo_rotulo {

		background-color: #e0d7eb;

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

<? include("novo_relatorio_topo.php"); ?>

		

		<table width="750" border="0" style="margin-top: 15px; margin-bottom: 15px;">

			<tr>

				<td width="350" class="titulotb"><strong><?=$theads[0]?></strong></td>

				<td width="270" class="titulotb"><strong><?=$theads[1]?></strong></td>

				<td width="130" align="center" class="titulotb"><strong><?=$theads[2]?></strong></td>

			</tr>

		</table><br/> 

		

		<table width="750" border="0" cellspacing="00">

			

  <?php

		$i = 0;
		$num = 1;

		$linha_arquivo = 1;

	//	echo "<p><b>CompetÃªncias:</b></p>";

		while ($i<20) { 

		//Remover 2,5,6,9,12,15,17,18,19
		if($i != 2 && $i != 3 && $i != 5 && $i != 6 && $i != 9 && $i != 12 && $i != 15 && $i != 17 && $i != 18 && $i != 19) {
		?>		

		  <tr>

		    <td width="670" class="titulo_competencia" nowrap="nowrap"><strong><? echo($num); ?> - <? echo $nome_competencias[$i]; ?></strong><span style="margin-left: 70px;" class="notas_ideias"><? ideal($i + 1); ?></span></td>

		    <td width="80">&nbsp;</td>

		  </tr>

		  <tr>

		    <td width="620" class="txt_feedback"><? echo feedback(($i + 1), $competencias[$i], $lang); ?><br/><br/></td>

		    <td align="center" class="nota_pessoa"><strong><? echo $competencias[$i]; ?></strong></td>

		  </tr>

		  

		  

		<?
			$num++;
				} 
				$i++;
			}

		?>

		  

	  

		  

		</table>

		

	</div>

	

	


	<!-- PAGINA 4 -->

	<br/>

	<div class="pagina">	

<? include("novo_relatorio_topo.php"); ?>



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

<? include("novo_relatorio_topo.php"); ?>



		<p class="txt_explica">

        <?

        $explicacao = 'A tabela a seguir possui 3 colunas sendo Sustentação, Aceitável e Crítico.<br />

		Por "Sustentação" entenda pelos "pontos fortes" do candidato / profissional que remetem aos fatores de excelência.<br />

		Na segunda coluna, compreenda que são os fatores aceitáveis, ou seja, estão adequados mas podem evoluir mais. <br />

		Por último, os fatores críticos sugerem as competências que podem prioritariamente ser trabalhadas.<br /><br /> 

		É importante lembrar que essa é uma classificação generalizada e deve ser adequada às competências organizacionais, portanto, ao perfil de cada cargo.';

        

        if($lang == "en") {

        $explicacao = 'The following table has 3 columns and Support, Acceptable and Critical. <br />

        By "Sustainable" is meant by the "strengths" of the candidate referring to excellence factors. <br />

        In the second column comprises factors that are acceptable, ie they are more suitable may evolve. <br />

        Finally, the critical factors suggest the skills that can primarily be worked. <br /> <br />

        It is important to remember that this is a general classification and shall be appropriate to organizational skills, so the profile of each post.';

        }

        

        if($lang == "es") {

        $explicacao = 'La siguiente tabla tiene 3 columnas y soporte técnico, Aceptable y Crítica. <br />

        Por "Sustentable" se entiende por los "puntos fuertes" del candidato se refieren a factores de excelencia. <br />

        En la segunda columna comprende factores que son aceptables, es decir, son más adecuados pueden evolucionar. <br />

        Por último, los factores críticos sugieren las habilidades que principalmente se pueden trabajar. <br /> <br />

        Es importante recordar que esta es una clasificación general y deberá ser adecuado a la capacidad de organización, por lo que el perfil de cada puesto.';

        

        }

        

        echo $explicacao;

        

        ?>

        

		

		</p>

		

		

		<p style="margin-top: 10px; margin-left: 25px;">

			<?include ("tabela2_novo_operacional.php");?>

		</p>

		





		<?

		// ESTILO LIDER

		$nota_competencia3 = $competencias[2];

		$nota_competencia4 = $competencias[3];



		// LIDER INTEGRAL

		if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

			$label_lider = "Líder Integral";

			$txt_estilo = "Professionals who reveal this profile have a good capacity Motivational Leadership (Leadership Style) and also easy to develop people (Support Capacity). Usually can motivate your team to achieve goals and objectives and also stimulate the potential of people promoting their development and revealing some potential, assuming the true role of Leader COACH.";

		

            if($lang == "en") {

                $label_lider = "Integral Leader";

		      	$txt_estilo = "Los profesionales que revelan este perfil tienen una buena capacidad de Liderazgo Motivacional (Estilo de Liderazgo) y también es fácil de desarrollar personas (apoyo a la capacidad). Por lo general, puede motivar a su equipo para lograr las metas y objetivos, y también estimular el potencial de las personas promoviendo su desarrollo y que revela un cierto potencial, asumiendo el verdadero papel de COACH Líder.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Integral";

		      	$txt_estilo = "Os profissionais que revelam este perfil apresentam boa capacidade de Liderança Motivacional (Estilo de Liderança) e também facilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente conseguem motivar sua equipe para atingir metas e objetivos e também estimulam o potencial das pessoas promovendo o seu desenvolvimento e revelando alguns potenciais, assumindo o verdadeiro papel de Líder COACH.";

            }

        }



		// LIDER CARISMETICO

		if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

			$label_lider = "Líder Carismático";

			$txt_estilo = "Os profissionais com este perfil geralmente conseguem motivar as pessoas para atingir os desafios, e possuem uma forte liderança inspiradora, contudo podem estar depositando muita energia nesta competï¿½ncia e faltando habilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente são excelentes Líderes motivacionais, mas precisam também desenvolver sua Liderança COACH. ";

		

            if($lang == "en") {

                $label_lider = "Charismatic leader";

		      	$txt_estilo = "Professionals with this profile usually can motivate people to achieve the challenges, and have a strong inspirational leadership, but may be deposited much energy in this competï¿½ncia and lacking ability to develop people (Support Capacity). Usually are excellent motivational leaders, but also need to develop their leadership COACH.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder carismático";

		      	$txt_estilo = "Los profesionales con este perfil por lo general puede motivar a la gente para lograr los retos, y tienen un fuerte liderazgo inspirador, pero pueden ser depositado mucha energía en este competï¿½ncia y la capacidad que carecen de desarrollar personas (Apoyo Capacity). Por lo general son excelentes líderes de motivación, pero también tienen que desarrollar su entrenador liderazgo.";

            }

        }



		// LIDER COACH

		if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

			$label_lider = "Líder Educador";

			$txt_estilo = "Os profissionais com este perfil revelam ótima capacidade para desenvolver pessoas (Capacidade de Acompanhamento) e geralmente conseguem estimular o potencial de sua equipe formando novos talentos. Contudo podem aprimorar sua habilidade para também motivar pessoas no intuito de atingir metas e objetivos. Todavia já revelam uma ótima habilidade de Liderança COACH.";

		

            if($lang == "en") {

                $label_lider = "Educator Leader";

		      	$txt_estilo = "Professionals with this profile shows great ability to develop people (Support Capacity) and often can stimulate the potential of your team forming new talent. However can improve their ability to also motivate people in order to achieve goals and objectives. However already show a great ability to COACH Leadership.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Educador";

		      	$txt_estilo = "Los profesionales con este perfil muestra una gran capacidad para desarrollar a las personas (Apoyo capacidad) y con frecuencia puede estimular el potencial de su equipo de formación de nuevos talentos. Sin embargo, pueden mejorar su capacidad para motivar a la gente también con el fin de alcanzar las metas y objetivos. Sin embargo ya muestran una gran habilidad para COACH Liderazgo.";

            }

        }



		// LIDER Fiscal

		if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

			$label_lider = "Líder Fiscal";

			$txt_estilo = "Os profissionais com este perfil são do tipo fiscalizadores que cobram sistematicamente de sua equipe as tarefas a serem desenvolvidas e geralmente não permitem que os mesmos expressem seu potencial. Revelam dificuldades para delegar e desenvolver pessoas inibindo o potencial do grupo.";

		

            if($lang == "en") {

                $label_lider = "Fiscal Leader";

		      	$txt_estilo = "Professionals with this profile are the inspection type that systematically charge of their team tasks to be developed and generally do not allow them to express their potential. Reveal difficulties to delegate and develop people by inhibiting the group's potential.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Fiscal";

		      	$txt_estilo = "Los profesionales con este perfil son el tipo de inspección que cobran sistemáticamente de sus tareas del equipo a desarrollar y generalmente no les permitan expresar su potencial. Revelar las dificultades a delegado y desarrollar a las personas mediante la inhibición potencial del grupo.";

            }

        }



		// LIDER Influenciador

		if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

			$label_lider = "Líder Influenciador";

			$txt_estilo = "Os profissionais com este perfil apresentam forte capacidade para influenciar pessoas, pois sua Liderança Motivacional é acentuada. Em virtude deste estilo inspirador e contagiante algumas pessoas podem perder a iniciativa em sua ausência. Todavia, conseguem desenvolver pessoas e revelam ótima capacidade para promover e formar equipes.";

		

            if($lang == "en") {

                $label_lider = "Influencer Leader";

		      	$txt_estilo = "Professionals with this profile have strong ability to influence people, for his Leadership Motivational is sharp. Because of this inspiring and contagious style some people may lose the initiative in his absence. However, people can develop and show great ability to promote and build teams.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Influenciador";

		      	$txt_estilo = "Los profesionales con este perfil tienen una fuerte capacidad de influir en las personas, por su motivación liderazgo es agudo. Debido a este estilo inspirador y contagioso algunas personas pueden perder la iniciativa en su ausencia. Sin embargo, las personas pueden desarrollar y demostrar una gran capacidad para promover y construir equipos.";

            }

        }



		// LIDER Diretivo

		if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

			$label_lider = "Líder Diretivo";

			$txt_estilo = "Os profissionais com este perfil apresentam facilidade para mobilizar pessoas revelando boa Liderança Motivacional. Contudo podem exceder na cobrança de resultados e metas inibindo o desenvolvimento da equipe. Também podem revelar dificuldades de delegação.";

		

            if($lang == "en") {

                $label_lider = "Directive Leader";

		      	$txt_estilo = "Professionals with this profile have facility to mobilize people revealing Leadership Motivational good. However may exceed the collection of results and goals inhibiting the development team. They can also reveal delegation of difficulties.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Directivo";

		      	$txt_estilo = "Los profesionales con este perfil tienen facilidad para movilizar a las personas que revelan motivación de la dirección buena. Sin embargo podrá ser superior al conjunto de resultados y metas que inhiben el equipo de desarrollo. También pueden revelar delegación de dificultades.";

            }

        }



		// LIDER Excï¿½ntrico

		if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

			$label_lider = "Líder Excêntrico";

			$txt_estilo = "Os profissionais com este perfil são muito intensos e tanto apresentam forte Liderança Mobilizadora como cobram em excesso da equipe podendo inibir seu potencial. Este tipo de comportamento pode dificultar o aprendizado e o crescimento do grupo, que ora sente-se estimulado e ou intensamente cobrado.";

		

            if($lang == "en") {

                $label_lider = "Eccentric Leader";

		      	$txt_estilo = "Professionals with this profile are very intense and both have strong Mobilizing Leadership Team as charge in excess may inhibit their potential. This type of behavior can hinder learning and the growth of the group, which sometimes feels stimulated and/or intensely charged.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Excéntrico";

		      	$txt_estilo = "Los profesionales con este perfil son muy intenso y ambos tienen un fuerte equipo de liderazgo Movilizador como carga en exceso puede inhibir su potencial. Este tipo de comportamiento puede dificultar el aprendizaje y el crecimiento del grupo, que ahora se siente estimulada e/o intensamente cargada.";

            }

        }



		// LIDER Motivador

		if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

			$label_lider = "Líder Motivador";

			$txt_estilo = "Os profissionais com este perfil conseguem mobilizar as pessoas para atingir metas e objetivos, mas ainda não sabem como desenvolver sua equipe, talvez por ainda desconhecerem como adotar a postura de Líder Treinador.";

		

            if($lang == "en") {

                $label_lider = "Motivating Leader";

		      	$txt_estilo = "Professionals with this profile can mobilize people to achieve goals and objectives, but do not know how yet to develop your team, perhaps even unaware of how to adopt the Coach Leader posture.";

            }

            

            if($lang == "es") {

                $label_lider = "Líder Motivador";

		      	$txt_estilo = "Los profesionales con este perfil pueden movilizar a las personas para lograr las metas y objetivos, pero no saben cómo todavía para desarrollar su equipo, tal vez ni siquiera es consciente de cómo adoptar la postura Líder Coach.";

            }

        }



		// LIDER Analista/ Em desenvolvimento

		if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

			$label_lider = "Em desenvolvimento";

			$txt_estilo = "Os profissionais com este perfil ainda não assumem a postura de liderança, talvez por não terem interesse em desenvolver esta competência, ou por nunca terem sido estimulados para tal.";

		

            if($lang == "en") {

                $label_lider = "In development";

		      	$txt_estilo = "Professionals with this profile not take the leadership position, perhaps have no interest in developing this competence or because they were never encouraged to do so.";

            }

            

            if($lang == "es") {

                $label_lider = "En desarrollo";

		      	$txt_estilo = "Los profesionales con este perfil no tomar la posición de liderazgo, tal vez no tienen ningún interés en el desarrollo de esta competencia o porque nunca se les anima a hacerlo.";

            }

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

                if($lang == "en") {

                    $label_perfil = "Negotiator";   

                }

                if($lang == "es") {

                    $label_perfil = "Negociador";   

                }

				break;

			case 1 :

				$label_perfil = "Produtor";

                if($lang == "en") {

                    $label_perfil = "Producer";   

                }

                if($lang == "es") {

                    $label_perfil = "Productor";   

                }

				break;

			case 2 :

				$label_perfil = "Mobilizador";

                if($lang == "en") {

                    $label_perfil = "Mobilizer";   

                }

                if($lang == "es") {

                    $label_perfil = "Movilizador";   

                }

				break;

			case 3 :

				$label_perfil = "Analista";

                if($lang == "en") {

                    $label_perfil = "Analyst";   

                }

                if($lang == "es") {

                    $label_perfil = "Analista";   

                }

				break;

			case 4 :

				$label_perfil = "Inovador";

                if($lang == "en") {

                    $label_perfil = "Innovator";   

                }

                if($lang == "es") {

                    $label_perfil = "Innovador";   

                }

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

<table width="300" align="center">

<tr>

<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

<?

$desc = "Seu Índice Geral";

if($lang == "en") { $desc = "Your General Index"; }

if($lang == "es") { $desc = "Su Índice General"; }

echo $desc;

?>

&nbsp;&nbsp;&nbsp;</td>

</tr>

<tr>

<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;<?=$indice_geral; ?>&nbsp;&nbsp;&nbsp;</td>

</tr>

</table>

<br/><br/>



<table width="600" align="center">

<tr>

	<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "ÍNDICE DE ADEQUAÇÃO AOS CARGOS";

    if($lang == "en") { $desc = "ROLE ADEQUATION INDEX"; }

    if($lang == "es") { $desc = "ÍNDICE DE ADECUACIÓN A POSICIONES"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

	<td class="titulo_estilo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "ÍNDICE MÉDIO";

    if($lang == "en") { $desc = "AVERAGE INDEX"; }

    if($lang == "es") { $desc = "ÍNDICE PROMEDIO"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

</tr>

<tr>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "INÍCIO DE CARREIRA";

    if($lang == "en") { $desc = "CAREER START"; }

    if($lang == "es") { $desc = "INICIO DE CARRERA"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;5,0 a 6,0&nbsp;&nbsp;&nbsp;</td>

</tr>

<tr>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "ASSISTENTE / ANALISTA";

    if($lang == "en") { $desc = "REPONSIBLE / ANALYST"; }

    if($lang == "es") { $desc = "A CARGO / ANALISTA"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;6,0 a 7,0&nbsp;&nbsp;&nbsp;</td>

</tr>
<!--
<tr>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "GERENTES";

    if($lang == "en") { $desc = "MANAGERS"; }

    if($lang == "es") { $desc = "GERENTES"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;7,0 a 8,0&nbsp;&nbsp;&nbsp;</td>

</tr>

<tr>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;

    <?

    $desc = "DIRETOR";

    if($lang == "en") { $desc = "DIRECTOR"; }

    if($lang == "es") { $desc = "DIRECTOR"; }

    echo $desc;

    ?>

    &nbsp;&nbsp;&nbsp;</td>

	<td class="titulo_rotulo" height="30" align="center" valign="middle">&nbsp;&nbsp;&nbsp;8,0 a 9,0&nbsp;&nbsp;&nbsp;</td>

</tr>
-->
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