<? 							$codigo_usuario= $_SESSION["id_usuario_adm"];

							//$permissao = $_SESSION["per_adm"];?>

	

<div id="menu">

    <div id="qm0" class="qmmc">

        <a href="#">Principal</a>

        <div>


            <?

            if(($permissao == "99991") or ($permissao == "99992")){?>
                    <a href="emails_ebook.php">E-mails Ebook</a>
                    <a href="seis_meses.php">Regra Seis Meses</a>

            <? } ?>

            <a href="home.php">Home</a>

            <a href="logout.php">Sair</a>

        </div>

<?

if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "99992") or ($permissao == "5555")){?>

        <a href="#">Usu&aacute;rios do Sistema</a>

        <div>

            <a href="usuario_cadastra.php">Novo Usu&aacute;rios </a>

            <a href="usuario_gerencia.php">Gerenciamento de Usu&aacute;rios</a>

        </div>

<?

}

if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "99992")){?>





        <a href="#">Palestras</a>

        <div>

            <a href="inscritos.php">Neurolideran�a</a>

        </div>

        

        

        <a href="#">Gerenciar Site</a>

        <div>

            <a href="#">Home</a>

            <a href="sobreApp.php">Sobre o APP</a>

            <a href="origem.php">Origem do APP</a>

            <a href="quemsomos.php">Quem Somos do APP</a>

            <a href="webshop.php">Webshop</a>

            <a href="#">Competencia</a>

			 <div>

				 <a href="competenciaBreve.php">Texto Breve</a>

				 <a href="txtcompetencia.php">Texto Compet�ncia</a>

			 </div>

			 

   			 <a href="aplicacoes.php">Aplica��es</a>          

            <a href="cadastroEmpresa.php">Clientes</a>

            <a href="exemplos.php">Exemplos</a>

        </div>



<?}?>



<?

if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "5555")){?>

        

        <a href="#">Dados</a>

        <div>

           <!-- <a href="orga.php">Gerenciamento de Organiza��es</a>-->

            <a href="cadastroEmpresa.php">Gerenciamento de Organiza��es</a> 

            <a href="grupos.php">Gerenciamento de Grupos</a>

        </div> 

<?}?>





<? if(($permissao == "99991") or($permissao == "1111") or ($codigo_usuario == "53") or ($codigo_usuario == "180") or ($codigo_usuario == "54") or ($codigo_usuario == "58") or ($codigo_usuario == "202")){?>        

        <!--<a href="#">Pesquisa de Clima</a>

        <div>

        <? if($codigo_usuario != "180") { ?>

        

        	<a href="#">Email</a>

		        <div>

		           <a href="cadastrarGrupoClima.php">Cadastrar/Gerenciar Grupos</a>

		           <a href="cadastrarEmailClima.php">Cadastrar/Gerenciar Email </a>

		              

		        </div>    

        

           <a href="cadastrar_pesquisas.php">Cadastrar/Gerenciar Pesquisa</a>

           <a href="pesquisa_perguntas.php">Cadastrar/Gerenciar Pergunta</a>

           <a href="cadastrarNewsPesquisa.php">Cadastrar/Gerenciar Newsletter</a> 

           <a href="enviarPesquisaClima.php">Enviar Pesquisa</a>

           <a href="ReenviarPesquisaClima.php">Reenviar Pesquisa</a>

           <a href="resultadoPesquisaClima.php">Resultado da Pesquisa</a>

        <? } ?>

        

        <? if($codigo_usuario == "180") { ?>

           <a href="gerar_tickets_clima.php">Relat�rio</a>

        <? } else { ?>  

           <a href="gerar_tickets_clima.php">Gerador de Tickets</a>  

        <? } ?>  

        </div>    

        -->

     <!--   <a href="#">Grupo de Emails</a>

        <div>

           <a href="">Cadastrar Grupos</a>

           <a href="cadastrarEmailClima.php">Cadastrar Emails</a>

           <a href="gerenciarEmailClima.php">Gerenciamento dos Emails</a>

           <a href="enviarPesquisaClima.php">Enviar Pesquisa</a>

              

        </div>  -->

  <?}?>      



<?

if($permissao == "99991" or $permissao == "99992") { echo '<a href="pc_pesquisa_cadastra.php">Pesquisa de Clima</a>'; }?>



<?

if($permissao == "3333") {?>

<a href="#">Dados</a>

<div> 

    <a href="grupos_orga.php">Gerenciamento de Grupos</a>

</div> 

<? } ?>

