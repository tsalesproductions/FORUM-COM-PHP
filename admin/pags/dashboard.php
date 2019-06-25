<div class="content">
	<h2>Bem vindo <?php $admcp = new admcp($con); echo $admcp->welcome_title();?></h2>
	<hr>
	<div class="oncenter">
		<div class="dashboard-ball blue">
			<h2><?php echo $admcp->get_totalcategorias();?></h2><span>CATEGORIAS</span>
		</div>

		<div class="dashboard-ball purple">
			<h2><?php echo $admcp->get_totalforums();?></h2><span>FÓRUMS</span>
		</div>

		<div class="dashboard-ball green">
			<h2><?php echo $admcp->get_ntotaltopics();?></h2><span>TÓPICOS</span>
		</div>

		<div class="dashboard-ball red">
			<h2><?php echo $admcp->get_ntotalrespostas();?></h2><span>RESPOSTAS</span>
		</div>

		<div class="dashboard-ball blue">
			<h2><?php echo $admcp->get_ntotalusuarios();?></h2><span>USUÁRIOS</span>
		</div>
	</div>
	<hr>
</div>