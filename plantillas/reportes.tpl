<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="page-header">
<h3>Reportes de Actividad</h3>
</div>
<div class="row">
	<div id="graficaVentas"></div>
</div>
<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
				var data = google.visualization.arrayToDataTable([
				['Mes', 'Ventas'],
				<!-- BEGIN blqDatosVentas -->
				[{fecha},  {venta}],
				<!-- END blqDatosVentas -->
			]);
		
			var options = {
				title: 'Ventas Mensuales',
				hAxis:{haxis}
			};
		
			var chart = new google.visualization.LineChart(document.getElementById('graficaVentas'));
			chart.draw(data, options);
		}
</script>