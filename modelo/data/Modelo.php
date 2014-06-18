<?php
	require_once("dataLayer.php");
	/**
	 * Esta clase se utiliza para abstraer la data independiente de la capa de datos que se use
	 * Es recomendado utilizarla para que en las páginas no se haga referencia directa a las clases que representan el modelo (Doctrine en este caso) 
	 * */
	class Modelo {
		/**
		 * Carga productos disponibles
		 * */
		public function cargarProductos($txtcriterio=""){
			$q = Doctrine_Query::create()->select('*')->from('products');
			if($txtcriterio!=""){		//Si trae un parámetro
				$txtcriterio = '%'.$txtcriterio.'%';
				$q->where('name like ?',$txtcriterio);
			}
			return $q->execute(array(),Doctrine::HYDRATE_ARRAY);
		}
		/**
		*Carga de categorias disponibles
		**/
		public function cargarCategorias($idcategoria=""){
			$q = Doctrine_Query::create()->select('*')->from('categories');
			if($idcategoria=""){
			$idcategoria= 'selcateg';
			$q->where('id like ?',$idcategoria);
			}
			return  $q->execute(array(),Doctrine::HYDRATE_ARRAY);
		}
		
		/**
		 * 
		 * */
		public function login($usuario,$clave){
			$q = Doctrine_Query::create()->select('*')->from('people')->where('name like ? and apppassword like ?',array($usuario,$clave));
			$arrDatos = $q->execute(array(),Doctrine::HYDRATE_ARRAY);
			$resultado=false;
			if(count($arrDatos)>0){
				$resultado=true;
			}
			return $resultado;
		}
		
		/**
		 * 
		 * */
		public function getUsers(){
			$q = Doctrine_Query::create()->select('*')->from('people')->where('visible=1');
			return $q->execute(array(),Doctrine::HYDRATE_ARRAY);
		}
		
		/**
		 * Verifica si el usuario tiene o no clave
		 * */
		public function logear($idusuario,$usuario,$clave){
			$resultado=false;
			$objUsuario = Doctrine_Core::getTable('people')->find($idusuario);
			if($objUsuario){
				if($objUsuario->apppassword!=""){		//Si tiene password guardado
					echo "hace login";
					$resultado = $this->login($idusuario,$clave);
				}else{
					$resultado=true;
				}
			}else $resultado=false;
			return $resultado; 
		}
		
		public function ventasMensuales(){
			$q = Doctrine_Manager::getInstance()->connection();
			$datos = $q->execute('SELECT sum(units*price) u_p, month(re.datenew) mes,year(re.datenew) y FROM `TICKETLINES` t join RECEIPTS re on t.ticket like re.id GROUP BY mes,y');
			$arrDatos = $datos->fetchAll();
			return $arrDatos;
		}
		
		public function getCajeros(){
			$q = Doctrine_Query::create()->select('*')->from('closedcash');
			$cajeros = $q->execute(array(),Doctrine::HYDRATE_ARRAY);
			return $cajeros;
		}
		
		public function getPendientes(){
			$q = Doctrine_Manager::getInstance()->connection();
			$datos = $q->execute("SELECT t.ticketid id,r.datenew fecha, p.temptotal total, c.host cajero,pe.name vendedor FROM receipts r JOIN tickets t ON r.id = t.id JOIN closedcash c on r.money = c.money JOIN payments p on p.receipt = r.id JOIN people pe on pe.id = t.person");
			$arrDatos = $datos->fetchAll();
			return $arrDatos;
		}
	}
?>