<?php 
	$forum = new forum($con);
	$forum->get_topicsbysearch($_POST['resultado']);
?>