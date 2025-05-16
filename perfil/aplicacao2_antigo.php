<?
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://www.mapertest.com.br" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>MAPER :: Gest&atilde;o por Compet&ecirc;ncias, Sistemas de Qualidade, Educa&ccedil;&atilde;o Corporativa e RH</title> 
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
</head>
<?
include("../library.php");
include("../script.js");

?>

<?

if($_REQUEST["enviar"]){
	$ok =1 ;
	
	$nome =  $_POST["nome"];
	
	$tele =  $_POST["telefone"];
	$assu =  $_POST["assunto"]; 
	$mens =  $_POST["msg"]; 
	
	
	// Validando o E-mail
	if (addslashes(trim($_POST["email"])) == "") {
		$ok = 0;
		$emai = addslashes(trim($_POST["email"]));
		alert("Preencha o campo E-mail corretamente!");
		redireciona("contato.php");
	} elseif (!validar_email(addslashes(trim($_POST["email"]))))  {
		$ok = 0;
		alert("Por favor verifique o(s) seguinte(s) erro(s): - E-mail deve conter um endereço de e-mail.");
		redireciona("contato.php");
		$emai = addslashes(trim($_POST["email"]));
	} else {
		$emai = addslashes(trim($_POST["email"]));
	}
	
	if($ok){
		// setando vari&aacute;veis
		//$emai_site = "leandroliberio@gmail.com,mlucia22@gmail.com,rozanareisfaria@gmail.com";
		$emai_site = "resultados@mapertest.com.br";
		//$emai_site = "vinicius@agenciapenta.com.br";
		//$emai_site = "educarh@terra.com.br";
		//$emai_from = "app@mapertest.com.br";
		
		$nome_site = "MAPER";
		$url_site = "www.mapertest.com.br";
	
		$header  = "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=iso-8859-1\r\n";
		$header_site = $header; 
		$header_clie = $header;
		$header_site .= "From: $nome_site<$emai_from>\r\n";
		$header_clie .= "From: $nome_site<$emai_from>\r\n";
		
	
		$men = "-------------------------------------------------------------------------------------------------<br/>\r\n";
		$men .= " ATEN&Ccedil;&Atilde;O:   Esta mensagem veio do FORMUL&Aacute;RIO preenchido<br/>\r\n";
		$men .= " no site da $nome_site ($url_site) <br/>\r\n";
		$men .= "-------------------------------------------------------------------------------------------------<p/>\r\n\r\n";
		$men .= "Formul&aacute;rio para: $dest<p/>\r\n";
		$men .= "Nome: $nome <br/>\r\n";
		$men .= "E-mail: $emai <br/>\r\n";
		$men .= "Telefone: $tele <br/>\r\n";
		$men .= "Assunto: $assu <br/>\r\n";
		$men .= "Mensagem:<br/>\r\n";
		$men .= $mens;

				
			if (@mail($emai_site, "Fale Conosco", $men, $header_site)) {
				mail($emai, "Confirma Recebimento: Fale Conosco", $men, $header_clie);
				echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
				echo "alert ('Sua mensagem foi enviada com sucesso. Obrigado por utilizar esse serviço.\\n                                   		Aguarde nosso contato!')";
				echo "</script>";
			} else {
		    		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
					echo "alert ('Sua mensagem não pode ser enviada.')";
					echo "</script>";
				}
	}
}


?>

<body OnKeyPress="return disableKeyPress(event)">
<div id="slice1">
        <div id="topo">
            <div id="topo_esq">
                <div id="logo"><a href="http://www.mapertest.com.br" target="_blank"><img src="css/style_novo/logo.png" alt="applogo" /></a></div>
            </div>
        </div>
    </div> 
<? if($_REQUEST["protocolo"] == "") { redireciona("http://perfil.mapertest.com.br/index.php"); } ?>
<div id="global">
	<div id="conteudo">
		<div class="txt_chamada" style=" margin-top:20px">Formul&aacute;rio de Aplica&ccedil;&atilde;o</div>
		<?php

include("../conn.php");

