<?php $admcp = new admcp($con);?>
<div class="content">
	<h4>NOVO FÓRUM</h4>
	<hr>
		<form method="POST">
			<div class="row">
				<div class="col-sm-6">
					<label>Nome do fórum</label>
					<input type="text" name="titulo" class="form-control" name="categoria" required><br>
				</div>

				<div class="col-sm-6">
					<label>Selecione a categoria</label>
					<select name="categoria"  class="form-control">
						<?php $admcp->get_categorias_options();?>
					</select>
				</div>

				<div class="col-sm-6">
					<label>Status</label>
					<select name="status"  class="form-control">
						<option value="1">Aberto - Podendo criar tópicos</option>
						<option value="0">Fechado - Ninguém pode criar tópicos</option>
					</select>
				</div>

				<div class="col-sm-6">
					<label>Permissão mínima para criar tópicos nesta área</label>
					<select name="permissao"  class="form-control">
						<option value="0">Membros, Moderadores e Administradores</option>
						<option value="1">Moderadores e Administradores</option>
						<option value="2">Apenas Administradores</option>
					</select>
				</div>

				<div class="col-sm-12">
					<label>Descrição</label>
					<textarea name="descricao" rows="2" maxlength="150" class="form-control" required></textarea>
				</div>
				</div><br>

			<p align="right"><input type="submit" value="Criar Fórum" class="btn btn-primary btn-sm"></p>
			<input type="hidden" name="env" value="forum">
		</form>
		<div><?php $admcp->new_forum();?> </div>
	<hr>
</div><br>