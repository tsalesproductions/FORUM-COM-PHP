<?php 
	include_once("lib/includes.php");
	$forum = new forum($con);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $forum->get_siteinfos('description');?>">
    <meta name="keywords" content="<?php echo $forum->get_siteinfos('keywords');?>">
    <meta name="author" content="Thiago Sales - Tutoriais e Informática">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php $forum->gera_titulo();?></title>

    <!-- CSS SCRIPTS -->
    <base href="<?php echo $hrefbase;?>">
    <link rel="icon" href="<?php echo $forum->get_nicon();?>" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <?php $cor = (isset($_GET['cor'])) ? $_GET['cor'] : 'styleblue';?>
    <link rel="stylesheet" href="css/<?php echo $cor;?>.css"/>
    <link href="css/prism.css" rel="stylesheet"/>

    <!-- JS SCRIPTS -->
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=0nuicspdixvx4k9tfw3hr38ncj59sxmvtlx4gedy2etxoqzz"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/prism.js"></script>
    <script src="js/plugin-prism.min.js"></script>
    <script src="js/scripts.js"></script>


    
  </head>
  <body>
		
  	<?php
  		$forum->mainmenu();
  		$forum->get_chatbox();
      $forum->grava_ip_online();
    ?>

	<div class="clearfix"></div>
	 
  <div class="row">
  	<div class="col-sm-9">
	  	<?php
        $forum->carrega_pagina($con);
      ?>
  	</div>

	<?php $forum->rightMenu();?>
</div>


<?php $forum->modalLogin();?>


    <!--JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  </body>

  <footer><?php echo $forum->get_siteinfos("titulo");?> &copy; Powered by <a href="http://www.tutoriaiseinformatica.com">Tutorias e Informática</a>.</footer>
</html>