<?php require("conn.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="estilo.css" type="text/css" />

<? $l_aplicacao = "Aplicação"; if($_GET["linguagem"] == "en") { $l_aplicacao = "Application"; } if($_GET["linguagem"] == "es") { $l_aplicacao = "Aplicación"; } ?>
<title>MAPER - <?=$l_aplicacao?></title>
<script type="text/javascript" src="aplicacao_js/jquery.js"></script>
<script type="text/javascript" src="aplicacao_js/mask.js"></script>
<script type="text/javascript" src="aplicacao_js/scripts.js"></script>
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="//assets.locaweb.com.br/locastyle/2.0.6/stylesheets/locastyle.css">
</head>
<?php


function gerar_protocolo()
{
	$protocolo = rand(11111,999999).substr(time(),-3,3);
	
	$consulta_protocolos = mysql_query("SELECT protocolo FROM protocolos WHERE protocolo = '$protocolo'");
    if(mysql_num_rows($consulta_protocolos) > 0) {
    	
		gerar_protocolo();
	}else{
		
		return $protocolo;
	}
}


//CHECA VERSÃO DO BROWSER
$bloqueia = false;
preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

if(count($matches)>1){
  //Then we're using IE
  $version = $matches[1];
  if($version < 8) {
    $bloqueia = true;
  }                  
}

if($bloqueia) {
    echo "<center><img src='aplicacao_img/desatualizado.jpg' /></center>";
    exit;
}
?>
<body>
<? if(!isset($_GET["linguagem"]) or ($_GET["linguagem"] != "br" and $_GET["linguagem"] != "en" and $_GET["linguagem"] != "es")) { ?>
<div class="fundo-linguagem">
    <div class="linguagem">
        <div class="escolha">Escolha sua linguagem / Choose your language / Elige tu idioma</div>
        <div class="bandeiras">
            <a href="?linguagem=br"><img src="<?=$base_cms;?>img/flag_br.jpg" /></a>
            <a href="?linguagem=en"><img src="<?=$base_cms;?>img/flag_en.jpg" /></a>
            <a href="?linguagem=es"><img src="<?=$base_cms;?>img/flag_es.jpg" /></a>
        </div>
    </div>
</div>
<? } else { ?>
<?php
 	$protocolo = gerar_protocolo();
	 
    $idioma["linguagem_br"] = array(
    "Formulário de Aplicação",
    "Por favor, leia com atenção as instruções a seguir:
    <br /><br />
    Você encontrará alguns pares de frases. Leia atentamente, sem se deter demasiadamente em nenhuma delas e escolha a que melhor retratar seu comportamento. Ainda que lhe pareça difícil fazer a opção, não omita nenhuma resposta. Escolha somente uma, em cada par de frases.
    <br /><br />
    Favor marcar todas as questões e restringir o seu tempo de resposta até 20 (vinte) minutos.
    <br /><br />
    <strong>Anote o número de protocolo: ".$protocolo.".</strong>
    <br /><br />
    Caso não conclua o teste agora, o número protocolo poderá ser utilizado para continuar a aplicação.<br/><br/>
    Ao responder este questionário você autoriza que seu resultado seja encaminhado para a empresa que o solicitou.",
    "Nome","E-mail","Organização","Grupo","Cargo","Telefone","Nascimento","CPF","Ticket",
    "Continuar a Aplicação","Número de Protocolo","Se você paralisar o teste, por algum motivo, favor salvar o número de protocolo abaixo e inseri-lo para continuar de onde você parou o teste.",
    "Campo obrigatório!","Digite um protocolo",
    "(escolha)","(escolha uma organização)",
    "Concordo com o termo e desejo iniciar o preenchimento");
    
    $idioma["linguagem_en"] = array(
    "Application Form",
    "Please carefully read the following instructions:
    <br /><br />
    You'll find a few pairs of sentences. Read carefully , without stopping too in any of them and choose the one that best portray their behavior. Although it seems difficult for him to make the choice , do not omit any response . Select only one of each pair of sentences .
    <br /><br />
    Please mark all the questions and limit its response time up to twenty (20) minutes.
    <br /><br />
    <strong>Take note of the protocol number: ".$protocolo.".</strong>
    <br /><br />
    If you do not complete the test now , the protocol number can be used to continue the application.",
    "Name","Mail","Organization","Group","Job Title","Phone","Birth","CPF","Ticket",
    "Continue Application","Protocol number","Enter your protocol number to continue the application:",
    "Required field!","Enter a protocol",
    "(choose)","(choose an organization)",
    "Send and start filling");
    
    $idioma["linguagem_es"] = array(
    "Formulario de Aplicación",
    "Por favor, lea atentamente las siguientes instrucciones:
    <br /><br />
    Usted encontrará algunos pares de oraciones. Léalas atentamente, sin detenerse demasiado en ninguna de ellas y elija aquella que mejor refleje su comportamiento. Aunque le resulte difícil tomar la decisión, no omita ninguna respuesta. Seleccione sólo una opción de cada par de oraciones.
    Marque todas las cuestiones y limite su tiempo de respuesta hasta 20 (veinte) minutos.
    <br /><br />
    <strong>Tenga en cuenta el número de protocolo: ".$protocolo.".</strong>
    <br /><br />
    Si usted no consigue completar la prueba hoy, el número de protocolo podrá ser utilizado para continuar con la aplicación.",
    "Nombre","Correo electrónico","Organización","Grupo","Título Profesional","Teléfono","Nacimiento","CPF","Billete",
    "Continuar Aplicación","Número de Protocolo","Introduzca su número de protocolo para continuar la aplicación:",
    "Campos obligatorios!","Introduzca un protocolo",
    "(elegir)","(elegir una organización)",
    "Enviar y comenzar a llenar");
    
    $linguagem = $_GET["linguagem"];
    $lang = $idioma["linguagem_".$linguagem];
?>

<div id="topo"><div id="interno"><a href="https://mapertest.com.br/" target="_blank"></a></div></div>

<div id="conteudo" class="formularios">
    <h1><?=$lang[0]?></h1>
    <p>
        <?=$lang[1]?>
    </p>
    
    
    <form action="https://perfil.mapertest.com.br/index2.php?linguagem=<?=$linguagem?>" method="POST" id="formulario">
        <input type="hidden" value="<?=$protocolo?>" name="protocolo" />
        <input type="hidden" value="" id="respostas" />
        <input type="hidden" value="" id="tempo" />
        
        <label for="ticket"><?=$lang[10]?>: </label>
        <input style="width: 110px;" type="text" name="ticket" id="ticket" value="" maxlength="10" /><br />
        <br />
        <div style="font-weight: bold;">
            Ao avançar, o candidado concorda com a <a href="POLTICA-DE-PRIVACIDADe.pdf" target="_blank">Politica de Privacidade</a>.<br/><br/>
        </div>
        <? if($linguagem != "en" and $linguagem != "es") { ?>
               <a class="submitbutton" style="padding: 3px 30px 3px 30px; margin-top: 10px; cursor: pointer; background: #DDD; margin-left: 92px;" onclick="valida_ticket('formulario','ticket','<?=$linguagem?>')">Avançar -></a>
        <? } else { ?>
               <a class="submitbutton" style="padding: 3px 30px 3px 30px; margin-top: 10px; cursor: pointer; background: #DDD; margin-left: 92px;" onclick="valida_ticket('formulario','ticket','<?=$linguagem?>')">Avançar -></a>
        <? } ?>
        
        <input type="hidden" id="linguagem" value="<?=$linguagem?>" />
    </form>
    
    <form id="formulario_protocolo" action="aplicacao.php?linguagem=<?=$linguagem?>" method="POST">
        <strong><?=$lang[11]?></strong><br />
        <p><?=$lang[13]?></p>
        <label for="ticket"><?=$lang[12]?>: </label>
        <input type="hidden" name="continuar" value="1" />
        <input style="width: 110px;" type="text" name="protocolo" id="protocolo" value="" maxlength="30" onKeyUp="javascript:somente_numero(this);" />
        <div id="erro_protocolo" style='color: #CD0000;'></div>
        <button name="submitbutton" class="submitbutton" type="button" onclick="valida_protocolo('<?=$linguagem?>');" style="color: #666;"><?=$lang[11]?></button> 
    </form>
    
</div>
<div id="rodape">Copyright 1979-<?=date("Y")?> MAPPER - +55 (31) 98201-5757</div>

<? } ?>
<script src="https://www.drcode.com.br/nofollow/aviso-cookies/drcode.cookies.js"></script>
<script>
  avisoCookiesDrcode({
    message:'Utilizamos cookies para que você tenha a melhor experiência em nosso site. Para saber mais acesse nossa página de Política de Privacidade',
    backgroundColor:'rgba(255,255,255,0.95)',
    textColor:'#666666',
    buttonBackgoundColor:'#0e9a20',
    buttonHoverBackgoundColor:'#0a6b16',
    buttonTextColor:'#ffffff'
})
</script>
    <!-- Atente-se para a ordem: primeiro jquery, depois locastyle, depois o JS do Bootstrap. -->
    <script async="" src="//www.google-analytics.com/analytics.js"></script><script type="text/javascript" src="//code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="//assets.locaweb.com.br/locastyle/2.0.6/javascripts/locastyle.js"></script>
    <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</body>
</html>