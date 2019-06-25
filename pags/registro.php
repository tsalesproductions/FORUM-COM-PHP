<script type="text/javaScript">
	function Trim(str){
		return str.replace(/( )/ig,"");
	}
</script>
<div class='global-content'>
<div class='global-title'>Registre-se</div>
	<div class="content">
		<h4>Cadastre-se para começar</h4>
		<hr>
		<form method="POST">
			<div class="row">
				<div class="col-sm-6">
					<label>Nome</label>
					<input type="text" name="nome" class="form-control" required><br>
				</div>

				<div class="col-sm-6">
					<label>Usuário</label>
					<input type="text" name="usuario" onkeyup="this.value = Trim(this.value)" class="form-control" required><br>
				</div>

				<div class="col-sm-6">
					<label>Senha</label>
					<input type="password" name="senha" class="form-control" required><br>
				</div>

				<div class="col-sm-6">
					<label>Email</label>
					<input type="email" name="email" class="form-control" required><br>
				</div>
			</div>
			
			<p align="right"><input type="submit" value="Concluir Registro" class="btn btn-outline-success"></p>
			<input type="hidden" name="env" value="cad">
		</form>
	</div>	
	<?php $forum = new forum($con); $forum->register();?>
</div>