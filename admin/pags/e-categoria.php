<?php $admcp = new admcp($con);?>
<div class="content">
	<h4>EDITAR CATEGORIA</h4>
	<hr>
		<form method="POST" class="col-sm-6">
			<label>Nome da categoria</label>
			<input type="text" class="form-control" name="categoria" value="<?php echo $admcp->get_dcategoria($explode['1'], 'categoria');?>"><br>

			<p align="right"><input type="submit" value="Enviar Alterações" class="btn btn-primary btn-sm"></p>
			<input type="hidden" name="env" value="updcategoria">
		</form>
		<div class="col-sm-6"><?php $admcp->edit_categoria($explode['1']);?> </div>
	<hr>
</div>