<? if($permissao != "1111"  and $permissao != "6666"  and $permissao != "2222") { ?>

        <a href="#">Aplica��es</a>

        <div>

          <?php if($permissao == "99991"){ ?> 
              <a href="telefones_clientes.php">Contatos Clientes</a>
          <?php } ?>    

	        <? if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "3333") or ($permissao == "2222")){?>

            
            <a href="aplica_gerencia.php">Visualizar Aplica��es</a>
            <a href="aplica_gerencia_aec.php">Filtro AeC</a>


            <? if(($permissao == "99991") or ($permissao == "99992")) { ?>

                <a href="filtro_fgv.php">Visualizar Aplicac�es FGV</a>

	            <a href="grupoMont_fgv.php">Gr�ficos em Grupo FGV</a>

            <? } ?>

              <a href="grupoMont.php">Gr�ficos em Grupo</a>
              <a href="grupoMont_venda.php">Gr�ficos em Grupo - Vendedores</a>
              <a href="grupoMont_operacional.php">Gr�ficos em Grupo - Operacional</a>
              <a href="feedbackGrupos.php">Gr�ficos em Grupo - Feedbacks</a>

	            <a href="ticket_unico_cliente.php">Envio de Ticket por E-mail</a>

           <?}?>

           

           <? if($permissao != "3333" and $permissao != "2222"){?>

           

            <a href="aplicacao_commit.php">Visualizar Aplicac�es - COMMIT</a>

              <!--<a href="grupoMont_commit.php">Gr�ficos em Grupo - COMMIT</a>

            -->

            <?}?>

            

            <? if(($permissao == "99991") or ($permissao == "99992")) { ?>
                <a href="competenciasVendas.php">Feedbacks de Vendas</a>

                <a href="questoes_en_es.php">Tradu��es Ingl�s/Espanhol das Quest�es</a>

	            <a href="feedbacks_en_es.php">Tradu��es Ingl�s/Espanhol dos Feedbacks</a>

              <a href="competencias_en_es.php">Tradu��es Ingl�s/Espanhol das Compet�ncias</a>
              <a href="competenciasBreve_en_es.php">Tradu��es Ingl�s/Espanhol das Descri��es das Compet�ncias</a>

              <a href="grupoMont_en_es.php">Tradu��es Ingl�s/Espanhol dos Grupos</a>

            <? } ?>

            

        </div> 
          <? if(($permissao == "99991") or ($permissao == "99992")) { ?>
        <a href="#">Aplicativo de Celular</a>
        <div>
            
            <a href="aplica_gerencia_aplicativo.php">Visualizar Aplicac�es (Aplicativo de Celular)</a>
            <a href="codigos_promocionais.php">C�digos Promocionais</a>
        </div>
        <? } ?>

        <a href="#">Perfil de Cargo</a>

        <div>

            <a href="perfil_cargos.php">Cadastrar/Gerenciar Perfil de Cargo</a>

            <a href="perfil_cargos_relatorio.php">Atribuir e Relat�rios de Perfil de Cargo</a>

                       

        </div> 

<? } ?>



<? if($permissao == "2222") { ?>

        <a href="#">Aplica��es</a>

        <div>

            <a href="aplicacao_super.php">Visualizar Aplicac�es</a>

        </div> 



<? } ?>



<?php 

    $libera_salario = mysql_query("SELECT salario FROM ce_usuario WHERE CodUsuario = '$codigo_usuario'");

    $libera_salario = mysql_fetch_array($libera_salario);

    $libera_salario = $libera_salario["salario"];

?>

