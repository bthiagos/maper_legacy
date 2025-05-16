
<?
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
?>
<?
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}
?>
<? include("functions.php");?>
<?php
/*

# NOVO RELATÓRIO DE RESULTADOS MAPER
Desenvolvedor: Sérgio Monteiro Júnior
Data: 19/09/2022

*/
?>
<?php
// # INICIO | CONEXÃO COM BANCO DE DADOS

$conn = mysqli_connect("167.99.177.121", "mysqladmin", "5kKMvHDeY0L5", "appweb_sistema");
 
if (!$conn) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// # FIM | CONEXÃO COM BANCO DE DADOS

$dados_teste = array();
$array_ideais = array();


// # INICIO | BUSCANDO INFORMAÇÕES DO CANDIDATO

//Capiturando ID da aplicação via GET
if ($_REQUEST['id']) {
    $id_aplicacao = $_REQUEST['id'];
}

// Query
$query = "
        SELECT
          aplicacoes.id, 
          aplicacoes.nome, 
          aplicacoes.cpf, 
          aplicacoes.nasc, 
          aplicacoes.organizacao, 
          aplicacoes.grupo, 
          aplicacoes.cargo, 
          aplicacoes.tempo, 
          aplicacoes.respostas, 
          aplicacoes.data_aplic, 
          aplicacoes.status_envio, 
          aplicacoes.pesos, 
          aplicacoes.descricao, 
          aplicacoes.ticket, 
          aplicacoes.sexo, 
          aplicacoes.grupo2, 
          aplicacoes.id_perfil, 
          aplicacoes.lang, 
          aplicacoes.aplicativo, 
          aplicacoes.facebook_id,
          organizacoes.id as 'id_organizacao',  
          organizacoes.nome as 'nome_organizacao', 
          grupos.nome as 'nome_grupo'
        FROM
          aplicacoes
          INNER JOIN
          organizacoes
          ON 
            aplicacoes.organizacao = organizacoes.id
          INNER JOIN
          grupos
          ON 
            aplicacoes.grupo = grupos.id
        WHERE
          aplicacoes.cpf = $id_aplicacao
        ORDER BY id DESC LIMIT 1
";


// Rodando a Query
$result = mysqli_query($conn, $query);

// Pegando as informações do candidato no banco
while ($linha = $result->fetch_assoc()) {
    
    $id_candidado = $linha["id"];
    $nome_candidato = $linha["nome"];
    $cpf_candidato = $linha["cpf"];
    $organizacao_candidato = $linha["nome_organizacao"];
    $grupo_candidato = $linha["nome_grupo"];
    $datanascimento_candidato = date('d/m/Y', strtotime($linha["nasc"]));
    $datateste_candidato = date('d/m/Y', strtotime($linha["data_aplic"]));
    $cargo_candidato = $linha["cargo"];
    $org = $linha["id_organizacao"];

    // Respostas do Candidato
    $pGabarito = $linha["respostas"];

    $dados_teste["nome"]  =  utf8_encode($nome_candidato);
    $dados_teste["data_aplicacao"]  =  utf8_encode($datateste_candidato);
    $dados_teste["cargo"]  =  utf8_encode($cargo_candidato);

}
// # FIM | BUSCANDO INFORMAÇÕES DO CANDIDATO



// # INICIO | BUSCANDO INFORMAÇÕES DE COMPETÊNCIAS E NOTAS
$lang ="";
$complang = "";
if($lang == "en" or $lang == "es") { $complang = "_".$lang; }
$i = $j = $total = 0;
$login = 0;
$Opcao = "";
$id_competencia = "";
$sql = "";
$row = "";
$competencias = array();
$nome_competencias[20] = array();
$i = 0;


while ($i < 20) {
  $competencias[$i] = 0;
  $i++;
}



if (strlen($pGabarito) == 100) {

  $sql = "
          SELECT c.descricao,c.descricao_en,c.descricao_es
          FROM  competencias c
          ORDER BY c.ordem
        ";

  //EXECUTA A QUERY
  $sql = mysqli_query($conn,$sql);
  $row = mysqli_num_rows($sql) or die("erro na busca dos nomes das competÃªncias");

  for ($i = 0; $i < $row; $i++) {
    $nome_competencias[$i] = mysqli_result($sql, $i, "descricao".$complang);
  }

  

$string_competencias = implode("|", $nome_competencias);

  $i = 0;
  while ($i < 100) {
    $Opcao = $pGabarito[$i];

    if (strcmp($Opcao, "a") || strcmp($Opcao, "b")) {

      //QUERY

      $sql = " 
              SELECT c.ordem 
              FROM  questoes q, competencias c
              WHERE q.competencia_id=c.competencias_id and q.ordem = " . ($i + 1) . " and q.sequencia like \"" . $Opcao . "\"";

      $sql = mysqli_query($conn,$sql);
      $row = mysqli_num_rows($sql) or die("erro na busca das questões");
      $id_competencia = mysqli_result($sql, 0, "ordem");
      $competencias[$id_competencia - 1]++;

    }//fim do if

    $i++;

  } //fim do while

}//fim do if

