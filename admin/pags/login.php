<?php $admcp = new admcp($con); $admcp->verifica_logado();?>
<div class="title-login col-sm-6 offset-md-2">LOGUE-SE PARA CONTINUAR</div>
<form method="POST" class="col-sm-6 offset-md-2 login">
	<label for="usuario"></label>
	<input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuário" required><br>

	<label for="senha"></label>
	<input type="password" name="senha" id="senha" class="form-control" placeholder="*********" required><br>

	<p><input type="submit" value="Entrar" class="btn btn-primary btn-lg btn-block"></p>
	<input type="hidden" name="env" value="login">
</form>
<div class="col-sm-6 offset-md-2 footer-login"><?php $admcp->loginADM();?></div>
<br><br>
