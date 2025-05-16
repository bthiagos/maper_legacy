<?php require("conn.php"); ?>
<?php require("aplicacao_ajax/cpf.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="estilo.css" type="text/css" />

<?



$idioma["linguagem_br"] = array("Nome","E-mail","Telefone","Nascimento","CPF","Organização","Grupo","Cargo","Ticket","Protocolo",
"<h1>Pronto!</h1><div>Você concluiu nosso formulário com sucesso. <br />Já recebemos o seu resultado. Obrigado!</div>",
"<h1>Esta aplicação foi finalizada!</h1><div>O protocolo já foi utilizado.</div>",
"Detectamos que a página foi atualizada. Utilize o seu protocolo para continuar a aplicação.");

$idioma["linguagem_en"] = array("Name","Mail","Phone","Birth","CPF","Organization","Group","Job Title","Ticket","Protocol",
"<h1>Done!</h1><div>You have successfully completed our form. <br />We have received your results. Thank you!</div>",
"<h1>This application is completed!</h1><div>The protocol has been used.</div>",
"We detected that the page was updated. Use your protocol to continue the application.");

$idioma["linguagem_es"] = array("Nombre","Correo electrónico","Teléfono","Nacimiento","CPF","Organización","Grupo","Título Profesional","Billete","Protocolo",
"<h1>Listo!</h1><div>Ha completado correctamente el formulario. <br />Hemos recibido los resultados. Gracias!</div>",
"<h1>Se completó esta aplicación!</h1><div>El protocolo se ha utilizado.</div>",
"Hemos detectado que la página fue actualizada. Utilice el protocolo a seguir la aplicación.");

$linguagem = $_GET["linguagem"];
$lang = $idioma["linguagem_".$linguagem];

?>

<? $l_aplicacao = "Aplicação"; if($_GET["linguagem"] == "en") { $l_aplicacao = "Application"; } if($_GET["linguagem"] == "es") { $l_aplicacao = "Aplicación"; } ?>
<title>MAPER - <?=$l_aplicacao?></title>
<script type="text/javascript" src="aplicacao_js/jquery.js"></script>
<script type="text/javascript" src="aplicacao_js/timer.js"></script>
<script type="text/javascript" src="aplicacao_js/mask.js"></script>
<script type="text/javascript" src="aplicacao_js/scripts.js"></script>
</head>

<body>
<div id="topo"><div id="interno"><a href="https://mapertest.com.br/" target="_blank"></a></div></div>

<?php
    $protocolo_atual = $_POST["protocolo"];
    if($protocolo_atual == "") {
        echo "<script>location.href='index.php?linguagem=".$_GET["linguagem"]."'</script>";
    }
    
    if(!isset($_POST["continuar"])) {
        $checa_protocolo = mysql_query("SELECT * FROM protocolos WHERE protocolo = '$protocolo_atual'");
        if(mysql_num_rows($checa_protocolo) != 0) {
            if(@$lang[12] != "") { echo "<script>alert('".$lang[12]."')"; }
            echo "location.href='index.php'</script>";
            die();
        }
    }

    //CARREGA RESPOSTAS
    $respostas = mysql_query("SELECT * FROM protocolos WHERE protocolo = '$protocolo_atual'");

    if(mysql_num_rows($respostas) != 0 and isset($_POST["continuar"])) {

        $tempo = mysql_result($respostas,0,"tempo");
        $resposta = mysql_result($respostas,0,"resposta");
        
        $organizacao = mysql_result($respostas,0,"organizacao");
        $grupo = mysql_result($respostas,0,"grupo");
    
        $organizacao_sql = mysql_query("SELECT nome FROM organizacoes WHERE id = '".$organizacao."'");
        $grupo_sql = mysql_query("SELECT nome FROM grupos WHERE id = '".$grupo."'");
        $organizacao_label = mysql_result($organizacao_sql,0,"nome");
        $grupo_label = mysql_result($grupo_sql,0,"nome");
        
        $nome_label = utf8_encode(mysql_result($respostas,0,"nome"));
        $email_label = mysql_result($respostas,0,"email");
        $cargo_label = utf8_encode(mysql_result($respostas,0,"cargo"));
        $telefone_label = mysql_result($respostas,0,"telefone");
        $nascimento_label = mysql_result($respostas,0,"nascimento");
        
        if($linguagem != "en" and $linguagem != "es") { 
            $cpf_label = mysql_result($respostas,0,"cpf");
            //echo $cpf_label; die();
            //CHECA REGRA CPF
            if(cpf_ok($cpf_label) == false) {
                $msg = "Detectamos que seu CPF foi utilizado para realizar esta aplicação dentro dos últimos 6 meses. Não será possível realizar a aplicação novamente.";
                
                if($linguagem != "en" and $linguagem != "es") {
                    //if($linguagem == "en") { $msg = "We have detected that its CPF was used for this application within the last 6 months. You can not make the application again."; }
                    //if($linguagem == "es") { $msg = "Hemos detectado que su CPF se utilizó para esta aplicación en los últimos 6 meses. No se puede hacer de nuevo la aplicación."; }
                    echo "<script type='text/javascript'>alert('".$msg."'); location.href='index.php'</script>"; 
                }

            }

        }
        $ticket_label = mysql_result($respostas,0,"ticket");
    }
?>
<input type="hidden" id="respostas" value="<?=$resposta?>" />
<div id="conteudo">
    <div id="perfil">
        <?
        $msg = "Sequência";
        if($linguagem == "en") { $msg = "Sequence"; }
        if($linguagem == "es") { $msg = "Secuencia"; }
        ?>
        <h1><?=$msg?> <span id="atual">1</span> <? if($linguagem == 'en') { echo "of"; } else { echo "de"; }?> 100</h1>   
        <div id="timer"></div>
        <input id="tempo" type="hidden" value="<?=$tempo?>" />
        <div id="slider_container">
            <div style="float: left; overflow: hidden;">
                <?
                $msg = "Houve um erro ao salvar a resposta. Por favor atualize seu navegador (F5).";
                if($linguagem == "en") { $msg = "There was an error saving the answer. Please refresh your browser (F5)."; }
                if($linguagem == "es") { $msg = "Se ha producido un error al guardar la respuesta. Por favor, actualice su navegador (F5)."; }
                ?>
                <div id="erro_falha" style="width: 901px; height: 57px; position: absolute; background: #B70000; color: #FFF; font-size: 22px; padding-top: 25px; text-align: center; display: none;"><?=$msg?></div>
                
                <?
                $msg = "Salvando resposta...";
                if($linguagem == "en") { $msg = "Saving answer..."; }
                if($linguagem == "es") { $msg = "Guardando respuesta..."; }
                ?>
                <div id="load" style="width: 901px; height: 57px; display: none; position: absolute; background: url('aplicacao_img/fundo.png'); font-size: 22px; padding-top: 25px; text-align: center;"><img src="aplicacao_img/ajax-loader.gif" /> <?=$msg?></div>
                
                <?
                $msg = "Processando resultados...";
                if($linguagem == "en") { $msg = "Processing results..."; }
                if($linguagem == "es") { $msg = "Generando resultados..."; }
                ?>
                <div id="load2" style="width: 901px; height: 57px; position: absolute; background: url('aplicacao_img/fundo.png'); font-size: 22px; padding-top: 25px; text-align: center;"><img src="aplicacao_img/ajax-loader.gif" /> <?=$msg?></div>
                
                <div id="slider_wrapper">    
                    <ul id="slider">
                    <? $count = 0; ?>
                    <? $questoes = mysql_query("SELECT DISTINCT ordem FROM questoes GROUP BY ordem ORDER BY ordem ASC"); ?>  
                    <? while($questao = mysql_fetch_array($questoes)) { ?>
                    <li>
                                                
                    <div id="conteudo_slider" style="padding: 20px;">
                    
                        <? $id_ordem = $questao["ordem"] ?>
                        <? $quest = mysql_query("SELECT * FROM questoes WHERE ordem = '$id_ordem' ORDER BY ordem ASC"); ?>
                        
                        <? while($q = mysql_fetch_array($quest)) { 
                            $descricao = "descricao"; 
                            if(@$_GET["linguagem"] == "en") {
                                $descricao = "descricao_en"; 
                            }
                            if(@$_GET["linguagem"] == "es") {
                                $descricao = "descricao_es"; 
                            }
                        ?>
                            <label style="line-height: 20px"><input type="radio" value="<?=$q["sequencia"]?>" class="q_<?=$count?>" name="q_<?=$q["ordem"]?>" onclick="respondeu(<?=$count?>,$('#timer').html(),this.value,'<?=$id_ordem?>','<?=$protocolo_atual?>','<?=$linguagem?>')" /> <?=utf8_encode($q[$descricao])?></label><br />
                        <? } ?>
                    </div>
                    <? $count++; } ?>
                    
                    </li>
                    </ul>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        
        <div id="dados">
            <label><?=$lang[0]?>: </label><?=utf8_decode($nome_label)?><br />
            <label><?=$lang[1]?>: </label><?=$email_label?><br />
            <label><?=$lang[2]?>: </label><?=$telefone_label?><br />
            <label><?=$lang[3]?>: </label><?=$nascimento_label?><br />
            <? if($linguagem != "en" and $linguagem != "es") { ?><label><?=$lang[4]?>: </label><?=$cpf_label?><? } ?>
        </div>
        <div id="dados_organizacao">
            <label><?=$lang[5]?>: </label><?=utf8_encode($organizacao_label)?><br />
            <label><?=$lang[6]?>: </label><?=utf8_encode($grupo_label)?><br />
            <label><?=$lang[7]?>: </label><?=$cargo_label?><br />
            <label><?=$lang[8]?>: </label><?=$ticket_label?><br />
            <label><?=$lang[9]?>: </label><?=$protocolo_atual?><br />
        </div>

    </div>
        
    <div id="fim">
        <?=$lang[10]?>
    </div>
    
    <div id="protocolo_invalido" style="text-align: center;">
        <?=$lang[11]?>
    </div>
    
    
</div>

<div id="rodape">Copyright 1979-<?=date("Y"); ?> MAPER - 55 (31)98201-5757</div>

</body>
</html>