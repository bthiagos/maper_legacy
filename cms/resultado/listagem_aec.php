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

?>

<!doctype html>
<html lang="pt-br">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Listagem Testes - AeC</title>

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

     <?

$i = 1;
$num_gerencial = $num_operacional = 0;

$query = "
            SELECT
                aplicacoes.aplicativo, 
                aplicacoes.id, 
                aplicacoes.ticket, 
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
                aplicacoes.nasc, 
                date_format( data_aplic, '%d/%m/%Y %H:%i:%s' ) AS databr, 
                organizacoes.nome AS orga, 
                grupos.id AS grupoid, 
                grupos.nome AS grupo, 
                organizacoes.id AS id_orga, 
                aplicacoes.status_envio
            FROM
                aplicacoes
                LEFT JOIN
                grupos
                ON 
                    aplicacoes.grupo = grupos.id
                LEFT JOIN
                organizacoes
                ON 
                    aplicacoes.organizacao = organizacoes.id
            WHERE
                (organizacoes.id = 630 OR
                organizacoes.id = 629 OR
                organizacoes.id = 673 OR
                organizacoes.id = 696 OR
                organizacoes.id = 488 OR
                organizacoes.id = 638 OR
                organizacoes.id = 632 OR
                organizacoes.id = 631 OR
                organizacoes.id = 636 OR
                organizacoes.id = 635 OR
                organizacoes.id = 633 OR
                organizacoes.id = 637 OR
                organizacoes.id = 634 OR
                organizacoes.id = 486) AND
                year(aplicacoes.data_aplic) >= 2022
            ORDER BY
                aplicacoes.data_aplic, orga ASC
        ";

        $result = mysqli_query($conn, $query);

     ?> 

  <body style="padding: 15px;">

      <h1 style="margin-bottom: 20px;">Listagem Testes - AeC</h1>

      <p  style="margin-bottom: 20px;">Foram realizados <b><?=mysqli_num_rows($result);?></b> testes a partir de  <b>01/01/2022</b></p>

      <table width="100%" border="1">
          <tr>
              <td>#</td>
              <td>Nome</td>
              <td>Ticket</td>
              <td>Tipo do Ticket</td>
              <td>CPF</td>
              <td>E-mail</td>
              <td>Data</td>
              <td>Organização</td>
              <td>Grupo</td>
          </tr>
      



     <? while ($linha = $result->fetch_assoc()) { ?>

        <tr>
              <td><?=$i++;?></td>
              <td style="text-transform: uppercase;"><?=utf8_encode($linha["nome"])?></td>
              <td style="text-transform: uppercase; text-align: center;"><?=$linha["ticket"]?></td>
              <td style="text-transform: uppercase; text-align: center;">
                <?
                    $tipo_ticket = "gerencial";
                    //echo "SELECT operacional,tipo_ticket FROM gerador_tickets WHERE numero_ticket = '".$linha["ticket"]."'";
                    $check_ticket = mysqli_query($conn, "SELECT operacional,tipo_ticket FROM gerador_tickets WHERE numero_ticket = '".$linha["ticket"]."'");
                    if(mysqli_num_rows($check_ticket) != 0) {
                        $tipo_ticket_assoc = mysqli_fetch_assoc($check_ticket);
                        $tipo_ticket = $tipo_ticket_assoc["tipo_ticket"];
                    }

                    if($tipo_ticket == "gerencial") { echo "Gerencial"; $num_gerencial++; }
                    if($tipo_ticket == "operacional") { echo "Operacional"; $num_operacional++; }
                    if($tipo_ticket == "vendas") { echo "Vendas"; }
                    if($tipo_ticket == "vendas1") { echo "Vendas 1? p?gina"; }

                ?>
              </td>
              <td style="text-transform: uppercase; text-align: center;"><?=$linha["cpf"]?></td>
              <td style="text-transform: uppercase; text-align: center;"><?=$linha["email"]?></td>
              <td style="text-transform: uppercase; text-align: center;"><?=$linha["databr"]?></td>
              <td style="text-transform: uppercase;" ><?=utf8_encode($linha["orga"]);?></td>
              <td style="text-transform: uppercase;"><?=$linha["grupo"]?></td>
        </tr>

    <? } ?>
    </table> 
    <div style="margin-top: 20px; margin-bottom: 20px;">
        Testes Gerenciais: <?=$num_gerencial;?><br/>
        Testes Operacinais: <?=$num_operacional;?><br/>
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