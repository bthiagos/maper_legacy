<?php include("conn.php"); ?>   
<?php include("library.php"); ?>    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Email contato MAPER</title>
</head>
<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$id = $_GET["id"];
$org = $_GET["orga"];
$grup = $_GET["grupo"]; 
$pw = md5($id);

//print_r($_POST);

//exit();

if($_POST["relatorio"] == "" OR $_POST["sendhow"] == "" OR $_POST["sendto"] == "")
{
    alert(utf8_decode("AAÉ necessário preencher todas as opções antes de enviar o e-mail."));
    echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php">';
    exit(); 
}

$relatorio = $_POST["relatorio"];
$enviarpor = $_POST["sendhow"];
$enviarpara = $_POST["sendto"];

$getinfo = mysql_query("SELECT * FROM aplicacoes WHERE id = '$id'");
$getinfo = mysql_fetch_array($getinfo);
$nome=strip_tags(trim($getinfo["nome"]));

//$nome = utf8_encode($nome);

$getorga = mysql_query("SELECT * FROM organizacoes WHERE id = '$org'");
$getorga = mysql_fetch_array($getorga);
$getorganame = $getorga["nome"];

//$link = "<a href='http://mapertest.com.br/cms/testepdf.php?id=".$id."&orga=".$org."' target='_blank'>";

switch($relatorio)
{
    case 1:
        $link = $base_cms."pdf_vendido.php?p=".$pw."&g=".$grup."&orga=1";
        break;
    
    case 2:
        $link = $base_cms."pdf_vendido.php?p=".$pw."&g=".$grup."&orga=999999";
        break;
        
    case 3:
        $link = $base_cms."form_laudo.php?p=".$pw."&g=".$grup."&alterar=1&cod=".$id;
        break;
        
    case 4:
        $link = $base_cms."testepdf.php?p=".$pw."&g=".$grup."&orga=1";
        break;
        
    case 5:
        $link = $base_cms."testepdf.php?p=".$pw."&g=".$grup."&orga=999999";
        break;
        
    case 6:
        $link = $base_cms."novo_relatorio_monta2.php?id=".$id."&p=".$pw."&g=".$grup."&orga=999999";
        break;

    case 7:
        $link = $base_cms."novo_relatorio_monta2.php?id=".$id."&orga=1&lang=br&fm";
        break;
        
    case 8:
        $link = $base_cms."novo_relatorio_monta2.php?id=".$id."&orga=1&lang=en&fm";
        break;
        
    case 9:
        $link = $base_cms."novo_relatorio_monta2.php?id=".$id."&orga=1&lang=es&fm";
        break;
    case 10:
        $link = $base_cms."novo_relatorio_operacional.php?id=".$id."&orga=1&lang=es&fm";
        break;
    case 11:
        $link = $base_cms."novo_relatorio_monta2_vendas.php?id=".$id."&orga=1&lang=es&fm";
        break;
    case 12:
        $link = $base_cms."novo_relatorio_monta2_vendas_1.php?id=".$id."&orga=1&lang=es&fm";
        break;
    case 13:
        $link = $base_cms."novo_relatorio_monta2.php?id=".$id."&orga=1&lang=es&fm&sn";
        break;
    case 14:
        $link = $base_cms."pdi/gerador.php?id=".$id;
        break;
}


//https://cms.mapertest.com.br/pdi/gerador.php?id=68449

