<?php include("logon.php"); ?>
<?php include("conn.php"); ?>
<?php include("library.php"); ?>


<?
/*
        $sql = "SELECT organizacoes.nome as orgname, grupos.nome as orggrupo, aplicacoes.nome,aplicacoes.email,aplicacoes.telefone FROM aplicacoes
        LEFT JOIN organizacoes ON organizacoes.id = aplicacoes.organizacao
        LEFT JOIN grupos ON grupos.id = aplicacoes.grupo
        WHERE organizacoes.id = '193' ORDER BY grupos.nome,aplicacoes.nome ASC
        ";

        $sql = mysql_query($sql);

        echo "<table border='1' cellspacing='1' cellpadding='1'>";
        while($g = mysql_fetch_array($sql))
        {
            $n = strtolower($g["nome"]);
                echo "<tr>
                <td>".ucwords($n)."</td>
                <td>".strtolower($g["email"])."</td>
                <td>".$g["telefone"]."</td>
                <td>".$g["orggrupo"]."</td>

                </tr>";
        }
        echo "</table>";
*/
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<body>
<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>


        <!-- INICIO - DIV global - Emgloba todo o site -->
        <div id="global">

                <!-- INICIO - DIV TOPO - Emgloba todo o site -->
        <div id="topo">
            <img src="imagens/top_mapper.png"   />
        </div>
                <!-- FIM - DIV TOPO - Emgloba todo o site -->


                <!-- INICIO - DIV MENU - Menu do Sistema -->
                <?php include("menu.php"); ?>
                <!-- INICIO - DIV MENU - Menu do Sistema -->

        <?php

        if(isset($_GET["nome_relatorio"])) {
            $nome_relatorio = $_POST["nome_relatorio"];
            mysql_query("UPDATE ce_usuario SET nome_relatorio = '$nome_relatorio' WHERE CodUsuario = '".$_SESSION["id_usuario_adm"]."'") or die(mysql_error());

           alert("Informa▒▒o salva!");
           redireciona("home.php");
        }

        $nome_rel = "";
        $nome_sql = mysql_query("SELECT nome_relatorio FROM ce_usuario WHERE CodUsuario = '".$_SESSION["id_usuario_adm"]."'");
        if(mysql_num_rows($nome_sql) > 0) { $nome_rel = mysql_result($nome_sql,0,"nome_relatorio"); }

        if(isset($_GET["sugestao"])) {
            require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
            $mail = new PHPMailer(); //instancia a classe PHPMailer
                $mail->IsSMTP(); //define que o email ser▒ enviado por SMTP
                $mail->SMTPAuth = true;
                //$mail->SMTPSecure = "tls";
                $mail->Port = 587; //define a porta do servidor smtp - altere para a porta que seu servidor usa
            $mail->Host = 'smtp.appweb.com.br'; //define o servidor smtp - altere para o seu servidor smtp
            //$mail->Host = 'smtp.gmail.com';
            //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usu▒rio
            //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua
            $mail->Username = 'atendimento@appweb.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usu▒rio
            $mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua
                $mail->SetFrom('app@appweb.com.br', 'APPWEB'); //define o remetente da mensagem, altere para o real

            //$mail->AddAddress("thalesu@gmail.com","Thales");
            $mail->AddAddress("contato@appweb.com.br","Contato App");
            $mail->AddAddress("leandroliberio@gmail.com","Webmaster");

            $data = date("d/m/Y H:i:s");
            $sugestao = $_POST["sugestao"];

            $men = "
            <table cellspacing='0' cellpadding='0' border='1'>
                <tr>
                    <td style='padding: 7px' align='center' bgcolor='#E8E8E8'>Sugest▒o enviada por <strong>".$_SESSION["nome_usuario_adm"]." ".$_SESSION["sobrenome_usuario_adm"]."</strong> ▒s $data</td style='padding: 7px'>
                </tr>
                <tr>
                    <td style='padding: 7px' align='center'>$sugestao</td style='padding: 7px'>
                </tr>
            </table>
            ";

            $mail->Subject = "APP - Sugest▒o"; //define o assunto da mensagem
            $mail->MsgHTML($men); //configura o email como HTML

                if ($mail->Send()) {
                   alert("Sua sugest▒o foi enviada com sucesso!");
               redireciona("home.php");
            } else {
               redireciona("home.php");
            }
        }

        ?>

        <script>
            function check_sug() {
                if($("#sugest").val() == 'Deixe sua sugest▒o.') {
                    alert("Por favor, digite uma sugest▒o.");
                    return false;
                }
            }
        </script>

        <form action="?nome_relatorio=1" method="POST">
            <div style="border: 2px solid gray; font-size: 15px; padding: 10px; font-family: Arial; width: 235px; margin-left: auto; margin-right: auto; margin-top: 150px; text-align: center; background: #E8E8E8">
                <div>Digite o nome que aparecer▒ no topo dos relat▒rios:</div>
                <div style="margin-top: 8px;"><input maxlength="40" value="<?=$nome_rel?>" type="text" id="nome_relatorio" name="nome_relatorio" style="padding: 5px; border: 1px solid gray; font-family: Arial; width: 90%; margin-left: auto; margin-right: auto;" /></div>
                <div style="margin-top: 8px; text-align: center;"><input id="salvar_nome" type="submit" value="Salvar" style="width: 80px; border: 1px solid #000; background: #FFF;" /></div>
            </div>
        </form>

        <div style="font-family: Arial; margin-inline: auto; border: 2px solid gray; font-size: 15px; padding: 10px; font-family: Arial; width: 435px; margin-left: auto; margin-right: auto; margin-top: 60px; text-align: center; background: #E8E8E8; margin-bottom: -100px;">
            Indique o Mapertest e transforme suas conex▒es em benef▒cios exclusivos: juntos, crescemos e reconhecemos quem faz a diferen▒a!<br/>
            <a href="https://api.whatsapp.com/send?phone=5531982015757&text=Tenho%20uma%20indica%C3%A7%C3%A3o%20para%20o%20Mapertest!" target="_blank">Clique aqui e indique agora!</a>
        </div>

        <form action="?sugestao=1" method="POST" onsubmit="return check_sug();">
        <div style="border: 2px solid gray; font-size: 15px; padding: 10px; font-family: Arial; width: 435px; margin-left: auto; margin-right: auto; margin-top: 200px; text-align: center; background: #E8E8E8">
            <div>Como podemos melhorar este sistema para voc▒?</div>
            <div style="margin-top: 8px;"><textarea id="sugest" name="sugestao" style="border: 1px solid gray; font-family: Arial; width: 90%; margin-left: auto; margin-right: auto; height: 50px;" onfocus="if($(this).html() == 'Deixe sua sugest▒o.') { $(this).html(''); }" onblur="if($(this).html() == '') { $(this).html('Deixe sua sugest▒o.'); }">Deixe sua sugest▒o.</textarea></div>
            <div style="margin-top: 8px; text-align: center;"><input id="bott" type="submit" value="Enviar" style="width: 80px; border: 1px solid #000; background: #FFF;" /></div>
        </div>
        </form>
        </div>
        <!-- FIM - DIV global - Emgloba todo o site -->

<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>

