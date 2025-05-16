<?
// BIBLIOTECA DE FUNCOES
function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++)
 {
 if($mask[$i] == '#')
 {
 if(isset($val[$k]))
 $maskared .= $val[$k++];
 }
 else
 {
 if(isset($mask[$i]))
 $maskared .= $mask[$i];
 }
 }
 return $maskared;
}

function criaURL($url){
	
    $nova_url = $url;
    //$nova_url = strtolower($nova_url);
        
	$retira = array("!","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�"," ",";",":","1�","2�","3�","/", ",");
	$coloca = array("","a","a","a","a","e","e","i","o","o","o","u","c","a","a","a","a","e","e","i","o","o","o","u","c","-","","","primeiro","segundo","terceiro","-","");
	
	$nova_url = str_replace($retira,$coloca,$nova_url);
	
    $nova_url = strtolower($nova_url);
        
	return $nova_url;
}

function total_resposta($id_pesq,$id_agrupa,$unidade) {
    $sql = "
        SELECT respostas_clima_ticket.ticket, tickets_clima.ticket, tickets_clima.id_agrupa
        FROM
        respostas_clima_ticket
        Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
        WHERE id_pesquisa='$id_pesq' and resposta='$unidade' and tickets_clima.id_agrupa='$id_agrupa' and id_alternativa=1
    ";
    
    //echo $sql;
    $reslta_resp = mysql_query($sql);
    $total = mysql_num_rows($reslta_resp);
    return $total;    
}

function total_resposta_tick($id_pesq,$id_agrupa,$unidade) {
    $sql = "
        SELECT respostas_clima_ticket.ticket, tickets_clima.ticket, tickets_clima.id_agrupa
        FROM
        respostas_clima_ticket
        Inner Join tickets_clima ON respostas_clima_ticket.ticket = tickets_clima.ticket
        WHERE id_pesquisa='$id_pesq' and resposta='$unidade' and tickets_clima.id_agrupa='$id_agrupa' and id_alternativa=1
    ";
    
    //echo $sql;
    $reslta_resp = mysql_query($sql);
    $total = mysql_fetch_array($reslta_resp);
    return $total["ticket"];    
}

// Busca o ID do agrupamento dos tickets de pesquisa de clima
function id_agrupamento($data,$orga,$quant,$pesq) {
    
    $sql = "SELECT id FROM grupo_tickets_clima WHERE id_cliente='$orga' and id_pesquisa='$pesq' and data_gera='$data' and quantidade='$quant'";
    $result = mysql_query($sql);
    $linha = mysql_fetch_assoc($result);
    $id = $linha["id"];
    return $id;
}

// Gera os tickets de pesquisa de clima
function gera_tickets_clima($id_agrupa,$quant,$id_pesquisa,$id_cliente) {

    //Criando o Numero
    $num = time();
    
    //Retirando os 6 ultimos numeros da string
    $num = substr($num,(strlen($num)-4),strlen($num));
    $num = $id_pesquisa.$id_cliente.$num.$i;
    
    for ($i=1;$i<=$quant;$i++) {
        //Concatenando o numero com o codigo do cliente e o codigo da pesquisa
        $num_final =  $num.$i; 
        mysql_query("INSERT INTO tickets_clima (ticket,id_agrupa,usou) VALUES ('$num_final','$id_agrupa','0')");
        //echo $sql."<br>";
    }
    
}

// Funcao q retorna Permissao da pagina
function bloqueio_relatorio($n_relatorio,$empresa) {
	
		$sql = "SELECT * FROM relatorios WHERE relatorio=$n_relatorio and id_empresa=$empresa";
		$result = mysql_query($sql);
		
		if (mysql_num_rows($result) > 0){
			return 1;
		}else{
			return 0;
		}
}




