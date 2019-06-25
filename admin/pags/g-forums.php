<div class='content'>
	<h4>GERENCIAR FÓRUMS</h4>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th width='5%'>#</th>
			<th width='75%'>Nome do fórum</th>
			<th width='20%'>Funções</th>
		</tr>
		<?php $admcp = new admcp($con); $admcp->get_nforums();?>
	</table>
</div>
<br>