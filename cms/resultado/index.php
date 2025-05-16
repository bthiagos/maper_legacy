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
    
    $nome_candidato = utf8_encode($linha["nome"]);
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
    <title><?=$nome_candidato;?></title>

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
                  <div class="col-md-4 logo">
                      <img src="img/IdVisual_Maper_Final-03.png" alt="Maper Logo">
                  </div>
                  <div class="col-md-8 assiantura_ml" >
                        Por: Maria Lúcia Rodrigues :: contato@mapertest.com.br // (31) 9 8454-4457
                  </div>

              </div>

            </div>


              <!-- Cabeçalho -->
              <div class="col-md-12 cabecalho">
                
                <div class="container">

                  <div class="col-md-12 box_nome_candidato">
                    
                      <h1 class="nome"><?=$nome_candidato;?></h1>
                      <h2 class="organizacao-grupo"><?=utf8_decode($cargo_candidato);?> | <?=$organizacao_candidato;?> | <?=$grupo_candidato;?></h2>
                      <h3 class="dados">
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
                      <h2>
                          Competências
                      </h2>

                      <? $i = 0; ?>
                      <? $string_competencias = $string_notas = "";?>
                      <? while ($i<20) {  ?>
                        <?
                          // Criando a string de competências para o Gráfico
                          $string_competencias .= utf8_encode("'$nome_competencias[$i]',");

                          // Criando a string de notas para o Gráfico
                          $string_notas .= "'$competencias[$i]',";
                        ?>
                        <div class="col-md-12 competencia">
                            <div class="col-md-5 nome_competencia">
                                <h3><? echo($i + 1); ?> - <? echo utf8_encode($nome_competencias[$i]); ?></h3>
                            </div>
                            <div class="col-md-5 ideais">
                                <div>
                                  <p class="label_ideal">Nota Ideal</p>
                                  <? ideal($i + 1, $conn); ?>
                                </div>
                            </div>
                            <div class="col-md-2 sua_notal">
                                <p class="label_nota">Sua Nota</p>
                                <div class="nota"><? echo $competencias[$i]; ?></div>
                            </div>
                            <div class="col-md-12 feedback">
                                <div><? echo utf8_encode(feedback(($i + 1), $competencias[$i], $conn)); ?></div>
                            </div>
                        </div>
                        <? $i++; ?>
                      <?}?>
                  </div>

              </div>

<?
// Gráfico Radar


//mysqli_query

$comp_sql = mysqli_query($conn, "SELECT * FROM competencias ORDER BY ordem ASC");
$c = 1;
$complang = "";

if($lang == "en" or $lang == "es") { $complang = "_".$lang; }

while($comp = mysqli_fetch_array($comp_sql)) {

    $txt = $comp["descricao".$complang];

    $txt = preg_replace('/ /', "\n", $txt, 1);

    

    if($comp["competencias_id"] == 11 || $comp["competencias_id"] == 10 || $comp["competencias_id"] == 1) { 

         $txt = preg_replace('/ /', "\n", $txt, 3);

         $txt = preg_replace('/ /', "\n", $txt, 6);

    }

    $liberado = true;

    /*
  if($org == 324 || $org == 487) {
    if($comp["competencias_id"] == 10) {
      $liberado = false;
    }
  }
  */

    if($liberado) {
      array_push($titles,$txt);
  }

    $c++;

}



//$titles=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");

$data = $notas_base10;
$string_convertida = implode(",", $data);



?>

              <div class="col-md-12 box_graficos">
                
                      <h2>
                          Gráficos de Desempenho
                      </h2>
                       
                      <div class="container">                        
                          <div class="col-md-12">
                            <?
                            $string_competencias = substr(trim($string_competencias), 0, -1);
                            $string_notas = substr(trim($string_notas), 0, -1);
                            ?>
                              <canvas id="myRadar" style="background-color: white; height: 600px;"></canvas>
                              <script>
                              const data_radar = {
                                labels: [
                                  <?=$string_competencias?>
                                ],
                                datasets: [{
                                  label: 'Notas por Competência',
                                  data: [<?=$string_convertida?>],
                                  fill: true,
                                  borderColor: 'rgb(0, 208, 188)',
                                  backgroundColor: 'rgba(0, 208, 188, 0.2)',
                                  pointBackgroundColor: 'rgb(255, 99, 132)',
                                  pointBorderColor: '#fff',
                                  pointHoverBackgroundColor: '#fff',
                                  pointHoverBorderColor: 'rgb(255, 99, 132)'
                                }]
                              };

                              const config_radar = {
                                type: 'radar',
                                data: data_radar,
                                options: {
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    // This more specific font property overrides the global property
                                                    font: {
                                                        size: 14
                                                    }
                                                }
                                            }
                                      },
                                        scale: {
                                          pointLabels: {
                                            fontSize: 20
                                          }
                                        },
                                  elements: {
                                    line: {
                                      borderWidth: 3
                                    }
                                  }
                                },
                              };
                              </script>
                              <script>
                                const myRadar = new Chart(
                                  document.getElementById('myRadar'),
                                  config_radar
                                );
                              </script>

                          </div>