//
function dispara_email_tickets($num_pedido,$nome,$email) {

// Destinario
$to = "$email";

// Assunto
$subject = "AppWeb - Tickets";

// Cabecalho
$headers = "From: AppWeb <leandro@appweb.com.br>\n";
$headers .= "Reply-To: AppWeb <leandro@appweb.com.br>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=utf-8";


$sql = "SELECT * FROM tickets WHERE num_pedido='$num_pedido'";
$result = mysql_query($sql);
echo $sql;
echo $email;
//break;

$tickets = "";
$i = 0;
while ($linha = mysql_fetch_assoc($result)) {
	$i++;
	$num_ticket = $linha["num_ticket"];
	$tickets .= "N&uacute;mero do $i� ticket: <strong>$num_ticket</strong><br/>";
}


// Corpo do E-mail
$message = "
<html>
	<head>
		<title>AppWeb - Tickets</title>
	</head>
	
	<body>
		<p>Ol&aacute; $nome,</p>
		<p>Recebemos a confirma&ccedil;&atilde;o do seu pagamento!</p>
		<p>Segue abaixo o n&uacute;mero do(s) seu(s) Ticket(s):</p>
		<p>$tickets</p>
		<p>Para realizar o teste, acesse nosso site <a href='http://www.appweb.com.br'>www.appweb.com.br</a> e entre no link <strong>Fa&ccedil;a seu teste</strong>. <strong>Aten&ccedil;&atilde;o! N&atilde;o esque&ccedil;a de fornecer o ticket no formul&aacute;rio de inscri&ccedil;&atilde;o do teste. Ap&oacute;s o teste realizado, voc&ecirc; receber&aacute; por e-mail o resultado.</strong></p>
		<p>Atenciosamente,</p>
		<p>Equipe AppWeb</p>
	</body>
</html>
";


// Envio da mensagem
$mail_sent = @mail($to, $subject, $message, $headers);
	
	
}

// Array de meses
$meses[1] = "Jan";
$meses[2] = "Fev";
$meses[3] = "Mar";
$meses[4] = "Abr";
$meses[5] = "Mai";
$meses[6] = "Jun";
$meses[7] = "Jul";
$meses[8] = "Ago";
$meses[9] = "Set";
$meses[10] = "Out";
$meses[11] = "Nov";
$meses[12] = "Dez";

function executa_url($url) {
    $header = array
    (
        "Host: www.appweb.com.br/" // IMPORTANT
    );
    
	$ch = curl_init();
	// informar URL e outras fun��es ao CURL
	curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Acessar a URL e retornar a sa�da
	
	$output = curl_exec($ch);
    
    if(curl_errno($ch)){
        echo 'Curl error: ' . curl_error($ch);
    }
    	
	// liberar
	curl_close($ch);
	
	// retorna a sa�da
    $output = file_get_contents($url);
	return $output;
	
}

function stringParaBusca($str) {
	//Transformando tudo em min�sculas
	$str = trim(strtolower($str));

	//Tirando espa�os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
	while ( strpos($str,"  ") )
		$str = str_replace("  "," ",$str);
	
	//Agora, vamos trocar os caracteres perigosos "�,�..." por coisas limpas "a"
	$caracteresPerigosos = array ("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","!","?",",","�","�","-","\"","\\","/");
	$caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
	$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);
	
	//Agora que n�o temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
	//vamos montar a express�o regular para o MySQL
	$caractresSimples = array("a","e","i","o","u","c");
	$caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
	$str = str_replace($caractresSimples,$caractresEnvelopados,$str);
	$caracteresParaRegExp = array(
		"(a|�|�|�|�|�|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|�|�|�|�|�|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
		"(e|�|�|�|�|&eacute;|&egrave;|&euml;|&ecirc;|�|�|�|�|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
		"(i|�|�|�|�|&iacute;|&igrave;|&iuml;|&icirc;|�|�|�|�|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
		"(o|�|�|�|�|�|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|�|�|�|�|�|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
		"(u|�|�|�|�|&uacute;|&ugrave;|&uuml;|&ucirc;|�|�|�|�|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
		"(c|�|�|&ccedil;|&Ccedil;)" );
	$str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);
	
	//Trocando espa�os por .*
	$str = str_replace(" ",".*",$str);
	
	//Retornando a String finalizada!
	return $str;
}

