<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// # INICIO | CONEXÃO COM BANCO DE DADOS

$conn = mysqli_connect("167.99.177.121", "mysqladmin", "5kKMvHDeY0L5", "appweb_sistema");
 
if (!$conn) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$base_cms = "https://cms.mapertest.com.br/";
$base_perfil = "https://perfil.mapertest.com.br/";
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
          aplicacoes.nome
        FROM
          aplicacoes
        WHERE
          aplicacoes.id = $id_aplicacao
";

// Rodando a Query
$result = mysqli_query($conn, $query);

// Pegando as informações do candidato no banco
while ($linha = $result->fetch_assoc()) {
    
    $nome_candidato = $linha["nome"];


}

$id = $_REQUEST['id'];

// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \mPDF();
$mpdf->SetDisplayMode('fullpage');

// Write some HTML code:
$url = $base_cms."pdi/pdf.php?id=$id";
$html = file_get_contents($url);
$mpdf->WriteHTML($html);

$nome_candidato = preg_replace('/[^a-zA-Z0-9\s]/', '', $nome_candidato);
$nome_candidato = preg_replace('/[ -]+/' , '-' , $nome_candidato);
$nome_candidato = strtoupper($nome_candidato);


$nome_pdf = $nome_candidato.".pdf";

// Output a PDF file directly to the browser
$mpdf->Output($nome_pdf, 'D');
//$mpdf->Output($nome_pdf);

?>