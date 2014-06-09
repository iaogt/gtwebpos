var listaVenta;	
var listProductos;
var arrVenta = [];	//Listado de los ID de los productos que está comprando

$(document).ready(function(){
	personalizaInterfaz();
	creaTabla();
	cargaProductos();
});

function bqProducto(e){
	if(e.keyCode==13){		//Si presiona el enter
		for(i=0;i<listProductos.length;i++){
			if(listProductos[i].code==$('#txtCodigo').val()){
				$('#iposprod').val(i);
				$('#lblProducto').html(listProductos[i].name);
				$('#cantProdFac').modal('show');
				i=listProductos.length;
			}
		}
		
	}
}

function addLinea(nombre,lacantidad,precio,posicion,quantity){
	var resultado=false;
	var cantidad=quantity;
	if(quantity==0)
		cantidad = prompt('Cantidad:','1');
	if(cantidad>0){
		listaVenta.row.add([nombre,cantidad,precio,cantidad*precio]).draw();
		var total = parseFloat($('#totalFactura').val());
		var subtotal = cantidad*precio;
		$('#totalFactura').val(total+subtotal);
		var objProd = listProductos[posicion];
		var arrData = [objProd.id,cantidad,precio,objProd.taxcat];
		arrVenta.push(arrData);
		resultado=true;
	}
	return resultado;
}

function filaSeleccionada(){
	$('#btnEliminar').removeClass('disabled');
}

function filaNoSeleccionada(){
	$('#btnEliminar').addClass('disabled');
}

function personalizaInterfaz(){
	$("#button").click(function(){
		$("#div1").slideToggle("slow");
	});
	$("#btnAreaProductos").click(function(){
	   $('#tabs-1').slideToggle("slow");
	});
	$("#btnCerrarLProds").click(function(){
	   $('#tabs-1').slideUp("slow");
	   $('.thumbnail').removeClass('prodsel');
	});
	$('#btnBuscarProd').click(function(){
		buscarProducto($('#txtBuscarProd').val());
		return false;
	});
	$('#btnFacturar').click(function(){
		var totalItems = $('tbody > tr[role]').length; 
		if(totalItems>0){		//Solo si hay items en la tabla
			$('#txtTotalFac').val($('#totalFactura').val());
			$('#afacturar').modal();
		}else{
			alert('No hay productos seleccionados');
		}
	});
	$('#btnCrearFactura').click(function(){
		crearFactura();
		return false;
	})
	$('#btnCerrarFactura').click(function(){
		$('#numFactura').css('display','none');
		$('#cobraFactura').css('display','block');
		$('#afacturar').modal('hide');
		$('#loaderFactura').css('display','none');
		limpiaTodo();
	})
	$('#btnEliminar').click(function(){
		borrarProducto();
	});
	$('#pgAnt').click(function(){
		if(nPagina>0){
			nPagina=nPagina-1;
			poblarProductos(listProductos);
		}
		if(nPagina==0){
			$('#pgAnt').css('display','none');
		}
		if(nPagina<totPaginas-1){
			$('#pgSig').css('display','block');
		}
	});
	$('#pgSig').click(function(){
		if(nPagina<totPaginas){
			nPagina=nPagina+1;
			poblarProductos(listProductos);
			$('#pgAnt').css('display','block');
		}
		if(nPagina==(totPaginas-1)){
			$('#pgSig').css('display','none');
		}
	});
	$('#selcateg').change(function(){
		filtrarCategoria();
	});
	$('.tecladoNum').click(function(){		//Teclado numérico
		var txt = $('#noLblProducto').val();
		txt = txt+$(this).html();
		$('#noLblProducto').val(txt);
	});
	$('#btnOkCantidad').click(function(){
		var cantidad = parseFloat($('#noLblProducto').val());
		var i = $('#iposprod').val();
		var precio = parseFloat(listProductos[i].pricesell);
		addLinea(listProductos[i].name,1,precio,i,cantidad);
		$('#txtCodigo').val('');
		$('#cantProdFac').modal('hide');
		$('#noLblProducto').val('1');
	});
	$('#btnBorrar').click(function(){
		var txt = $('#noLblProducto').val();
		if(txt.length>1){
			txt = txt.substr(0,txt.length-1);
		}else{
			txt='';
		}
		$('#noLblProducto').val(txt);
	});
}

function creaTabla(){
	listaVenta = $('#listaVenta').DataTable({
		"searching":false, 
		"lengthChange":false,
		"pageLength":10,
		"scrollY":"400px",
		"scrollColapse":true,
	});
	
	$('#listaVenta tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('selected') ) {
		    $(this).removeClass('selected');
		    filaNoSeleccionada();
		}
		else {
		    listaVenta.$('tr.selected').removeClass('selected');
		    $(this).addClass('selected');
		    filaSeleccionada();
		}
	} );
}