// Funcao q retorna Permissao da pagina
function permita($cod_permit,$pagina) {
	if ($cod_permit != 555) {
		$sql = "SELECT $pagina FROM ce_permissoes WHERE codigo=$cod_permit";
		$result = mysql_query($sql);
		$linha = mysql_fetch_assoc($result);
		
		if ($linha["$pagina"] == 0) {
			header("Location: alerta.php");
		}
	}
}


// Funcao q retorna Permissao da pagina
function retorna_permita($cod_permit,$pagina) {
	if ($cod_permit != 555) {
		$sql = "SELECT $pagina FROM ce_permissoes WHERE codigo=$cod_permit";
		$result = mysql_query($sql);
		$linha = mysql_fetch_assoc($result);
		
		return $linha["$pagina"];
	}else{
		return 1;
	}
	
}
// Funcao pra acionar o alert
function alert($frase) {

	echo "<script language=\"javascript\">alert('$frase');</script>";
	
}

// Funcao pra acionar o alert
function alert_return($frase) {

	return "<script language=\"javascript\">alert('$frase');</script>";
	
}


// Funcao para redirecionar.
function redireciona($arq) {

	echo "<script language=\"javascript\">
		location.href = \"$arq\";
	</script>";
	
}

function SimNaoIcone($valor,$tabela,$campo,$codigo) {
	
	if ($valor == 1) {
		$icone = "<a href='noticias_gerencia.php?muda=1&valor=0&tabela=$tabela&campo=$campo&cod=$codigo'><img src='imagens/sim.gif' title='Sim' alt='Sim' border='0'></a>";
	}
	
	if ($valor == 0) {
		$icone = "<a href='noticias_gerencia.php?muda=1&valor=1&tabela=$tabela&campo=$campo&cod=$codigo'><img src='imagens/nao.gif' title='N�o' alt='N�o' border='0'></a";
	}
	
	return $icone;
	
}

// E-mail de ouvintes
function email_ouvinte($nome, $sobrenome, $email, $login, $senha) {

// Destinario
$to = "$email";

// Assunto
$subject = "AppWeb - Login de acesso";

// Cabecalho
$headers = "From: AppWeb <leandro@appweb.com.br>\n";
$headers .= "Reply-To: AppWeb <leandro@appweb.com.br>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=utf-8";

// Corpo do E-mail
$message = "
<html>
	<head>
		<title>Senha do programa AppWeb</title>
	</head>
	
	<body>
		<p>Ol&aacute; $nome $sobrenome,</p>
		<p>Segue abaixo a sua senha de acesso para o CMS do AppWeb</p>
		<p><strong>Login:</strong> $login <br />
		    <strong>Senha: </strong> $senha</p>
		<p>O endere&ccedil;o para acesso &eacute;: <a href='http://www.appweb.com.br/cms'>http://www.appweb.com.br/cms</a></p>
		<p>Atenciosamente,</p>
		<p>Programa Bastidores</p>
	</body>
</html>
";

// Envio da mensagem
$mail_sent = @mail($to, $subject, $message, $headers);
}

// 
function email($nome, $sobrenome, $email, $login, $senha) {

// Destinario
$to = "$email";

// Assunto
$subject = "AppWeb - Login de acesso";

// Cabecalho
$headers = "From: AppWeb <contato@appweb.com.br>\n";
$headers .= "Reply-To: AppWeb <contato@appweb.com.br>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=utf-8";

// Corpo do E-mail
$message = "
<html>
	<head>
		<title>Senha do programa AppWeb</title>
	</head>
	
	<body>
		<p>Ol&aacute; $nome $sobrenome,</p>
		<p>Segue abaixo a sua senha de acesso para o CMS do AppWeb</p>
		<p><strong>Login:</strong> $login <br />
		    <strong>Senha: </strong> $senha</p>
		<p>O endere&ccedil;o para acesso &eacute;: <a href='http://www.appweb.com.br/cms'>http://www.appweb.com.br/cms</a></p>
		<p>Atenciosamente,</p>
		<p>Equipe AppWeb</p>
	</body>
</html>
";

// Envio da mensagem
$mail_sent = @mail($to, $subject, $message, $headers);
}

