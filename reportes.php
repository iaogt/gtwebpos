<?php
	session_start();
	ob_start();
	require_once('appConf.php');
	require_once('controladores/aplicacion/Base.php');
	require_once('controladores/aplicacion/Pagina.php');
	require_once('data/Modelo.php');
	require_once('libs/funciones.php');
	ob_end_clean();
	
	$objModelo = new Modelo();
	
	$vista= new Base();
	$vista->assign_template("plantillas/layout.tpl");
	
	$vista = new Pagina($vista,"contenido");
	$vista->assign_template("plantillas/reportes.tpl");
	
	$arrVentas = $objModelo->ventasMensuales();
	if($arrVentas){
		$arrNomMeses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$arrMeses = array();
		foreach($arrVentas as $venta){
			array_push($arrMeses,"{v:new Date(".$venta['y'].",".($venta['mes']-1).",01"."),f:'".$arrNomMeses[($venta['mes']-1)]."'}");
			$vista->tpl->setVariable('fecha',"new Date(".$venta['y'].",".($venta['mes']-1).",01)");
			$vista->tpl->setVariable('venta',$venta['u_p']);
			$vista->tpl->parse("blqDatosVentas");
		}
		$meses = implode(",", $arrMeses); 
		$vista->tpl->setVariable('haxis',"{ticks:[".$meses."]}");
	}
	
	echo $vista->show();
?>