$i = 0;
$notas_base10 = array();
$num = 0;
while ($i < 20) {
  $liberado = true;
  if($org == 324 || $org == 487) {
    //if($i == 9) {
    //  $liberado = false;
    //}
  }

  if($liberado) {
    $notas_base10[$num] = base102(($i + 1), $competencias[$i],$conn);
    
    $num++;
  }
  $i++;
}
$i=0; 



// Buscando Notas Ideais

for ($i = 1; $i <= 20; $i++) {
     $array_ideais[$i] = ideal_jason($i, $conn);
}


// Classificação das competência como Sustentação, aceitavel e Critico
$i = 0;
//$datax = array();
$tabela_critico = $tabela_aceitavel = $tabela_sustencao = array();
while ($i<20) {

    //echo $competencias[$i];

    $nota110 = base10(($i+1),$competencias[$i],$conn);
    if ($nota110 <= 4) {
      $tabela_critico[] = $nome_competencias[$i];
    }

    if ($nota110 >= 5 and $nota110 <= 6) {
      $tabela_aceitavel[] = $nome_competencias[$i];
    }

    if ($nota110 >= 7) {
      $tabela_sustencao[] = $nome_competencias[$i];
    } 

    $i++;
}

// Calculo indice geral
$notamedia = 0;
$i = 0;

while ($i < 20) {

  $nota110 = base10(($i + 1), $competencias[$i],$conn);
  $notamedia += $nota110;

  $i++;

}



$indice_geral = $notamedia / 20;



//print_r($competencias);


// Estilos Estilos

  // Buscando notas Base 10
  $competencias10 = $final = array();
  $i = 0;

  while ($i < 20) {

    $competencias10[$i] = base10(($i + 1), $competencias[$i],$conn);

    /*
    if($org == 324 || $org == 487) {
      //elimina comp Criatividade
      //if($i == 9) { $competencias10[$i] = 0; }
    }
    */

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

  $stringnota = "";

  $total_nota = 0;

  $total_nota += $competencias10[9];
  $total_nota += $competencias10[10];
  $total_nota += $competencias10[11];

  //echo "soma: $competencias10[9] + $competencias10[10] + $competencias10[11] <br>";
  //print_r($competencias10);

  array_push($final, ($total_nota / 3));

  $nota_inovador = $total_nota / 3;

  $nota_inovador = number_format($nota_inovador, 1, '.', '');


    $nota_competencia3 = $competencias[2];
    $nota_competencia4 = $competencias[3];

    if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

      $label_lider = "Líder Integral";
    }

    if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

      $label_lider = "Líder Carismático";
    }

    if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

      $label_lider = "Líder Educador";

    }

    if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

      $label_lider = "Líder Fiscal";

    }

    if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 5) && ($nota_competencia3 <= 7))) {

      $label_lider = "Líder Influenciador";

    }


    if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

      $label_lider = "Líder Diretivo";

    }


    if ((($nota_competencia4 >= 8) && ($nota_competencia4 <= 10)) && (($nota_competencia3 >= 8) && ($nota_competencia3 <= 10))) {

      $label_lider = "Líder Excêntrico";

    }


    if ((($nota_competencia4 >= 5) && ($nota_competencia4 <= 7)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

      $label_lider = "Líder Motivador";

    }

    if ((($nota_competencia4 >= 0) && ($nota_competencia4 <= 4)) && (($nota_competencia3 >= 0) && ($nota_competencia3 <= 4))) {

      $label_lider = "Em desenvolvimento";

    }


//Concatenendo notas:

$string_notas = implode("|", $competencias);
$string_ideais = implode("|", $array_ideais);
$notas_fim = "$id_candidado#$string_notas";

$string_competencias = str_replace("Array|","",$string_competencias);

$dados_teste["competencias"] = utf8_encode($string_competencias);
$dados_teste["notas"] = utf8_encode($string_notas);
$dados_teste["link_teste"] = "https://cms.mapertest.com.br/resultado/index.php?id=$id_candidado";
$dados_teste["ideais"] = $string_ideais;
$dados_teste["critico"] = utf8_encode(implode("-",$tabela_critico));
$dados_teste["aceitavel"] = utf8_encode(implode("-",$tabela_aceitavel));
$dados_teste["sustentacao"] = utf8_encode(implode("-",$tabela_sustencao));
$dados_teste["indice_geral"] = $indice_geral;
$dados_teste["nota_negociador"] = $nota_negociador;
$dados_teste["nota_executor"] = $nota_executor;
$dados_teste["nota_mobilizador"] = $nota_mobilizador;
$dados_teste["nota_analista"] = $nota_analista;
$dados_teste["nota_inovador"] = $nota_inovador;
$dados_teste["estilo_lideranca"] = utf8_encode($label_lider);

print_r($dados_teste);

echo json_encode($dados_teste);

?>

<?
mysqli_close($conn);
?>