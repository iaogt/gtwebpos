	   <!-- DataTables CSS -->
	   <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	   <!-- DataTables -->
	   <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
       <script src="js/venta.js" type="text/javascript"></script>
    <div id="bmenu" class="row">
        <div id="menuHeader">
            <div id="areaLogin" style="float:right;margin-right:15px"> 
            	<a href="logout.php" class="btn btn-danger">Salir</a>
            </div>
        	<div id="btnHeader">
            <button id="button" class="btn btn-default">Menu</button>
            </div>
        </div>
        <div id="div1" style="display:none;"> 
			<input type="button" value="Nuevo" class="btn btn-primary">
			<label>No. Factura</label>
			<input type="text" name="nofactura">
			<input type="button" value="Eliminar" class="btn btn-primary">
			<input type="button" value="Editar" class="btn btn-primary"> 
			<input type="button" value="Buscar" class="btn btn-primary">
		</div>
	</div>
    <div class="row">        
		<div class="descripcion col-md-9">
			<div id="areaTabla" class="row">
			    <table id="listaVenta">
			    	<thead>
			    		<tr>
			    			<th>Producto</th>
			    			<th>Cantidad</th>
			    			<th>Precio</th>
			    			<th>Sub-Total</th>
			    		</tr>
			    	</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div id="codigo" class="row">
				<div class="col-md-6">
					<label for="txtCodigo">Codigo:</label>
					<input type="text" id="txtCodigo" onkeydown="return agregarProducto(event);">
				</div>
				<div class="col-md-6" style="text-align:right">
					<label for="totalFactura">Total:</label>
					<input value="0.00" style="text-align:right" type="text" id="totalFactura">
				</div>
			</div>
		</div>	
		<div class="col-md-3"> 
				<input id="btnEliminar" type="button" value="Eliminar" class="btn btn-primary btn-block disabled"/>
				<input type="button" value="% Descuento" class="btn btn-primary btn-block"/>
				<button class="btn btn-primary btn-block" id="btnFacturar">Facturar</button>
		</div> 
   </div>     
   <div id="categoria" class="row">      
        <div id="tabs" class="col-md-12">
        	<div class="row">
	        	<div id="productosHeader">	      
            		<button id="btnAreaProductos" class="btn btn-default" >Productos</button>
	        	</div>
        	</div>
        </div>
   </div>
   
           	<div id="tabs-1" style="left:0px;position:absolute;top:0px;width:100%;height:100%;padding-top:20px;display:none;background-color:#E4EFF5;">
	            <div class="row" style="margin:15px;text-align:right;">
		            <div class="col-md-2" style="text-align:left">
		            	<a href="#" id="btnCerrarLProds"><img src="images/close.png"/></a>
		            </div>
		            <div class="col-md-10" style="text-align:right;">
						<label for="selcateg">Categorias:</label>
						<select name="selcateg" id="selcateg">	
						<option value="todos">Todas</option>				
						<!-- BEGIN blqCategoria -->
						   <option value="{idcat}">{nombrecat}</option>
						<!-- END blqCategoria -->	
						</select>
						<label>Buscar:</label>
						<input type="text" name="txtbuscar" id="txtBuscarProd">
						<input type="button" value="Buscar" class="btn btn-primary" id="btnBuscarProd"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6" style="text-align:right">
						<button type="button" class="btn btn-link" id="pgAnt"><- Anterior</button>
					</div>
					<div class="col-md-6">
						<button type="button" class="btn btn-link" id="pgSig">Siguiente -></button>
					</div>
				</div>
				<div id="areaProductos" class="row" style="border:1px solid #000;overflow:scroll;margin-right:0px;margin-left:0px;">
					<div id="cargandoProductos">
						<img src="images/ajax-loader.gif"/>
					</div>
					<div class="col-xs-4 col-md-2" style="display:none" id="tplProdBox">
						<a href="#" class="thumbnail">
							<input type="hidden" value="" class="posinArr"/>
							<img src="images/file.jpg" width="30px">
							<label class="nomProducto"></label>
						</a>
					</div>
	            </div>
            </div>
        					<!-- Modal -->
<div class="modal fade" id="afacturar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Payments</h4>
      </div>
      <div class="modal-body">
      	<div style="text-align:right" id="cobraFactura">
      	<form>
      		<label>Total:</label><input name="total" id="txtTotalFac" readonly="readonly" style="text-align:right"/><br/>
      		<label>Efectivo:</label><input name="efectivo" id="txtEfectivoFac" style="text-align:right" onkeydown="return calculaVuelto(event);"/><br/>
      		<label>Vuelto:</label><input name="vuelto" id="txtVueltoFac" readonly="readonly" style="text-align:right"/><br/>
      	</form>
      	</div>
      	<div id="numFactura" style="display:none;text-align:center;" align="center">
      		<p id="nFac" style="color:#f00;font-size:30px;"></p>
      		<button type="button" class="btn btn-primary" id="btnCerrarFactura">Ok</button>
      	</div>
      	<img src="images/ajax-loader.gif" id="loaderFactura" style="display:none"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnCrearFactura">Facturar</button>
      </div>
    </div>
  </div>
</div>