<?
//$string_convertida = implode(",", $data);
//echo "$string_convertida<br/>";
//echo "$string_notas<br/>";
?>
                      <div class="col-md-12">
                              <canvas id="myChart" style="background-color: white; height: 600px;"></canvas>
                              <script>
                              const data = {
                                labels: [
                                  <?=$string_competencias?>
                                ],
                                datasets: [
                                {
                                  label: 'Ideal Máximo',
                                  data: [6,6,7,7,6,7,1,7,6,2,5,6,6,6,6,4,6,4,6,7],
                                  fill: false,
                                  borderColor: 'rgb(75, 192, 192)',
                                  tension: 0.1
                                },
                                {
                                  label: 'Ideal Mínimo',
                                  data: [4,4,6,6,5,6,0,5,4,0,4,5,4,5,4,3,4,4,5,5],
                                  fill: false,
                                  borderColor: 'rgb(75, 192, 192)',
                                  tension: 0.1
                                },
                                {
                                  label: 'Sua nota',
                                  data: [<?=$string_notas?>],
                                  fill: false,
                                  borderColor: 'rgb(101, 46, 174)',
                                  tension: 0.1
                                }]
                              };

                              const config = {
                                type: 'line',
                                data: data,
                                    options: {
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    // This more specific font property overrides the global property
                                                    font: {
                                                        size: 14
                                                    }
                                                }
                                            }
                                        }
                                    }
                              };
                              </script>
                              <script>
                                const myChart = new Chart(
                                  document.getElementById('myChart'),
                                  config
                                );
                                </script>
                          </div>

                      </div>

              </div>

              <?
              // Classificação das competência como Sustentação, aceitavel e Critico
              $i = 0;
              //$datax = array();
              $tabela_critico = $tabela_aceitavel = $tabela_sustencao = "";
              while ($i<20) {

                  //echo $competencias[$i];

                  $nota110 = base10(($i+1),$competencias[$i],$conn);
                  if ($nota110 <= 4) {
                    $tabela_critico .= "<li>".
                    $nome_competencias[$i]
                    ."</li>";
                  }

                  if ($nota110 >= 5 and $nota110 <= 6) {
                    $tabela_aceitavel .= "<li>".
                    $nome_competencias[$i]
                    ."</li>";
                  }

                  if ($nota110 >= 7) {
                    $tabela_sustencao .= "<li>".
                    $nome_competencias[$i]
                    ."</li>";
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
              ?>

              <div class="col-md-12 box_sustentacao">

                <div class="container">
                      
                      <div class="col-md-12 txt_sustentacao">                          
                            <p>A tabela a seguir possui 3 colunas sendo Sustentação, Aceitável e Crítico.<br />

                              <p>Por "Sustentação" entenda pelos "pontos fortes" do candidato / profissional que remetem aos fatores de excelência. </p>

                              <p>Na segunda coluna, compreenda que são os fatores aceitáveis, ou seja, estão adequados mas podem evoluir mais.</p>

                              <p>Por último, os fatores críticos sugerem as competências que podem prioritariamente ser trabalhadas.</p>

                              <p>É importante lembrar que essa é uma classificação generalizada e deve ser adequada às competências organizacionais, portanto, ao perfil de cada cargo.</p>
                          </p>
                      </div>

                      <div class="col-md-4 ">
                        <div class="box_sustenta">
                          <h3>Sustentação</h3>
                          <ul><?=utf8_encode($tabela_sustencao);?></ul>
                        </div>
                        
                      </div>

                      <div class="col-md-4">  
                        <div class="box_aceitavel">
                          <h3>Aceitável</h3>
                          <ul><?=utf8_encode($tabela_aceitavel);?></ul>
                        </div>
                        
                      </div>

                      <div class="col-md-4">
                        <div class="box_critico">
                          <h3>Crítico</h3>
                          <ul><?=utf8_encode($tabela_critico);?></ul>
                        </div> 
                      </div>


                      <div class="clearfix"></div>

                      <div class="col-md-8 indice_medio">  
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">ÍNDICE DE ADEQUAÇÃO AOS CARGOS</th>
                              <th scope="col" class="medio_titulo">ÍNDICE MÉDIO</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">INÍCIO DE CARREIRA</th>
                              <td>5,0 a 6,0</td>
                            </tr>
                            <tr>
                              <th scope="row">ENCARREGADO / ANALISTA</th>
                              <td>6,0 a 7,0</td>
                            </tr>
                            <tr>
                              <th scope="row">GERENTES</th>
                              <td>7,0 a 8,0</td>
                            </tr>
                            <tr>
                              <th scope="row">DIRETOR</th>
                              <td>8,0 a 9,0</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-4 indice_geral">
                        
                          <h3>SEU ÍNDICE GERAL</h3>
                          <span class="nota_geral"><?=$indice_geral;?></span>

                      </div>

                </div>

              </div>

<?
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

  //exit;
?>

              <div class="box_estilos_profissionais">

                <div class="container">               
                    <div class="col-md-8">
                        <h2>ESTILOS PROFISSIONAIS MAPERTEST®</h2>

                        <div class="col-md-12 titulo_estilo">
                            Negociador
                        </div>
                        <div class="col-md-12 texto_estilo">
                            Revela habilidade de relacionamento interpessoal, convive bem em grupos e estabelece bom relacionamento afetivo, separando relações pessoais de profissionais. Comunica-se com clareza e objetividade e procura se fazer entender para atingir seus objetivos. Gerencia bem suas emoções tanto em situações tensas como nos impasses do dia a dia. É um profissional que aprecia trabalhar com pessoas. Geralmente revelam grande aptidão para negociar.
                        </div>

                        <div class="col-md-12 titulo_estilo">
                            Produtor 
                        </div>
                        <div class="col-md-12 texto_estilo">
                            Apresenta alta produtividade no atingimento de suas metas ou na execução de suas tarefas. Consegue trabalhar bem com prazos e pressão de tempo e aprecia muito atingir suas metas. Confia em seu potencial profissionais que possuem identidade com atividades que exijam rapidez no cumprimento de prazos e imprevistos.
                        </div>     
                        <div class="col-md-12 titulo_estilo">
                            Mobilizador  
                        </div>
                        <div class="col-md-12 texto_estilo">
                            Revela grande habilidade para obter resultados por meio das pessoas e aprecia gerenciar e mobilizar as pessoas para atingir metas e objetivos. Estimula e promove o desenvolvimento das equipes sob sua responsabilidade e delega com facilidade. Confia em seu potencial e sabe tomar decisões com assertividade sem se omitir ou se precipitar. Geralmente ascendem rapidamente nas empresas assumindo posições de liderança, pois conseguem conquistar seguidores facilmente.
                        </div>   
                        <div class="col-md-12 titulo_estilo">
                            Analista  
                        </div>
                        <div class="col-md-12 texto_estilo">
                            Revela um perfil de análise e planejamento e interessa-se mais por atividades em que possa lidar com detalhes e concentração. Prefere ser orientado do que liderar e necessita de direcionamento para a execução de suas tarefas. Revelam aderência por atividades de assessoria e suporte.
                        </div>  
                        <div class="col-md-12 titulo_estilo">
                            Inovador  
                        </div>
                        <div class="col-md-12 texto_estilo">
                            Revela interesse por atividades em que possa ter liberdade para expressar suas ideias e opiniões. Prefere trabalhos sem rotinas ou rigor excessivo, pois a necessidade permanente de mudança é inerente ao seu perfil. Geralmente são pessoas mais criativas e inventivas e têm aversão a situações burocráticas. Lidam bem com imprevistos sem se estressar e se adaptam facilmente a novas situações.
                        </div> 
                    </div>

                    <div class="col-md-4">
                        <h2>SUAS NOTAS DO ESTILO MAPERTEST®</h2>

                        <div class="col-md-12 titulo_estilo_nota">
                            NEGOCIADOR
                        </div>
                        <div class="col-md-12 texto_estilo_nota">
                            <?=$nota_negociador; ?>
                        </div>

                        <div class="col-md-12 titulo_estilo_nota">
                            PRODUTOR
                        </div>
                        <div class="col-md-12 texto_estilo_nota">
                            <?=$nota_executor; ?>
                        </div>

                        <div class="col-md-12 titulo_estilo_nota">
                            MOBILIZADOR
                        </div>
                        <div class="col-md-12 texto_estilo_nota">
                            <?=$nota_mobilizador; ?>
                        </div>

                        <div class="col-md-12 titulo_estilo_nota">
                            ANALISTA
                        </div>
                        <div class="col-md-12 texto_estilo_nota">
                            <?=$nota_analista; ?>
                        </div>

                        <div class="col-md-12 titulo_estilo_nota">
                            INOVADOR
                        </div>
                        <div class="col-md-12 texto_estilo_nota">
                            <?=$nota_inovador; ?>
                        </div>

                    </div>

                    <div class="col-md-12 img-estilo">
                        <img src="https://cms.mapertest.com.br/quadro_app_web_profissional.png" alt="" class="img-responsive" />
                    </div>

                </div>

              </div>


              <div class="box_estilos_lideranca">

                <div class="container">

                    <h2>ESTILOS MAPERTEST® DE LIDERANÇA</h2>
                  
                    <div class="col-md-12 titulo_estilo">
                      Líder Integral
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais que revelam este perfil apresentam boa capacidade de Liderança Motivacional (Estilo de Liderança) e também facilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente conseguem motivar sua equipe para atingir metas e objetivos e também estimulam o potencial das pessoas promovendo o seu desenvolvimento e revelando alguns potenciais, assumindo o verdadeiro papel de Líder COACH.
                    </div>



                    <div class="col-md-12 titulo_estilo">
                      Líder Carismático
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil geralmente conseguem motivar as pessoas para atingir os desafios, e possuem uma forte liderança inspiradora, contudo podem estar depositando muita energia nesta competência e faltando habilidade para desenvolver pessoas (Capacidade de Acompanhamento). Geralmente são excelentes líderes motivacionais, mas precisam também desenvolver sua Liderança COACH.
                    </div>


                    <div class="col-md-12 titulo_estilo">
                      Líder Educador
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil revelam ótima capacidade para desenvolver pessoas (Capacidade de Acompanhamento) e geralmente conseguem estimular o potencial de sua equipe formando novos talentos. Contudo podem aprimorar sua habilidade para também motivar pessoas no intuito de atingir metas e objetivos. Todavia já revelam uma ótima habilidade de Liderança COACH.
                    </div>


                    <div class="col-md-12 titulo_estilo">
                      Líder Fiscal
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil são do tipo fiscalizadores que cobram sistematicamente de sua equipe as tarefas a serem desenvolvidas e geralmente não permitem que os mesmos expressem seu potencial. Revelam dificuldades para delegar e desenvolver pessoas inibindo o potencial do grupo.
                    </div>


                    <div class="col-md-12 titulo_estilo">
                      Líder Influenciador
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil apresentam forte capacidade para influenciar pessoas, pois sua Liderança Motivacional é acentuada. Contudo, conseguem desenvolver pessoas e revelam ótima capacidade para promover e formar sua equipe.
                    </div>


                    <div class="col-md-12 titulo_estilo">
                      Líder Diretivo
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil apresentam facilidade para mobilizar pessoas revelando ótima Liderança Motivacional. Contudo podem exceder na cobrança de resultados e metas inibindo o desenvolvimento da equipe. Também podem revelar dificuldades de delegação.
                    </div>



                    <div class="col-md-12 titulo_estilo">
                      Líder Excêntrico
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil são muito intensos e tanto apresentam forte Liderança Mobilizadora como cobram em excesso da equipe podendo inibir seu potencial. Este tipo de comportamento dúbio pode dificultar o aprendizado e o crescimento do grupo, que ora sentem-se estimulados e ou intensamente cobrados.
                    </div>




                    <div class="col-md-12 titulo_estilo">
                      Líder Motivador
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil conseguem mobilizar as pessoas para atingir metas e objetivos, mas ainda não sabem como desenvolver sua equipe, talvez por ainda desconhecerem como adotar a postura de Líder Treinador.
                    </div>




                    <div class="col-md-12 titulo_estilo">
                      Em desenvolvimento
                    </div>

                    <div class="col-md-12 texto_estilo">
                      Os profissionais com este perfil ainda não assumem a postura de liderança, talvez por não terem interesse em desenvolver esta competência, ou por nunca terem sido estimulados para tal.
                    </div>


                    <div class="col-md-6 img_lider">
                        <img src="https://cms.mapertest.com.br/GRAFICO.jpg" alt="" class="img-responsive" />
                    </div>

<?
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


?>

                    <div class="col-md-6 box_lider">
                        <h2>SEU ESTILO DE LIDERANÇA</h2>

                        <div class="col-md-12 titulo_estilo_nota">
                               <?=$label_lider;?>  
                        </div>
                    </div>

                </div>

              </div>

          
      
    </section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

    

  </body>

</html>
<?
mysqli_close($conn);
?>