<?php require_once("../conn.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<?php
 /*
    $sql = "SELECT * FROM aplicacoes WHERE organizacao = '187'";
    $sql = mysql_query($sql);
    $container = 0;
    while($linha = mysql_fetch_array($sql)) {
    $container++;
    
    $respostas = $linha["respostas"];
    }
   */    
?>

<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: 'Thales de Assis'
            },
            subtitle: {
                text: 'Isto é um teste'
            },
            xAxis: {
                categories: [
                    'Capacidade de planejamento',
                    'Capacidade de organização',
                    'Capacidade de acompanhamento',
                    'Estilo de liderança',
                    'Estilo de comunicação',
                    'Tomada de decisão',
                    'Capacidade de delegação',
                    'Administração de tempo',
                    'Volume de trabalho',
                    'Potencial criativo e flexibilidade',
                    'Cap. priorizar e trab. c/ imprevistos',
                    'Gestão de mudanças',
                    'Relacionamento com superiores',
                    'Gestão de conflitos',
                    'Controle das emoções',
                    'Relacionamento afetivo',
                    'Relacionamento em grupos',
                    'Imagem pessoal',
                    'Tônus vital',
                    'Necessidade de Realização'
                ],
               labels: {
                    rotation: -90,
                    align: 'right',
                    verticalAlign: 'middle',
                    style: {
                        font: 'normal 11px Arial, sans-serif'
                    }
               }
            },
            yAxis: {
                min: 0,
                max: 10,
                title: {
                    text: ''
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' mm';
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
                series: [{
                width: 100,
                pointWidth: 20,
                showInLegend: false,
                name: '',
                data: [{y: 1.9, color: '#BF0B23'}, 5.5, 2.4, {y: 7.9, color: '#BF0B23'}, 10.0, 9.0, 4.6, 7.5, 8.4, 6.1, 2.6, 1.4, 5.2, 8.0, 6.0, 5.6, 8.5, 4.1, 5.6, 2.4]
    
            }]
        });
    });
    
});
</script>


	</head>
	<body>
<script src="classe/highcharts.js"></script>
<script src="classe/modules/exporting.js"></script>

<div id="container" style="width: 600px; height: 450px; margin: 0 auto"></div>

	</body>
</html>