// Retorna string do mes
function string_mes ($mes) {
	
	switch ($mes) {
    case 1:
        return "janeiro";
        break;
    case 2:
        return "fevereiro";
        break;
    case 3:
        return "mar&ccedil;o";
        break;
    case 4:
        return "abril";
        break;
    case 5:
        return "maio";
        break;
    case 6:
        return "junho";
        break;
    case 7:
        return "julho";
        break;
    case 8:
        return "agosto";
        break;
    case 9:
        return "setembro";
        break;
    case 10:
        return "outubro";
        break;
    case 11:
        return "novembro";
        break;
    case 12:
        return "dezembro";
        break;
	} //End IF switch
}

// Retorna string do mes
function string_dia_semana ($mes) {
	
	switch ($mes) {
    case "Sunday":
        return "Domingo";
        break;
    case "Monday":
        return "Segunra-feira";
        break;
    case "Tuesday":
        return "Ter�a-feira";
        break;
    case "Wednesday":
        return "Quarta-feira";
        break;
    case "Thursday":
        return "Quinta-feira";
        break;
    case "Friday":
        return "Sexta-feira";
        break;
    case "Saturday":
        return "S�bado";
        break;
	} //End IF switch
}

//Pega a idade a partir da data de nascimento no formato dd/mm/aaaa
function calc_idade( $data_nasc ){

$data_nasc = explode("/", $data_nasc);

$data = date("d/m/Y");
$data = explode("/", $data);
$anos = $data[2] - $data_nasc[2];

if ( $data_nasc[1] >= $data[1] ){

if ( $data_nasc[0] <= $data[0] ){
return $anos; break;
}else{
return $anos-1;
break;
}
}else{

return $anos;
}
} 

// Validar Email
function validar_email($email){
   $mail_correcto = 0;
   //verifico umas coisas
   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
      if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
         //vejo se tem caracter .
         if (substr_count($email,".")>= 1){
            //obtenho a termina��o do dominio
            $term_dom = substr(strrchr ($email, '.'),1);
            //verifico que a termina��o do dominio seja correcta
         if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
            //verifico que o de antes do dominio seja correcto
            $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
            $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
            if ($caracter_ult != "@" && $caracter_ult != "."){
               $mail_correcto = 1;
            }
         }
      }
   }
}

if ($mail_correcto)
   return 1;
else
   return 0;
} 




function formatarCPF_CNPJ($campo, $formatado = true){
	//retira formato
	$codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);
	// pega o tamanho da string menos os digitos verificadores
	$tamanho = (strlen($codigoLimpo) -2);
	//verifica se o tamanho do c�digo informado � v�lido
	if ($tamanho != 9 && $tamanho != 12){
		return false; 
	}
 
	if ($formatado){ 
		// seleciona a m�scara para cpf ou cnpj
		$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 
 
		$indice = -1;
		for ($i=0; $i < strlen($mascara); $i++) {
			if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
		}
		//retorna o campo formatado
		$retorno = $mascara;
 
	}else{
		//se n�o quer formatado, retorna o campo limpo
		$retorno = $codigoLimpo;
	}
 
	return $retorno;
 
}


function valida_cpf($cpf){
for( $i = 0; $i < 10; $i++ ){
    if ( $cpf ==  str_repeat( $i , 11) or !preg_match("@^[0-9]{11}$@", $cpf ) or $cpf == "12345678909" )return false;        
    if ( $i < 9 ) $soma[]  = $cpf{$i} * ( 10 - $i );
        $soma2[] = $cpf{$i} * ( 11 - $i );            
}
if(((array_sum($soma)% 11) < 2 ? 0 : 11 - ( array_sum($soma)  % 11 )) != $cpf{9})return false;
return ((( array_sum($soma2)% 11 ) < 2 ? 0 : 11 - ( array_sum($soma2) % 11 )) != $cpf{10}) ? false : true;
}