if($_REQUEST["protocolo_check"] = "") {
    $protocolo = $_POST["protocolo"];
    $checkar = mysql_query("SELECT * FROM protocolos WHERE protocolo = '$protocolo'");
    if(mysql_num_rows($checkar) == 0) {
        alert("Protocolo inválido.");
        redireciona("http://perfil.mapertest.com.br/index.php");
        die();
    } else {
        $checkar99 = mysql_query("SELECT * FROM protocolos WHERE protocolo = '$protocolo' and ordem >= 99");
        if(mysql_num_rows($checkar99) != 0) {
            alert("O ticket já foi utilizado.");
            redireciona("http://perfil.mapertest.com.br/index.php");
            die();
        } else {
        
        $checkar_fetch = mysql_fetch_array($checkar);
        $checkar_ticket = $checkar_fetch["ticket"];
        $checkar_tick = mysql_query("SELECT * FROM gerador_tickets WHERE numero_ticket = '$checkar_ticket'");
        $checkar_tick = mysql_fetch_array($checkar_tick);
        
        if($checkar_tick["commit"] == "1") { 
            redireciona("aplicacao_commit_novo.php?protocolo=".$_REQUEST["protocolo"]."&protocolo_check=1");
        }
        }
        
    }
}
?>

<br/>
<script language='JavaScript'>history.go(1);</script>
<?php
include("../conn.php");
include("../funcoes.php");

/*

$pNome = $_POST["nome"]; 
$pCPF = $_POST["ncpf"]; 
$pEmail = $_POST["emai"]; 
$dia = $_POST["dia"];
$mes = $_POST["mes"];
$ano = $_POST["ano"];
$pNascimento = $dia."/".$mes."/".$ano;

$pTelefone = $_POST["tele"]; 
$pOrganizacao= $_POST["orga"]; 
$pGrupo= $_POST["grup"];
$pCargo= $_POST["carg"];
*/

?>
<script language="JavaScript">
function checkEnter(e){
 e = e || event;
 return (e.keyCode || event.which || event.charCode || 0) !== 13;
}
</script>
<script>
<!--
function Valida() {

  var erros='';
  
  if(document.form1.resposta[0].checked ) { erros=true;} 
	else { if (document.form1.resposta[1].checked ) { erros=true;} 
  		else { alert('Escolha uma das opções'); erros=false; }
  
/*if(form1.resposta[0].checked) { erros=true;} 
	else { if (form1.resposta[1].checked) { erros=true; } 
  		else { alert('Escolha uma das opções'); erros=false; }*/
}

document.MM_returnValue = erros;

return erros;

}
-->
</script>
<form action="perfil/aplicacao2.php" method="post" name="form1" target="_top" id="form1" onkeypress="return checkEnter(event)">

  <p>
    <?

//CONECTA AO MYSQL                     
//include("sysapp/conecta.php");
include("../conn.php");
$Total = 100;           

//RECEBE PARÃMETRO                     
if($_POST["nome"] == "") {
$protocolo = $_REQUEST["protocolo"];

$prots = mysql_query("SELECT * FROM protocolos WHERE protocolo = '$protocolo' ORDER BY ordem DESC");
$prots = mysql_fetch_array($prots) or die(mysql_error());

$pOrdem = $prots["ordem"]; 
$pNome = $prots["nome"]; 
$pCPF = $prots["cpf"]; 
$pEmail = $prots["email"]; 
$pTelefone = $prots["telefone"];
$pNascimento = $prots["nascimento"];

//$pNascimento = $prots["nasc"]; 
$pOrganizacao = nome_orga($prots["organizacao"]); 
$id_Organizacao = $prots["organizacao"]; 
$pGrupo = $prots["grupo"]; 
$pCargo = $prots["cargo"]; 
$nomeGrupo = nome_grupo($prots["grupo"]);
$ticketi = $prots["ticket"];
$_SESSION["crono"] = $prots["tempo"];
}  else {   
$pOrdem = $_POST["ordem"]; 
$pNome = $_POST["nome"]; 
$pCPF = $_POST["ncpf"]; 
$pEmail = $_POST["emai"]; 
$pddd = $_POST["ddd"];
$ptele = $_POST["tele"];
$pTelefone = "($pddd) - ". $ptele; 
$dia = $_POST["dia"];
$mes = $_POST["mes"];
$ano = $_POST["ano"];
$pNascimento = $dia."/".$mes."/".$ano;
//$pNascimento = $_POST["nasc"]; 
$pOrganizacao = nome_orga($_POST["orga"]); 
$id_Organizacao = $_POST["orga"]; 
$pGrupo = $_POST["grup"]; 
$pCargo = $_POST["carg"]; 
$nomeGrupo = nome_grupo($_POST["grup"]);
$ticketi = $_POST["ticket"];
}

