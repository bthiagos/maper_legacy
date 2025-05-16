<?php require("conn.php"); ?>
<?php require("enviar_email.php"); ?>
<?php require("aplicacao_ajax/cpf.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript">
function submitForm()
{
  document.frm.submit();
}
</script>
</head>
<body>
<? $linguagem = $_GET["linguagem"]; ?>
<form action="aplicacao.php?linguagem=<?=$linguagem?>" method="POST" id="frm" name="frm">
    <input type="hidden" name="protocolo" value="<?=$_POST["protocolo"]?>" />
    <input type="hidden" name="continuar" value="1" />

</form>
</body>
</html>


<?php
//RECEBE DADOS
$protocolo = $_POST["protocolo"];
$browser = $_SERVER["HTTP_USER_AGENT"];
$data = date("Y-m-d H:i:s");
$tempo = "00:00";
$resposta = "";

$organizacao = $_POST["organizacao"];
$grupo = $_POST["grupo"];

$nome = utf8_decode($_POST["nome"]);
$email = $_POST["email"];
$cargo = utf8_decode($_POST["cargo"]);
$ddd = $_POST["ddd"];
$telefone = "(".$ddd.") ".$_POST["telefone"];
$nascimento = $_POST["nascimento"];
if(isset($_POST["cpf"])) {
    $cpf = $_POST["cpf"];
} else {
    $cpf="";
}
$ticket = $_POST["ticket"];
    
//CHECA REGRA CPF
if(cpf_ok($cpf) == false) {
    $msg = "Detectamos que seu CPF foi utilizado para realizar esta aplicação dentro dos últimos 6 meses. Não será possível realizar a aplicação novamente.";
    
    if($linguagem != "en" and $linguagem != "es") {
        //if($linguagem == "en") { $msg = "We have detected that its CPF was used for this application within the last 6 months. You can not make the application again."; }
        //if($linguagem == "es") { $msg = "Hemos detectado que su CPF se utilizó para esta aplicación en los últimos 6 meses. No se puede hacer de nuevo la aplicación."; }
        echo "<script type='text/javascript'>alert('".$msg."'); location.href='index.php'</script>"; 
    }

}

//CHECA SE O PROTOCOLO JÁ EXISTE
$checa_protocolo = mysql_query("SELECT id FROM protocolos WHERE protocolo = '$protocolo'"); 
if(mysql_num_rows($checa_protocolo) != 0) {
    $msg = "Detectamos que o protocolo gerado para você está em uso. Ao apertar OK você será redirecionado para a página do formulário e um novo protocolo será fornecido. Será necessário preencher novamente seus dados.";
    if($linguagem == "en") { $msg = "We have detected that you generated protocol is in use. By pressing OK you will be redirected to the page of the form and a new protocol will be provided . You must re- enter your data."; }
    if($linguagem == "es") { $msg = "Hemos detectado que generó protocolo está en uso. Al pulsar Aceptar se le redirigirá a la página del formulario y se le proporcionará un nuevo protocolo . Debe volver a introducir sus datos."; }
    echo "<script type='text/javascript'>alert('".$msg."'); location.href='index.php'</script>";
    die();
} else {
    //INSERE NO BANCO
    $query = "INSERT INTO protocolos (nome,email,telefone,cpf,nascimento,organizacao,grupo,cargo,tempo,resposta,ordem,protocolo,ticket,data,browser) 
    VALUES ('$nome','$email','$telefone','$cpf','$nascimento','$organizacao','$grupo','$cargo','$tempo','$resposta','$ordem','$protocolo','$ticket','$data','$browser')";
    if(mysql_query($query)) {
        //ENVIA EMAIL
        $mensagem = "
        <div style='font-family: Arial, Verdana; font-size: 14px;'>
        <p>Olá $nome! <br /><br />Sua aplicação de perfil foi iniciada. Utilize o protocolo <b>$protocolo</b> no endereço https://mapertest.com.br/perfil/ para dar continuidade caso ainda não tenha finalizado o sua aplicação.</p>
    
        Atenciosamente,<br />MAPER</div>";
        
        if($linguagem == "en") {
            $mensagem = "
            <div style='font-family: Arial, Verdana; font-size: 14px;'>
            <p>Olá $nome! <br /><br />Your profile application started. Use the protocol <b>$protocolo</b> at the address https://mapertest.com.br/perfil/ to continue if you have not finalized your application.</p>
        
            Sincerely,<br />MAPER</div>";
        }
        
        if($linguagem == "es") {
            $mensagem = "
            <div style='font-family: Arial, Verdana; font-size: 14px;'>
            <p>Olá $nome! <br /><br />Su aplicación de perfil comenzó. Utilizar el protocolo <b>$protocolo</b> en la dirección https://mapertest.com.br/perfil/ para continuar si no se ha finalizado la aplicación.</p>
        
            Sinceramente,<br />MAPER</div>";
        }
        
        $msg = "Aplicação de Perfil";
        if($linguagem == "en") { $msg = "Profile Application"; }
        if($linguagem == "es") { $msg = "Perfil de Aplicación"; }

        if(cpf_ok($cpf)) {
            enviar_email($email,"MAPER - ".$msg,utf8_decode($mensagem));
        }
        
        //CONTINUA
        echo "<script type='text/javascript'>submitForm();</script>";
    } else {
        echo "<script type='text/javascript'>alert('Houve um erro ao realizar seu cadastro. Por favor entre em contato com a APPWEB.'); location.href='index.php'</script>";
        die();
    }
}?>