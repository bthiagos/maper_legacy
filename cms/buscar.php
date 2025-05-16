<?php include("conn.php"); ?>
<?php include("logon.php"); ?>
<?php include("library.php"); ?>

<?

if(isset($_REQUEST["pesquisar"]))
{
	$pesquisar = strtolower($_REQUEST["pesquisar"]);
}

if(isset($_REQUEST["categoria"]))
{
	$categoria = $_REQUEST["categoria"];
}

$termo = stringParaBusca($pesquisar);
?>   


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>

<style type="text/css">
a:link, a:visited {
	text-decoration: none;
	color: #000000;
	}
a:hover {
	text-decoration: underline; 
	color: #000000;
	}
a:active {
	text-decoration: none;
	color: #000000;
	}
</style>

<body>

<!-- This optional free use link disables the online purchase reminder.  Include within the body of your page -->
<div style="display: none;"><a id='qm_free' href='http://www.opencube.com'>OpenCube Drop Down Menu (www.opencube.com)</a>
<br><br><br></div>

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<?php include("topo.php"); ?>	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->
		<div id="principal">
		
			<!-- INICIO - DIV info - Barra de informacao -->
			<div id="info">

			</div>
			<!-- INICIO - DIV info - Barra de informacao -->
			
	 <?php //CONTEÙDO +++++++++++++++++++ ?>
            	
        <div id="box_conteudo">
        <div style="margin-left: 40px; margin-right: 40px;">
<?
            function buscar($termo,$pesquisar, $aonde, $where1, $where2, $where3, $where4, $where5, $nome, $link, $param, $id,$abrir)
            {
            $sql = "SELECT
	                *
	                FROM
	                ".$aonde." WHERE
	                ".$where1." REGEXP \"$termo\"";
                
              		if($where2 != "")
              		{
              			$sql .= " OR $where2 REGEXP \"$termo\"";
              		}
                
                	if($where3 != "")
              		{
              			$sql .= " OR $where3 REGEXP \"$termo\"";
              		}
              		
              		if($where4 != "")
              		{
              			$sql .= " OR $where4 REGEXP \"$termo\"";
              		}
              		
              		if($where5 != "")
              		{
              			$sql .= " OR $where5 REGEXP \"$termo\"";
              		}
                	

	            	$sql = mysql_query($sql);
	            	$num = mysql_num_rows($sql);
            	if($num != 0) {
        	  		echo "<div style='font-family: Tahoma, Geneva, sans-serif; font-size: 17px; color: #000066; margin-left: 0px; padding-top: 10px; border-bottom-width: thin; border-bottom-style: solid; border-bottom-color: #000066; width: 100%;'><a href='buscar.php?pesquisar=".$pesquisar;
        	  		if($_REQUEST["abrir"] != $abrir)
        	  		{
        	  			echo "&abrir=".$abrir;
        	  		}
        	  		echo "'>";
        	  		if($_REQUEST["abrir"] == $abrir)
        	  		{
        	  			echo "[-] ";
        	  		}else{
        	  			echo "[+] ";
        	  		}
        	  		echo $nome." " . "(" . $num . " resultados)" ."</a></p><ul>";
   
		           while ($linha = mysql_fetch_array($sql))
		           {
		           		if($_REQUEST["abrir"] == $abrir)
	            		echo  "<li><a href='".$link."cod=".$linha[$id]."'>" . $linha[$param] . "</a></li>";
		           }
		           echo "</ul></div>";
            }
            }
            
            if(isset($_REQUEST["pesquisar"]))
            {
	            buscar($termo,$pesquisar, "aplicacoes","nome","email","telefone","cargo","respostas","Aplicações","aplica_alt.php?alterar=1&","nome","id","1");
	            buscar($termo,$pesquisar, "ce_contatos","contato","email","","","","Contatos","contatos_gerencia_alt.php?alterar=1&","contato","codigo","2");
	            buscar($termo,$pesquisar, "ce_letter","titulo","msg","","","","Newsletter","letter_cadastro.php?","titulo","codigo","3");
	            buscar($termo,$pesquisar, "organizacoes","nome","","","","","Organizações","cadastroEmpresa_alt.php?edit=1&","nome","id","4");
	            buscar($termo,$pesquisar, "clima_GrupoEmail","nome","","","","","Clima - Grupos de Emails","cadastrarGrupoClima_alt.php?alterar=1&","nome","id","5");           
	            buscar($termo,$pesquisar, "depoimentos","depoimento","nome","cargo","","","Depoimentos","depoimentos_alt.php?edit=1&","depoimento","id","6");
	            buscar($termo,$pesquisar, "gerador_tickets_pedidos","nome_cliente","cidade","email","","","Tickets APP","gerar_tickets_app.php?","nome_cliente","id","7");
	            buscar($termo,$pesquisar, "gerador_tickets_pedidos_app","nome_cliente","cidade","email","","","Tickets","gerar_tickets.php?","nome_cliente","id","8");
				
	            buscar($termo,$pesquisar, "empresaCadastra","razao_social","nome_contato","cargo","inscricao_estadual","inscricao_municipal","Cadastro de Empresas","ces_empresas_alt.php?edit=1&","nome_cliente","id","9");
	           
            }
            
            


?>
</div>
				
			<!-- INICIO - DIV info fim - Barra de informacao -->
			<div id="info_fim">
				&nbsp;
			</div>
			<!-- INICIO - DIV info fim - Barra de informacao -->				
				
		</div>
		<!-- INICIO - DIV PRINCIPAL - Div com conteudo principal -->		
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	


<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>