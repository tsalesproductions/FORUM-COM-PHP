<?php
	$forum = new forum($con);
	$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
	$explode = explode('/', $url);
	$idCategoria = $explode['1'];
	$idForum = $explode['2'];
	$forum->new_topic($idForum, $idCategoria);
?>