<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>APPWeb - Avaliação de Potencial e Perfil Profissional</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style18 {
	font-size: 24px
}
-->
</style>
</head>

<body>
<p><?php

$pGabarito = $_GET["gabarito"];

if (!$pGabarito) {

$pGabarito = $_POST["gabarito"]; 

}

$pNome = $_POST["nome"]; 
$pCpf = $_POST["cpf"]; 
$pNasc = $_POST["nasc"];  
$pPerfil = $_POST["perfil"]; 
$pCargo= $_POST["cargo"];  
$pSenha= $_POST["senha"];  
?>
</p>
<form action="" method="post" name="form1" target="_blank" id="form1">
  <table width="100%%" border="1" cellpadding="10" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="25%"><img src="../logo_appweb.jpg" width="159" height="65" /></td>
      <td><table width="100%%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="48%"><strong>Nome: </strong><?php echo $pNome;?>
              <input name="nome" type="hidden" id="hiddenField" value="<?php echo $pNome;?>" />
              <br />
                <strong>CPF: </strong><?php echo $pCpf;?>
              <input type="hidden" name="cpf" id="hiddenField2" value="<?php echo $pCpf;?>" />
                <br />
                <strong>Nasc: </strong><?php echo $pNasc;?>
            <input type="hidden" name="nasc" id="nasc" value="<?php echo $pNasc;?>" /></td>
            <td width="52%"><strong>Perfil: </strong><?php echo $pPerfil;?>
              <input type="hidden" name="perfil" id="hiddenField4" value="<?php echo $pPerfil;?>" />
              <br />
                <strong>Cargo:</strong> <?php echo $pCargo;?>
            <input type="hidden" name="cargo" id="hiddenField5" value="<?php echo $cargo;?>" />
            <input name="senha" type="hidden" id="senha" value="<?php echo $pSenha;?>" />
            <input name="gabarito" type="hidden" id="gabarito" value="<?php echo $pGabarito;?>" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p align="center" class="style18"><a href="#" onclick="javascript:document.form1.action='prim_pagi_resu.php';document.form1.submit();">Página 01</a></p>
  <p align="center" class="style18"><a href="#" onclick="javascript:document.form1.action='segu_pagi_resu.php';document.form1.submit();">Página 02</a></p>
  <p align="center" class="style18"><a href="#" onclick="javascript:document.form1.action='base_7e10_resu.php';document.form1.submit();">Base 7 e 10</a></p>
</form>
<script language='JavaScript'>history.go(1);</script>
</body>
</html>
