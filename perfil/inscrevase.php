<?
session_start();
include("../library.php");

$server = $_SERVER['SERVER_NAME']; 
$endereco = $_SERVER ['REQUEST_URI'];
$www = explode(".",$server);
if($www[0] != "www" and $server != 'localhost'){
	header ('HTTP/1.1 301 Moved Permanently');
	header ('Location:  http://www.'.$server.$endereco);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://www.mapertest.com.br" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>Maper  :: Gest&atilde;o por Compet&ecirc;ncias, Sistemas de Qualidade, Educa&ccedil;&atilde;o Corporativa e RH</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="resource-types" content="document" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta name="revisit-after" content="1 Weeks" />
	<meta name="classification" content="Internet" />
	<meta name="Description" content="O APP® - Avaliação de Potencial e Perfil - é uma ferramenta que permite profissionais e organizações gerenciarem o seu patrimônio mais valioso - as pessoas." />
	<meta name="Keywords" content="" />
	<meta name="robots" content="ALL" />
	<meta name="distribution" content="Global" />
	<meta name="rating" content="General" />
	<meta name="author" content="Agência Penta - http://www.agenciapenta.com.br" />
	<meta name="language" content="pt-br" />
	<meta name="doc-class" content="Completed" />
	<meta name="doc-rights" content="Public" />
	<link href="css/style_novo.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
    <script src="js/jquery.js" type="text/javascript"></script>

    <script>        
        function valida(formulario,campos) {
			ok = 1;
			msg = "";
			
			campo = campos.split(",");
			
			for(i = 0; i < campo.length; i++) {
				if($("#"+formulario+" "+"#"+campo[i]).val() == "") {
					ok = 0;
                    if(campo[i] == "ddd1") {
                        msg += "Por favor, preencha o campo DDD do telefone.\n";
                    } else {
                        if(campo[i] == "ddd2") {
                            msg += "Por favor, preencha o campo DDD do celular.\n";
                        } else {
                            msg += "Por favor, preencha o campo "+campo[i]+".\n";
                        }
                    }
					
				} else {
				    if(campo[i] == "email") {
                        er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
                        if(!er.exec($("#"+formulario+" "+"#"+campo[i]).val())) {
                            ok = 0;
                            msg += "O e-mail digitado não é válido.\n";
                        }
                    }
				}
			}
			
			if(!ok) { alert(msg); return false; } else { return true; }
		}
    </script>
</head>

<body>
<div id="slice1">
        <div id="topo">
            <div id="topo_esq">
                <div id="logo"><a href="http://www.mapertest.com.br" target="_blank"><img src="css/style_novo/logo.png" alt="applogo" /></a></div>
                
            </div>
           
        </div>
    </div> 
<div id="global">

<? 

    if(isset($_GET["cadastrar"])) {
        $nome = $_POST["nome"];
        $empresa = $_POST["empresa"];
        $cargo = $_POST["cargo"];
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $ddd1 = $_POST["ddd1"];
        $celular = $_POST["celular"];
        $ddd2 = $_POST["ddd2"];
        
        require('../cms/class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
        $mail = new PHPMailer(); //instancia a classe PHPMailer
        $mail->IsSMTP(); //define que o email será enviado por SMTP
        $mail->SMTPAuth = true;
        //$mail->SMTPSecure = "tls";
        $mail->Port = 587; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        $mail->Host = '216.59.16.52'; //define o servidor smtp - altere para o seu servidor smtp
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        $mail->Username = 'atendimento@mapertest.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        $mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
        $mail->SetFrom('app@mapertest.com.br', 'APPWEB'); //define o remetente da mensagem, altere para o real
        
        //$mail->AddAddress("thalesu@gmail.com","Thales");
        
        //$mail->AddAddress("leandroliberio@gmail.com","Webmaster");
        
        $message = "
        <strong>Nome: </strong> $nome<br />
        <strong>Empresa: </strong> $empresa<br />
        <strong>Cargo: </strong> $cargo<br />
        <strong>email: </strong> $email<br />
        <strong>telefone: </strong> ($ddd1) $telefone<br />
        <strong>celular: </strong> ($ddd2) $celular
        ";
        
        $mail->AddAddress('contato@mapertest.com.br');
            
        $mail->Subject = "APPWEB - Inscrição"; //define o assunto da mensagem
        $mail->MsgHTML($message); //configura o email como HTML
        				
        if ($mail->Send()) {
         echo "<script>location.href='http://www.mapertest.com.br/curso/inscrevase?f=1'</script>";
	       	
	   }
        
    }
?>

<? if(isset($_GET["f"])) { 
?>
<div id="conteudo">
<div class="txt_chamada" style=" margin-top:20px; text-align: center">Sua inscrição foi recebida com sucesso!</div>
</div>
<?    
} else { ?>
	
	
	<div id="conteudo">
	
		<div class="txt_chamada" style=" margin-top:20px; text-align: center">Inscrição</div>

<style>
    .textos { text-align: right; }
    .campo { width: 308px; }
</style>

<div style="width: 420px; margin-left: auto; margin-right: auto; margin-top: 15px; font-family: Arial; font-size: 13px; text-align: center;">
Preencha corretamente os campos abaixo para fazer sua inscrição.
</div>
<div style="width: 420px; margin-left: auto; margin-right: auto; margin-top: 15px;">
<form id="formulario" action="http://www.mapertest.com.br/curso/inscrevase?cadastrar=1" method="POST" onsubmit="return valida('formulario','nome,empresa,cargo,email,ddd1,telefone,ddd2,celular')">
  <table width="420" border="0" align="left" cellpadding="3" cellspacing="0">
    <tr>
      <td ><div  class="textos">Nome:</div></td>
      <td ><input class="campo" type="text" name="nome" id="nome" value="<?=$_POST["nome"]?>"/></td>
    </tr>
    <tr>
      <td ><div  class="textos">Empresa:</div></td>
      <td ><input class="campo" type="text" name="empresa" id="empresa" value="<?=$_POST["empresa"]?>" /></td>
    </tr>
    <tr>
      <td ><div  class="textos">Cargo:</div></td>
      <td ><input class="campo" type="text" name="cargo" id="cargo" value="<?=$_POST["cargo"]?>" /></td>
    </tr>
    <tr>
      <td ><div  class="textos">E-mail:</div></td>
      <td ><input class="campo" type="text" name="email" id="email" value="<?=$_POST["email"]?>" /></td>
    </tr>
    <tr>
      <td ><div  class="textos">Telefone Fixo:</div></td>
      <td ><input class="campo" type="text" name="ddd1" id="ddd1" style="width: 35px;" maxlength="3" value="<?=$_POST["telefone"]?>" /> - <input class="campo" type="text" name="telefone" id="telefone" maxlength="9" style="width: 95px;" value="<?=$_POST["telefone"]?>" /></td>
    </tr>
    <tr>
      <td ><div  class="textos">Telefone Celular:</div></td>
      <td ><input class="campo" type="text" name="ddd2" id="ddd2" style="width: 35px;" maxlength="3" value="<?=$_POST["telefone"]?>" /> - <input class="campo" type="text" name="celular" id="celular" maxlength="9" style="width: 95px;" value="<?=$_POST["celular"]?>" /></td>
    </tr>
    
    <tr>
      <td  colspan="2"><input type="submit" value="Cadastrar" class="form_bt" style="float: right;" /></td>
 
    </tr>
    
    

    
  </table>
</form>
</div>


</div>
<? } ?>
</div>
<div id="rodape">Copyright 1979-<?=date("Y")?> MAPPER - +55 (31) 98201-5757</div>


</body>

</html>