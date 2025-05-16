<?php include("config.php"); ?>
<?php //include("library.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Language" content="pt-br">
	<title>CMS MAPER - Mapeamento de Perfil :: Gest&atilde;o por Compet&ecirc;ncias, Sistemas de Qualidade, Educa&ccedil;&atilde;o Corporativa e RH</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="css/new_css.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.esm.min.js" integrity="sha384-pXJyILVSfKOB4xKYbM0dJr+oH4iVvo4s7mWbiTHe6LSxd38hl16DMj6AOJyy2Wcz" crossorigin="anonymous"></script>
</head>
<body>

	<div class="wrapper fadeInDown">
	  <div id="formContent">
	    <!-- Tabs Titles -->

	    <!-- Icon -->
	    <div class="fadeIn first">
	      <img src="img/IdVisual_Maper_Final-01.png" id="icon" alt="User Icon" />
	    </div>

	    <!-- Login Form -->
		<form method="post" action="recuperar.php">
		        <div class="input_form_login">
		            <label for="email_aluno">Insira o seu e-mail e redefina a sua senha.</label>
		            <input class="fadeIn second" type="email" id="email_aluno" name="email_aluno" placeholder="Seu email">
		        </div> 

		        <div class="input_form_login">
		            <input type="submit" name="esqueciasenha" value="Redefinir">
		        </div>
		</form>

	    <!-- Remind Passowrd -->

	  </div>
	</div>
	
</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>

