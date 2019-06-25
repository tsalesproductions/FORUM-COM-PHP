<?php $admcp = new admcp($con);?>
<div class="content">
	<h4>EDITAR FÓRUM</h4>
	<hr>
		<form method="POST">
			<div class="row">
				<div class="col-sm-6">
					<label>Nome do fórum</label>
					<input type="text" name="titulo" class="form-control" name="categoria" value="<?php echo $admcp->get_foruminfos($explode['1'], 'titulo');?>" required><br>
				</div>

				<div class="col-sm-6">
					<label>Selecione a categoria</label>
					<select name="categoria"  class="form-control">
						<?php $admcp->get_forumcategoria_option($admcp->get_foruminfos($explode['1'], 'categoria'));?>
						<?php $admcp->get_categorias_options();?>
					</select>
				</div>

				<div class="col-sm-6">
					<label>Status</label>
					<select name="status"  class="form-control">
						<?php $admcp->get_switchstatuseforum($admcp->get_foruminfos($explode['1'], 'status'));?>
						<option value="1">Aberto - Podendo criar tópicos</option>
						<option value="0">Fechado - Ninguém pode criar tópicos</option>
					</select><br>
				</div>

				<div class="col-sm-6">
					<label>Permissão mínima para criar tópicos nesta área</label>
					<select name="permissao"  class="form-control">
						<?php $admcp->get_switchpermissaotopublicinforum($admcp->get_foruminfos($explode['1'], 'permissao'));?>
						<option value="0">Membros, Moderadores e Administradores</option>
						<option value="1">Moderadores e Administradores</option>
						<option value="2">Apenas Administradores</option>
					</select><br>
				</div>

				<div class="col-sm-12">
					<label>Descrição</label>
					<textarea name="descricao" rows="2" maxlength="150" class="form-control" required><?php echo $admcp->get_foruminfos($explode['1'], 'descricao');?></textarea>
				</div>
				</div><br>

			<p align="right"><input type="submit" value="Salvar Alterações" class="btn btn-primary btn-sm"></p>
			<input type="hidden" name="env" value="updforum">
		</form>
		<div><?php $admcp->edit_forum($explode['1']);?> </div>
	<hr>
</div><br>