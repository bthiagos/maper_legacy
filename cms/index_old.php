<?php include("conn.php"); ?>
<?php include("library.php"); ?>

<html>
<head><title>CMS APPWeb :: Gest&atilde;o por Compet&ecirc;ncias, Sistemas de Qualidade, Educa&ccedil;&atilde;o Corporativa e RH</title>
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
								<form action="valida_logon.php" method="POST">
									<input type="hidden" name="FormName" value="Login">
									<tr>
										<td colspan="2" class="td_05">
											Sistema Administrativo
										</td>
									</tr>

  
									<tr>
										<td>
											Usu&aacute;rio:
										</td>
										<td>
											<input type="text" name="login" value="" maxlength="50" />
										</td>
									</tr>

										<td>
											Senha:
										</td>
										<td>
											<input type="password" name="senha" maxlength="50" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;

											
										</td>
										<td>
											<input type="hidden" name="FormAction" value="login">

											<input type="submit" value="Entrar">
											<br>
												<input type="hidden" name="ret_page" value="">
											<input type="hidden" name="querystring" value="">

										</td>
									</tr>
								</form>
                                	<!--<tr>
                                    	<td>&nbsp;</td>
                                        <td><a href="esqueci_senha">Esqueci minha senha</a></td>
                                    </tr>-->
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