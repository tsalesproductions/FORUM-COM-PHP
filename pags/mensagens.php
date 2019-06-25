<?php $forum = new forum($con);?>
<div class='messages-content'>
	<div class='global-title'>Mensagens</div>
	<div class='content'>
		<div class='row'>
			<div class='col-sm-3'>
				<h4>Gerenciar Mensagens</h4>
				<hr>
				 <?php $forum->messages_menu();?>
			</div>
			<div class='col-sm-9'>
				<h4>Mensagens</h4>
				<hr>
				<?php $forum->get_messages();?>
			</div>
		</div>
	</div>
</div>