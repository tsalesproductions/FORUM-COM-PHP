<div class="topic-content">
	<?php
		$idTopico = explode('-', $explode['1']);
		$forum = new forum($con);
		$forum->get_topic($idTopico['0']);
	?>
</div>