function CalculaCNPJ($CampoNumero)
{
$RecebeCNPJ=${"CampoNumero"};

$s="";
for ($x=1; $x<=strlen($RecebeCNPJ); $x=$x+1)
{
$ch=substr($RecebeCNPJ,$x-1,1);
if (ord($ch)>=48 && ord($ch)<=57)
{
$s=$s.$ch;
}
}

$RecebeCNPJ=$s;

if (strlen($RecebeCNPJ)!=14)
{
return false;
}
else
if ($RecebeCNPJ=="00000000000000")
{
$then;
return false;
}
else
{
$Numero[1]=intval(substr($RecebeCNPJ,1-1,1));
$Numero[2]=intval(substr($RecebeCNPJ,2-1,1));
$Numero[3]=intval(substr($RecebeCNPJ,3-1,1));
$Numero[4]=intval(substr($RecebeCNPJ,4-1,1));
$Numero[5]=intval(substr($RecebeCNPJ,5-1,1));
$Numero[6]=intval(substr($RecebeCNPJ,6-1,1));
$Numero[7]=intval(substr($RecebeCNPJ,7-1,1));
$Numero[8]=intval(substr($RecebeCNPJ,8-1,1));
$Numero[9]=intval(substr($RecebeCNPJ,9-1,1));
$Numero[10]=intval(substr($RecebeCNPJ,10-1,1));
$Numero[11]=intval(substr($RecebeCNPJ,11-1,1));
$Numero[12]=intval(substr($RecebeCNPJ,12-1,1));
$Numero[13]=intval(substr($RecebeCNPJ,13-1,1));
$Numero[14]=intval(substr($RecebeCNPJ,14-1,1));

$soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+$Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;

$soma=$soma-(11*(intval($soma/11)));

if ($soma==0 || $soma==1)
{
$resultado1=0;
}
else
{
$resultado1=11-$soma;
}

if ($resultado1==$Numero[13])
{
$soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+$Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;
$soma=$soma-(11*(intval($soma/11)));
if ($soma==0 || $soma==1)
{
$resultado2=0;
}
else
{
$resultado2=11-$soma;
}

if ($resultado2==$Numero[14])
{
return true;
}
else
{
return false;
}
}
else
{
return false;
}
}
}


function SimNaoIconeCliente($valor,$tabela,$campo,$codigo) {
	
	if ($valor == 1) {
		$icone = "<a href='cadastroEmpresa.php?muda=1&valor=0&tabela=$tabela&campo=$campo&cod=$codigo'><img src='imagens/sim.gif' title='Sim' alt='Sim' border='0'></a>";
	}
	
	if ($valor == 0) {
		$icone = "<a href='cadastroEmpresa.php?muda=1&valor=1&tabela=$tabela&campo=$campo&cod=$codigo'><img src='imagens/nao.gif' title='N�o' alt='N�o' border='0'></a";
	}
	
	return $icone;
	
}

function SimNaoIconeOrganizacoes($valor,$tabela,$campo,$codigo) {
	
	if ($valor == 1) {
		$icone = "<a href='cadastroEmpresa.php?muda=1&valor=0&tabela=$tabela&campo=$campo&cod=$codigo'><img src='imagens/sim.gif' title='Sim' alt='Sim' border='0'></a>";
	}
	
	if ($valor == 0) {
		$icone = "<a href='cadastroEmpresa.php?muda=1&valor=1&tabela=$tabela&campo=$campo&cod=$codigo'><img src='imagens/nao.gif' title='N�o' alt='N�o' border='0'></a";
	}
	
	return $icone;
	
}

function codigo_pesquisa($id_perguntas){
	

	$sql = "SELECT * FROM pesquisa_perguntas WHERE id = $id_perguntas";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	
	return $linha["id_pesquisa"];
	
	
}

// PEGANDO NOME DO GRUPO-EMAIL PESQUISA CLIMA
function nome_grupo($grupo){	

	$sql = "SELECT * FROM clima_GrupoEmail WHERE id = $grupo";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);	
	return $linha["nome"];	
	
}

// PEGANDO NOME DA PESQUISA
function nome_pesquisa($pesquisa){	

	$sql = "SELECT * FROM pesquisas WHERE id = $pesquisa";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);	
	return $linha["nome"]."|".$linha["texto"];	
	
}

