<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>
<?php

$aplica = $_REQUEST["aplicacoes"];
$aplica = explode("/",$aplica);

$url = "http://www.appweb.com.br/cms/perfil_cargos_gerador.php?aplicacoes=".$_REQUEST["aplicacoes"];

$resultado_url = executa_url($url);

    $html .='
	
	<table width="90%" border="0" cellspacing="0" bordercolor="#000000" align="center" style="margin-top:19px; border: 1px #000000 solid; background-image: url(fun_table.gif);
	background-repeat: repeat-y;"">
  <tr>
    <td width="19%"><img src="logo_appweb2.jpg"/></td>
    <td style="font-family: Arial, Verdana; font-size: 15px; font-weight: bold;" valign="middle">Lista de Relatórios de Perfis de Cargo
    </td>
  </tr>
</table><div style="margin-top: 10px; font-family: Arial; font-size:12px; margin-left: 30px; text-transform:uppercase;">
 ';
 
 for($i = 0; $i < sizeof($aplica);$i++) {
    $id = $aplica[$i];
    $get = mysql_query("SELECT * FROM aplicacoes WHERE id = '$id' ORDER BY nome ASC");
    while($lin = mysql_fetch_array($get)) {
        $getperfil = mysql_query("SELECT * FROM perfil_cargos WHERE id = '".$lin["id_perfil"]."'");
        $getperfil = mysql_fetch_array($getperfil);
        $getperfil = $getperfil["cargo"];
        $html .= "<div style='margin-top: 5px;'><a href='http://appweb.com.br/cms/perfil_cargos_gerar.php?aplicacoes=".$lin["id"]."'>".strtoupper($lin["nome"])." - ".strtoupper($getperfil)."</a></div>";    
    }
    
 }
 
 $html .='</div>
	<div style="heigth:15px;">&nbsp;&nbsp;</div>
	<table width="79%" border="0" align="center">
		<tr>
			<td valign="top"><hr style="height: 1px; width: 70%; color: #666666; margin-top:10px">
		<div style="text-align: center; font-size: 12px">        
		Maria Lúcia Rodrigues Corrêa CRP 1560	
		</div>
		</td>
		</tr>
	</table>
  </div>';

require_once("dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("App_Web.pdf");
?>