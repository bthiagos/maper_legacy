<?php include("conn.php"); ?>
<?php
	// Inicia sess�es
	session_start();
	
	// Recupera o login
	$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
	// Recupera a senha, a criptografando em MD5
	$senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE;
	
	// Usu�rio n�o forneceu a senha ou o login
	if(!$login || !$senha)
	{
	    echo  "<script language=\"javascript\">alert(' Voc� deve digitar sua senha e login!')
	    location.href = \"index.php\"; 
	    </script>";
	}
	
	/**
	* Executa a consulta no banco de dados.
	* Caso o n�mero de linhas retornadas seja 1 o login � v�lido,
	* caso 0, inv�lido.
	*/
$SQL = "SELECT *
        FROM ce_usuario
        WHERE login ='$login' "; 
	$result_id = @mysql_query($SQL) or die("Erro no banco de dados!");
	$total = @mysql_num_rows($result_id);
	
	// Caso o usu�rio tenha digitado um login v�lido o n�mero de linhas ser� 1..
	if($total)
	{
	    // Obt�m os dados do usu�rio, para poder verificar a senha e passar os demais dados para a sess�o
	    $dados = @mysql_fetch_array($result_id);
	
	    // Agora verifica a senha
	    if(!strcmp($senha, $dados["Senha"]))
	    {
	        // TUDO OK! Agora, passa os dados para a sess�o e redireciona o usu�rio
	        $_SESSION["id_usuario_adm"]   = $dados["CodUsuario"];
	        $_SESSION["nome_usuario_adm"] = stripslashes($dados["Nome"]);
	        $_SESSION["sobrenome_usuario_adm"] = stripslashes($dados["Sobrenome"]);
	        $_SESSION["login_adm"] = stripslashes($dados["Login"]);
	        $_SESSION["mudar_adm"]    = $dados["MudaSenha"];
	        $_SESSION["per_adm"]    = $dados["permisao"];
	        
	        if(($dados["permisao"] == '3333') or ($dados["permisao"] == '4444')){
	        	
	        	if($dados["organizacao"] != ""){
	        		$_SESSION["organizacaon"]    = $dados["organizacao"];
	        	}else{
	        		header("Location:index.php");
	        		exit;
	        	}
	        	
	        }
	        
	        $cod_user = $dados["CodUsuario"];
	        
	        $data = date("Y-m-d H:i:s");
	        $sql = "UPDATE ce_usuario SET UltimoLogon='$data' WHERE CodUsuario='$cod_user'";
	        mysql_query($sql);
	        
	        if ($dados["MudaSenha"] == "1") {
	        	header("Location: usuario_mudasenha.php");
	        	exit;
	        }else{
	        
	        	header("Location: home.php");
	        	exit;
	        }
	        
	    }
	    // Senha inv�lida
	    else
	    {
	    echo  "<script language=\"javascript\">alert('Senha Inv�lida!')
	    location.href = \"index.php\"; 
	    </script>";
	    }
	}
	// Login inv�lido
	else
	{
	    echo  "<script language=\"javascript\">alert('O login fornecido por voc� � inexistente!!')
	    location.href = \"index.php\"; 
	    </script>";
	    $erro = "O login fornecido por voc� � inexistente!";
	     echo $erro;
	}

	

?>	