var nPagina=0;
var totPaginas = 0;

function cargaProductos(){
	$('#pgAnt').css('display','none');
	$('#pgSig').css('display','none');
	$('#cargandoProductos').css('display','block');
	$.get('api.php?m=listproductos',{p:nPagina},function(data){
		$('#cargandoProductos').css('display','none');
		listProductos = data;
		if(data){
			if(data.length>0)
				poblarProductos(listProductos);
			else{ 
				alert('No hay productos');
			}
		}
		$('#pgSig').css('display','block');
		nPagina=0;
		totPaginas=Math.ceil(data.length/30);
		if(totPaginas<=1){
			$('#pgAnt').css('display','none');
			$('#pgSig').css('display','none');
		}else{
			$('#pgSig').css('display','block');
		}
	});
}

function poblarProductos(data){
	$('#areaProductos').find('.row').remove();
	var i=0;
	var inicio=nPagina*30;
	var fin = inicio+30;
	if(data.length<fin) fin=data.length;
	for(i = inicio; i<fin;i++){
		agregarProducto(data[i].name,i);
	}
	agregarEvento();
}

function agregarEvento(){
	$('.thumbnail').click(function(){
		var posicion = $(this).find('.posinArr').eq(0).val();
		var objProducto = listProductos[posicion];
		if(addLinea(objProducto.name,1,objProducto.pricesell,posicion,0))
			$(this).addClass('prodsel');
		return false;
	});
}

var row=null;
var cantrow=0;

function agregarProducto(nombre,pos){
	if(row==null){
		row = $('<div></div>');
		row.addClass('row');
	}
	var blq = $('#tplProdBox').clone();
	blq.css('display','block');
	blq.find('.nomProducto').eq(0).html(nombre);
	blq.find('.posinArr').eq(0).val(pos);
	row.append(blq);
	cantrow=cantrow+1;
	if(cantrow==6){
		$('#areaProductos').append(row);
		row = $('<div></div>');
		row.addClass('row');
		cantrow=0;
	}
}


function buscarProducto(nomprod){
	var blq = $('#tplProdBox').clone();
	$('#areaProductos').find('.row').remove();
	var cont=0;
	for(i=0;i<listProductos.length;i++){
		var strNom =listProductos[i].name;
		if(strNom!=""){
			strNom = strNom.toLowerCase();
			if(strNom.search(nomprod.toLowerCase())>-1){
				cont=cont+1;
				agregarProducto(listProductos[i].name,i);
			}
		}
	}
	agregarEvento();
	if(cont==0){
		$('#areaProductos').append('<p>No se encontraron productos</p>');
	}
}

function filtrarCategoria(){
	var catego = $('#selcateg').val();
	if(catego){
		$('#areaProductos').find('.row').remove();
		if(catego!='todos'){
			var cont=0;
			for(i=0;i<listProductos.length;i++){
				var strNom =listProductos[i].category;
				if(strNom!=""){
					strNom = strNom.toLowerCase();
					if(strNom.search(catego.toLowerCase())>-1){
						cont=cont+1;
						agregarProducto(listProductos[i].name,i);
					}
				}
			}
			agregarEvento();
		}else{
			poblarProductos(listProductos);
		}
	}
}

function calculaVuelto(e){
	var total = parseFloat($('#txtTotalFac').val());
	var efec = $('#txtEfectivoFac').val()+String.fromCharCode(e.keyCode);
	efec = parseFloat(efec);
	var vuelto = efec-total;
	$('#txtVueltoFac').val(vuelto);
}

/**
 Crea la factura
 * */
function crearFactura(){
	$('#loaderFactura').css('display','block');
	var tot = $('#txtTotalFac').val();
	$.post('api.php?m=crearfactura',{"prods":arrVenta,"total":tot},function(data){
		if(data){
			$('#nFac').html(data['ticket']);
			$('#cobraFactura').css('display','none');
			$('#numFactura').css('display','block');
			$('#loaderFactura').css('display','none');
		}
	},'json');
}

function limpiaTodo(){
	listaVenta.clear().draw();
	$('#btnEliminar').addClass('disabled');
	$('#totalFactura').val('0.00');
	$('#txtTotalFac').val('0.00');
	$('#txtVueltoFac').val('');
	$('#txtEfectivoFac').val('');
}

function borrarProducto(){
	listaVenta.row('.selected').remove().draw( false );
}
