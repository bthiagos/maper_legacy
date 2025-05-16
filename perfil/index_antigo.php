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
	<title>APPWeb :: Gest&atilde;o por Compet&ecirc;ncias, Sistemas de Qualidade, Educa&ccedil;&atilde;o Corporativa e RH</title>
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
	<? include("../script.js"); ?>
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

	
	
	
	<div id="conteudo">
	
		<div class="txt_chamada" style=" margin-top:20px">Formul&aacute;rio de Aplica&ccedil;&atilde;o</div>
		
		<?php

include("../conn.php");
?>

<?php 
if($_POST["protocolo"] == "") {
    $protocolo = rand(111,999).substr(time(),-3,3); 
}

function time_diff($dt1,$dt2) {
    $y1 = substr($dt1,0,4);
    $m1 = substr($dt1,5,2);
    $d1 = substr($dt1,8,2);
    $h1 = substr($dt1,11,2);
    $i1 = substr($dt1,14,2);
    $s1 = substr($dt1,17,2);    

    $y2 = substr($dt2,0,4);
    $m2 = substr($dt2,5,2);
    $d2 = substr($dt2,8,2);
    $h2 = substr($dt2,11,2);
    $i2 = substr($dt2,14,2);
    $s2 = substr($dt2,17,2);    

    $r1=date('U',mktime($h1,$i1,$s1,$m1,$d1,$y1));
    $r2=date('U',mktime($h2,$i2,$s2,$m2,$d2,$y2));
    return ($r1-$r2);

}	
?>
<br clear="all" />
<p class="textos"> Por favor, leia com aten&ccedil;&atilde;o as <strong>instru&ccedil;&otilde;es</strong> a seguir:</p>
<p class="textos">Voc&ecirc; encontrar&aacute; alguns pares de frases. 
  Leia atentamente, sem se deter demasiadamente em nenhuma delas e escolha a que melhor retratar seu comportamento. 
  Ainda que lhe pare&ccedil;a dif&iacute;cil fazer a op&ccedil;&atilde;o, n&atilde;o omita nenhuma resposta. 
  Escolha somente uma, em cada par de frases.</p>
<p class="textos">Favor marcar todas as quest&otilde;es e restringir o seu tempo de resposta at&eacute; <strong>20</strong> (vinte)   minutos. </p>
<h4>Anote o número de protocolo: <strong><? if($protocolo == "") { echo $_POST["protocolo"]; } else { echo $protocolo; } ?></strong>. </h4><p class="textos">Caso não conclua o teste agora, o número protocolo poderá ser utilizado para continuar a aplicação.</p>
<div style="width: 600px; height: auto; float: left;">


