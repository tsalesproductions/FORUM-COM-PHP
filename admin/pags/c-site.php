<?php $admcp = new admcp($con);?>
<div class='content'>
	<h4>CONFIGURAÇÕES DO SITE</h4>
	<hr>
	<form method="POST" enctype="multipart/form-data">
		<label>Título do site</label>
		<input type="text" name="titulo" class="form-control col-sm-6" value="<?php echo $admcp->get_siteinfos('titulo');?>" required><br><br>
		

		<h4>CONFIGURAÇÕES DE META</h4>
		<hr>

		<div class="row">
			<div class="col-sm-6">
				<label>Description</label>
				<input type="text" name="description" class="form-control" value="<?php echo $admcp->get_siteinfos('description');?>"><br>
			</div>

			<div class="col-sm-6">
				<label>Keywords</label>
				<input type="text" name="keywords" class="form-control" value="<?php echo $admcp->get_siteinfos('keywords');?>"><br>
			</div>
		</div><br><br>

		<h4>BANNER E ICON</h4>
		<hr>
		
		<div class="row">
			<div class="col-sm-6">
				<?php $admcp->get_logo(); ?>
				<label>banner</label>
				<input type="file" name="bannerfile" class="form-control"><br>
			</div>

			<div class="col-sm-6">
				<?php $admcp->get_icon(); ?>
				<label>Icon</label>
				<input type="file" name="iconfile" class="form-control"><br>
			</div>
		</div><br><br>
		
		<p align="right"><input type="submit" value="Salvar Alterações" class="btn btn-outline-primary btn-lg"></p>
		<input type="hidden" name="env" value="csite">
	</form>
	<?php $admcp->update_configs_site();?>
</div>