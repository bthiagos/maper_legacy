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


// Buscando todos os CPFs de 2024
$sql2 = "SELECT * FROM aplicacoes WHERE notas IS NULL ORDER BY id ASC";
$sql2 = mysqli_query($conn,$sql2);

//Pegando IDs
while($linha2 = mysqli_fetch_assoc($sql2)){ 
 
    $id_aplicacao = $linha2["id"];
    $respostas_aplicacao = $linha2["respostas"];


    // Gerando Notas
        // Query
        $query = "
                SELECT
                  aplicacoes.id, 
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
        //echo $string_competencias;

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

        //print_r($competencias);

        //Concatenendo notas:

        $string_notas = implode("|", $competencias);
        $notas_fim = "$string_notas";



    // Gerando Notas

    $query = "UPDATE aplicacoes SET notas = '$notas_fim' WHERE id = $id_aplicacao";

    
    if (mysqli_query($conn, $query)) {
            echo $id_aplicacao." - ".$respostas_aplicacao." - ".$string_notas." - OK<br/>";
    } else {
        echo 'error';
    }
    


}
?>