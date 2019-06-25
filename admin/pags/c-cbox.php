<?php $admcp = new admcp($con);?>
<div class='content'>
	<h4>CONFIGURAÇÕES CHATBOX</h4>
	<hr>
	<form method="POST">
		<div class="row">
			<div class="col-sm-12">
				<label><b>Descrição / Mensagem / Regras</b></label>
				<textarea name="regras" rows="10" class="form-control" id="editable"><?php echo $admcp->chatbox_infos('regras');?></textarea><br><br>
			</div>

			<div class="col-sm-12">
				<label><b>Permissão minima para conversar</b></label>
				<select name="permissao" class="form-control">
					<?php $admcp->chatbox_permissionoption();?>
					<option value="0">Membros, Moderadores, Administradores</option>
					<option value="1">Moderadores e Administradores</option>
					<option value="2">Apenas Administradores</option>
				</select><br>
			</div><br>
		</div>

		<p align="right"><input type="submit" value="Salvar Alterações" class="btn btn-primary btn-sm"></p>
		<input type="hidden" name="env" value="chatboxupd">
	</form>
</div>
<?php $admcp->chatbox_send_updates();?>
<br>