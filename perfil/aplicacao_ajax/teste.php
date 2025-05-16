<?php 

            //salvando notas
            // create a new cURL resource
            $ch = curl_init();
            $url = "https://mapertest.com.br/cms/resultado/notas2.php?id=01518977600";

            echo $url;

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

            echo ("UPDATE aplicacoes SET notas = '$notas_fim' WHERE id = '$id_teste'");

 ?>