<? if(($permissao == "99991") or ($permissao == "99992") or ($codigo_usuario == "202") or ($libera_salario == 1)){?>

    

    <? if(($permissao == "99991") or ($permissao == "99992")) { ?>

        <a href="#">Depoimentos</a>

        <div>

            <a href="depoimentos_cadastra.php">Cadastro dos Depoimentos</a>

            <a href="depoimentos_gerencia.php">Gerenciamento dos Depoimentos</a>

        </div>



     <!--   <a href="#">Clientes</a>

        <div>

            <a href="cliente_gerencia.php">Gerenciamento dos Clientes</a>

        </div>  -->

        <? }

        } 

		

		if( $permissao != "6666" ){?>

        

        <a href="#">Processamento Manual</a>

        <div>

        

         <? if(($permissao == "99991") or ($permissao == "99992") or ($codigo_usuario == "202") or ($libera_salario == 1)){?>

    <? if(($permissao == "99991") or ($permissao == "99992")) { ?>



            <a href="manual3.php">Inserir por Gabarito</a>

        <? }

        } ?>

            

       

        <a href="manual2.php">Inserir por Resposta</a>

        </div> 

        <? } ?>

         <? if(($permissao == "99991") or ($permissao == "99992") or ($codigo_usuario == "202") or ($libera_salario == 1)){?>

    <? if(($permissao == "99991") or ($permissao == "99992")) { ?>



        <a href="#">E-commerce</a>

        <div>

           <!-- <a href="planos_gerencia.php">Gerenciamento de Planos</a> -->

           <a href="configuracoes.php">Configura��es</a> 

           <a href="pedidos_gerencia.php">Pedidos</a> 

           <a href="emails_gerencia.php">Listagem de E-mails</a> 

           <a href="prospectsEmpresas.php">Prospects ? Empresas</a> 

           <a href="prospectsEmpesa_emails.php">Prospects ? Empresas (Lista de E-mails)</a> 

        </div>   

        <? } ?>

        <? if(($permissao == "99991") or ($permissao == "99992") or ($codigo_usuario == "202") or ($libera_salario == 1)) { ?>

        <a href="#">Cargos e Sal�rios</a>

        <div>

           <!-- <a href="planos_gerencia.php">Gerenciamento de Planos</a> -->

           <a href="ces_empresas.php">Cadastro de Empresas e Cargos</a>      

           <a href="cadastrar_relatorio.php">Cadastrar Relat�rio</a>      

           <a href="gerar_avaliacao_cargos.php">Avalia��es de Cargos</a>      

        </div>  

        <? } ?>

        <? if(($permissao == "99991") or ($permissao == "99992")) { ?>

        <a href="#">Ferramentas Transacionais</a>

        <div>

           <!-- <a href="planos_gerencia.php">GerencViamento de Planos</a> -->

           <a href="usuariosTesteOnline.php">Gerenciar Usu�rios</a>       

           <a href="verTesteOnline.php">Visualizar todos os resultados</a>       

        </div>  



         <a href="#">Newsletter</a>

        <div>

            <a href="grupos_gerencia.php">Gerenciamento de Grupos </a>

            <a href="contatos_cadastra.php">Cadastro de Contatos </a>

            <a href="contatos_gerencia.php">Gerenciamento de Contatos </a>

            <a href="letter_cadastro.php">Gerenciamento de Newsletters do Tipo Texto </a>

            <a href="letter_cadastro_img.php">Gerenciamento de Newsletters do Tipo Imagem</a>

            <a href="letter_cadastro_html.php">Gerenciamento de Newsletters do Tipo HTML</a>



        </div>

        <? } ?>

<?}?>



<? if($permissao != "1111" and $permissao != "3333" and $permissao != "4444" and $permissao != "6666" and $codigo_usuario != "180"){?>   

        <a href="#">Tickets</a>

        <div>

          <? if(($permissao == "99991") or ($permissao == "99992")){?> <a href="gerar_tickets_app.php">Gerar Tickets - APP</a> <?}?>

          

          

          <? if($permissao == "5555" or ($codigo_usuario == "154" or $codigo_usuario != "232")) {?>

          	<a href="gerar_tickets.php">Gerar Tickets - COMMIT</a>

          	<!--<a href="ticket_unico.php">Gerar Ticket �nico</a> -->

          <?}?>

          <? if(($permissao == "99991") or ($permissao == "99992")){?>

           <a href="ticket_unico.php">Gerar Ticket �nico</a> 

           <? } ?>

        </div> 

<? } ?>





<!-- PERMISS�O DE N�VEL DE PESQUISA DE CLIMA -->

<? if($permissao == "6666"){?>   

        <a href="#">Pesquisa de clima</a>

        <div>

       	  <a href="pc_mostra_pesquisas.php">Mostrar Pesquisas</a>

        </div> 

<? } ?>

        

        <a href="#">Ajuda</a>

        <div>

            <a target="_blank" href="http://appweb.com.br/cms/Guia_de_formaccao_para_avaliadores_de_perfil_profissional.pdf">Guia de Forma��o de Avaliadores</a>

            <a target="_blank" href="http://www.youtube.com/watch?v=5curkTkdb7c&feature=plcp">V�deo de Apresenta��o</a>

            <a target="_blank" href="http://www.youtube.com/playlist?list=PL50739A4A187A44D4">V�deos das 20 compet�ncias</a>

            <? //if(($permissao == "6666") or ($permissao == "99991") or ($permissao == "99992")){?>   

            <a target="_blank" href="http://appweb.com.br/cms/tutoriais/painel_pesquisa_clima.php">Tutorial para o painel de Pesquisa de Clima</a>

			<a target="_blank" href="http://appweb.com.br/cms/tutoriais/questionario_pesquisa_clima.php">Tutorial para o questionario de Pesquisa de Clima</a>

			<a target="_blank" href="http://appweb.com.br/cms/Interpretacao_resultadosAPP.ppt">Tutorial para o Interpreta��o de Resultados do APP.</a>

            <? //} ?>

        </div> 

  <?

if(($permissao == "99991") or ($permissao == "99992") or ($permissao == "99992") or ($permissao == "5555")){?>      
        <a href="#">PDI</a>

        <div>

            <a target="_blank" href="pdi_gerencia.php">Cadastro PDI</a>

        </div> 
  <? } ?>     



    </div>

    <span class="qmclear">&nbsp;</span>

</div>

</div>

