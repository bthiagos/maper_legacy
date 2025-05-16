<head><title>CMS Mapertest :: Gest&atilde;o por Compet&ecirc;ncias, Sistemas de Qualidade, Educa&ccedil;&atilde;o Corporativa e RH</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<link href="js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" type="text/css" rel="stylesheet" />
<link rel="shortcut icon" href="favicon.ico" />
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">  

<!-- *** QuickMenu copyright (c) 2007, OpenCube Inc. All Rights Reserved.

	-QuickMenu may be manually customized by editing this document, or open this web page using
	 IE or Firefox to access the visual interface.

-->


<!-- QuickMenu Noscript Support [Keep in head for full validation!] -->
<noscript><style type="text/css">.qmmc {width:200px !important;height:200px !important;overflow:scroll;}.qmmc div {position:relative !important;visibility:visible !important;}.qmmc a {float:none !important;white-space:normal !important;}</style></noscript>


<!--%%%%%%%%%%%% QuickMenu Styles [Keep in head for full validation!] %%%%%%%%%%%-->
<style type="text/css">



/*!!!!!!!!!!! QuickMenu Core CSS [Do Not Modify!] !!!!!!!!!!!!!*/
.qmclear {font-size:1px;height:0px;width:0px;clear:left;line-height:0px;display:block;}.qmmc {position:relative;}.qmmc a {float:left;display:block;white-space:nowrap;}.qmmc div a {float:none;}.qmsh div a{float:left;}.qmmc div {visibility:hidden;position:absolute;}

/*!!!!!!!!!!! QuickMenu Styles [Please Modify!] !!!!!!!!!!!*/



	/* QuickMenu 0 */

	/*"""""""" (MAIN) Container""""""""*/	
	#qm0	
	{	
		background-color:transparent;
	}


	/*"""""""" (MAIN) Items""""""""*/	
	#qm0 a	
	{	
		padding:5px 40px 5px 8px;
		background-color:#FFFFFF;
		color:#000000;
		font-family:Arial;
		font-size:0.8em;
		text-decoration:none;
		border-width:1px;
		border-style:solid;
		border-color:#A6A6A6;
	}


	/*"""""""" (MAIN) Hover State""""""""*/	
	#qm0 a:hover	
	{	
		background-color:#FFFFFF;
	}


	/*"""""""" (MAIN) Parent items""""""""*/	
	#qm0 .qmparent	
	{	
	}


	/*"""""""" (MAIN) Active State""""""""*/	
	body #qm0 .qmactive, body #qm0 .qmactive:hover	
	{	
		background-color:#E6E6E6;
		text-decoration:underline;
	}


	/*"""""""" (SUB) Container""""""""*/	
	#qm0 div	
	{	
		padding:5px;
		margin:-1px 0px 0px 0px;
		background-color:#E6E6E6;
		border-width:1px;
		border-style:solid;
		border-color:#A6A6A6;
	}


	/*"""""""" (SUB) Items""""""""*/	
	#qm0 div a	
	{	
		padding:2px 40px 2px 5px;
		background-color:transparent;
		border-width:0px;
		border-style:none;
		border-color:#000000;
	}


	/*"""""""" (SUB) Hover State""""""""*/	
	#qm0 div a:hover	
	{	
		text-decoration:underline;
	}


	/*"""""""" (SUB) Parent items""""""""*/	
	#qm0 div .qmparent	
	{	
	}


	/*"""""""" (SUB) Active State""""""""*/	
	body #qm0 div .qmactive, body #qm0 div .qmactive:hover	
	{	
		background-color:#FFFFFF;
	}

	/* CSS for the demo. CSS needed for the scripts are loaded dynamically by the scripts */

	
	#mainContainer{
		width:600px;
		margin:0 auto;
		margin-top:10px;
		border:1px double #000;
		padding:3px;

	}
	#calendarDiv,#calendarDiv2{
		width:240px;
		height:240px;
		float:left;
	}
	.clear{
		clear:both;
	}
	
	#info h2 {
		color:#727272;
		font-size:16px;
		font-family:Arial, Helvetica, sans-serif
	}

</style>
<style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style>
<script type="text/javascript" src="codigo.js"></script>
<script type="text/javascript" src="js/fl.js"></script>
<script src="jquery.js" type="text/javascript"></script>
<Script languange="JavaScript" src="ajax.js"></Script>
<script src="sorttable.js"></script>
<?include("validacao.php")?>



<script type="text/javascript">
function is_email(email)
{
  er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
  
  if(er.exec(email))
        {
          return true;
        } else {
          return false;
        }
}

