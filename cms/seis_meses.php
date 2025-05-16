<?php include("logon.php"); ?>
<?php include("conn.php"); ?>
<?php include("library.php"); ?>	


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
			<img src="imagens/bastidores.gif" align="Programa Bastidores"  />
		</div>
		<!-- FIM - DIV TOPO - Emgloba todo o site -->	
		
		
		<!-- INICIO - DIV MENU - Menu do Sistema -->
		<?php include("menu.php"); ?>
		<!-- INICIO - DIV MENU - Menu do Sistema -->
        
        <script type="text/javascript">
            function seis_meses(valor, tipo) {
                $.ajax({
                url: 'seis_meses_muda.php',
                type: 'POST',
                data: ({
                	valor: valor,
                    tipo: tipo
                }),
                  
                 success: function(data){
                				
                }					  
                }); 
            }
        </script>
        
        <div style="clear: left; margin-top: 70px;">
        <div style="width: 100%; text-align: center;font-family: Arial, Verdana; font-size: 16px;">Ativar ou Desativar bloqueio de CPF para fazer a aplicação uma vez a cada seis meses.</div>
            <table cellpadding="5" cellspacing="5" style="border: 1px solid #000; width: 500px; font-family: Arial, Verdana; font-size: 16px; margin-top: 5px; margin-left: auto; margin-right: auto;">
                <tr>
                    <td style="background: #DADADA; padding: 10px;"><strong>APLICAÇÃO APP</strong></td>
                    <td style="background: #DADADA;  padding: 10px;"><strong>APLICAÇÃO COMMIT</strong></td>
                </tr>
                <?php
                    $check = mysql_query("SELECT * FROM seis_meses");
                    $check = mysql_fetch_array($check);
                    $app = $check["app"];
                    $commit = $check["commit"];
                ?>
                <tr>
                    <td style="padding: 10px;">
                        <input type="radio" name="app" value="1" <?php if($app == 1) { echo "checked"; } ?> onclick="seis_meses(this.value, 'app')" /> Ativado<br />
                        <input type="radio" name="app" value="0" <?php if($app == 0) { echo "checked"; } ?> onclick="seis_meses(this.value, 'app')" /> Desativado
                    </td>
                    <td style="padding: 10px;">
                        <input type="radio" name="commit" value="1" <?php if($commit == 1) { echo "checked"; } ?> onclick="seis_meses(this.value, 'commit')" /> Ativado<br />
                        <input type="radio" name="commit" value="0" <?php if($commit == 0) { echo "checked"; } ?> onclick="seis_meses(this.value, 'commit')" /> Desativado
                    </td>
                </tr>
            </table>
        </div>

	
	
	</div>
	<!-- FIM - DIV global - Emgloba todo o site -->	

<!-- QuickMenu Structure [Menu 0] -->


<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
</body>
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false);</script>
</html>