<?		


        session_destroy();
        $ano2 = date("Y");
		$im = 0;
        
		if($_POST["Submit"]){
	    
        //Verificar se o TICKET é da commit  
        $is_commit = mysql_query("SELECT commit FROM gerador_tickets WHERE numero_ticket = '".$_POST["ticket"]."'");
        $is_commit = mysql_fetch_array($is_commit);
        $is_commit = $is_commit["commit"];
        if($is_commit == 1) {
            $goto = "../commit/aplicacao_commit.php";
        } else {
            $goto = "perfil/aplicacao2.php";
        }   	  
    
		$im = 1;
		
		$frase .= "Os campos abaixo devem ser preenchido corretamente:".'\n';
		
		if($_POST["nome"] == ""){
			$im =0;
			$frase .= "Nome.".'\n';
		}
        		
		if($_POST["carg"] == ""){
			$im =0;
			$frase .= "Cargo.".'\n';
		}
        
		if($_POST["orga"] == "(escolha)"){
			$im =0;
			$frase .= "Organização.".'\n';
		}
		
		if($_POST["grup"] == "(escolha)" or $_POST["grup"] == "" or !isset($_POST["grup"])) {
			$im =0;
			$frase .= "Grupo.".'\n';
		}
		
		if($_POST["ddd"] == ""){
			$im =0;
			$frase .= "DDD.".'\n';
		}
		
		if($_POST["tele"] == ""){
			$im =0;
			$frase .= "Telefone.".'\n';
		}		
		
		if($_POST["ticket"] != ""){
			$ticket = $_POST["ticket"];
			$tick = 1;
		}
        
        /*
        if($_POST["orga"] == '248' and $_POST["orga"] == '249' and $_POST["orga"] != "154" and $_POST["orga"] != "207" and $_POST["orga"] != "244" and $_POST["orga"] != "18" and $_POST["orga"] != "194" and $_POST["orga"] != "242" and $_POST["orga"] != "187" and $_POST["orga"] != "196")
        {
        */
            $sel = mysql_query("SELECT * FROM gerador_tickets WHERE numero_ticket = '$ticket'");
            if(mysql_num_rows($sel) != 0)
            {
                $geta = mysql_fetch_array($sel);
                $usado = $geta["utilizado"];
                $orga1 = $_POST["orga"];
                $grup1 = $_POST["grup"];
                $orga2 = $geta["organizacao"];
                $grup2 = $geta["grupo"];
                $unico = $geta["ticket_unico"];
                
                
                if($is_commit != '1') {
                if($unico != "1")
                {
                    if($grup1 == $grup2)
                    {        
                        
                            if($usado == 1)
                            {
                                $frase .= "O ticket já foi utilizado.".'\n';
                                $im = 0;
                            } else {
                                //mysql_query("UPDATE gerador_tickets SET utilizado = 1 WHERE numero_ticket = '$ticket'");
                                $_SESSION["tick"] = $ticket;
                            }
                        
                    } else {
                        $frase .= "O ticket não corresponde à empresa/grupo.".'\n';
                        $im = 0;
                    }
                } else {
                    if($orga1 == $orga2)
                    {        
                        

                        //mysql_query("UPDATE gerador_tickets SET utilizado = 1 WHERE numero_ticket = '$ticket'");
                        $_SESSION["tick"] = $ticket;

                
                    } else {
                        $frase .= "O ticket não corresponde à empresa/grupo.".'\n';
                        $im = 0;
                    }
                }
               } 
            } else {
                $frase .= "O ticket não existe.".'\n';
                $im = 0;
            }
            
        

		if($_POST["dia"] == "(dia)"){
		
			$im = 0;
			$frase .= "Dia.".'\n';
		}else{
			$dia = $_POST["dia"];
		}
		
		if($_POST["mes"] == "(mes)"){
	
			$im = 0;
			$frase .= "Mes.".'\n';
		}else{
				$mes = $_POST["mes"];
		}
		
		if($_POST["ano"] == "(ano)"){
			$im = 0;
			$ano = $_POST["ano"];
			$frase .= "Ano.".'\n';
		}else{
			$ano = $_POST["ano"];
		}
        
        		
						// Validando Cpf
	if (addslashes(trim($_POST["ncpf"])) == "") {
		$im = 0;
		$frase .= "Preencha o campo CPF corretamente!".'\n';
		$cpf = addslashes(trim($_POST["ncpf"]));
	} elseif (!valida_cpf(addslashes(trim($_POST["ncpf"]))))  {
		$im = 0;
		$frase .= "CPF Inválido!".'\n';
		
	} else {
	    $cpf = addslashes(trim($_POST["ncpf"]));
	    
        $ativado = mysql_query("SELECT * FROM seis_meses");
        $ativado = mysql_fetch_array($ativado);
        $ativado = $ativado["app"];
        
        if($ativado == 1) {
            $get_cpf = mysql_query("SELECT cpf, data_aplic FROM aplicacoes WHERE cpf = '$cpf' ORDER BY data_aplic DESC");
            $get_cpf = mysql_fetch_array($get_cpf);
            $the_cpf = $get_cpf["cpf"];
            $the_data = $get_cpf["data_aplic"];
            $hoje = date("Y-m-d H:i:s");
            if($the_cpf == $cpf) {
                $tempo_seg = time_diff($hoje,$the_data);
                //15552000 são 6 meses em seg
                if($tempo_seg <= 15552000) {
                    $im = 0;
                    $frase .= "O CPF inserido já efetuou esta aplicação nos últimos seis meses.";
                }
            }
        }
	}
		
			
		if (addslashes(trim($_POST["emai"])) == "") {
		$im = 0;
		$frase .= "Preencha o campo Email corretamente!".'\n';
		$email = addslashes(trim($_POST["emai"]));
		//alert("Preencha o campo E-amil corretamente!");
	} elseif (!validar_email(addslashes(trim($_POST["emai"]))))  {
		$im = 0;
		$frase .= "Email Inválido!".'\n';
		//alert("Email Inválido!");
		$email = addslashes(trim($_POST["emai"]));
	} else {
		$email = addslashes(trim($_POST["emai"]));
	}
	
		
		
		if(!$im){
			echo "<script language=\"javascript\">alert('$frase');</script>";
			
		} else {
		    
            
            
            ?>
            
            <form action="<?=$goto?>" method="post"  name="form1" id="formtosubmit">		
    		<input type="hidden" name="nome" value="<?=$_POST["nome"]?>"/>
            <input type="hidden" name="carg" value="<?=$_POST["carg"]?>"/>
            <input type="hidden" name="orga" value="<?=$_POST["orga"]?>"/>
            <input type="hidden" name="grup" value="<?=$_POST["grup"]?>"/>
            <input type="hidden" name="ddd" value="<?=$_POST["ddd"]?>"/>
            <input type="hidden" name="tele" value="<?=$_POST["tele"]?>"/>
            <input type="hidden" name="ticket" value="<?=$_POST["ticket"]?>"/>
            <input type="hidden" name="dia" value="<?=$_POST["dia"]?>"/>
            <input type="hidden" name="mes" value="<?=$_POST["mes"]?>"/>
            <input type="hidden" name="ano" value="<?=$_POST["ano"]?>"/>
            <input type="hidden" name="ncpf" value="<?=$_POST["ncpf"]?>"/>
            <input type="hidden" name="emai" value="<?=$_POST["emai"]?>"/>
            <input type="hidden" name="protocolo" value="<?=$_POST["protocolo"]?>"/>
            </form>
            <script>
                $("#formtosubmit").submit();
            </script>
            <?  
		}
		
        
        }
		
		if($im == 0){ 
		?>
			<form action="perfil/index.php" method="POST" name="form1">
		<?} if(($_POST["Submit"]) and ($im == 1)){
			
			$sql = "UPDATE tickets SET status=1 WHERE num_ticket=$ticket";
			mysql_query($sql);
			
			?>
			<form action="perfil/aplicacao2.php" method="post"  name="form1" id="form1">		
			<input type="hidden" value="1" name="pagina_aplicacao">		
			<body onLoad="document.form1.submit()">
		<?}?>
    
  <input type="hidden" name="protocolo"  title="protocolo" id="protocolo" value="<? if($protocolo == "") { echo $_POST["protocolo"]; } else { echo $protocolo; } ?>"/>
  <table width="80%" border="0" align="left" cellpadding="3" cellspacing="0">
    <tr>
      <td ><div  class="textos">Nome</div></td>
      <td ><input type="text" name="nome"  title="Nome" size="29"  id="nome" onfocus="P7_MultiClass2('nome','InputFocus')" onblur="P7_MultiClass2('nome','')" value="<?=$_POST["nome"]?>"/>      </td>
    </tr>
    <tr>
      <td ><div  class="textos">E-mail</div></td>
      <td ><input type="text" name="emai" title="E-mail" size="29"  id="emai" onfocus="P7_MultiClass2('emai','InputFocus')" onblur="P7_MultiClass2('emai','')" value="<?=$_POST["emai"]?>" />      </td>
    </tr>
    <tr>
      <td ><div class="textos">Organiza&ccedil;&atilde;o</div></td>
      <td >
          <? 
          $sql = "SELECT * FROM `organizacoes` WHERE pg_organizacao = 1 ORDER BY `nome`";
          $result = mysql_query($sql);
          //echo $result;
          ?>
      <label>
      <? $groupos = $_POST["orga"]; ?>
      <? if($groupos == "") { $groupos = 0; } ?>
      <script>
        $(document).ready(function() {
            if(<?=$groupos?> == 0) {
                $("#grupo").attr("disabled",true);
            } else {
                get_grupos(<?=$groupos?>);
            }

        })
           
            function get_grupos(id) {
            
            $.ajax({ 
    			url: '../pegar_grupos.php',
    			type: 'POST',
    			data: ({
    				id: id
    			}),
                
    			 success: function(data){
			     if(data != "fail") {
    			    $("#grupo").removeAttr("disabled");
                    $("#grupo").html('<option value="(escolha)" selected="selected">(escolha)</option>');
    			    $("#grupo").append(data);
                 } else {
                    $("#grupo").html('<option value="(escolha)" selected="selected">(escolha)</option>');
                    $("#grupo").attr("disabled",true);
                 }
    			}					  
    	   });            
                
          }
   
      </script>
      
     
        <select name="orga" id="orgs" onchange="get_grupos(this.value)" >
          <option value="0">(escolha)</option>

          <? while ($linha = mysql_fetch_assoc($result)) { 
          	$id = $_POST["orga"];
          	if($linha["id"] == $id){
          		$select = " SELECTED ";
          	}else{
          		$select = " ";
          	}
          	
          	?>
          	<option value="<?=$linha["id"]?>" <?=$select?> ><?=$linha["nome"]?></option>
         <? }?>
        </select>
      </label></td>
    </tr>
    
    <tr>
      <td ><div  class="textos">Grupo</div></td>
      <td ><label>
        <select name="grup" id="grupo" >
          <option value="(escolha)" selected="selected">(escolha)</option>
          
        </select>
      </label></td>
    </tr>
    <tr>
      <td><div  class="textos">Cargo</div></td>
      <td ><input type="text" name="carg" title="Cargo" size="29"  id="carg" onfocus="P7_MultiClass2('carg','InputFocus')" onblur="P7_MultiClass2('carg','')" value="<?=$_POST["carg"]?>"/></td>
    </tr>
    <tr>
      <td ><div  class="textos">Telefone</div></td>
      <td ><input type="text" name="ddd" title="Telefone" size="2"  maxlength="2" id="ddd" onfocus="P7_MultiClass2('ddd','InputFocus')" onblur="P7_MultiClass2('ddd','')" onKeyUp="javascript:somente_numero(this);" value="<?=$_POST["ddd"]?>"/> - <input type="text" name="tele" title="Telefone" size="10" id="tele" onfocus="P7_MultiClass2('tele','InputFocus')" onblur="P7_MultiClass2('tele','')" onKeyUp="javascript:somente_numero(this);" value="<?=$_POST["tele"]?>"/>      </td>
    </tr>
    <tr>
      <td ><div  class="textos">Nascimento</div></td>
      <td ><select name="dia" class="form_style">
      						 <option value="(dia)" selected>Dia</option>
					<?
						for ($i=1;$i<=31;$i++) {
							if ($dia == $i) {
								$check = "selected=\"selected\"";
							} else {
								$check = "";
							}
					?>
						<option value="<?=$i?>" <?=$check?>><?=$i?></option>
					<?
						}
					?>
					</select>
					<!-- Select de dia -->
					/
					<!-- Select de mes -->
					<select name="mes" class="form_style">
						<option value="(mes)" selected>Mês</option>
					<?
						for ($i=1;$i<=12;$i++) {
							if ($mes == $i) {
								$check = "selected=\"selected\"";
							} else {
								$check = "";
							}
					?>
						<option value="<?=$i?>" <?=$check?>><?=ucfirst(string_mes($i));?></option>
					<?
						}
					?>
					</select>
					<!-- Select de mess -->
					/
					<!-- Select de ano -->
					<select name="ano" class="form_style">
						<option value="(ano)" selected>Ano</option>
					<?
						for ($i=($ano2-100);$i<=($ano2);$i++) {
							if ($ano == $i) {
								$check = "selected=\"selected\"";
							} else {
								$check = "";
							}
					?>
						<option value="<?=$i?>" <?=$check;?>><?=$i;?></option>
					<?
						}
					?>
					</select></td>
    </tr>
    <tr>
      <td ><div  class="textos">CPF</div></td>
      <td ><input type="text" name="ncpf" title="CPF" size="29"  id="ncpf" onfocus="P7_MultiClass2('ncpf','InputFocus')" onblur="P7_MultiClass2('ncpf','')" onKeyUp="javascript:somente_numero(this);" value="<?=$_POST["ncpf"]?>"/></td>
    </tr>
    <tr>
      <td ><div  class="textos">Ticket</div></td>
      <td ><input type="text" name="ticket" title="ticket" size="29"  id="ticket" onKeyUp="javascript:somente_numero(this);" value="<?=$_POST["ticket"]?>"/></td>
    </tr>
    <tr>
      <td colspan="2"><div style="margin-left:40px;">
        
          
          <input name="Submit" type="submit" onclick="MM_validateForm('nome','','R','emai','','RisEmail','carg','','R','tele','','R','nasc','','R','ncpf','','R');return document.MM_returnValue" value="Enviar e iniciar o preenchimento" tabindex="9" class="form_bt" />
          &nbsp;
       
      </div></td>
      
    </tr>

    
  </table>
</form>
    </div>
    <form action="perfil/aplicacao2.php" method="POST">
    <div style="float: left; width: 300px; border: 1px solid gray; padding: 10px">
        <div class="textos" style="text-align: center; font-weight: bold;">Continuar aplicação</div>
        <div class="textos" style="margin-top: 10px;">Digite seu número de protocolo para continuar a aplicação: </div>
        <center><div class="textos">Número de Protocolo: <input type="text" name="protocolo"  title="protocolo" id="protocolo"  onKeyUp="javascript:somente_numero(this);" /></div></center>
        <center><input name="Submit" type="submit" value="Continuar a Aplicação" class="form_bt" style="margin-top: 10px;" /></center>
    </div> 
     <input type="hidden" name="protocolo_check" value="1" title="protocolo" id="protocolo" />
    </form>
	</div>
</div>	
	


<div id="rodape">Copyright 1979-2012 APP - 55 (31) 3293-2590</div>


</body>

</html>