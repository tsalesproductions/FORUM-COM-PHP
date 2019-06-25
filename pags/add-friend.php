<?php
	$forum = new forum($con);
	$forum->friends_send_solicitation(addslashes($explode['1']));
?>