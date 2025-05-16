<?php include("conn.php"); ?>
<?php include("library.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php include("header.php"); ?>
<link rel="stylesheet" type="text/css" href="css/shadowbox.css">
<script>
function envia_contato() {
		var email = $("#email").val();
		var ticket = $("#ticket").val();
		if (email!='')
		{		
			$.post("ticket_unico_semd.php",{email: email, ticket:ticket},
				function(retorno){
					alert("Mensagem enviada com sucesso!");
					document.getElementById('form-contato').reset() 

			}) 
		}else{
					alert("Existem campos incompletos no formulÃ¡rio. Favor preencher todos.");
		}
		return false;
}
</script>

<style>
	#box_email_envia {
		text-align: center;
	}
	
	#box_email_envia p {
		text-align: center;
		font-size: 18px;
		color: #40a2df;
		font-family: arial;
		margin-top: 28px;
		margin-bottom: 10px;
	}
	
	#box_email_envia input[type="text"] {
	  padding: 10px;
	  border: solid 5px #c9c9c9;
	  transition: border 0.3s;
	}
	#box_email_envia input[type="text"]:focus,
	#box_email_enviainput[type="text"].focus {
	  border: solid 5px #969696;
	}
	
	.style_bt {
		border: 2px solid #40a2df;
		background-color: #40a2df;
		color: #ffffff;
		border-radius: 5px;
	    width: 107px;
	    height: 44px;
		font-size: 18px;
	}
	
	.style_bt:hover {
		border: 2px solid #40a2df;
		background-color: #ffffff;
		color: #40a2df;
	}
	
	
</style>
<body>

	<!-- INICIO - DIV global - Emgloba todo o site -->
	<div id="global">
	
		<div id="principal" style="background-color: #ffffff; height: 150px;" >
			
			<form action="?cadastra=1" method="post" name="cadastra" enctype="multipart/form-data" onsubmit="return envia_contato();">
				<div id="box_email_envia">
					<p>
						Informe o endereço de e-mail para envio:
						</br>
						<small style="font-size: 12px; color: #000000;">Use ponto e vírgula ( ; ) para separar um e-mail do outro.</small>
					</p>
					<input type="text" name="email" id="email" style="width: 300px;" placeholder="Informe o endereço de E-mail" />
					<input type="hidden" name="ticket" id="ticket" value="<?=$_REQUEST["id"];?>" />
					<input type="submit" value="Enviar" class="style_bt" />
				</div>
			</form>
		
		</div> <!-- FIM DIV PRINCIPAL -->
	</div> 

</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
</html>