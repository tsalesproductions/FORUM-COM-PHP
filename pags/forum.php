<?php
	$forumid = $explode['1'];
	$idForum = explode('-', $forumid);
	//$idForum = str_replace('-', ' ', $forumid);

	$forum = new forum($con);
	$forum->get_forum($idForum['0']);
?>