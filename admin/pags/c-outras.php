<?php $admcp = new admcp($con);?>
<div class="content">
	<h4>OUTRAS CONFIGURAÇÕES</h4>
	<hr>

	<form method="POST" class="col-sm-6">
		<label>Pontos por curtida</label><br>
		<code>Quantos pontos o usuário receberá após alguém curtir um tópico ou resposta que o mesmo postou.</code>
		<input type="number" name="pontos" value="<?php echo $admcp->get_siteinfos('pontos_por_curtidas');?>" class="form-control" required><br>
		
		<p align="right"><input type="submit" value="Salvar Alterações" class="btn btn-primary btn-sm"></p>
		<input type="hidden" name="env" value="upd">
	</form>
	<?php $admcp->edit_others();?>
</div>