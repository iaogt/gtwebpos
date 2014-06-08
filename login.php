<?php
	ob_start();
	session_start();
	
	require_once('appConf.php');
	require_once('controladores/aplicacion/Base.php');
	require_once('controladores/aplicacion/Pagina.php');
	require_once('data/Modelo.php');
	require_once('libs/funciones.php');
	$var = ob_get_contents();
	ob_end_clean();
	$objModelo = new Modelo();
	
	function verificar_login($usuario,$contraseña,&$resultado) {
		$resultado=false;
		if($objModelo->login($usuario,$contraseña)){
			$resultado=true;
		}else{
			$resultado=false;
		}
		return $resultado;
	}
	
	$vista= new Base();
	$vista->assign_template("plantillas/layout.tpl");
	
	$vista = new Pagina($vista,"contenido");
	$vista->assign_template("plantillas/login.tpl");
	
	$arrUsers = $objModelo->getUsers();
	
	foreach($arrUsers as $user){
		$vista->tpl->setVariable('iduser',$user['id']);
		$vista->tpl->setVariable('nomuser',$user['name']);
		if($user['apppassword']!=""){
			$vista->tpl->setVariable('pedirclave',1);
		}else{
			$vista->tpl->setVariable('pedirclave',0);
		}
		$vista->tpl->parse('blqUser');
	}
	
    if((isset($_POST['usuario']))&&($objModelo->logear($_POST['idusuario'],$_POST['usuario'],$_POST['contraseña'])))
    {
    	$id = intval($_POST['idusuario']);
        $_SESSION['userid'] = $id;
        header("Location:index.php");
    }else{
        $vista->tpl->touchBlock('nologin');
    }
	
	echo $vista->show();
?>