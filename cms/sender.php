<?php
        require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"
        $mail = new PHPMailer(); //instancia a classe PHPMailer
    	$mail->IsSMTP(); //define que o email será enviado por SMTP
    	$mail->SMTPAuth = true;
    	//$mail->SMTPSecure = "tls";
    	$mail->Port = 587; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        $mail->Host = '216.59.16.52'; //define o servidor smtp - altere para o seu servidor smtp
        //$mail->Host = 'smtp.gmail.com';
        //$mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        //$mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        $mail->Username = 'atendimento@appweb.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        $mail->Password = 'App2205Ate'; //define a senha do servidor smtp, altere para a sua    
    	$mail->SetFrom('app@appweb.com.br', 'APPWEB'); //define o remetente da mensagem, altere para o real
    
        //$mail->AddAddress("thalesu@gmail.com","Thales");
        $mail->AddAddress("thalesu@gmail.com");
        //$mail->AddAddress("leandroliberio@gmail.com","Webmaster");
        

        $men = '
        <table border="0" cellpadding="0" cellspacing="0" width="691">
  <tr>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/news_1_r1_c1.jpg" alt="" name="news_1_r1_c1" width="691" height="400" usemap="#news_1_r1_c1Map" id="news_1_r1_c1" border="0" /></td>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/spacer.gif" width="1" height="400" alt="" /></td>
  </tr>
  <tr>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/news_1_r2_c1.jpg" alt="" name="news_1_r2_c1" width="691" height="403" usemap="#news_1_r2_c1Map" id="news_1_r2_c1" border="0" /></td>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/spacer.gif" width="1" height="403" alt="" /></td>
  </tr>
  <tr>
   <td valign="top"><img style="display:block;" name="news_1_r3_c1" src="http://appweb.com.br/marketing/news1/news_1_r3_c1.jpg" width="691" height="392" id="news_1_r3_c1" alt="" /></td>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/spacer.gif" width="1" height="392" alt="" /></td>
  </tr>
  <tr>
   <td valign="top"><img style="display:block;" name="news_1_r4_c1" src="http://appweb.com.br/marketing/news1/news_1_r4_c1.jpg" width="691" height="363" id="news_1_r4_c1" alt="" /></td>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/spacer.gif" width="1" height="363" alt="" /></td>
  </tr>
  <tr>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/news_1_r5_c1.jpg" alt="" name="news_1_r5_c1" width="691" height="101" usemap="#news_1_r5_c1Map" id="news_1_r5_c1" border="0" /></td>
   <td valign="top"><img style="display:block;" src="http://appweb.com.br/marketing/news1/spacer.gif" width="1" height="101" alt="" /></td>
  </tr>
</table>
<map name="news_1_r2_c1Map">
  <area shape="rect" coords="515,152,606,178" href="#" target="_blank" alt="Saiba Mais">
</map>

<map name="news_1_r5_c1Map">
  <area shape="rect" coords="84,37,174,52" href="#" target="_blank" alt="Site App">
  <area shape="rect" coords="528,34,585,49" href="#" target="_blank" alt="Perfil App">
</map>

<map name="news_1_r1_c1Map">
  <area shape="rect" coords="54,28,212,122" href="#" target="_blank" alt="Logo App">
</map>
';
        
        $mail->Subject = "APP - Sugestão"; //define o assunto da mensagem
        $mail->MsgHTML($men); //configura o email como HTML
    					
    	if ($mail->Send()) {
    	   echo "ok";
        } else {
            echo "erro";
        }
    ?>