<?php include("conn.php"); ?>
<?php include("library.php"); ?>

<html>
<head><title><?=titulo_janela();?></title>
	<meta name="GENERATOR" content="YesSoftware CodeCharge v.2.0.4 build 11/30/2001">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
	<style>
		body {scrollbar-base-color: #E1EFC9;}.style1 {color: #FFFFFF}
	</style>
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<link href="teste.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<div align="center">
	  <table height="100%">
	    <tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="td_01" scope="col">

							<img src="imagens/logo_pequena.gif">

						</td>
					</tr>
					<tr>
						<td class="td_02">Acesso exclusivo para usu&aacute;rios autorizados.
						</td>
					</tr>
					<tr>

						<td class="td_03">
							<table align="center" cellspacing="5">
								<form action="esqueci_senha_acao.php" method="POST">
									<input type="hidden" name="FormName" value="Senha">
									<tr>
										<td colspan="2" class="td_05">
											Esqueci minha senha
										</td>
									</tr>

  
									<tr>
										<td>
											Insira seu e-mail:
										</td>
										<td>
											<input type="text" name="email" value="" maxlength="50" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;

											
										</td>
										<td>
											<input type="submit" value="Enviar nova senha">
										</td>
									</tr>
								</form>
							</table>
    
						</td>
					</tr>
					<tr>
						<td class="td_04" style="color : #ffffff;">
						</td>

					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>