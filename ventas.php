<?php
	session_start();
	ob_start();
	require_once('appConf.php');
	require_once('controladores/aplicacion/Base.php');
	require_once('controladores/aplicacion/Pagina.php');
	require_once('data/Modelo.php');
	require_once('libs/funciones.php');
	ob_end_clean();
	
	verificaLogin();
	
	$vista= new Base();
	$vista->assign_template("plantillas/layout.tpl");
	
	$vista = new Pagina($vista,"contenido");
	$vista->assign_template("plantillas/facturas.tpl");
	
	$objModelo = new Modelo();
	
	$tid ="";
	if(@$_POST['nticket'])
		$tid=$_POST['nticket'];
	
	$arrPendientes = $objModelo->getPendientes($tid);
	if($arrPendientes){
		foreach($arrPendientes as $p){
			$vista->tpl->setVariable('id',$p['id']);
			$vista->tpl->setVariable('ticketid',$p['tid']);
			$vista->tpl->setVariable('vendedor',$p['vendedor']);
			$vista->tpl->setVariable('cajero',$p['cajero']);
			$vista->tpl->setVariable('fecha',$p['fecha']);
			$vista->tpl->setVariable('total',$p['total']);
			$vista->tpl->parse("blqPendiente");
		}
	}else{
		$vista->tpl->touchBlock('blqNoHay');
	}
	
	echo $vista->show();
?>