$pCrono = $_SESSION["crono"];



if ((!$pCrono)||($pCrono=="")){ 
	$pCrono = "00:00:00";
	$pAjuste = "false";
} else {$pAjuste = "true";}

$pSeg = (int)substr($pCrono,6,2);
$pMin = (int)substr($pCrono,3,2);
$pHor = (int)substr($pCrono,0,2);

?>
    <?php

   
if (!$pOrdem){ $pOrdem=1;} 

if ($_POST["fim"] == ''){


$pResp = $_POST["anterior"] . $_POST["resposta"] ;      

    

//$row = mysql_num_rows($sql) or die("erro na busca das questões");    

//VERIFICA SE VOLTOU ALGO 
  $protocolo = $_REQUEST["protocolo"];
  $prots = mysql_query("SELECT ordem FROM protocolos WHERE protocolo = '$protocolo' ORDER BY ordem DESC");
  
  if(mysql_num_rows($prots) == 0) {
    echo "Sequ&ecirc;ncia <strong><span id='num_questao'>1</span></strong> de <strong>$Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  } else {
    $prots_ordem = mysql_fetch_array($prots);
    $prots_ordem = $prots_ordem["ordem"]+1;
    echo "Sequ&ecirc;ncia <strong><span id='num_questao'>$prots_ordem</span></strong> de <strong>$Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  }
  ?>
  
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempo:
  <input name="crono" type="text" size="6" />
  <script language="JavaScript" type="text/javascript">
<!-- 
var timeCrono; 

var hor = <?php echo $pHor; ?>;
var min = <?php echo $pMin; ?>;
var seg = <?php echo $pSeg; ?>;

var startTime = new Date(); 
var start = startTime.getSeconds();
var ajuste = <?php echo $pAjuste;?>;

if (ajuste == false){
	start = startTime.getSeconds();
}

StartCrono();
            
function StartCrono() {
       
if (seg + 1 > 59) { 
min+= 1 ;
}
if (min > 59) {
min = 0;
hor+= 1;
}

var time = new Date(); 

if (ajuste == false){
	if (time.getSeconds() >= start) {
		seg = time.getSeconds() - start;
	} 
	else {
		seg = 60 + (time.getSeconds() - start);
	}
} else { seg ++; 

	if (seg > 59) {
		seg = 0;
	}

}

timeCrono= (hor < 10) ? "0" + hor : hor;
timeCrono+= ((min < 10) ? ":0" : ":") + min;
timeCrono+= ((seg < 10) ? ":0" : ":") + seg;
document.form1.crono.value = timeCrono;
$.ajax({
url: '../aplicacao_crono.php',
type: 'POST',
data: ({
	crono: timeCrono
}),
  
 success: function(data){
				
}					  
});     
setTimeout("StartCrono()", 1000);
} //--> 
    </script>
  <br />
  <br />
  
  <script>
  $(document).ready(function() {
  $(".finalizar").hide();
  });
  </script>
  <script>
    
    function esconder(id,protocolo,pnome,pemail,ptelefone,pcpf,pnasc,porg,pgrupo,pcargo,ticketi) 
    {
       var divresp = 'resposta_'+id;
       if ($("input[type=radio][name="+divresp+"]:checked").val()) {
            var input_val = $("input[name="+divresp+"]:checked").val();
            //alert(input_val);
            ide = "#"+id;
            $(ide).hide();
            prox = id + 1;
            ide2 = "#"+prox;
            $(ide2).show();
            $("#num_questao").html('');
            $("#num_questao").append(prox);
            
            $.ajax({
					url: '../aplicacao_ajax.php',
					type: 'POST',
					data: ({
						nome: pnome,
                        email: pemail,
                        telefone: ptelefone,
                        cpf: pcpf,
                        nascimento: pnasc,
                        organizacao: porg,
                        grupo: pgrupo,
                        cargo: pcargo,
                        crono: timeCrono,
                        resposta: input_val,
                        ordem: id,
                        ticket: ticketi,
                        protocolo: protocolo
					}),
					  
					 success: function(data){
									
					}					  
		   });            
            
            if(id == 99)
            {
                $(".proximo").hide();
                $(".finalizar").show();
            }
            
        } else {
            alert("Marque um dos campos para prosseguir.");
        }
    }
    
  </script>
  
  
  

  <?php
  //QUERY  
  
  //print_r($_POST);
  $protocolo = $_REQUEST["protocolo"];
  $prots = mysql_query("SELECT ordem FROM protocolos WHERE protocolo = '$protocolo' ORDER BY ordem DESC");
  
  if(mysql_num_rows($prots) == 0) {
    $ordens = mysql_query("SELECT DISTINCT ordem FROM questoes ORDER BY ordem ASC");
    $goalt = false;
  } else {
    $goalt = true;
    $prots_fetch = mysql_fetch_array($prots);
    $prots_ordem = $prots_fetch["ordem"]+1;
   $ordens = mysql_query("SELECT DISTINCT ordem FROM questoes ORDER BY ordem ASC");
  }
  
  while($ord = mysql_fetch_array($ordens))
  {
    if(!$goalt) {
      if($ord["ordem"] != '1')
      {
      echo '
      <script>
      $(document).ready(function() {
      $("#'.$ord["ordem"].'").hide();
      });
      </script>';
      }
    } else {
      
      if($ord["ordem"] != $prots_ordem)
      {
      echo '
      <script>
      $(document).ready(function() {
      $("#'.$ord["ordem"].'").hide();
      });
      </script>';
      }
    }
    
    
    
  echo '<div id="'.$ord["ordem"].'" class="hideclass">';
  $sql = " 
           SELECT questoes_id, descricao, sequencia, ordem 
           FROM  questoes WHERE ordem = '".$ord["ordem"]."'
    	   ORDER BY ordem, sequencia";            
    
  //EXECUTA A QUERY               
  $sql = mysql_query($sql);   
      
  while($row = mysql_fetch_array($sql)) {                
      
    $codigo = $row["questoes_id"];
    $sequencia = $row["sequencia"];
    $descricao = $row["descricao"];
    $ordem = $row["ordem"];
    $proximo = $ordem + 1;
?>
    <?
      $protocolo = $_REQUEST["protocolo"];  
      $prots = mysql_query("SELECT resposta FROM protocolos WHERE protocolo = '$protocolo' and ordem = '".$ordem."'");
      $prots = mysql_fetch_array($prots);
      $resposta_dada = $prots["resposta"];
    ?>
  
      <label>
      <input name="resposta_<?php echo $ordem; ?>" type="radio" class="inputbox" id="radio_<?php echo $sequencia; ?>" <? if($sequencia == $resposta_dada) { echo "checked"; } ?> value="<?php echo $sequencia; ?>" />
      <?php echo $descricao;?>  </label>
      <br/>

    <?php  
  
    }//FECHA IF (row) 
    ?>
    <br />
    <button class="proximo" type="button" onClick="javascript:esconder(<?=$ordem?>,'<?=$protocolo?>','<?=$pNome?>','<?=$pEmail?>','<?=$pTelefone?>','<?=$pCPF?>','<?=$pNascimento?>','<?=$id_Organizacao?>','<?=$pGrupo?>','<?=$pCargo?>','<?=$ticketi?>');" style="width: 200px;">Ok</button>
    <button class="finalizar" type="submit" style="width: 200px;">Ok</button>
    <?
    echo "</div>";
}                                              
     
?>

  <input name="anterior" type="hidden" value="<?php echo $pResp;?>" />
  <input name="nome" type="hidden" value="<?php echo $pNome;?>" />
  <input name="emai" type="hidden" value="<?php echo $pEmail;?>" />  
  <input name="ddd" type="hidden" value="<?php echo $pddd;?>" />
  <input name="tele" type="hidden" value="<?php echo $ptele;?>" />
  <input name="dia" type="hidden" value="<?php echo $dia;?>" />  
  <input name="mes" type="hidden" value="<?php echo $mes;?>" />  
  <input name="ano" type="hidden" value="<?php echo $ano;?>" />  
  <input name="ncpf" type="hidden" value="<?php echo $pCPF;?>" />    
  <input name="orga" type="hidden" value="<?php echo $id_Organizacao;?>" />  
  <input name="grup" type="hidden" value="<?php echo $pGrupo;?>" /> 
  <input name="carg" type="hidden" value="<?php echo $pCargo;?>" />
  <input name="ordem" type="hidden" value="<?php echo $pOrdem+1;?>" />
  <input name="ticket" type="hidden" value="<?php echo $ticketi;?>" />
  <input name="protocolo" type="hidden" value="<?php echo $protocolo;?>" />
  <input name="fim" type="hidden" value="1" />

  <label>
    <input name="sub" type="hidden" id="sub" value="<?php if ($pOrdem==($Total+1)) {echo "1"; } else {echo "0";} ?>" />
    <br />
    <!--<input type="submit" name="button" id="button" value="               Ok               " onClick="return Valida();"/>-->
  </label>
</form>
  <hr size="1"/>
  <?php
echo "<p><strong>Dados Cadastrais</strong></p>";  
echo "<strong>Nome: </strong>$pNome<br/>";
echo "<strong>E-mail: </strong>$pEmail<br/>";
echo "<strong>Telefone: </strong>$pTelefone<br/>";
echo "<strong>CPF: </strong>$pCPF<br/>";
echo "<strong>Nascimento: </strong>$pNascimento<br/>";
echo "<strong>Organização: </strong>$pOrganizacao<br/>";
echo "<strong>Grupo: </strong>$nomeGrupo<br/>";
echo "<strong>Cargo: </strong>$pCargo<br/>";

  ?>
  

    
<?php
 
}

if ($_POST["fim"] != "") {

$pResp = $_POST["anterior"] . $_POST["resposta"] ;   


// setando variáveis
$emai_site = "resultados@mapertest.com.br";
//$emai_site = "leandroliberio@gmail.com,mlucia22@gmail.com,rozanareisfaria@gmail.com";
$emai_from = "app@mapertest.com.br";

$nome_site = "MAPER";
$url_site = "www.mapertest.com.br";

$header  = "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=iso-8859-1\r\n";
$header_site = $header; 
$header_clie = $header;
$header_site .= "From: $nome_site<$emai_from>\r\n";
$header_clie .= "From: $nome_site<$emai_from>\r\n";

$men = "-------------------------------------------------------------------------------------------------<br/>\r\n";
$men .= " ATENÇÃO:   Esta mensagem veio do FORMULÁRIO preenchido<br/>\r\n";
$men .= " no site da $nome_site ($url_site) <br/>\r\n";
$men .= "-------------------------------------------------------------------------------------------------<p/>\r\n\r\n";
$men .= "Nome: $pNome <br/>\r\n";
$men .= "E-mail: $pEmail <br/>\r\n";
$men .= "Telefone: $pTelefone <br/>\r\n";
$men .= "CPF: $pCPF <br/>\r\n";
$men .= "Nasc: $pNascimento <br/>\r\n";
$men .= "Organização: $pOrganizacao<br/>\r\n";
$men .= "Grupo: $nomeGrupo <br/>\r\n";
$men .= "Cargo: $pCargo <br/>\r\n";
$men .= "Tempo: $pCrono <br/>\r\n";
$men .= "Respostas: <br/>\r\n";

$auxi = 0;

while ($auxi<$Total){
	$men .=  $auxi+1;
	$men .=  ") ";
	$men .=  $pResp[$auxi];
	$men .=  "&nbsp;&nbsp;&nbsp;&nbsp;";
	if ((($auxi+1)%2)==0){$men .=  "<br/>\r\n";}
	$auxi++;
}
$men .= "<br/>\r\n<br/>\r\nString de Resposta: " . $pResp;

$men_clie = "-------------------------------------------------------------------------------------------------<br/>\r\n";
$men_clie .= " ATENÇÃO:   Esta mensagem veio do FORMULÁRIO preenchido<br/>\r\n";
$men_clie .= " no site da $nome_site ($url_site) <br/>\r\n";
$men_clie .= "-------------------------------------------------------------------------------------------------<p/>\r\n\r\n";
$men_clie .= "Informamos que seu formulário de aplicação APPWeb foi recebido pela nossa equipe.";

	if (@mail($emai_site, "Formulario MAPER", $men, $header_site)) {
		//mail($emai, "Confirma Recebimento: APPWeb", $men_clie, $header_clie);
		
        //$pResp = ;
        $sql = "SELECT DISTINCT ordem FROM questoes ORDER BY ordem ASC";            
    
        //EXECUTA A QUERY               
        $sql = mysql_query($sql);   
  
        while($row = mysql_fetch_array($sql)) {     
            $ordem = $row["ordem"];
            $todas_respostas .= $_POST["resposta_".$ordem];
            
            
        }
        
		$data =  date("Y-m-d H:i:s");
		$tick = $_SESSION["tick"];
        $pNome = addslashes($pNome);
		$sql = "INSERT INTO aplicacoes (nome,email,telefone,cpf,nasc,organizacao,grupo,cargo,tempo,respostas,data_aplic,status_envio,ticket) VALUES ('$pNome','$pEmail','$pTelefone','$pCPF','$pNascimento','$id_Organizacao','$pGrupo','$pCargo','$pCrono','$todas_respostas','$data','0','$ticketi')";
		if(mysql_query($sql)){
		 
        
        mysql_query("UPDATE gerador_tickets SET utilizado = 1 WHERE numero_ticket = '$ticketi'");	
		
		//echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
		//echo "alert ('Obrigado por utilizar esse serviço.')";
		//echo "</script>";
        
        require('../class.phpmailer.php'); //carrega a classe phpmailer, altere para a pasta onde se encontra o arquivo "class.phpmailer.php" 
        $mail = new PHPMailer(); //instancia a classe PHPMailer
        $mail->IsSMTP(); //define que o email será enviado por SMTP
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587; //define a porta do servidor smtp - altere para a porta que seu servidor usa
        $mail->Host = 'smtp.gmail.com'; //define o servidor smtp - altere para o seu servidor smtp
        $mail->Username = 'autenticacao@agenciapenta.com.br'; //define o nome de usuario do servidor smtp, altere para o seu usuário
        $mail->Password = 'penta2030'; //define a senha do servidor smtp, altere para a sua    
        $mail->SetFrom('contato@mapertest.com.br', 'APPWEB'); //define o remetente da mensagem, altere para o real
        
        $sql_select = "SELECT * FROM ce_usuario WHERE organizacao = '$id_Organizacao'";
        // Executa o Query
        $sql_query = mysql_query($sql_select);
        $row = mysql_fetch_array($sql_query);
        
        $mail->AddAddress($row["Email"]); //define o destino da mensagem, altere para o desejado
        //echo $pOrganizacao;
        
        //$mail->AddAddress("thales@agenciapenta.com.br");
        $message = "Um profissional de sua empresa finalizou nesse momento um inventário do APP® - Avaliação de Potencial e Perfil. <br /><br />Atenciosamente,<br />APPWEB"; 
        
        if($id_Organizacao != '207' and $id_Organizacao != '167' and $id_Organizacao != '191' and $id_Organizacao != '187')
        {
            $mail->Subject = 'APPWEB - Comunicado'; //define o assunto da mensagem
            $mail->MsgHTML($message); //configura o email como HTML
            //$mail->Send();	
        }
        }
		} else {
    		echo "<script language=\"JavaScript\" type=\"text/JavaScript\">";
			echo "alert ('Falha no envio do formulário.')";
			echo "</script>";
		}


echo "<script>location.href='https://perfil.mapertest.com.br/aplicacao3.php'</script>";

}

mysql_close ($conn);

?> 

	</div>
</div>	
<div id="rodape">Copyright 1979-2012 APP - 55 (31) 3293-2590</div>
<style>
    .hideclass { height: 100px; overflow: hidden; }
</style>

</body>

</html>