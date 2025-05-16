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
          aplicacoes.id = $id_aplicacao
";

// Rodando a Query
$result = mysqli_query($conn, $query);

// Pegando as informações do candidato no banco
while ($linha = $result->fetch_assoc()) {
    
    $nome_candidato = $linha["nome"];
    $cpf_candidato = utf8_encode($linha["cpf"]);
    $organizacao_candidato = utf8_encode($linha["nome_organizacao"]);
    $grupo_candidato = utf8_encode($linha["nome_grupo"]);
    $datanascimento_candidato = date('d/m/Y', strtotime($linha["nasc"]));
    $datateste_candidato = date('d/m/Y', strtotime($linha["data_aplic"]));
    $cargo_candidato = utf8_encode($linha["cargo"]);
    $org = utf8_encode($linha["id_organizacao"]);

    // Respostas do Candidato
    $pGabarito = $linha["respostas"];


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




?>
<!doctype html>
<html lang="pt-br">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PDI | <?=$nome_candidato;?> | Relatório MaperTest</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS Main -->
    <link rel="stylesheet" href="css/style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <section class="col-md-12 pagina">

            <!-- Assinatura de Topo -->
            <div class="col-md-12 topo">
              
              <div class="container">
                  <div class="col-md-4 logo"  style="text-align: center;" >
                      <img src="img/IdVisual_Maper_Final-03.png" alt="Maper Logo" style="text-align: center; height: 200px;" >
                  </div>
                  <div class="col-md-8 assiantura_ml"  style="text-align: center;" >
                        Por: Maria Lúcia Rodrigues :: contato@mapertest.com.br // (31) 9 8454-4457
                  </div>

              </div>

            </div>


              <!-- Cabeçalho -->
              <div class="col-md-12 cabecalho">
                
                <div class="container">

                  <div class="col-md-12 box_nome_candidato" style="text-align: center; font-weight: bolder; color: #ffffff;">
                    
                      <h1 class="nome" style="color: #ffffff; font-weight: bolder;"><?=$nome_candidato;?></h1>
                      <h2 class="organizacao-grupo" style="color: #ffffff; font-weight: bolder;"><?=$cargo_candidato;?> | <?=$organizacao_candidato;?> | <?=$grupo_candidato;?></h2>
                      <h3 class="dados" style="color: #ffffff; font-weight: bolder;">
                        <strong>CPF:</strong> <?=$cpf_candidato;?> | 
                        <strong>Data de Nascimento:</strong> <?=$datanascimento_candidato;?> | 
                        <strong>Teste realizado em:</strong> <?=$datateste_candidato;?>
                        
                      </h3>

                  </div>

                </div>

              </div>


              <!-- Competências -->
              <div class="col-md-12 box_competencias">

                  <div class="container">
                      <h2 style="color: #00D0BC; font-size: 30px;">
                          PROGRAMA DE DESENVOLVIMENTO INDIVIDUAL
                      </h2>
                      <h2>
                          Competências
                      </h2>

                      <? $i = 0; ?>
                      <? $string_competencias = $string_notas = "";?>
                      <? while ($i<20) {  ?>
                        <?
                          // Criando a string de competências para o Gráfico
                          $string_competencias .= utf8_encode("'$nome_competencias[$i]',");
                          $id_competencia = $i + 1;

                          // Criando a string de notas para o Gráfico
                          $string_notas .= "'$competencias[$i]',";
                          $nota = $competencias[$i];

                          //Buscando Feedback PDI
                          $sql_pdi = "
                                  SELECT * FROM pdi_feedbacks 
                                  WHERE id_competencia=$id_competencia and nota=$nota
                                ";

                                

                          //EXECUTA A QUERY
                          $result_pdi = mysqli_query($conn,$sql_pdi);
                          $row_pdi = mysqli_num_rows($result_pdi);
                          $linha_pdi = mysqli_fetch_assoc($result_pdi);
                        ?>
                        <?if ($linha_pdi["feedback"]) {?>
                        <div class="col-md-12 competencia">
                            <div class="col-md-5 nome_competencia">
                                <h3 style="text-align: center;"><? echo($i + 1); ?> - <? echo utf8_encode($nome_competencias[$i]); ?></h3>
                            </div>
                            <div class="col-md-5 ideais">
                                <? //echo $sql_pdi;?>
                            </div>
                            <div class="col-md-2 sua_notal">
                                <p class="label_nota">Sua Nota</p>
                                <div class="nota"><? echo $competencias[$i]; ?></div>
                            </div>
                            <div class="col-md-12 feedback">
                                <div>
                                  <?

                                      echo utf8_encode(nl2br($linha_pdi["feedback"]));
                                    
                                  ?>
                                </div>
                            </div>
                        </div>
                        <?}?>
                        <? $i++; ?>
                      <?}?>
                  </div>

              </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

    

  </body>

</html>
<?
mysqli_close($conn);
?>