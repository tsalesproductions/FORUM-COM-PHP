<?php
	$forum = new forum($con);
	$forum->friends_accept_solicitation(addslashes($explode['1']), addslashes($explode['2']), $explode['3']);
?>