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
	$vista->assign_template("plantillas/venta2.tpl");
	
	$objModelo = new Modelo();
	
	$criterio="";
	if(@$_POST['txtbuscar']){
		$criterio = $_POST['txtbuscar'];
	}

	
	$seleccion="";
	if(@$_POST['selcateg']){
	    $seleccion = $_POST['selcateg'];
	}
		
	$arrCategorias = $objModelo->cargarCategorias($seleccion);
	   if($arrCategorias){
	   foreach($arrCategorias as $categoria){
			$vista->tpl->setVariable("idcat",$categoria['id']);
			$vista->tpl->setVariable("nombrecat",$categoria['name']);
			$vista->tpl->parse("blqCategoria");
			}
		}else{
			$vista->tpl->touchBlock('noproducto');
		}	

	$arrProductos = $objModelo->cargarProductos($criterio);
	if($arrProductos){
		$vista->tpl->hideBlock('noproducto');
		foreach($arrProductos as $producto){
			$vista->tpl->setVariable("nomproducto",$producto['name']);
			$vista->tpl->parse("blqProducto");
		}
	}else{
		$vista->tpl->touchBlock('noproducto');
	}
	
	$arrCajeros = $objModelo->getCajeros();
	if($arrCajeros){
		foreach($arrCajeros as $c){
			$vista->tpl->setVariable('idCajero',$c['money']);
			$vista->tpl->setVariable('nombreCajero',$c['host']);
		}
	}
	
	echo $vista->show();
?>