function Validar(theCPF)
{
  
  if (theCPF.value == "")
  {
    alert("Campo inválido. É necessário informar o CPF ou CNPJ");
    theCPF.focus();
    return false;
  }
  if (((theCPF.value.length == 11) && (theCPF.value == 11111111111) || (theCPF.value == 22222222222) || (theCPF.value == 33333333333) || (theCPF.value == 44444444444) || (theCPF.value == 55555555555) || (theCPF.value == 66666666666) || (theCPF.value == 77777777777) || (theCPF.value == 88888888888) || (theCPF.value == 99999999999) || (theCPF.value == 00000000000)))
  {
    alert("CPF/CNPJ inválido.");
    theCPF.focus();
    return (false);
  }


  if (!((theCPF.value.length == 11) || (theCPF.value.length == 14)))
  {
    alert("CPF/CNPJ inválido.");
    theCPF.focus();
    return (false);
  }

  var checkOK = "0123456789";
  var checkStr = theCPF.value;
  var allValid = true;
  var allNum = "";
  for (i = 0;  i < checkStr.length;  i++)
  {
    ch = checkStr.charAt(i);
    for (j = 0;  j < checkOK.length;  j++)
      if (ch == checkOK.charAt(j))
        break;
    if (j == checkOK.length)
    {
      allValid = false;
      break;
    }
    allNum += ch;
  }
  if (!allValid)
  {
    alert("Favor preencher somente com dígitos o campo CPF/CNPJ.");
    theCPF.focus();
    return (false);
  }

  var chkVal = allNum;
  var prsVal = parseFloat(allNum);
  if (chkVal != "" && !(prsVal > "0"))
  {
    alert("CPF zerado !");
    theCPF.focus();
    return (false);
  }

if (theCPF.value.length == 11)
{
  var tot = 0;

  for (i = 2;  i <= 10;  i++)
    tot += i * parseInt(checkStr.charAt(10 - i));

  if ((tot * 10 % 11 % 10) != parseInt(checkStr.charAt(9)))
  {
    alert("CPF/CNPJ inválido.");
    theCPF.focus();
    return (false);
  }
  
  tot = 0;
  
  for (i = 2;  i <= 11;  i++)
    tot += i * parseInt(checkStr.charAt(11 - i));

  if ((tot * 10 % 11 % 10) != parseInt(checkStr.charAt(10)))
  {
    alert("CPF/CNPJ inválido.");
    theCPF.focus();
    return (false);
  }
}
else
{
  var tot  = 0;
  var peso = 2;
  
  for (i = 0;  i <= 11;  i++)
  {
    tot += peso * parseInt(checkStr.charAt(11 - i));
    peso++;
    if (peso == 10)
    {
        peso = 2;
    }
  }

  if ((tot * 10 % 11 % 10) != parseInt(checkStr.charAt(12)))
  {
    alert("CPF/CNPJ inválido.");
    theCPF.focus();
    return (false);
  }
  
  tot  = 0;
  peso = 2;
  
  for (i = 0;  i <= 12;  i++)
  {
    tot += peso * parseInt(checkStr.charAt(12 - i));
    peso++;
    if (peso == 10)
    {
        peso = 2;
    }
  }

  if ((tot * 10 % 11 % 10) != parseInt(checkStr.charAt(13)))
  {
    alert("CPF/CNPJ inválido.");
    theCPF.focus();
    return (false);
  }
}
  return(true);
}



function mostrarEmail(valor){
	if(valor == 1){
		document.getElementById('mostrarEmail').style.display = "none";  
	}
	
	if(valor == 2){
		document.getElementById('mostrarEmail').style.display = "block";  
	}
	
}

function buscar_emails(tipo,id){
	if(id != 0){
		if(tipo == 1){
			
			document.cadastro.id_email.length=0;
			document.cadastro.id_email.disabled = true;
			document.cadastro.id_email.options[0] = new Option("Carregando...", 0, false, false);
		}
			
			imput_xml("mn",'busca_email.php?tipo='+tipo+'&id='+id,'combos');
			
	}
}

function verificaTipoPermissao(permissao){
	if(permissao == '2222'){
		 document.getElementById('organizacoes_super').style.display = "block";  
	}else{
		 document.getElementById('organizacoes_super').style.display = "none";  
	}
	
	if(permissao == '3333'){
		 document.getElementById('organizacoes').style.display = "block";  
	}else{
		 document.getElementById('organizacoes').style.display = "none";  
	}
	
	if(permissao == '4444'){
		 document.getElementById('organizacoescommit').style.display = "block";  
	}else{
		 document.getElementById('organizacoescommit').style.display = "none";  
	}
	
}

function numeric(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>


<script>

$(document).ready(function() {
	$('#selectAll').click(function() {
		if(this.checked == true){
			$("input[type=checkbox]").each(function() { 
				this.checked = true; 
			});
		} else {
			$("input[type=checkbox]").each(function() { 
				this.checked = false; 
			});
		}
	});	
});
</script>

<link rel="stylesheet" type="text/css" href="css/overlay.css"/>	

<script type="text/javascript" src="js/jquery_tools.js"></script>

<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.20.custom.css"/>	
<script src="jquery_ui.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	var dates = $( "#from, #to" ).datepicker({

        dateFormat: "dd/mm/yy",
        dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        monthNamesShort: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
		changeMonth: true,
		numberOfMonths: 1,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
</script>

<script src="js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118" type="text/javascript"></script>
<script type="text/javascript" src="tiny/jscripts/tiny_mce/tiny_mce.js" ></script >
<script type="text/javascript" >
tinyMCE.init({
        mode : "exact",
        content_css : "tiny/formatacao_default.css",
        elements : "pc_descricao,pc_mensagem,input_novaquestao",
        theme : "simple",   //(n.b. no trailing comma, this will be critical as you experiment later)
        force_br_newlines : true,
        force_p_newlines : false,
        forced_root_block : '' // Needed for 3.x
        
});
</script >

</head>
