// PEGANDO NOME DA PESQUISA
function nome_pesquisa_enviados($pesquisa){	

	$sql = "SELECT * FROM pesquisa_enviados WHERE id = $pesquisa";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	$nome = explode("|",$linha["codpesquisa"]);
	return $nome[1];	
	
}
// PEGANDO NOME DA PESQUISA
function pegando_id_pesquisa($pesquisa){	

	$sql = "SELECT * FROM pesquisa_enviados WHERE id = $pesquisa";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	$nome = explode("|",$linha["codpesquisa"]);
	return $nome[0];	
	
}

function pegar_email($id_email){
	$sql = "SELECT * FROM clima_Email WHERE id = $id_email";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	return $linha["email"];	
	
}

// PEGANDO PERGUNAS E TEXTO DE INTRODUCAO PERGUNTAS
function pegar_perguntas($pesquisa){	

	$sql = "SELECT * FROM pesquisa_perguntas WHERE id_pesquisa = $pesquisa ORDER BY id";
	$result = mysql_query($sql);	
	while($linha = mysql_fetch_assoc($result)){
	   $perguntas .= $linha["perguntas"]."|".$linha["texto"]."#";
	}
	return $perguntas;	
	
}

// PEGANDO FORMATO DE CADA ALTERNATIVA
function formato_alternativa($pesquisa){	

	$sql = "SELECT * FROM
			pesquisa_perguntas
			Inner Join pesquisa_alternativas ON pesquisa_perguntas.id = pesquisa_alternativas.id_perguntas
			WHERE id_pesquisa = $pesquisa ORDER BY pesquisa_perguntas.id";
	$result = mysql_query($sql);	
	while($linha = mysql_fetch_assoc($result)){
	   $formata_pergunta .= $linha["formato_perguntas"]."#";
	}
	return $formata_pergunta;	
	
}

// PEGANDO PEGANDO AS ALTERNATIVA DPS DE SABER O TIPO DE CADA ALTERNATIVA
function pegar_alternativas($pesquisa){	

	$sql = "SELECT * FROM
			pesquisa_perguntas
			Inner Join pesquisa_alternativas ON pesquisa_perguntas.id = pesquisa_alternativas.id_perguntas
			WHERE id_pesquisa = $pesquisa ORDER BY pesquisa_perguntas.id";
	$result = mysql_query($sql);	
	while($linha = mysql_fetch_assoc($result)){
	   
		// QUESTAO 1 = ABERTA
		if($linha["formato_perguntas"] == 1){
			$alternativas .= $linha["texto_aberta"]."#";
		}
	   
		// QUESTAO 2 = FECHADA
		if($linha["formato_perguntas"] == 2){
			$alternativas .= $linha["alternativas"]."#";
		}
	}
	return $alternativas;	
	
}

// ZERANDO RESPOSTAS ALTERNATIVAS DE CADA PERGUNTA
function zerando_respostas($pesquisa){	

	$sql = "SELECT * FROM
			pesquisa_perguntas
			Inner Join pesquisa_alternativas ON pesquisa_perguntas.id = pesquisa_alternativas.id_perguntas
			WHERE id_pesquisa = $pesquisa ORDER BY pesquisa_perguntas.id";
	$result = mysql_query($sql);	
	while($linha = mysql_fetch_assoc($result)){
	   
		// QUESTAO 1 = ABERTA
		if($linha["formato_perguntas"] == 1) {
			$respostas .= " #";
		}
	   
		// QUESTAO 2 = FECHADA
		if($linha["formato_perguntas"] == 2){
			
			$total = count(explode("|",$linha["alternativas"]));
			//alert($total);
			for($i=1;$i<=$total;$i++){
				$respostas .= "0|";
			}
			$respostas .= "#";
		}
	}
	return $respostas;	
	
}


// VERIFICANDO SE EXITE RESPOSTAS COM ALTERNATIVAS/DEFINICAO
function verificar_pesquisas($pesquisa){	

	$sql = "SELECT * FROM
			pesquisa_perguntas			
			WHERE id_pesquisa = $pesquisa ORDER BY pesquisa_perguntas.id";
	$result = mysql_query($sql);	
	while($linha = mysql_fetch_assoc($result)){
	  	$id_pergunta = $linha["id"];
		$sql_alternativa = "SELECT * FROM
			pesquisa_alternativas			
			WHERE id_perguntas = $id_pergunta";
		$result_alternativa = mysql_query($sql_alternativa);
		if(mysql_num_rows($result_alternativa)<=0){
			
			$enviar = 1;
		}
	}
	return $enviar;	
	
}

