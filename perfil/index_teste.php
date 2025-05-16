<?php require("conn.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="estilo.css" type="text/css" />

<title>APPWEB - Aplicação</title>
<script type="text/javascript" src="aplicacao_js/jquery.js"></script>
<script type="text/javascript" src="aplicacao_js/mask.js"></script>
<script type="text/javascript" src="aplicacao_js/scripts2.js"></script>
</head>

<body>
<div id="topo"><div id="interno"><a href="https://mapertest.com.br/" target="_blank"></a></div></div>
<? $protocolo = rand(111,999).substr(time(),-3,3);  ?>
<div id="conteudo" class="formularios">
    <h1>Formulário de Aplicação</h1>
    <p>
        Por favor, leia com atenção as instruções a seguir:
        <br /><br />
        Você encontrará alguns pares de frases. Leia atentamente, sem se deter demasiadamente em nenhuma delas e escolha a que melhor retratar seu comportamento. Ainda que lhe pareça difícil fazer a opção, não omita nenhuma resposta. Escolha somente uma, em cada par de frases.
        <br /><br />
        Favor marcar todas as questões e restringir o seu tempo de resposta até 20 (vinte) minutos.
        <br /><br />
        <strong>Anote o número de protocolo: <?=$protocolo?>.</strong>
        <br /><br />
        Caso não conclua o teste agora, o número protocolo poderá ser utilizado para continuar a aplicação.
    </p>
    
    <div id="debug"></div>
    <form action="aplicacao.php" method="POST" id="formulario">
        <input type="hidden" value="<?=$protocolo?>" name="protocolo" />
        <input type="hidden" value="" id="respostas" />
        <input type="hidden" value="" id="tempo" />
        
        <label for="nome">Nome: </label>
        <input type="text" name="nome" id="nome" value="" /><br />
        
        <label for="email">E-mail: </label>
        <input type="text" name="email" id="email" value="" /><br />
        
        <label for="organizacao">Organização: </label>
        <select name="organizacao" id="organizacao" style="height: 25px; width: auto;" onchange="getGrupos(this.value)">
                <option value="">(escolha)</option>
            <? $organizacoes = mysql_query("SELECT id,nome FROM organizacoes WHERE pg_organizacao = 1 ORDER BY nome") or die(mysql_error()); ?>
            <? while($organizacao = mysql_fetch_array($organizacoes)) { ?>
                <option value="<?=$organizacao["id"]?>"><?=utf8_encode($organizacao["nome"])?></option>
            <? } ?>
        </select><br />
        
        <label for="grupo">Grupo: </label>
        <select name="grupo" id="grupo" style="height: 25px; width: auto;" disabled="1">
            <option value="">(escolha uma organização)</option>
        </select><br />
        
        <label for="cargo">Cargo: </label>
        <input type="text" name="cargo" id="cargo" value="" /><br />
        
        <label for="telefone">Telefone: </label>
        <input style="width: 30px;" maxlength="3" type="text" name="ddd" id="ddd" value="" /> - <input maxlength="9" style="width: 74px;" type="text" name="telefone" id="telefone" value="" /><br />
        
        <label for="nascimento">Nascimento: </label>
        <input style="width: 110px;" type="text" name="nascimento" id="nascimento" value="" /><br />
        
        <label for="cpf">CPF: </label>
        <input style="width: 110px;" type="text" name="cpf" id="cpf" maxlength="11" value="" /><br />
        
        <label for="ticket">Ticket: </label>
        <input style="width: 110px;" type="text" name="ticket" id="ticket" value="" maxlength="10" /><br />
        
        <a style="margin-left: 92px;" onclick="valida('formulario','nome|email|organizacao|grupo|cargo|ddd|telefone|nascimento|cpf|ticket')"><img src="aplicacao_img/bt_enviar.jpg" style="margin-top:5px;" /></a>
    </form>
    
    <form id="formulario_protocolo" action="aplicacao.php" method="POST">
        <strong>Continuar Aplicação</strong>
        <p>Digite seu número de protocolo para continuar a aplicação:</p>
        <label for="ticket">Número de Protocolo: </label>
        <input style="width: 110px;" type="text" name="protocolo" id="protocolo" value="" maxlength="30" onKeyUp="javascript:somente_numero(this);" />
        <div id="erro_protocolo" style='color: #CD0000;'></div>
        <button name="submitbutton" class="submitbutton" type="button" onclick="valida_protocolo();" style="color: #666;">Continuar a Aplicação</button> 
    </form>
    
</div>

<div id="rodape">Copyright 1979-<?=date("Y")?> MAPPER - +55 (31) 98201-5757</div>

</body>
</html>