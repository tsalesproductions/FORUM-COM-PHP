<div class='content'>
	<h4>BUSCAR TÓPICOS</h4>
	<hr>
	<form method="POST">
	<div class="row resultados">
		<div class="col-sm-10">
			<input type="text" name="resultado" class="form-control" placeholder="Busque pelo título do tópico ou  usuário que postou" required>
		</div>

		<div class="col-sm-2">
			<input type="submit" value="BUSCAR" class="btn btn-primary">
			<input type="hidden" name="env" value="busca">
		</div>
	</div>
	</form>
	<br>
	<hr>
	<br>
	<table class='table table-bordered'>
		<tr>
			<th width='5%'>#</th>
			<th width='75%'>Título do Tópico</th>
			<th width='20%'>Funções</th>
		</tr>
		<?php $admcp = new admcp($con); $admcp->get_rtopicos();?>
	</table>
</div>
<br>