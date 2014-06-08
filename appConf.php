<?php
$root = getenv('DOCUMENT_ROOT');
$path = getenv('PATH_INFO');
$path=dirname(__FILE__);

/**
 * Esta clase contiene información específica acerca de la aplicación que se ejecuta.  Sus valores se pueden utilizar alrededor de toda la app haciendo inclusión de este script.
 * */

set_include_path(get_include_path().PATH_SEPARATOR.$path.'/controladores');		//Agrega el directorio controladores para hacer acceso directo de sus clases sin necesidad de referencia directa
set_include_path(get_include_path().PATH_SEPARATOR.$path.'/modelo');			//Agrega el directorio modelo para hacer acceso directo de sus clases sin necesidad de referencia directa
set_include_path(get_include_path().PATH_SEPARATOR.$path.'/libs/HTML_Template_Sigma-1.3.0');			//Agrega el directorio modelo para hacer acceso directo de sus clases sin necesidad de referencia directa
set_include_path(get_include_path().PATH_SEPARATOR.$path.'/libs/Doctrine-1.2.4');			//Agrega el directorio modelo para hacer acceso directo de sus clases sin necesidad de referencia directa

ini_set("display_errors", "On");
error_reporting(E_ALL & ~E_STRICT);
?>