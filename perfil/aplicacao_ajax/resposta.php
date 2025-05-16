<?php
    include("../conn.php");
    
    $tempo = $_POST["tempo"];
    $resposta = $_POST["resposta"];
    $ordem = $_POST["ordem"];
    $protocolo = $_POST["protocolo"];
    $data = date("Y-m-d H:i:s");
	
	$lang = $_POST["lang"];
	
	$salvar_aplicacao = $_POST["salvar_aplicacao"];
    
    //CHECA SE O PROTOCOLO EXISTE
    $existe = mysql_query("SELECT protocolo, resposta FROM protocolos WHERE protocolo = '$protocolo'");
    if(mysql_num_rows($existe) == 0) {
        echo "error";
    } else {
        //EXISTE
        $respostas_previas = mysql_result($existe,0,"resposta").$resposta;
        $query = "UPDATE protocolos SET ordem = '$ordem', resposta = '$respostas_previas',data = '$data',tempo = '$tempo' WHERE protocolo = '$protocolo'";
    
    }
    
    if(mysql_query($query)) {
    	
		if($salvar_aplicacao == 0){
			
			echo "1";
		}else{ 
			
			include("../enviar_email.php");
			
			$get_resposta = mysql_query("SELECT resposta,nome,email,telefone,cpf,nascimento,organizacao,grupo,cargo,tempo,ordem,ticket FROM protocolos WHERE protocolo = '$protocolo'");
		    $resposta = mysql_result($get_resposta,0,"resposta");
		    
		    $nome = mysql_result($get_resposta,0,"nome");
		    $email = mysql_result($get_resposta,0,"email");
		    $telefone = mysql_result($get_resposta,0,"telefone");
		    $cpf = str_replace(".","",mysql_result($get_resposta,0,"cpf"));
		    $cpf = str_replace("-","",$cpf);
		    $nascimento = mysql_result($get_resposta,0,"nascimento");
		    $organizacao = mysql_result($get_resposta,0,"organizacao");
		    $grupo = mysql_result($get_resposta,0,"grupo");
		    $cargo = mysql_result($get_resposta,0,"cargo");
		    $tempo = "00:".mysql_result($get_resposta,0,"tempo"); 
		    $ordem = mysql_result($get_resposta,0,"ordem");
		    $ticket = mysql_result($get_resposta,0,"ticket");
		    $data = date("Y-m-d H:i:s");
		    
		    mysql_query("UPDATE gerador_tickets SET utilizado = 1 WHERE numero_ticket = '$ticket'");
		    
		    if(strlen($resposta) > 99) {
		        $query = "INSERT INTO aplicacoes (nome,email,telefone,cpf,nasc,organizacao,grupo,cargo,tempo,respostas,ticket,data_aplic,lang) 
		        VALUES ('$nome','$email','$telefone','$cpf','$nascimento','$organizacao','$grupo','$cargo','$tempo','$resposta','$ticket','$data','$lang')";
		        
		        if(mysql_query($query)) {
		        	
		            //salvando notas
		            // create a new cURL resource
		            $ch = curl_init();
		            $url = "https://cms.mapertest.com.br/resultado/notas2.php?id=$cpf";

		            // set URL and other appropriate options
		            curl_setopt($ch, CURLOPT_URL, $url);
		            curl_setopt($ch, CURLOPT_HEADER, 0);
		            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		            // grab URL and pass it to the browser
		            $result = curl_exec($ch);

		            // close cURL resource, and free up system resources
		            curl_close($ch);

		            $separando = explode("#",$result);
		            $id_teste = $separando[0];
		            $notas_fim = $separando[1];

		            if (mysql_query("UPDATE aplicacoes SET notas = '$notas_fim' WHERE id = '$id_teste'")) {
		                echo 1;
		            }
		        } else {
		        	 
		            echo "error";
		        }
		    } else {
		        echo "error";
		    }
		}
		
    } else {
        echo "error";
    }
?>