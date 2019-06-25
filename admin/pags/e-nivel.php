<?php $admcp = new admcp($con); $admcp->show_onlyadmin();?>

<div class="content">
	<h4>EDITAR NIVEL</h4>
	<hr>

	<form method="POST" class="col-sm-6">
		<label>Nível</label>
		<select name="nivel" class="form-control">
			<?php $admcp->get_userniveloption($explode['1']);?>
			<option value="0">Membro</option>
			<option value="1">Moderador</option>
			<option value="2">Administrador</option>
		</select><br>

		<p align="right"><input type="submit" value="Salvar Alteração" class="btn btn-primary btn-sm"></p>
		<input type="hidden" name="env" value="nvupd">
	</form>
	<?php $admcp->edit_nivel($explode['1']);?>
</div>
