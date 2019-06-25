<?php $admcp = new admcp($con); $admcp->show_onlyadmin();?>
<div class='content'>
	<h4>ALTERAR SENHA DO USUÁRIO</h4>
	<hr>
	<form method="POST">
		<div class="row">
			<div class="col-sm-6">
				<label>Senha Atual</label>
				<input type="password" name="asenha" value="<?php echo $admcp->get_userinfos($explode['1'], 'senha');?>" class="form-control" disabled/><br>
			</div>

			<div class="col-sm-6">
				<label>Nova Senha</label>
				<input type="password" name="nsenha" class="form-control" required/><br>
			</div>
		</div>
		<p align="right"><input type="submit" value="Alterar Senha" class="btn btn-primary btn-sm"></p>
		<input type="hidden" name="env" value="updsenha">
	</form>
</div>
<?php $admcp->upd_senhaUser($explode['1']);?>
<br>