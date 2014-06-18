<form role="form"> 
	<label>No. Ticket</label><input name="nticket"/>
	<button>Buscar</button>
</form>
<table  class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Vendedor</th>
			<th># Productos</th>
			<th>Fecha</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<!-- BEGIN blqPendiente -->
		<tr>
			<td><a class="idfac" href="#">{id}</a></td><td>{vendedor}</td><td></td><td>{fecha}</td><td>Q. {total}</td>
		</tr>
	<!-- END blqPendiente -->
	</tbody>
</table>
        					<!-- Modal -->
<div class="modal fade" id="afacturar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">A pagar</h4>
      </div>
      <div class="modal-body">
      	<div style="text-align:right" id="cobraFactura">
      	
      	</div>
      	<div id="numFactura" style="display:none;text-align:center;" align="center">
      		<p id="nFac" style="color:#f00;font-size:30px;"></p>
      		<button type="button" class="btn btn-primary" id="btnCerrarFactura">Ok</button>
      	</div>
      	<img src="images/ajax-loader.gif" id="loaderFactura" style="display:none"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnCrearFactura">Pagada</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.idfac').click(function(){
			$('#afacturar').modal();
		});
		$('#btnCrearFactura').click(function(){
			var a = confirm('¿El cliente pagó?','Si','No');
			if(a){
				
			}
		});
	});
</script>