<div class='global-content'>
	<div class='global-title'>Meus Tópico</div>
	<div class='table-responsive'>
		<table class='table table-bordered'>
			<tr align='center'>
				<th width='5%' align='center'>#</th>
				<th style='text-align: left;'>Título</th>
				<th width='18%;'>Gerenciar</th>
			</tr>
			<?php $forum = new forum($con); $forum->get_mytopics();?>
		</table>
	</div>
</div>
