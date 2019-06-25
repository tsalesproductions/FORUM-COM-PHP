<div class='content'>
	<h4>GERENCIAR USUÁRIOS</h4>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th width='5%'>#</th>
			<th width='75%'>Nome / Usuário</th>
			<th width='20%'>Funções</th>
		</tr>
		<?php $admcp = new admcp($con); $admcp->show_onlyadmin(); $admcp->get_nusuarios();?>
	</table>
</div>
<br>