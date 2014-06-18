	   <!-- DataTables CSS -->
	   <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	   <!-- DataTables -->
	   <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
       <script src="js/venta.js" type="text/javascript"></script>
       <div class="row">
       <div class="col-sm-6 col-md-6">
       </div>
			<div class="col-sm-6 col-md-6" style="text-align:right">
				<label for="totalFactura">Total: Q.</label>
				<input value="0.00" style="text-align:right;font-size:20px;border:0px;" type="text" id="totalFactura">
			</div>
       </div>
<div class="row">
	<div class="descripcion col-md-8">
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
	</div>	 
	<div class="col-md-4"> 
	<label>Preguntar cantidad</label><input type="checkbox" checked id="preguntar"/>
			<input id="btnEliminar" type="button" value="Eliminar" class="btn btn-primary btn-block disabled"/>
			<button class="btn btn-primary btn-block" id="btnListado">Listado Continuo</button>
			<button class="btn btn-warning btn-block" id="btnFacturar">Facturar</button>
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
      		<!--label>Efectivo:</label><input name="efectivo" id="txtEfectivoFac" style="text-align:right" onkeydown="return calculaVuelto(event);"/><br/>
      		<label>Vuelto:</label><input name="vuelto" id="txtVueltoFac" readonly="readonly" style="text-align:right"/><br/-->
      		<label>Cajero:</label><select name="ncajero" id="nomCajero">
      		<!-- BEGIN blqCajero -->
      		<option value="{idCajero}">{nombreCajero}</option>
      		<!-- END blqCajero -->
      		</select>
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
<div class="modal fade" id="cantProdFac" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Cantidad</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-6 col-sm-6 col-md-6">
      		<input type="hidden" id="iposprod" value="0"/>
      		<label id="lblProducto"></label>
      		<label>Cantidad:</label><input id="noLblProducto" value="1"/>
      		</div>
      		<div class="col-xs-6 col-sm-6 col-md-6">
	      		<div class="row">
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">7</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">8</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">9</button>
	      			</div>
	      		</div>
	      		<div class="row">
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">4</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">5</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">6</button>
	      			</div>
	      		</div>
	      		<div class="row">
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">1</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">2</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">3</button>
	      			</div>
	      		</div>
	      		<div class="row">
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">.</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg tecladoNum">0</button>
	      			</div>
	      			<div class="col-xs-4 col-sm-4 col-md-4">
	      			<button class="btn btn-default btn-lg" id="btnBorrar"><-</button>
	      			</div>
	      		</div>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnOkCantidad">Ok</button>
      </div>
    </div>
  </div>
</div>