function salvar_pessoas_enviadas($idPesquisa,$idpessoa,$perguntas){
	
 	$sql = "INSERT INTO pesquisa_visualizados (id_pesquisa,id_pessoa,visualizado,resposta,outra) VALUES  ('$idPesquisa','$idpessoa','0','$perguntas','$perguntas')";
 	if(mysql_query($sql)){
 		
 	}
	
}

function pegarCodigoNewsletter($id_pesquisa_enviar)
{
	$sql = "SELECT * FROM pesquisa_enviados WHERE id = $id_pesquisa_enviar";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	return $linha["newsletter"];
}

function pegarTituloNews($newsletter)
{
	$sql = "SELECT * FROM pesquisa_newsletter WHERE id = $newsletter";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	return $linha["titulo"];
}

function pegarImagemNews($newsletter)
{
	$sql = "SELECT * FROM pesquisa_newsletter WHERE id = $newsletter";
	$result = mysql_query($sql);	
	$linha = mysql_fetch_assoc($result);
	return $linha["imagem"];
}


function verificarOrganizacao($cod,$commit){
	if($commit){
		$sql = "SELECT * FROM
			aplicacoes_commit
			INNER JOIN gerador_tickets ON aplicacoes_commit.ticket = gerador_tickets.numero_ticket
			INNER JOIN gerador_tickets_pedidos ON gerador_tickets.num_pedido = gerador_tickets_pedidos.id
			WHERE aplicacoes_commit.id = $cod";
		$result = mysql_query($sql);	
		$linha = mysql_fetch_assoc($result);
		if($linha["nome_cliente"] == $_SESSION["organizacaon"]){
			return 1;
		}else{
			return 0;
		}
	}else{
		$sql = "SELECT * FROM aplicacoes WHERE id = $cod";
		$result = mysql_query($sql);	
		$linha = mysql_fetch_assoc($result);
		if($linha["organizacao"] == $_SESSION["organizacaon"]){
			return 1;
		}else{
			return 0;
		}
	}
}

function sendMail($de,$mensagem,$nome) {	
	
	// Assunto
	$subject = "APPWEB - Perfil Profissional";

	require('class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php"

	$mail = new PHPMailer(); //instancia a classe PHPMailer	
	//$mail->IsSMTP(); //define que o email será enviado por SMTP	
	//$mail->SMTPAuth = false;	
	//$mail->SMTPSecure = "ssl";
	//$mail->SMTPDebug = 2;
	$mail->CharSet = 'UTF-8';	
	$mail->Port = 465; //define a porta do servidor smtp - altere para a porta que seu servidor usa	
	$mail->Host = 'smtp.gmail.com'; //define o servidor smtp - altere para o seu servidor smtp	
	$mail->Username = 'site@publixcomunicacao.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário	
	$mail->Password = 'hjl141806'; //define a senha do servidor smtp, altere para a sua  	
	$mail->SetFrom('contato@appweb.com.br', 'Appweb'); //define o remetente da mensagem, altere para o real	
	
	foreach ($de as $value) {
		$mail->AddAddress(''.$value.'', 'Appweb'); //define o destino da mensagem, altere para o desejado
	}
	$mail->AddAddress('contato@appweb.com.br', 'Appweb'); //define o destino da mensagem, altere para o desejado
	
	//$mail->AddAddress('sergio@publixcomunicacao.com.br', 'S�rgio Monteiro Jr.'); //define o destino da mensagem, altere para o desejado
	$mail->Subject = ''.$subject.''; //define o assunto da mensagem
	
	$body = $mensagem;

	//a variavel $body define o corpo da mensagem
	$mail->MsgHTML($body); //configura o email como HTML
	
	if($mail->Send()){
		return true;
	}else{	
		return false;
	}
} 
?>