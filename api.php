<?php
	ob_start();
	require_once('appConf.php');
	require_once('data/Modelo.php');
	ob_end_clean();
	
	$info = $_GET['m'];
	
	switch($info){
		case "producto":{ 
			$id = $_GET['id'];
			$obj = Doctrine_Core::getTable('products')->find($id);
			if($obj){
				echo '{"nom":"'.$obj->name.'","price":"'.$obj->pricesell.'"}';
			}
			break;
		}
		
		case "listproductos":{
			$p= isset($_GET['p']) ? intval($_GET['p']) : 0;
			$q = Doctrine_Manager::getInstance()->connection();
			$datos = $q->execute('SET CHARSET utf8');
        	$q = new Doctrine_Query();
        	$arrProductos = $q->select('id,name,category,pricesell,code,taxcat')
        	->from('PRODUCTS p')
        	->orderBy('category,name,code')
        	->execute(array(), Doctrine::HYDRATE_ARRAY);
			header('Content-type: application/json');
			echo json_encode($arrProductos);
			break;
		}
		
		case "crearfactura":{
			
			$strAttributes = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
			<!DOCTYPE properties SYSTEM "http://java.sun.com/dtd/properties.dtd">
			<properties>
			<comment>Openbravo POS</comment>
			<entry key="product.com">false</entry>
			<entry key="product.taxcategoryid">{taxcatid}</entry>
			<entry key="product.categoryid">{catid}</entry>
			<entry key="product.name">{prodname}</entry>
			</properties>';
			
			$arrProductos = $_POST['prods'];		//Listado de productos
			$total = $_POST['total'];				//Total de la factura
			
			$qid = new Doctrine_Query();
			$qid->select('id')->from('ticketsnum');
			$collData = $qid->execute(array());
			$objData=null;
			foreach($collData as $obj){
				$objData = $obj;
			}
			$intId = $objData['id'];		//ID del ticket que le toca
			$arrDate = getdate();
			
			$receipts = new receipts;
			$receipts->id = $arrDate[0];
			$receipts->money=$_POST['cajero'];		//ID de cierre de caja
			$receipts->datenew = new Doctrine_Expression('NOW()'); 
			$receipts->save();
			
			$objPay = new payments;
			$objPay->id = 'p'.$arrDate[0];
			$objPay->receipt = $receipts->id;
			$objPay->payment = 'cash';
			$objPay->total = 0;//$total;
			$objPay->temptotal = $total;	//Este es el total mientras no se recibe el dinero, luego se traslada
			$objPay->transid = 'no ID';
			$objPay->save();
			
			$tickets = new tickets;
			$tickets->id = $receipts->id;
			$tickets->tickettype=0;
			$tickets->ticketid=$intId;
			$tickets->person=0;
			$tickets->customer=null;
			$tickets->status=0;
			$tickets->save();
			
			$objData->id=$intId+1;
			$objData->save();
			$line=0;
			$arrImpuestos = array();
			foreach($arrProductos as $prod){
				$objProd = Doctrine_Core::getTable('products')->find($prod[0]);
				if($objProd){
					$impuestos = new Doctrine_Query();
					$impuestos->select('*')->from('taxes')->where('category like ?',$objProd->taxcat);
					$arr_Impuestos = $impuestos->execute(array(),Doctrine::HYDRATE_ARRAY);
					if(count($arr_Impuestos)>0){
						$lineaprod = new ticketlines();
						$lineaprod['ticket']=$tickets->id;
						$lineaprod['line']=$line;
						$lineaprod['product']=$prod[0];		//Id del producto
						$lineaprod['units']=$prod[1];	//Cantidad
						$lineaprod['price']=$prod[2];	//Precio
						$lineaprod['taxid']='ab8f785b-e2b0-4402-9a79-4b6b9c21efab';		//Libre de impuestos
						$strAtt = str_replace("{taxcatid}",$objProd->taxcat,$strAttributes);
						$strAtt = str_replace("{catid}",$objProd->category,$strAttributes);
						$strAtt = str_replace("{prodname}",$objProd->name,$strAttributes);
						$lineaprod['attributes']=$strAtt;
						$lineaprod->save();
						$line=$line+1;
						array_push($arrImpuestos,$arr_Impuestos[0]);
					}
				} 
			}

			if(count($arrImpuestos)>0){
				foreach($arrImpuestos as $imp){
					$objTax = new taxlines;
					$objTax->id = 't'.$arrDate[0];
					$objTax->receipt = $receipts->id;
					$objTax->taxid = $imp['id'];
					$objTax->base = $total;
					$objTax->amount = floatval($imp['rate'])*$total;
					$objTax->save();
				}
			}
			
			echo '{"ticket":'.$intId.'}';
		 
			/*$obj = new Doctrine_Query();
			$obj->select('*')->from('ticketlines');
			$arrData = $obj->execute(array(),Doctrine::HYDRATE_ARRAY);
			echo $arrData[0]['attributes'];*/
			break;
		}

		case "detalleProds":{
			$ticketid = $_POST['ticketid'];
			if($ticketid){
				$q = new Doctrine_Query();
				$q = Doctrine_Manager::getInstance()->connection();				
				$arrLineas = $q->execute("SELECT p.name nom, t.units,t.price precio FROM ticketlines t join products p on t.product = p.id WHERE t.ticket like '".$ticketid."'");
				echo '<table role="table">';
				echo '<thead><tr><th>Cantidad</th><th>Producto</th><th>Precio</th></tr></thead>';
				foreach($arrLineas as $linea){
					echo '<tr><td align="center">'.$linea['units'].'</td><td>'.$linea['nom'].'</td><td>'.$linea['precio'].'</td></tr>';
				}
				echo '</table>';
			}
			break;
		} 

		case "pagar":{
			$resultado='{resultado:"no"}';
			$idrecibo = $_POST['receipt'];
			if($idrecibo>0){
				$objPayment = Doctrine_Core::getTable('payments')->findByDql('receipt like ?',$idrecibo);
				foreach($objPayment as $obj){
					$obj->total = $obj->temptotal;
					$obj->save();
				}
				$resultado = '{resultado:"ok"}';
			}
			echo $resultado;
			break;
		}

	}
	
?>