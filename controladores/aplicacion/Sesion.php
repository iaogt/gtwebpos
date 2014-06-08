<?php 
	session_start();
	class Sesion {
		var $idUser;
		var $ida;
		function __construct(){
			$this->idUser	= (isset($_SESSION['_user'.Configuracion::appId()]))?$_SESSION['_user'.Configuracion::appId()]:'';
			$this->ida		= (isset($_SESSION['_ida'.Configuracion::appId()]))?$_SESSION['_ida'.Configuracion::appId()]:'';
			if (!isset($_SESSION['_intentos'.Configuracion::appId()])) {
				$_SESSION['_intentos'.Configuracion::appId()] = 0;
			}
		}
		public function isUserLog() {
			if ($this->idUser != '') {
				return true;
			}
			return false;
		}
		public function setUserLog ($uid, $pass) {
			$objModelo = new Modelo();
			$infoUser = $objModelo->getAdmin($uid, md5($pass));
			if (isset($infoUser[0]['adm_id']) and is_numeric($infoUser[0]['adm_id'])) {
				$_SESSION['_user'.Configuracion::appId()]	= $uid;
				$_SESSION['_ida'.Configuracion::appId()]	= $infoUser[0]['adm_id'];
				$this->idUser		= $_SESSION['_user'.Configuracion::appId()];
				$this->ida			= $infoUser[0]['adm_id'];
				return true;
			} 
			$_SESSION['_intentos'.Configuracion::appId()]++;
			return false;
		}	
		public function delSesion () {
			unset($_SESSION['_user'.Configuracion::appId()]);
			unset($_SESSION['_ida'.Configuracion::appId()]);
			unset($_SESSION['_intentos'.Configuracion::appId()]);
			return true;
		}
	}
?>