<!--style type="text/css">
form.login {
    background:#F1F1F1;
    border: 1px solid #DDDDDD;
    font-family: sans-serif;
    margin: 0 auto;
    padding: 20px;
    width: 278px;
    box-shadow:0px 0px 20px black; 
    border-radius:10px; 

}
form.login div {
    margin-bottom: 15px;
    overflow: hidden;
}
form.login div label {
    display: block;
    float: left;
    line-height: 25px;
}
form.login div input[type="text"], form.login div input[type="password"] {
    border: 1px solid #DCDCDC;
    float: right;
    padding: 4px;
}
form.login div input[type="submit"] {
    background:#DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
}
.error{
    color: red;
    font-weight: bold;
    margin: 10px;
    text-align: center;
}
</style-->
<script type="text/javascript">
	function enviarLogin(){ 
		$('#frmLogin').submit();
		return false;
	}

	function hacerlogin(idusuario,nombre,clave){
		if(clave){		//Si hay q pedir clave al usuario
			$('#formLogin').modal();
		}else{
			$('#txtIdusuario').val(idusuario);
			$('#txtNomusuario').val(nombre);
			enviarLogin();
		}
		return false;
	}
	
</script>
<div class="row">
<!-- BEGIN blqUser -->
<div class="thumbnail col-md-2">
<a href="#" onclick="return hacerlogin({iduser},'{nomuser}',{pedirclave})">
<img src="images/preview.png"/>
{nomuser}
</a>
</div>
<!-- END blqUser -->
</div>
<div class="modal fade" id="formLogin">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Clave de acceso</h4>
      </div>
      <div class="modal-body">
		<form action="login.php" method="post" class="login" id="frmLogin">
			<input type="hidden" name="idusuario" id="txtIdusuario" value=""/>
			<div><label>Usuario</label><input name="usuario" id="txtNomusuario" type="text" ></div>
			<div><label>Contrase&ntildea</label><input name="contraseña" type="password"></div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="return enviarLogin();">Acceder</button>
      </div>
    </div><!-- /.modal-content --> 
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->