<?php 
    session_start();
    const host = '167.99.177.121';
    const dbname = 'appweb_sistema';
    const user = 'mysqladmin';
    const senha = '5kKMvHDeY0L5';

    try {
        $pdo = new PDO('mysql:host='.host.';dbname='.dbname.'', user, senha, [PDO::MYSQL_ATTR_INIT_COMMAND =>  "SET NAMES 'UTF8'"]);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Vai mostrar erros caso exista.
    }catch (Exception $e) { /*Pegue a exception e coloque na variável $e */
        echo 'Erro ao conectar ao banco de dados';
        echo $e;
    } 
?>