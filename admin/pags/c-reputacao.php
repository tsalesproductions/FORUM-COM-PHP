<div class="content">
	<h4>NÍVEIS DE REPUTAÇÃO</h4>
	<p>Os niveis de reputação funciona para qualificar ou patentear usuários em diferentes niveis. <br>Exemplo: <b>Nivel 1 = Novato</b> .. <b>Nivel 5 = Membro avançado</b>.</p>
	<hr>

	<div class="row">
		<div class="col-sm-6">
			<h5>Cadastrar</h5>
			<hr>
			<form method="POST">
				<label>Nome da reputação</label>
				<input type="text" name="nome" id="nomereputation" class="form-control" reqired>
				<br>

				<label>Pontos necessários</label>
				<input type="number" name="nivel" class="form-control" required><br>

				<label>Cor do texto:</label>
				<input type="color" name="cor" id="color" style="margin-left: 20px"><br>

				<label>Cor do fundo:</label>
				<input type="color" name="bg_cor" id="bg_color" style="margin-left: 16px"><br>

				<div id="previewcolor"></div>

				<p align="right"><input type="submit" value="Adicionar" class="btn btn-outline-primary btn-sm"></p>
				<input type="hidden" name="env" value="reputacao">
			</form>
			<?php $admcp = new admcp($con); $admcp->add_reputation();?>
		</div>

		<div class="col-sm-6">
			<h5>Gerenciar</h5>
			<hr>
			<ul style="list-style: none;">
				<?php $admcp->get_reputation();?>
			</ul>
		</div>
	</div>
</div>