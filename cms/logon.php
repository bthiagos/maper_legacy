<?php
// Inicia sessões
session_start();

// Verifica se existe os dados da sessão de login
if(!isset($_SESSION["id_usuario_adm"]) || !isset($_SESSION["nome_usuario_adm"]))
{
    // Usuário não logado! Redireciona para a página de login
    header("Location: index.php");
    exit;
}
$permissao = $_SESSION["per_adm"];
?>