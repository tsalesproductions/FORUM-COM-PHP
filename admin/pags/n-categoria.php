<div class="content">
	<h4>NOVA CATEGORIA</h4>
	<hr>
		<form method="POST" class="col-sm-6">
			<label>Nome da categoria</label>
			<input type="text" class="form-control" name="categoria"><br>

			<p align="right"><input type="submit" value="Criar Categoria" class="btn btn-primary btn-sm"></p>
			<input type="hidden" name="env" value="categoria">
		</form>
		<div class="col-sm-6"><?php $admcp = new admcp($con); $admcp->new_categoria();?> </div>
	<hr>
</div>