if($enviarpor == "Grupo")
{
    if($enviarpara == "Candidato")
    {
        //GRUPO -> Candidato
        require('class.phpmailer.php');
        
        $texto="<a href='http://mapertest.com.br/cms/testepdf.php?&p=".$pw."&g=".$grup."&orga=".$org."' target='_blank'>Relatório: ".$nome."</a>";
        
        $mail = new PHPMailer(); //instancia a classe PHPMailer
        $mail->IsSMTP(); //define que o email será enviado por SMTP
        $mail->SMTPAuth = true;
        //$mail->SMTPSecure = "tls";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        //$mail->Host = 'comlinux3.citis.com.br'; //define o servidor smtp - altere para o seu servidor smtp
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        //$mail->Username = 'noreply@mapertest.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
        $mail->SetFrom('naorespondapublix@yahoo.com', 'MAPER'); //define o remetente da mensagem, altere para o real


        $mail->Host       = "smtp.mail.yahoo.com";
        $mail->Username =   "naorespondapublix@yahoo.com";
        $mail->Password =   "eyxagqxhuvjsbaxj";
            
        
        $mailstosend = mysql_query("SELECT * FROM aplicacoes WHERE grupo = '$grup'");
        while($tosend = mysql_fetch_array($mailstosend))
        {
            
        $nome = $tosend["nome"];
        $nome = utf8_encode($nome);
        $email = $tosend["email"];
        //$email = "thales@agenciapenta.com.br";
        
        $mail->ClearAllRecipients();
        $mail->AddAddress($email, 'Contato'); 
        $mail->Subject = utf8_encode('MAPER - Relatório ').utf8_encode($nome); //define o assunto da mensagem
        //$mail->AddAddress($email, 'Contato'); //define o destino da mensagem, altere para o desejado
        
        $ide = $tosend["id"];
        $pw = md5($ide);
        switch($relatorio)
        {
            case 1:
                $link = $base_cms."pdf_vendido.php?p=".$pw."&g=".$grup."&orga=1";
                break;
            
            case 2:
                $link = $base_cms."pdf_vendido.php?p=".$pw."&g=".$grup."&orga=999999";
                break;
                
            case 3:
                $link = $base_cms."form_laudo.php?p=".$pw."&g=".$grup."&alterar=1&cod=".$ide;
                break;
                
            case 4:
                $link = $base_cms."testepdf.php?p=".$pw."&g=".$grup."&orga=1";
                break;
                
            case 5:
                $link = $base_cms."testepdf.php?p=".$pw."&g=".$grup."&orga=999999";
                break;
            case 6:
                $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&p=".$pw."&g=".$grup."&orga=999999";
                break;

            case 7:
                $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=br&fm";
                break;
                
            case 8:
                $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=en&fm";
                break;
                
            case 9:
                $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=es&fm";
                break;
            case 10:
                $link = $base_cms."novo_relatorio_operacional.php?id=".$id."&orga=1&lang=es&fm";
                break;
            case 11:
                $link = $base_cms."novo_relatorio_monta2_vendas.php?id=".$id."&orga=1&lang=es&fm";
                break;
            case 12:
                $link = $base_cms."novo_relatorio_monta2_vendas_1.php?id=".$id."&orga=1&lang=es&fm";
                break;
            case 13:
                $link = $base_cms."novo_relatorio_monta2.php?id=".$id."&orga=1&lang=es&fm&sn";
                break;
    case 14:
        $link = $base_cms."pdi/gerador.php?id=".$id;
        break;
        }
        $body = "
        <span style='font-size: 12px; font-family: Arial, Verdana;'>
        Prezado ".$nome.",<br /><br />
        Os resultados de sua avaliação do diagnóstico de perfil e competências MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação.
        <br /><br />Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: 31-3293-2590.<br /></br /><br /></br />
        Clique no link abaixo para visualizar o seu relatório.<br /><br />
        </span>
        <span style='font-size: 12px; font-family: Arial, Verdana;'>
        <a href='".$link."' target='_blank'>Relatório: ".$nome."</a>
        </span><br /><br />
        <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";
        
        if (($org == "418")) {
            $body = "
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            Prezado ".$nome.",<br /><br />
            Os resultados de sua avaliação do diagnóstico de perfil e competências MAPER® foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. 
            <br /><br />É importante que você imprima o seu diagnóstico e leve ao Seminário Presencial de Abertura do seu MBA Online.<br /></br /><br /></br />
            Clique no link abaixo para visualizar o seu relatório.<br /><br />
            </span>
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório: ".$nome."</a>
            </span><br /><br />
            <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";    
        }
         
        //a variavel $body define o corpo da mensagem
        $mail->MsgHTML($body); //configura o email como HTML
        $mail->Send();
        
        }
        echo'<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?feito=1">';
    } else {
        //GRUPO -> Empresa
        require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
        $email = $_POST["mailempresa"];
        //$email = "thales@agenciapenta.com.br";
        
        $mail = new PHPMailer(); //instancia a classe PHPMailer
        $mail->IsSMTP(); //define que o email será enviado por SMTP
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        //$mail->Host = 'comlinux3.citis.com.br'; //define o servidor smtp - altere para o seu servidor smtp
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        //$mail->Username = 'noreply@mapertest.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
        $mail->SetFrom('naorespondapublix@yahoo.com', 'MAPER'); //define o remetente da mensagem, altere para o real


        $mail->Host       = "smtp.mail.yahoo.com";
        $mail->Username =   "naorespondapublix@yahoo.com";
        $mail->Password =   "eyxagqxhuvjsbaxj";
        
        $mail->AddAddress($email, 'Contato'); //define o destino da mensagem, altere para o desejado
        $mail->Subject = utf8_encode('MAPER - Relatório ').$getorganame; //define o assunto da mensagem
        
        $mailstosend = mysql_query("SELECT * FROM aplicacoes WHERE grupo = '$grup' ORDER BY nome ASC");
         
        $body = "
        <span style='font-size: 12px; font-family: Arial, Verdana;'>
        Prezada ".utf8_encode($getorganame).",<br /><br />
        Os resultados  de seus candidatos / funcionários do diagnóstico de perfil e competências MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo.
        <br /><br />Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: 31-3293-2590.<br /></br /><br /></br />
        Clique no link abaixo para visualizar o seu relatório.<br /><br />
        </span>";
        
        if (($org == "418")) {
            $body = "
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            Prezado ".$nome.",<br /><br />
            Os resultados de sua avaliação do diagnóstico de perfil e competências MAPER® foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. 
            <br /><br />É importante que você imprima o seu diagnóstico e leve ao Seminário Presencial de Abertura do seu MBA Online.<br /></br /><br /></br />
            Clique no link abaixo para visualizar o seu relatório.<br /><br />
            </span>
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório: ".$nome."</a>
            </span><br /><br />
            <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";    
        }
        
        while($tosend = mysql_fetch_array($mailstosend))
        {
            $ide = $tosend["id"];
            $pw = md5($ide);
            switch($relatorio)
            {
                case 1:
                    $link = $base_cms."pdf_vendido.php?p=".$pw."&g=".$grup."&orga=1";
                    break;
                
                case 2:
                    $link = $base_cms."pdf_vendido.php?p=".$pw."&g=".$grup."&orga=999999";
                    break;
                    
                case 3:
                    $link = $base_cms."form_laudo.php?p=".$pw."&g=".$grup."&alterar=1&cod=".$id;
                    break;
                    
                case 4:
                    $link = $base_cms."testepdf.php?p=".$pw."&g=".$grup."&orga=1";
                    break;
                    
                case 5:
                    $link = $base_cms."testepdf.php?p=".$pw."&g=".$grup."&orga=999999";
                    break;
                    
                case 6:
                    $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&p=".$pw."&g=".$grup."&orga=999999";
                    break;

                case 7:
                    $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=br&fm";
                    break;
                    
                case 8:
                    $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=en&fm";
                    break;
                    
                case 9:
                    $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=es&fm";
                    break;
                case 10:
                    $link = $base_cms."novo_relatorio_operacional.php?id=".$ide."&orga=1&lang=es&fm";
                    break;
                case 11:
                    $link = $base_cms."novo_relatorio_monta2_vendas.php?id=".$ide."&orga=1&lang=es&fm";
                    break;
                case 12:
                    $link = $base_cms."novo_relatorio_monta2_vendas_1.php?id=".$ide."&orga=1&lang=es&fm";
                    break;
                case 13:
                    $link = $base_cms."novo_relatorio_monta2.php?id=".$ide."&orga=1&lang=es&fm&sn";
                    break;
                case 14:
                    $link = $base_cms."pdi/gerador.php?id=".$id;
                    break;
            }
             
            $nome = $tosend["nome"];
            $nome = utf8_encode($nome);
            $body .= "<span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório: ".$nome."</a>
            </span><br />";
        }
        $body .= "<br /><span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";
        //a variavel $body define o corpo da mensagem
        $mail->MsgHTML($body); //configura o email como HTML
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        if($mail->Send()){ //tenta enviar o email
        //se consegue
        echo'<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?feito=1">';
            //echo 1;
        }else{
         //se n�o conseguir, exibe a mensagem aqui definida
        echo'<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?erro=1">';
           // echo 2;
        }
    }
} else {
    if($enviarpara == "Candidato")
    {
        
        //INDIVIDUAL -> Candidato
        $email = $_POST["mailcandidato"];
        //$email = "thales@agenciapenta.com.br";

        if(empty($nome)){
        $msg='O Nome é Obrigatório';
        }elseif(empty($email)){
        $msg='O E-mail é Obrigatório';
        }else{ //se todos os campos estiverem preenchidos, configura e envia o email
        require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
        
        $texto="<a href='http://mapertest.com.br/cms/testepdf.php?id=".$id."&orga=".$org."' target='_blank'>Relatório: ".$nome."</a>";

        $mail = new PHPMailer(); //instancia a classe PHPMailer
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP(); //define que o email será enviado por SMTP
        $mail->SMTPAuth = true;
        //$mail->SMTPSecure = "tls";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        //$mail->Host = 'comlinux3.citis.com.br'; //define o servidor smtp - altere para o seu servidor smtp
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        //$mail->Username = 'noreply@mapertest.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
        $mail->SetFrom('naorespondapublix@yahoo.com', 'MAPER'); //define o remetente da mensagem, altere para o real


        $mail->Host       = "smtp.mail.yahoo.com";
        $mail->Username =   "naorespondapublix@yahoo.com";
        $mail->Password =   "eyxagqxhuvjsbaxj";
        
        $mail->AddAddress($email, 'Contato'); //define o destino da mensagem, altere para o desejado

        //$nome = utf8_decode($nome);

        $mail->Subject = utf8_decode("MAPER - Relatório - ".$nome); //define o assunto da mensagem 



        $body = "Prezado $nome <br /><br />".
        $body .= "Os resultados de sua avaliação do diagnóstico de perfil e competências MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. ";
        $body .= "<br /><br />";
        $body .= " Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: (31) 98201-5757 (WhatsApp) ou (31) 98454-4457.";
        $body .= "<br /><br />";
        $body .= "<span style='font-size: 12px; font-family: Arial, Verdana;'>
        <a href='".$link."' target='_blank'>Relatório: ".$nome."</a>
        </span><br /><br />
        <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";

        
        if (($org == "418")) {
            $body = "
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            Prezado ".utf8_encode($nome).",<br /><br />
            Os resultados de sua avaliação do diagnóstico de perfil e competências MAPER® foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. 
            <br /><br />É importante que você imprima o seu diagnóstico e leve ao Seminário Presencial de Abertura do seu MBA Online.<br /></br /><br /></br />
            Clique no link abaixo para visualizar o seu relatório.<br /><br />
            </span>
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório: ".utf8_encode($nome)."</a>
            </span><br /><br />
            <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";    
        }

        if ($relatorio == 14) {
            $body = "";
            $body = "Prezado $nome <br /><br />".
            $body .= "Os resultados de sua avaliação do Programa de desenvolvimento pessoal (PDI) do MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. ";
            $body .= "<br /><br />";
            $body .= " Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: (31) 98201-5757 (WhatsApp) ou (31) 98454-4457.";
            $body .= "<br /><br />";
            $body .= "<span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório PDI: ".$nome."</a>
            </span><br /><br />
            <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";  
            $mail->Subject = utf8_decode("MAPER - Relatório PDI - ".$nome); //define o assunto da mensagem 
        }
        
        //a variavel $body define o corpo da mensagem
        $mail->MsgHTML($body); //configura o email como HTML
        
        if($mail->Send()){ //tenta enviar o email
        //se consegue
        echo'<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?feito=1">';
        }else{
         //se n�o conseguir, exibe a mensagem aqui definida
        echo'<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?erro=1">';
        }
        }
        
    } else {
        //INDIVIDUAL -> Empresa
        $email = $_POST["mailempresa"];
        //$email = "thales@agenciapenta.com.br";

        if(empty($nome)){
        $msg='O Nome é Obrigatório';
        }elseif(empty($email)){
        $msg='O E-mail é Obrigatório';
        }else{ //se todos os campos estiverem preenchidos, configura e envia o email
        require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
        
        $texto="<a href='http://mapertest.com.br/cms/testepdf.php?id=".$id."&orga=".$org."' target='_blank'>Relatório: ".$nome."</a>";

        $mail = new PHPMailer(); //instancia a classe PHPMailer
        $mail->IsSMTP(); //define que o email será enviado por SMTP
        $mail->SMTPAuth = true;
        //$mail->SMTPDebug = true;
        //$mail->SMTPSecure = "tls";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        //$mail->Host = 'comlinux3.citis.com.br'; //define o servidor smtp - altere para o seu servidor smtp
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        //$mail->Username = 'noreply@mapertest.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
        $mail->SetFrom('naorespondapublix@yahoo.com', 'MAPER'); //define o remetente da mensagem, altere para o real


        $mail->Host       = "smtp.mail.yahoo.com";
        $mail->Username =   "naorespondapublix@yahoo.com";
        $mail->Password =   "eyxagqxhuvjsbaxj";
        
        //$mail->SetFrom('sergio@publixcomunicacao.com.br', 'MAPER'); //define o remetente da mensagem, altere para o real
        $mail->AddAddress($email, 'Contato'); //define o destino da mensagem, altere para o desejado
        $mail->Subject = utf8_decode('MAPER - Relatório ').$getorganame; //define o assunto da mensagem
        //contato@obaeventos.net
        
         $body = "
        <span style='font-size: 12px; font-family: Arial, Verdana;'>
        Prezada ".utf8_encode($getorganame).",<br /><br />
        Os resultados de seus candidatos / funcionários do diagnóstico de perfil e competências MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo.
        <br /><br />Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: 31-3293-2590.<br /></br /><br /></br />
        Clique no link abaixo para visualizar o seu relatório.<br /><br />
        </span>";
            $body .= "<span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório: ".utf8_encode($nome)."</a>
            </span><br />";
        
        $body .= "<br /><span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";
        
        if (($org == "418")) {
            $body = "
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            Prezado ".utf8_encode($nome).",<br /><br />
            Os resultados de sua avaliação do diagnóstico de perfil e competências MAPER® foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. 
            <br /><br />É importante que você imprima o seu diagnóstico e leve ao Seminário Presencial de Abertura do seu MBA Online.<br /></br /><br /></br />
            Clique no link abaixo para visualizar o seu relatório.<br /><br />
            </span>
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório: ".utf8_encode($nome)."</a>
            </span><br /><br />
            <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";    
        }

        if ($relatorio == 14) {
            $body = "";
            $body = "Prezado $nome <br /><br />".
            $body .= "Os resultados de sua avaliação do Programa de desenvolvimento pessoal (PDI) do MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo e apreciação. ";
            $body .= "<br /><br />";
            $body .= " Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: (31) 98201-5757 (WhatsApp) ou (31) 98454-4457.";
            $body .= "<br /><br />";
            $body .= "<span style='font-size: 12px; font-family: Arial, Verdana;'>
            <a href='".$link."' target='_blank'>Relatório PDI: ".$nome."</a>
            </span><br /><br />
            <span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";  

             $body = "
            <span style='font-size: 12px; font-family: Arial, Verdana;'>
            Prezada ".utf8_encode($getorganame).",<br /><br />
            Os resultados de seus candidatos / funcionários do Programa de desenvolvimento pessoal (PDI) do MAPER® - Avaliação de Potencial e Perfil foram tabulados e estamos enviando-lhe uma cópia para seu arquivo.
            <br /><br />Caso tenha alguma dúvida favor nos contatar por meio da nossa central de atendimento: 31-3293-2590.<br /></br /><br /></br />
            Clique no link abaixo para visualizar o seu relatório.<br /><br />
            </span>";
                $body .= "<span style='font-size: 12px; font-family: Arial, Verdana;'>
                <a href='".$link."' target='_blank'>Relatório PDI: ".utf8_encode($nome)."</a>
                </span><br />";
            
            $body .= "<br /><span style='font-size: 12px; font-family: Arial, Verdana;'>Atenciosamente, <br />Equipe MAPER</span>";


            $mail->Subject = utf8_decode('MAPER - Relatório PDI ').$getorganame; //define o assunto da mensagem
        }
 
        //a variavel $body define o corpo da mensagem
        $mail->MsgHTML($body); //configura o email como HTML
        
        if($mail->Send()){ //tenta enviar o email
        //se consegue
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?feito=1">';
        }else{
         //se n�o conseguir, exibe a mensagem aqui definida
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=aplica_gerencia.php?erro=1">';
        }
        }
    }
}

//fim

//contato@obaeventos.net 

?>
<body>
</body>
</html> 